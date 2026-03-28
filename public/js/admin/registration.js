/**
 * Registration Page - Rawat Jalan Table Management
 * Script untuk fetch dan display data appointments dari backend
 */

class RegistrationManager {
    constructor() {
        this.currentPage = 1;
        this.perPage = 8;
        this.currentFilters = {
            date: '',
            poli_id: 'semua',
            doctor_id: 'semua',
            payment_method_id: 'semua',
            search: ''
        };
        this.currentDetailAppointmentId = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadAppointments();
    }

    setupEventListeners() {
        // Date filter
        const dateInput = document.getElementById('regDateFilter');
        if (dateInput) {
            dateInput.addEventListener('change', (e) => {
                this.currentFilters.date = e.target.value;
                this.currentPage = 1;
                this.loadAppointments();
            });
        }

        // Custom selects
        const customSelects = document.querySelectorAll('.reg-custom-select');
        customSelects.forEach(dropdown => {
            const trigger = dropdown.querySelector('.reg-select-trigger');
            const options = dropdown.querySelectorAll('.reg-option');
            
            options.forEach(option => {
                option.addEventListener('click', (e) => {
                    e.stopPropagation();

                    options.forEach((opt) => opt.classList.remove('is-selected'));
                    option.classList.add('is-selected');
                    const triggerText = dropdown.querySelector('.reg-select-text');
                    if (triggerText) {
                        triggerText.textContent = option.textContent;
                    }
                    dropdown.classList.remove('open');

                    // Update filter based on name attribute
                    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
                    if (hiddenInput) {
                        hiddenInput.value = option.dataset.value;
                        const filterName = hiddenInput.name;
                        this.currentFilters[filterName] = option.dataset.value;
                        this.currentPage = 1;
                        this.loadAppointments();
                    }
                });
            });
        });

        // Search box
        const searchInput = document.querySelector('.reg-search-box input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.currentFilters.search = e.target.value;
                    this.currentPage = 1;
                    this.loadAppointments();
                }, 300);
            });
        }

        // Pagination
        const pageSizeSelect = document.querySelector('.reg-page-size select');
        if (pageSizeSelect) {
            pageSizeSelect.addEventListener('change', (e) => {
                this.perPage = parseInt(e.target.value);
                this.currentPage = 1;
                this.loadAppointments();
            });
        }

        const prevPageBtn = document.querySelectorAll('.reg-page-btn')[0];
        const nextPageBtn = document.querySelectorAll('.reg-page-btn')[1];
        
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', () => {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.loadAppointments();
                }
            });
        }

        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', () => {
                this.currentPage++;
                this.loadAppointments();
            });
        }

        const detailCloseBtn = document.getElementById('regDetailCloseBtn');
        if (detailCloseBtn) {
            detailCloseBtn.addEventListener('click', () => this.closeDetailModal());
        }

        const detailOverlay = document.getElementById('regDetailModal');
        if (detailOverlay) {
            detailOverlay.addEventListener('click', (e) => {
                if (e.target === detailOverlay) {
                    this.closeDetailModal();
                }
            });
        }
    }

    async loadAppointments() {
        try {
            // Show loading state
            this.showLoading();

            // Build query string
            const params = new URLSearchParams();
            if (this.currentFilters.date) params.append('date', this.currentFilters.date);
            if (this.currentFilters.poli_id && this.currentFilters.poli_id !== 'semua') params.append('poli_id', this.currentFilters.poli_id);
            if (this.currentFilters.doctor_id && this.currentFilters.doctor_id !== 'semua') params.append('doctor_id', this.currentFilters.doctor_id);
            if (this.currentFilters.payment_method_id && this.currentFilters.payment_method_id !== 'semua') params.append('payment_method_id', this.currentFilters.payment_method_id);
            if (this.currentFilters.search) params.append('search', this.currentFilters.search);
            params.append('page', this.currentPage);
            params.append('per_page', this.perPage);

            // Use session auth (credentials: include sends session cookie)
            const response = await fetch(`/admin/api/registration/appointments?${params}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
                credentials: 'include' // Send session cookie
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => null);
                console.error('API Error:', response.status, errorData);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.populateTable(data.data);
            this.updatePagination(data);
            
        } catch (error) {
            console.error('Error loading appointments:', error);
            this.showError('Gagal memuat data. Silakan coba lagi. (Lihat console untuk detail)');
        }
    }

    populateTable(appointments) {
        const tbody = document.querySelector('.reg-table tbody');
        
        if (!tbody) {
            console.warn('Table tbody not found');
            return;
        }

        // Clear existing rows
        tbody.innerHTML = '';

        if (appointments.length === 0) {
            tbody.innerHTML = '<tr><td colspan="11" style="text-align: center; padding: 20px;">Tidak ada data</td></tr>';
            return;
        }

        appointments.forEach((apt, index) => {
                const row = this.createTableRow(apt, index + 1);
            tbody.appendChild(row);
        });
    }

    createTableRow(apt, itemNumber) {
        const row = document.createElement('tr');
        
        // Format dates
        const visitDate = new Date(apt.appointment_datetime);
        const createdDate = apt.registration_date ? new Date(apt.registration_date) : null;
        
        const visitDateStr = this.formatDate(visitDate);
        const visitTimeStr = this.formatTime(visitDate);
        const createdDateStr = createdDate ? this.formatDate(createdDate) : '-';
        const createdTimeStr = createdDate ? this.formatTime(createdDate) : '-';

        // Status badge
        const statusColor = this.getStatusColor(apt.status);
        const statusBadge = `<span class="reg-status ${apt.status}">${this.formatStatus(apt.status)}</span>`;

        // Patient info
        const patientAge = apt.patient ? this.calculateAge(apt.patient.date_of_birth) : '-';
        const patientInfo = `${apt.patient?.full_name || '-'}<br>MR${apt.patient?.medical_record_no || '-'}<br>${patientAge} Tahun`;

        // Doctor name
        const doctorName = apt.doctor?.full_name ? 
            `${apt.doctor.title_prefix || ''} ${apt.doctor.full_name}`.trim() : '-';

        // Payment method
        const paymentMethod = apt.payment_method?.name || '-';

        // Complaint/procedure plan
        const medicalNotes = apt.procedure_plan || apt.complaint || '-';

        row.innerHTML = `
            <td data-label="Status">${statusBadge}</td>
            <td data-label="Tanggal Kunjungan">${visitDateStr},<br>${visitTimeStr}</td>
            <td data-label="Tanggal Dibuat">${createdDateStr},<br>${createdTimeStr}</td>
            <td data-label="No">${itemNumber}</td>
            <td data-label="Poli">${apt.poli?.name || '-'}</td>
            <td data-label="Nama Pasien">${patientInfo}</td>
            <td data-label="Rencana Tindakan">${apt.procedure_plan || '-'}</td>
            <td data-label="Dokter Pemeriksa">${doctorName}</td>
            <td data-label="Metode Bayar">${paymentMethod}</td>
            <td data-label="Catatan Medis">${medicalNotes}</td>
            <td data-label="Aksi">
                <button class="reg-btn-outline" style="padding: 4px 8px;" onclick="regManager.showDetail('${apt.id}')">Detail</button>
            </td>
        `;

        return row;
    }

    formatDate(date) {
        if (!date) return '-';
        const d = new Date(date);
        return d.toLocaleDateString('id-ID', { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit' 
        }).replace(/\//g, '/');
    }

    formatTime(date) {
        if (!date) return '-';
        const d = new Date(date);
        return d.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: false
        });
    }

    formatStatus(status) {
        const statusMap = {
            'pending': 'Pending',
            'confirmed': 'Confirmed',
            'waiting': 'Waiting',
            'engaged': 'Engaged',
            'succeed': 'Succeed'
        };
        return statusMap[status] || status;
    }

    getStatusColor(status) {
        const colorMap = {
            'pending': '#EF4444',
            'confirmed': '#F59E0B',
            'waiting': '#8B5CF6',
            'engaged': '#3B82F6',
            'succeed': '#84CC16'
        };
        return colorMap[status] || '#999';
    }

    calculateAge(birthDate) {
        if (!birthDate) return '-';
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        
        return age;
    }

    updatePagination(data) {
        const pageInfo = document.querySelector('.reg-page-info');
        const prevBtn = document.querySelectorAll('.reg-page-btn')[0];
        const nextBtn = document.querySelectorAll('.reg-page-btn')[1];

        if (pageInfo) {
            const from = (data.current_page - 1) * data.per_page + 1;
            const to = Math.min(data.current_page * data.per_page, data.total);
            pageInfo.textContent = `${from}-${to} Dari ${data.total} Data`;
        }

        if (prevBtn) {
            prevBtn.disabled = data.current_page <= 1;
        }

        if (nextBtn) {
            nextBtn.disabled = data.current_page >= data.last_page;
        }
    }

    async showDetail(appointmentId) {
        this.currentDetailAppointmentId = appointmentId;
        const modal = document.getElementById('regDetailModal');
        const modalBody = document.getElementById('regDetailBody');

        if (!modal || !modalBody) return;

        modal.style.display = 'flex';
        modalBody.innerHTML = 'Memuat detail...';

        try {
            const response = await fetch(`/admin/appointments/${appointmentId}/detail`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
                credentials: 'include'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            if (!result.success || !result.data) {
                throw new Error('Data detail registrasi tidak ditemukan');
            }

            modalBody.innerHTML = this.buildDetailHtml(result.data);
        } catch (error) {
            console.error('Error loading detail:', error);
            modalBody.innerHTML = '<p style="color:#EF4444;">Gagal memuat detail registrasi.</p>';
        }
    }

    closeDetailModal() {
        const modal = document.getElementById('regDetailModal');
        if (modal) {
            modal.style.display = 'none';
        }
        this.currentDetailAppointmentId = null;
    }

    buildDetailHtml(data) {
        const patient = data.patient || {};
        const doctor = data.doctor || {};
        const poli = data.poli || {};

        const appointmentDate = data.appointment_datetime
            ? new Date(data.appointment_datetime).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' })
            : '-';

        const registrationDate = data.registration_date
            ? new Date(data.registration_date).toLocaleDateString('id-ID', { dateStyle: 'full' })
            : '-';

        const gender = this.formatGender(patient.gender);
        const age = this.calculateAge(patient.date_of_birth);

        return `
            <div class="reg-detail-grid">
                <div class="reg-detail-item"><span>ID Registrasi</span><strong>${data.id || '-'}</strong></div>
                <div class="reg-detail-item"><span>Status</span><strong><span class="reg-status ${data.status || ''}">${this.formatStatus(data.status || '-')}</span></strong></div>
                <div class="reg-detail-item"><span>Nama Pasien</span><strong>${patient.full_name || '-'}</strong></div>
                <div class="reg-detail-item"><span>No RM</span><strong>${patient.medical_record_no || '-'}</strong></div>
                <div class="reg-detail-item"><span>Jenis Kelamin</span><strong>${gender}</strong></div>
                <div class="reg-detail-item"><span>Umur</span><strong>${age === '-' ? '-' : `${age} Tahun`}</strong></div>
                <div class="reg-detail-item"><span>Nomor HP</span><strong>${patient.phone_number || '-'}</strong></div>
                <div class="reg-detail-item"><span>Alamat</span><strong>${patient.address || '-'}</strong></div>
                <div class="reg-detail-item"><span>Dokter Pemeriksa</span><strong>${doctor.full_title || doctor.full_name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Poli</span><strong>${poli.name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Tanggal Kunjungan</span><strong>${appointmentDate}</strong></div>
                <div class="reg-detail-item"><span>Tanggal Registrasi</span><strong>${registrationDate}</strong></div>
                <div class="reg-detail-item"><span>Metode Pembayaran</span><strong>${data.payment_method?.name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Jenis Kunjungan</span><strong>${data.visit_type?.name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Jenis Perawatan</span><strong>${data.care_type?.name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Jenis Penjamin</span><strong>${data.guarantor_type?.name || '-'}</strong></div>
                <div class="reg-detail-item"><span>Tipe Pasien</span><strong>${data.patient_type || '-'}</strong></div>
                <div class="reg-detail-item"><span>Durasi</span><strong>${data.duration_minutes ? `${data.duration_minutes} menit` : '-'}</strong></div>
                <div class="reg-detail-item full"><span>Keluhan</span><strong>${data.complaint || '-'}</strong></div>
                <div class="reg-detail-item full"><span>Kondisi Pasien</span><strong>${data.patient_condition || '-'}</strong></div>
                <div class="reg-detail-item full"><span>Rencana Tindakan</span><strong>${data.procedure_plan || '-'}</strong></div>
            </div>

            <div class="reg-detail-actions">
                <select id="regDetailStatusSelect">
                    <option value="pending" ${data.status === 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="confirmed" ${data.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                    <option value="waiting" ${data.status === 'waiting' ? 'selected' : ''}>Waiting</option>
                    <option value="engaged" ${data.status === 'engaged' ? 'selected' : ''}>Engaged</option>
                    <option value="succeed" ${data.status === 'succeed' ? 'selected' : ''}>Succeed</option>
                </select>

                <button type="button" class="reg-detail-emr-btn" onclick="regManager.openEmrFromDetail()">Lihat Rekam Medis</button>
                <button type="button" class="reg-detail-save-btn" onclick="regManager.saveStatusFromDetail()">Update Status</button>
            </div>
        `;
    }

    formatGender(gender) {
        if (!gender) return '-';
        const normalized = String(gender).toLowerCase();
        if (normalized === 'm' || normalized === 'male' || normalized === 'l' || normalized === 'laki-laki') {
            return 'Laki-laki';
        }
        if (normalized === 'f' || normalized === 'female' || normalized === 'p' || normalized === 'perempuan') {
            return 'Perempuan';
        }
        return gender;
    }

    openEmrFromDetail() {
        if (!this.currentDetailAppointmentId) return;
        sessionStorage.setItem('autoSelectAppointmentId', this.currentDetailAppointmentId);
        window.location.href = '/admin/emr';
    }

    async saveStatusFromDetail() {
        if (!this.currentDetailAppointmentId) return;

        const select = document.getElementById('regDetailStatusSelect');
        if (!select) return;

        try {
            const response = await fetch(`/admin/appointments/${this.currentDetailAppointmentId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                credentials: 'include',
                body: JSON.stringify({ status: select.value })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            if (result.success) {
                this.closeDetailModal();
                this.loadAppointments();
            }
        } catch (error) {
            console.error('Error updating status:', error);
            alert('Gagal update status');
        }
    }

    showLoading() {
        const tbody = document.querySelector('.reg-table tbody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="11" style="text-align: center; padding: 20px;">Loading...</td></tr>';
        }
    }

    showError(message) {
        const tbody = document.querySelector('.reg-table tbody');
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="11" style="text-align: center; padding: 20px; color: red;">${message}</td></tr>`;
        }
    }

}

// Initialize when DOM is ready
let regManager;
document.addEventListener('DOMContentLoaded', function() {
    regManager = new RegistrationManager();
});
