/**
 * RawatJalanManager - Manage Rawat Jalan (Outpatient) Page
 * Displays all registered patients for a specific date with filters and modal popup
 */

class RawatJalanManager {
    constructor() {
        this.currentDate = this.getTodayDate();
        this.currentDoctorId = null;
        this.currentStatus = null;
        this.searchQuery = '';
        this.appointments = [];
        this.selectedAppointment = null;

        this.init();
    }

    /**
     * Initialize event listeners and load initial data
     */
    init() {
        try {
            console.log('[RawatJalan] Initializing...');

            // Event listeners
            document.getElementById('dateInput')?.addEventListener('change', (e) => {
                this.currentDate = e.target.value;
                this.loadAppointments();
            });

            document.getElementById('doctorFilter')?.addEventListener('change', (e) => {
                this.currentDoctorId = e.target.value || null;
                this.loadAppointments();
            });

            document.getElementById('statusFilter')?.addEventListener('change', (e) => {
                this.currentStatus = e.target.value || null;
                this.loadAppointments();
            });

            document.getElementById('searchInput')?.addEventListener('input', (e) => {
                this.searchQuery = e.target.value.trim();
                // Debounce search - reload after 300ms of no typing
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => this.loadAppointments(), 300);
            });

            document.getElementById('todayBtn')?.addEventListener('click', () => {
                this.currentDate = this.getTodayDate();
                document.getElementById('dateInput').value = this.currentDate;
                this.loadAppointments();
            });

            // Close modal on outside click
            const modal = document.getElementById('appointmentModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        this.closeModal();
                    }
                });
            }

            // Initial load
            document.getElementById('dateInput').value = this.currentDate;
            this.loadAppointments();

            console.log('[RawatJalan] Initialization complete');
        } catch (error) {
            console.error('[RawatJalan] Init error:', error);
            this.showError('Gagal menginisalisasi halaman');
        }
    }

    /**
     * Get today's date in YYYY-MM-DD format
     */
    getTodayDate() {
        return new Date().toISOString().split('T')[0];
    }

    /**
     * Load appointments from backend
     */
    async loadAppointments() {
        try {
            const params = new URLSearchParams({
                date: this.currentDate,
            });

            if (this.currentDoctorId) params.append('doctor_id', this.currentDoctorId);
            if (this.currentStatus) params.append('status', this.currentStatus);
            if (this.searchQuery) params.append('search', this.searchQuery);

            const response = await fetch(`/admin/api/rawat-jalan/appointments?${params}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Gagal memuat data');
            }

            this.appointments = result.data || [];
            this.populateTable();

            console.log(`[RawatJalan] Loaded ${this.appointments.length} appointments for ${this.currentDate}`);
        } catch (error) {
            console.error('[RawatJalan] Load error:', error);
            this.showError('Gagal memuat data. Silakan coba lagi');
        }
    }

    /**
     * Populate the appointments table
     */
    populateTable() {
        const tbody = document.querySelector('#appointmentTable tbody');
        if (!tbody) return;

        if (this.appointments.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <p>Tidak ada data pasien untuk tanggal ini</p>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = this.appointments.map((apt, idx) => this.createTableRow(apt, idx)).join('');

        // Add click event listeners
        document.querySelectorAll('tbody tr').forEach((row, idx) => {
            row.addEventListener('click', () => {
                this.showModal(this.appointments[idx]);
            });
            row.style.cursor = 'pointer';
        });
    }

    /**
     * Create a table row for an appointment
     */
    createTableRow(apt, idx) {
        const patient = apt.patient || {};
        const doctor = apt.doctor || {};
        const time = this.formatTime(apt.appointment_datetime);
        const dateObj = new Date(apt.appointment_datetime);
        const age = this.calculateAge(patient.date_of_birth);

        // Status badge styling
        const statusColors = {
            pending: '#ef4444',
            confirmed: '#f59e0b',
            waiting: '#3b82f6',
            engaged: '#8b5cf6',
            succeed: '#10b981',
        };
        const statusColor = statusColors[apt.status] || '#6b7280';

        return `
            <tr class="appointment-row" data-appointment-id="${apt.id}">
                <td class="col-no">${idx + 1}</td>
                <td class="col-time">
                    <span class="time-badge">${time}</span>
                </td>
                <td class="col-patient">
                    <div class="patient-info">
                        <div class="patient-name">${this.escapeHtml(patient.full_name || 'N/A')}</div>
                        <div class="patient-mr">RM: ${this.escapeHtml(patient.medical_record_no || '-')}</div>
                    </div>
                </td>
                <td class="col-doctor">${this.escapeHtml(doctor.full_title || 'N/A')}</td>
                <td class="col-age">${age ?? '-'} tahun</td>
                <td class="col-status">
                    <span class="status-badge" style="background-color: ${statusColor}">
                        ${this.capitalizeFirst(apt.status)}
                    </span>
                </td>
            </tr>
        `;
    }

    /**
     * Show modal with appointment details
     */
    showModal(apt) {
        this.selectedAppointment = apt;
        const patient = apt.patient || {};
        const doctor = apt.doctor || {};

        const dateTime = new Date(apt.appointment_datetime);
        const formattedDate = dateTime.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
        const formattedTime = dateTime.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
        });

        const age = this.calculateAge(patient.date_of_birth);

        // Status color
        const statusColors = {
            pending: '#ef4444',
            confirmed: '#f59e0b',
            waiting: '#3b82f6',
            engaged: '#8b5cf6',
            succeed: '#10b981',
        };
        const statusColor = statusColors[apt.status] || '#6b7280';

        const modalContent = `
            <div class="modal-content-container">
                <div class="modal-header-section">
                    <h2>Detail Pasien Rawat Jalan</h2>
                    <button id="closeModalBtn" class="close-btn">&times;</button>
                </div>

                <div class="modal-body">
                    <!-- Patient Info -->
                    <div class="info-section">
                        <h3>Informasi Pasien</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Nama Pasien</label>
                                <p>${this.escapeHtml(patient.full_name || 'N/A')}</p>
                            </div>
                            <div class="info-item">
                                <label>No. RM</label>
                                <p>${this.escapeHtml(patient.medical_record_no || '-')}</p>
                            </div>
                            <div class="info-item">
                                <label>Umur</label>
                                <p>${age ?? '-'} tahun</p>
                            </div>
                            <div class="info-item">
                                <label>Jenis Kelamin</label>
                                <p>${patient.gender === 'M' ? 'Laki-laki' : patient.gender === 'F' ? 'Perempuan' : 'N/A'}</p>
                            </div>
                            <div class="info-item">
                                <label>No. Telepon</label>
                                <p>${this.escapeHtml(patient.phone_number || '-')}</p>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <p>${this.escapeHtml(patient.email || '-')}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Info -->
                    <div class="info-section">
                        <h3>Informasi Jadwal</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Dokter</label>
                                <p>${this.escapeHtml(doctor.full_title || 'N/A')}</p>
                            </div>
                            <div class="info-item">
                                <label>Tanggal</label>
                                <p>${formattedDate}</p>
                            </div>
                            <div class="info-item">
                                <label>Jam</label>
                                <p>${formattedTime}</p>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                <p>
                                    <span class="status-badge" style="background-color: ${statusColor}">
                                        ${this.capitalizeFirst(apt.status)}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="info-section">
                        <h3>Alamat</h3>
                        <p>${this.escapeHtml(patient.address || '-')}</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="emrBtn" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lihat Rekam Medis
                    </button>
                    <button id="statusBtn" class="btn btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m7-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Status
                    </button>
                </div>
            </div>
        `;

        const modal = document.getElementById('appointmentModal');
        modal.innerHTML = modalContent;
        modal.classList.add('active');

        // Add event listeners to buttons
        document.getElementById('emrBtn').addEventListener('click', () => {
            this.goToEMR(apt.patient_id);
        });

        document.getElementById('statusBtn').addEventListener('click', () => {
            this.showStatusUpdateForm();
        });

        document.getElementById('closeModalBtn').addEventListener('click', (e) => {
            e.preventDefault();
            this.closeModal();
        });
    }

    /**
     * Show status update form in modal
     */
    showStatusUpdateForm() {
        if (!this.selectedAppointment) return;

        const apt = this.selectedAppointment;
        const currentStatus = apt.status;
        
        // Define status progression
        const statusOptions = [
            { value: 'pending', label: 'Menunggu Konfirmasi', color: '#ef4444' },
            { value: 'confirmed', label: 'Terkonfirmasi', color: '#f59e0b' },
            { value: 'waiting', label: 'Menunggu Dipanggil', color: '#3b82f6' },
            { value: 'engaged', label: 'Sedang Dilayani', color: '#8b5cf6' },
            { value: 'succeed', label: 'Selesai', color: '#10b981' },
        ];

        const statusFormHTML = `
            <div class="modal-content-container">
                <div class="modal-header-section">
                    <h2>Update Status Pasien</h2>
                    <button id="closeModalBtn" class="close-btn">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="status-form">
                        <label>Pilih Status Baru:</label>
                        <div class="status-options">
                            ${statusOptions.map(option => `
                                <div class="status-option">
                                    <input type="radio" id="status-${option.value}" name="appointmentStatus" 
                                           value="${option.value}" ${currentStatus === option.value ? 'checked' : ''}>
                                    <label for="status-${option.value}" style="border-left-color: ${option.color}">
                                        <span class="radio-label">${option.label}</span>
                                    </label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="cancelBtn" class="btn btn-secondary">Batal</button>
                    <button id="confirmStatusBtn" class="btn btn-primary">Simpan Status</button>
                </div>
            </div>
        `;

        const modal = document.getElementById('appointmentModal');
        modal.innerHTML = statusFormHTML;

        document.getElementById('closeModalBtn').addEventListener('click', (e) => {
            e.preventDefault();
            this.closeModal();
        });

        document.getElementById('cancelBtn').addEventListener('click', () => {
            this.closeModal();
        });

        document.getElementById('confirmStatusBtn').addEventListener('click', async () => {
            const newStatus = document.querySelector('input[name="appointmentStatus"]:checked')?.value;
            if (newStatus) {
                await this.updateStatus(newStatus);
            }
        });
    }

    /**
     * Update appointment status
     */
    async updateStatus(newStatus) {
        if (!this.selectedAppointment) return;

        try {
            const response = await fetch(`/admin/appointments/${this.selectedAppointment.id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                credentials: 'include',
                body: JSON.stringify({ status: newStatus }),
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const result = await response.json();
            
            if (result.success) {
                this.showSuccess('Status berhasil diupdate');
                this.closeModal();
                this.loadAppointments();
            } else {
                throw new Error(result.error || 'Gagal update status');
            }
        } catch (error) {
            console.error('[RawatJalan] Update status error:', error);
            this.showError('Gagal mengupdate status. Silakan coba lagi');
        }
    }

    /**
     * Navigate to EMR page for patient
     */
    goToEMR(patientId) {
        if (!this.selectedAppointment) {
            this.showError('Data appointment tidak ditemukan');
            return;
        }

        // Store appointment ID in session storage for EMR page to auto-select
        sessionStorage.setItem('autoSelectAppointmentId', this.selectedAppointment.id);
        
        // Redirect to EMR page
        window.location.href = '/admin/emr';
    }

    /**
     * Close modal
     */
    closeModal() {
        const modal = document.getElementById('appointmentModal');
        if (modal) {
            modal.classList.remove('active');
            modal.innerHTML = '';
        }
        this.selectedAppointment = null;
    }

    /**
     * Format time from datetime string
     */
    formatTime(dateTimeStr) {
        if (!dateTimeStr) return '-';
        const date = new Date(dateTimeStr);
        return date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        });
    }

    /**
     * Calculate age from date of birth
     */
    calculateAge(dateOfBirth) {
        if (!dateOfBirth) return null;
        const birthDate = new Date(dateOfBirth);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age > 0 ? age : 0;
    }

    /**
     * Capitalize first letter
     */
    capitalizeFirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    /**
     * Escape HTML special characters
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Show error message
     */
    showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-error';
        errorDiv.textContent = message;
        document.body.insertBefore(errorDiv, document.body.firstChild);
        setTimeout(() => errorDiv.remove(), 5000);
    }

    /**
     * Show success message
     */
    showSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'alert alert-success';
        successDiv.textContent = message;
        document.body.insertBefore(successDiv, document.body.firstChild);
        setTimeout(() => successDiv.remove(), 5000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('[RawatJalan] DOM loaded, initializing manager...');
    window.rawatJalanManager = new RawatJalanManager();
});
