/**
 * EMR Page - Electronic Medical Record Queue Management
 * Script untuk fetch dan display patient queue dari backend
 */

class EMRManager {
    constructor() {
        this.filterWaktu = 'hari_ini';
        this.searchQuery = '';
        this.appointments = [];
        this.patientHistory = [];
        this.patientDoctorNotes = [];
        this.selectedAppointment = null;
        this.currentDiagnosisAppointmentId = null;
        this.activeTab = 'timeline';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadAppointments();
    }

    setupEventListeners() {
        // Filter waktu dropdown
        const filterOptions = document.querySelectorAll('.emr-option');
        filterOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.stopPropagation();
                
                const value = option.dataset.value;
                this.filterWaktu = value;
                
                // Update UI
                document.querySelectorAll('.emr-option').forEach(opt => opt.classList.remove('is-selected'));
                option.classList.add('is-selected');
                document.querySelector('.emr-select-text').textContent = option.textContent;
                document.getElementById('filterWaktuVal').value = value;
                
                this.loadAppointments();
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const filterDropdown = document.getElementById('customFilterDropdown');
            if (filterDropdown && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.remove('open');
            }
        });

        // Search pasien di navbar kiri atas (EMR)
        const searchInput = document.querySelector('.navbar-search-input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.searchQuery = (e.target.value || '').trim();
                    this.loadAppointments();
                }, 250);
            });

            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.searchQuery = (e.target.value || '').trim();
                    this.loadAppointments();
                }
            });
        }

        // Diagnosis modal events
        const diagnosisModal = document.getElementById('emrDiagnosisModal');
        const diagnosisCloseBtn = document.getElementById('emrDiagnosisCloseBtn');
        const diagnosisCancelBtn = document.getElementById('emrDiagnosisCancelBtn');

        if (diagnosisCloseBtn) {
            diagnosisCloseBtn.addEventListener('click', () => this.closeDiagnosisModal());
        }

        if (diagnosisCancelBtn) {
            diagnosisCancelBtn.addEventListener('click', () => this.closeDiagnosisModal());
        }

        if (diagnosisModal) {
            diagnosisModal.addEventListener('click', (e) => {
                if (e.target === diagnosisModal) {
                    this.closeDiagnosisModal();
                }
            });
        }
    }

    async loadAppointments() {
        try {
            this.showLoadingState();

            const params = new URLSearchParams({
                filter_waktu: this.filterWaktu,
                search: this.searchQuery
            });

            // Use session auth (credentials: include sends session cookie)
            const response = await fetch(`/admin/api/registration/appointments-emr?${params}`, {
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

            const result = await response.json();
            this.appointments = result.data;
            
            if (result.count === 0) {
                this.showEmptyState();
            } else {
                this.displayQueue();
                
                // Auto-select appointment if coming from Rawat Jalan page
                const autoSelectId = sessionStorage.getItem('autoSelectAppointmentId');
                if (autoSelectId) {
                    sessionStorage.removeItem('autoSelectAppointmentId');
                    const apt = this.appointments.find(a => String(a.id) === String(autoSelectId));
                    if (apt) {
                        // Delay slightly to ensure DOM is updated
                        setTimeout(() => this.selectPatient(String(autoSelectId)), 100);
                    } else {
                        this.selectPatient(this.appointments[0].id);
                    }
                } else {
                    this.selectPatient(this.appointments[0].id);
                }
            }
            
        } catch (error) {
            console.error('Error loading appointments:', error);
            this.showErrorState('Gagal memuat data antrean (Lihat console untuk detail)');
        }
    }

    displayQueue() {
        const sidebar = document.querySelector('.emr-sidebar');
        const mainContent = document.querySelector('.emr-main');
        
        if (!sidebar || !mainContent) return;

        // Update queue alert with count
        const queueAlert = sidebar.querySelector('.emr-queue-alert');
        if (queueAlert) {
            queueAlert.innerHTML = `
                <div style="padding: 12px; background-color: #F0F9FF; border-left: 4px solid #3B82F6; border-radius: 4px;">
                    <strong>${this.appointments.length} Pasien</strong> menunggu pemeriksaan
                </div>
            `;
        }

        // Build queue list
        const queueList = document.createElement('div');
        queueList.className = 'emr-queue-list';
        queueList.innerHTML = this.appointments.map((apt) => {
            const statusColor = this.getStatusColor(apt.status);
            const statusText = this.formatStatus(apt.status);
            const visitTime = new Date(apt.appointment_datetime).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            return `
                <div class="emr-queue-item" data-appointment-id="${apt.id}" onclick="emrManager.selectPatient('${apt.id}')">
                    <div class="emr-queue-item-inner" style="border-left-color: ${statusColor};">
                        <div class="emr-queue-name">${apt.patient?.full_name || 'Unknown'}</div>
                        <div class="emr-queue-meta">MR: ${apt.patient?.medical_record_no || '-'}</div>
                        <div class="emr-queue-footer">
                            <span class="emr-mini-badge" style="background-color: ${statusColor};">${statusText}</span>
                            <span class="emr-queue-time">${visitTime}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Replace sidebar queue list
        const existingList = sidebar.querySelector('.emr-queue-list');
        if (existingList) {
            existingList.remove();
        }
        sidebar.appendChild(queueList);

        // Pemilihan pasien dilakukan di loadAppointments
    }

    async displayPatientDetail(apt) {
        const mainContent = document.querySelector('.emr-main');
        
        if (!mainContent) return;

        this.selectedAppointment = apt;
        this.activeTab = 'timeline';

        const age = this.calculateAge(apt.patient?.date_of_birth);
        const gender = this.formatGender(apt.patient?.gender);
        const ageText = age === '-' ? '-' : `${age} Tahun`;
        mainContent.innerHTML = `
            <div class="emr-record-wrap">
                <section class="emr-patient-card">
                    <div class="emr-patient-avatar-wrap">
                        <div class="emr-patient-avatar"></div>
                    </div>
                    <div class="emr-patient-summary">
                        <div class="emr-patient-summary-top">
                            <div>
                                <h2 class="emr-patient-name">${apt.patient?.full_name || '-'}</h2>
                                <p class="emr-patient-brief">${apt.patient?.medical_record_no || '-'} · ${gender} · ${ageText}</p>
                                <p class="emr-patient-dob">${this.formatBirthDate(apt.patient?.date_of_birth)}</p>
                            </div>
                            <button class="emr-edit-btn" onclick="emrManager.openPatientRecord('${apt.id}')">EDIT DATA DIRI</button>
                        </div>

                        <div class="emr-info-row">
                            <div class="emr-info-cell">
                                <span class="emr-info-label">Alamat Rumah</span>
                                <span class="emr-info-value">${apt.patient?.address || '-'}</span>
                            </div>
                            <div class="emr-info-cell">
                                <span class="emr-info-label">Nomor KTP</span>
                                <span class="emr-info-value">${apt.patient?.id_card_number || '-'}</span>
                            </div>
                            <div class="emr-info-cell">
                                <span class="emr-info-label">Nomor HP</span>
                                <span class="emr-info-value">${apt.patient?.phone_number || '-'}</span>
                            </div>
                            <button class="emr-more-link" onclick="emrManager.openPatientRecord('${apt.id}')">Lihat data lainnya ></button>
                        </div>
                    </div>
                </section>

                <section class="emr-registration-card">
                    <div class="emr-registration-head">
                        <h3>INFORMASI REGISTRASI</h3>
                        <div class="emr-status-control">
                            <select id="emrDetailStatusSelect" class="emr-status-select">
                                <option value="pending" ${apt.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="confirmed" ${apt.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="waiting" ${apt.status === 'waiting' ? 'selected' : ''}>Waiting</option>
                                <option value="engaged" ${apt.status === 'engaged' ? 'selected' : ''}>Engaged</option>
                                <option value="succeed" ${apt.status === 'succeed' ? 'selected' : ''}>Succeed</option>
                            </select>
                            <button class="emr-main-btn" onclick="emrManager.applyDetailStatus()">UPDATE STATUS</button>
                            <button class="emr-diagnosis-btn" onclick="emrManager.openDiagnosisModal('${apt.id}')">DIAGNOSA</button>
                        </div>
                    </div>
                    ${this.renderRegistrationInfo(apt)}
                </section>

                <nav class="emr-record-tabs">
                    <button class="emr-tab active" data-tab="timeline" onclick="emrManager.switchTab('timeline')">TIMELINE</button>
                    <button class="emr-tab" data-tab="catatan-dokter" onclick="emrManager.switchTab('catatan-dokter')">CATATAN DOKTER</button>
                </nav>

                <section id="emrTabContent"></section>
            </div>
        `;

        this.markSelectedQueueItem(apt.id);
        await this.loadPatientData(apt.patient?.id || apt.patient_id || null, apt.id);
        this.renderActiveTab();
    }

    async selectPatient(appointmentId) {
        const apt = this.appointments.find(a => String(a.id) === String(appointmentId));
        if (apt) {
            await this.displayPatientDetail(apt);
        }
    }

    async loadPatientData(patientId, appointmentId = null) {
        if (!patientId && !appointmentId) {
            this.patientHistory = [];
            this.patientDoctorNotes = [];
            return;
        }

        try {
            const params = new URLSearchParams();
            if (patientId) params.append('patient_id', patientId);
            if (appointmentId) params.append('appointment_id', appointmentId);
            const response = await fetch(`/admin/api/emr/patient-data?${params}`, {
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
            if (result.success && result.data) {
                this.patientHistory = result.data.history || [];
                this.patientDoctorNotes = result.data.doctor_notes || [];

                if (this.patientHistory.length === 0 && this.selectedAppointment) {
                    // Fallback agar registrasi terpilih tetap tampil di timeline
                    this.patientHistory = [
                        {
                            id: this.selectedAppointment.id,
                            appointment_datetime: this.selectedAppointment.appointment_datetime,
                            registration_date: this.selectedAppointment.registration_date,
                            status: this.selectedAppointment.status,
                            status_color: this.getStatusColor(this.selectedAppointment.status),
                            complaint: this.selectedAppointment.complaint,
                            procedure_plan: this.selectedAppointment.procedure_plan,
                            doctor_name: this.selectedAppointment.doctor?.full_name,
                            poli_name: this.selectedAppointment.poli?.name,
                            payment_method_name: this.selectedAppointment.payment_method?.name,
                        },
                    ];
                }
            } else {
                this.patientHistory = [];
                this.patientDoctorNotes = [];
            }
        } catch (error) {
            console.error('Error loading EMR patient data:', error);
            this.patientHistory = [];
            this.patientDoctorNotes = [];
        }
    }

    switchTab(tabName) {
        this.activeTab = tabName;

        const tabButtons = document.querySelectorAll('.emr-tab');
        tabButtons.forEach((btn) => {
            btn.classList.toggle('active', btn.dataset.tab === tabName);
        });

        this.renderActiveTab();
    }

    renderActiveTab() {
        const tabContent = document.getElementById('emrTabContent');
        if (!tabContent || !this.selectedAppointment) return;

        if (this.activeTab === 'timeline') {
            tabContent.innerHTML = this.renderTimelineTab();
            return;
        }

        if (this.activeTab === 'catatan-dokter') {
            tabContent.innerHTML = this.renderDoctorNotesTab();
            return;
        }

        tabContent.innerHTML = this.renderTimelineTab();
    }

    renderRegistrationInfo(apt) {
        const appointmentDate = this.formatDateTime(apt.appointment_datetime);
        const registrationDate = apt.registration_date
            ? new Date(apt.registration_date).toLocaleDateString('id-ID')
            : '-';

        const fields = [
            ['ID Registrasi', apt.id],
            ['Tanggal Registrasi', registrationDate],
            ['Jadwal Kunjungan', appointmentDate],
            ['Dokter', apt.doctor?.full_name],
            ['Poli', apt.poli?.name],
            ['Metode Pembayaran', apt.payment_method?.name],
            ['Jenis Kunjungan', apt.visit_type?.name],
            ['Jenis Perawatan', apt.care_type?.name],
            ['Jenis Penjamin', apt.guarantor_type?.name],
            ['Tipe Pasien', apt.patient_type],
            ['Keluhan', apt.complaint],
            ['Kondisi Pasien', apt.patient_condition],
            ['Rencana Tindakan', apt.procedure_plan],
        ];

        return `
            <div class="emr-registration-grid">
                ${fields.map(([label, value]) => `
                    <div class="emr-registration-item">
                        <span class="emr-registration-label">${label}</span>
                        <span class="emr-registration-value">${this.escapeHtml(value || '-')}</span>
                    </div>
                `).join('')}
            </div>
        `;
    }

    applyDetailStatus() {
        if (!this.selectedAppointment) return;
        const statusSelect = document.getElementById('emrDetailStatusSelect');
        if (!statusSelect) return;
        this.updateStatus(this.selectedAppointment.id, statusSelect.value);
    }

    renderTimelineTab() {
        if (!this.patientHistory.length) {
            return `
                <section class="emr-visit-summary">
                    <div class="emr-visit-body">
                        <p>Belum ada riwayat registrasi pasien.</p>
                    </div>
                </section>
            `;
        }

        const rows = this.patientHistory.map((item) => {
            const dateValue = item.appointment_datetime ? new Date(item.appointment_datetime) : null;
            const dateText = dateValue
                ? dateValue.toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' })
                : '-';

            return `
                <article class="emr-timeline-item">
                    <div class="emr-visit-head">
                        <span class="emr-mini-badge" style="background-color: ${item.status_color || this.getStatusColor(item.status)};">${this.formatStatus(item.status)}</span>
                        <span>${dateText}</span>
                        <span>Dokter: ${item.doctor_name || '-'}</span>
                        <span>Poli: ${item.poli_name || '-'}</span>
                    </div>
                    <div class="emr-visit-body">
                        <p class="emr-visit-complaint-title">Keluhan</p>
                        <p>${item.complaint || 'Tidak ada keluhan tercatat'}</p>
                        <p class="emr-visit-complaint-title">Kondisi Pasien</p>
                        <p>${item.patient_condition || '-'}</p>
                        <p class="emr-visit-complaint-title">Rencana Tindakan</p>
                        <p>${item.procedure_plan || '-'}</p>
                        <p class="emr-visit-complaint-title">Pembayaran</p>
                        <p>${item.payment_method_name || '-'} · ${item.guarantor_type_name || '-'}</p>
                    </div>
                    <div class="emr-visit-actions">
                        <div class="emr-status-control">
                            <select id="emrStatusSelect-${item.id}" class="emr-status-select">
                                <option value="pending" ${item.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="confirmed" ${item.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="waiting" ${item.status === 'waiting' ? 'selected' : ''}>Waiting</option>
                                <option value="engaged" ${item.status === 'engaged' ? 'selected' : ''}>Engaged</option>
                                <option value="succeed" ${item.status === 'succeed' ? 'selected' : ''}>Succeed</option>
                            </select>
                            <button class="emr-main-btn" onclick="emrManager.applyTimelineStatus('${item.id}')">UPDATE STATUS</button>
                            <button class="emr-diagnosis-btn" onclick="emrManager.openDiagnosisModal('${item.id}')">DIAGNOSA</button>
                        </div>
                    </div>
                </article>
            `;
        }).join('');

        return `<section class="emr-visit-summary emr-timeline-list">${rows}</section>`;
    }

    applyTimelineStatus(appointmentId) {
        const statusSelect = document.getElementById(`emrStatusSelect-${appointmentId}`);
        if (!statusSelect) return;
        this.updateStatus(appointmentId, statusSelect.value);
    }

    renderDoctorNotesTab() {
        if (!this.patientDoctorNotes.length) {
            return `
                <section class="emr-visit-summary">
                    <div class="emr-visit-body">
                        <p>Belum ada catatan dokter.</p>
                    </div>
                </section>
            `;
        }

        const rows = this.patientDoctorNotes.map((note) => {
            const createdAt = note.created_at
                ? new Date(note.created_at).toLocaleDateString('id-ID', { dateStyle: 'medium' })
                : '-';

            return `
                <tr>
                    <td>${createdAt}</td>
                    <td>${note.doctor_name || '-'}</td>
                    <td>${note.author_name || '-'}</td>
                    <td>${note.notes || '-'}</td>
                </tr>
            `;
        }).join('');

        return `
            <section class="emr-visit-summary">
                <div class="emr-doctor-note-head">
                    <h3>CATATAN DOKTER</h3>
                </div>
                <div class="emr-doctor-note-table-wrap">
                    <table class="emr-doctor-note-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Penginput</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            </section>
        `;
    }

    markSelectedQueueItem(appointmentId) {
        const items = document.querySelectorAll('.emr-queue-item');
        items.forEach((item) => {
            item.classList.toggle('active', String(item.dataset.appointmentId) === String(appointmentId));
        });
    }

    getAppointmentById(appointmentId) {
        const selected = this.appointments.find((apt) => String(apt.id) === String(appointmentId));
        if (selected) return selected;

        if (this.selectedAppointment && String(this.selectedAppointment.id) === String(appointmentId)) {
            return this.selectedAppointment;
        }

        const fromHistory = this.patientHistory.find((apt) => String(apt.id) === String(appointmentId));
        if (fromHistory) return fromHistory;

        return null;
    }

    openDiagnosisModal(appointmentId) {
        const modal = document.getElementById('emrDiagnosisModal');
        const textArea = document.getElementById('emrDiagnosisText');
        const title = document.getElementById('emrDiagnosisPatientTitle');
        const subtitle = document.getElementById('emrDiagnosisPatientMeta');

        if (!modal || !textArea) return;

        const apt = this.getAppointmentById(appointmentId);
        if (!apt) {
            alert('Data registrasi tidak ditemukan.');
            return;
        }

        this.currentDiagnosisAppointmentId = String(appointmentId);

        if (title) {
            title.textContent = apt.patient?.full_name || this.selectedAppointment?.patient?.full_name || 'Pasien';
        }

        if (subtitle) {
            const meta = [
                apt.patient?.medical_record_no || this.selectedAppointment?.patient?.medical_record_no || '-',
                this.formatDateTime(apt.appointment_datetime || this.selectedAppointment?.appointment_datetime),
            ];
            subtitle.textContent = meta.join(' · ');
        }

        textArea.value = '';
        modal.classList.add('open');
        setTimeout(() => textArea.focus(), 40);
    }

    closeDiagnosisModal() {
        const modal = document.getElementById('emrDiagnosisModal');
        const textArea = document.getElementById('emrDiagnosisText');
        if (!modal) return;

        modal.classList.remove('open');
        this.currentDiagnosisAppointmentId = null;
        if (textArea) {
            textArea.value = '';
        }
    }

    async saveDiagnosis() {
        if (!this.currentDiagnosisAppointmentId) {
            alert('Registrasi belum dipilih.');
            return;
        }

        const textArea = document.getElementById('emrDiagnosisText');
        const saveBtn = document.getElementById('emrDiagnosisSaveBtn');
        const diagnosisText = (textArea?.value || '').trim();

        if (!diagnosisText) {
            alert('Diagnosa tidak boleh kosong.');
            return;
        }

        const originalText = saveBtn?.textContent;
        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.textContent = 'Menyimpan...';
        }

        try {
            const response = await fetch(`/admin/appointments/${this.currentDiagnosisAppointmentId}/diagnosis`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                credentials: 'include',
                body: JSON.stringify({ diagnosis: diagnosisText }),
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => null);
                throw new Error(errorData?.message || `HTTP error! status: ${response.status}`);
            }

            this.closeDiagnosisModal();
            await this.loadAppointments();
        } catch (error) {
            console.error('Error saving diagnosis:', error);
            alert(error.message || 'Gagal menyimpan diagnosa');
        } finally {
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.textContent = originalText || 'Simpan Diagnosa';
            }
        }
    }

    openPatientRecord(appointmentId) {
        console.log('Open patient record:', appointmentId);
        alert('Fitur EMR detail akan segera tersedia');
    }

    async updateStatus(appointmentId, newStatus) {
        try {
            const response = await fetch(`/admin/appointments/${appointmentId}/status`, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                credentials: 'include',
                body: JSON.stringify({ status: newStatus })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            if (result.success) {
                this.loadAppointments();
            }
        } catch (error) {
            console.error('Error updating status:', error);
            alert('Gagal update status');
        }
    }

    showEmptyState() {
        const mainContent = document.querySelector('.emr-main');
        if (mainContent) {
            mainContent.innerHTML = `
                <div class="emr-empty-state">
                    <img src="/images/empty-queue.png" alt="Tidak ada antrean" class="emr-empty-img">
                    <h2 class="emr-empty-title">Tidak ada antrean pasien${this.filterWaktu === 'hari_ini' ? ' hari ini' : ''}</h2>
                    <p class="emr-empty-desc">Gunakan search bar atau advance search pada pojok kiri atas untuk mencari pasien.</p>
                </div>
            `;
        }
    }

    showLoadingState() {
        const mainContent = document.querySelector('.emr-main');
        if (mainContent) {
            mainContent.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #6B7280;">
                    <div>Loading...</div>
                </div>
            `;
        }
    }

    showErrorState(message) {
        const mainContent = document.querySelector('.emr-main');
        if (mainContent) {
            mainContent.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #EF4444;">
                    <div>${message}</div>
                </div>
            `;
        }
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

    formatBirthDate(dateValue) {
        if (!dateValue) return '-';
        return new Date(dateValue).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }

    formatDateTime(dateValue) {
        if (!dateValue) return '-';
        const date = new Date(dateValue);
        if (Number.isNaN(date.getTime())) return '-';

        return date.toLocaleString('id-ID', {
            dateStyle: 'medium',
            timeStyle: 'short',
        });
    }

    escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

}

// Initialize when DOM is ready
let emrManager;
document.addEventListener('DOMContentLoaded', function() {
    emrManager = new EMRManager();
});
