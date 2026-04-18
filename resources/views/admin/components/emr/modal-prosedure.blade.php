@push('styles')
<style>
/* BACKDROP UTAMA PROSEDUR */
#modalTambahProsedur {
  backdrop-filter: blur(10px);
  background-color: rgba(15, 23, 42, 0.25); /* soft dark overlay, tidak full hitam */
  overflow-y: auto;
  padding: 16px;
}

/* BACKDROP KONFIRMASI */
#modalConfirm {
  backdrop-filter: blur(10px);
  background-color: rgba(15, 23, 42, 0.25);
}

/* MODAL CARD */
#modalTambahProsedur > div {
  border-radius: 16px;
  box-shadow: 0 24px 55px rgba(0, 0, 0, 0.22);
  overflow: hidden;
  max-height: calc(100vh - 32px);
  width: min(100%, 56rem);
}

/* HEADER */
#modalTambahProsedur .modal-header-panel {
  background: linear-gradient(180deg, #fdf7f1 0%, #ffffff 100%);
}

/* BODY */
#modalTambahProsedur .modal-body-panel {
  background: #fffdfa;
  min-height: 0;
  overflow-y: auto;
}

/* FOOTER */
#modalTambahProsedur .modal-footer-panel {
  background: #ffffff;
}

#modalTambahProsedur .modal-shell {
  padding-left: 24px;
  padding-right: 24px;
}

/* SECTION */
#modalTambahProsedur .section-panel {
  border: 0;
  border-radius: 0;
  padding: 0;
  background: transparent;
}

#modalTambahProsedur .patient-meta-card {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 10px;
  border: 1px solid #eadfd3;
  border-radius: 12px;
  background: #fdfaf8;
  padding: 14px;
}

#modalTambahProsedur .patient-meta-item {
  min-width: 0;
}

#modalTambahProsedur .patient-meta-label {
  font-size: 10px;
  color: #6b4b2f;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 2px;
}

#modalTambahProsedur .patient-meta-value {
  font-size: 13px;
  color: #8e6a45;
  font-weight: 700;
}

/* ROW */
#modalTambahProsedur .prosedur-row,
#modalTambahProsedur .obat-row,
#modalTambahProsedur .bhp-row {
  position: relative;
  border-radius: 12px;
  padding: 12px;
  background: #fffdfa;
  align-items: end;
  transition: all 0.2s ease;
}

#modalTambahProsedur .prosedur-row:focus-within {
  z-index: 30;
}

#modalTambahProsedur .obat-row:focus-within {
  z-index: 40;
}

#modalTambahProsedur .bhp-row:focus-within {
  z-index: 20;
}

#modalTambahProsedur .obat-row {
  z-index: 1;
}

#modalTambahProsedur .bhp-row {
  z-index: 1;
}

#modalTambahProsedur .prosedur-row {
  display: grid;
  grid-template-columns: minmax(240px, 1fr) 92px 74px 120px 88px 190px;
  gap: 10px;
}

#modalTambahProsedur .obat-row {
  display: grid;
  grid-template-columns: minmax(220px, 1fr) 84px 32px;
  gap: 10px;
}

#modalTambahProsedur .bhp-row {
  display: grid;
  grid-template-columns: minmax(220px, 1fr) 84px 32px;
  gap: 10px;
}

#modalTambahProsedur .field-prosedur,
#modalTambahProsedur .field-gigi,
#modalTambahProsedur .field-qty,
#modalTambahProsedur .field-price,
#modalTambahProsedur .field-doctor-share,
#modalTambahProsedur .field-actions,
#modalTambahProsedur .field-obat,
#modalTambahProsedur .field-obat-qty,
#modalTambahProsedur .field-obat-delete,
#modalTambahProsedur .field-bhp,
#modalTambahProsedur .field-bhp-qty,
#modalTambahProsedur .field-bhp-delete {
  min-width: 0;
}

#modalTambahProsedur .action-pack {
  display: grid;
  grid-template-columns: 1fr auto auto auto;
  gap: 8px;
  align-items: end;
}

#modalTambahProsedur .action-pack .fix-label {
  color: #6b7280;
  font-size: 12px;
  font-weight: 600;
  padding-bottom: 8px;
}

#modalTambahProsedur .icon-btn {
  height: 34px;
  width: 28px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

#modalTambahProsedur .medis-panel {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 14px;
}

#modalTambahProsedur .prosedur-row:hover,
#modalTambahProsedur .obat-row:hover,
#modalTambahProsedur .bhp-row:hover {
  background: #fdf7f1;
}

/* INPUT */
#modalTambahProsedur .input-underline {
  width: 100%;
  border: 1px solid #d8c7b2;
  border-radius: 10px;
  padding: 8px 10px;
  font-size: 13px;
  color: #5d3f28;
  background: #fffdfb;
  transition: all 0.2s ease;
  min-height: 36px;
}

/* INPUT FOCUS */
#modalTambahProsedur .input-underline:focus {
  border-color: #a67c52;
  box-shadow: 0 0 0 3px rgba(166,124,82,0.14);
  background: #fff;
}

/* DISABLED */
#modalTambahProsedur .input-underline:disabled,
#modalTambahProsedur .input-underline[readonly] {
  color: #9ca3af;
  background: #f7f3ef;
}

/* LABEL */
#modalTambahProsedur .label-small {
  display: block;
  font-size: 11px;
  color: #7a5536;
  margin-bottom: 4px;
  font-weight: 700;
  line-height: 1.1;
  letter-spacing: 0.03em;
}

#modalTambahProsedur .section-heading {
  display: block;
  font-size: 10px;
  color: #7a5536;
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 5px;
}

#modalTambahProsedur .search-field {
  position: relative;
}

#modalTambahProsedur .search-field .search-icon {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 2;
  color: #8e6a45;
}

#modalTambahProsedur .search-field .search-input {
  padding-left: 34px;
}

#modalTambahProsedur .modal-title {
  margin: 0;
  margin-top: 20px;
  font-size: 30px;
  font-weight: 800;
  color: #3b331e;
  letter-spacing: 0.01em;
}

#modalTambahProsedur .modal-close-btn {
  width: 30px;
  height: 30px;
  border: 0;
  border-radius: 8px;
  background: transparent;
  color: #8e6a45;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

#modalTambahProsedur .modal-close-btn:hover {
  color: #6b4b2f;
  background: transparent;
}

#modalTambahProsedur .action-link {
  margin-left: 12px;
  font-size: 10px;
  line-height: 1.1;
  margin-top: 8px;
  display: inline-block;
}

#modalTambahProsedur .info-shift {
  padding-left: 16px;
}

#modalTambahProsedur .asisten-title {
  margin-bottom: 6px;
}

/* ADD ASSISTANT BUTTON STYLING */
#modalTambahProsedur .add-assistant-btn {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 0.02em;
  color: #60a5fa;
  transition: all 0.2s ease;
  text-transform: uppercase;
  display: inline-block;
  margin-top: 6px;
}

#modalTambahProsedur .add-assistant-btn:hover {
  color: #3b82f6;
}

#modalTambahProsedur .modal-header-panel {
  padding-bottom: 8px;
}

#modalTambahProsedur .modal-body-panel {
  padding-top: 16px;
  padding-bottom: 16px;
}

/* INCREASED SPACING BETWEEN SECTIONS */
#modalTambahProsedur #obatContainer {
  margin-bottom: 10px;
}

#modalTambahProsedur #prosedurContainer {
  margin-bottom: 8px;
}

#modalTambahProsedur .footer-layout {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 18px;
  width: 100%;
}

#modalTambahProsedur .footer-layout .total-box {
  text-align: right;
}

#modalTambahProsedur .footer-layout .save-box {
  flex-shrink: 0;
  
}

/* Memperbaiki ukuran tombol agar tidak melar 100% */
#modalTambahProsedur .footer-layout .save-box button {
  width: auto; 
  padding: 9px 15px; 
  font-size: 14px; 
  border-radius: 12px; 
}

/* SEARCH ICON FIX ALIGN */
#modalTambahProsedur svg {
  flex-shrink: 0;
}

/* CLEAR BUTTON */
#modalTambahProsedur button svg {
  pointer-events: none;
}

/* DROPDOWN RESULT */
#modalTambahProsedur .res-container,
#modalTambahProsedur .res-container-prosedur {
  border-radius: 10px;
  margin-top: 6px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  z-index: 9999;
}

/* ITEM RESULT */
#modalTambahProsedur .res-item {
  padding: 10px 12px;
  cursor: pointer;
  font-size: 13px;
  border-bottom: 1px solid #f3f4f6;
  transition: background 0.15s ease;
}

#modalTambahProsedur .res-item:hover {
  background-color: #f3f8ff;
}

/* SCROLLBAR */
#modalTambahProsedur ::-webkit-scrollbar {
  width: 6px;
}
#modalTambahProsedur ::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 6px;
}
#modalTambahProsedur ::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

/* BUTTON SAVE */
#modalTambahProsedur .primary-save-btn {
  background: #A67C52;
  border-radius: 0;
  border: 1px solid #A67C52;
  box-shadow: 0 8px 18px rgba(59, 51, 30, 0.25);
  transition: all 0.2s ease;
}

#modalTambahProsedur .primary-save-btn:hover {
  background: #A67C52;
  transform: translateY(-1px);
}

/* TOTAL HARGA */
#totalHargaDisplay {
  font-size: 22px;
  font-weight: 700;
  color: #374151;
}

/* FIX INPUT NUMBER (HILANG SPINNER) */
#modalTambahProsedur input[type="number"]::-webkit-inner-spin-button,
#modalTambahProsedur input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* RESPONSIVE FIX */
@media (max-width: 1024px) {
  #modalTambahProsedur .prosedur-row {
    grid-template-columns: 1fr 92px 74px 120px 88px;
  }

  #modalTambahProsedur .field-actions {
    grid-column: 1 / -1;
  }
}

@media (max-width: 768px) {
  #modalTambahProsedur {
    padding: 10px;
  }

  #modalTambahProsedur .modal-shell {
    padding-left: 14px;
    padding-right: 14px;
  }

  #modalTambahProsedur .modal-title {
    font-size: 22px;
    margin-top: 14px;
  }

  #modalTambahProsedur .patient-meta-card,
  #modalTambahProsedur .medis-panel {
    grid-template-columns: 1fr;
  }

  #modalTambahProsedur .modal-body-panel {
    padding-top: 12px;
    padding-bottom: 12px;
  }

  #modalTambahProsedur .prosedur-row {
    grid-template-columns: 1fr;
  }

  #modalTambahProsedur .obat-row,
  #modalTambahProsedur .bhp-row {
    grid-template-columns: 1fr;
  }

  #modalTambahProsedur .footer-layout {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }

  #modalTambahProsedur .footer-layout .total-box {
    text-align: left;
  }

  #totalHargaDisplay {
    font-size: 18px;
  }
}
</style>
@endpush
<div
      id="modalTambahProsedur"
  class="hidden fixed inset-0 flex items-start md:items-center justify-center transition-opacity duration-300"
  style="z-index:2147483000;"
    >
      <div
        class="bg-white rounded-lg shadow-2xl w-full max-w-4xl flex flex-col relative transform transition-all scale-100"
      >
        <!-- Tombol Close (X) -->
        <button
          onclick="toggleProsedureModal(false)"
          class="absolute top-3 right-3 z-10 modal-close-btn"
          type="button"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>

        <!-- HEADER MODAL (Tetap / Sticky) -->
        <div class="modal-shell pt-6 flex-shrink-0 modal-header-panel">
          <h2 class="modal-title text-center mb-5">
            Tambah Prosedur
          </h2>

          <!-- Info Pasien -->
          <div>
            <p id="prosedur-date-display" class="text-xs mb-1" style="color: #c58f59;">Tanggal Hari Ini</p>
            <div class="patient-meta-card">
              <div class="patient-meta-item">
                <div class="patient-meta-label">Nama Pasien</div>
                <div id="prosedur-patient-name" class="patient-meta-value">Nama Pasien</div>
              </div>
              <div class="patient-meta-item">
                <div class="patient-meta-label">Metode Pembayaran</div>
                <div id="prosedur-patient-payment" class="patient-meta-value">Tunai/Umum</div>
              </div>
              <div class="patient-meta-item">
                <div class="patient-meta-label">Data Pasien</div>
                <div id="prosedur-patient-demographics" class="patient-meta-value">No. RM &middot; Jenis Kelamin &middot; Umur</div>
              </div>
            </div>
          </div>
          
          <!-- Hidden Inputs untuk Data Master -->
          <input type="hidden" id="prosedur-patient-id" value="">
          <input type="hidden" id="prosedur-registration-id" value="">
        </div>

        <!-- BODY MODAL (Bisa di-scroll) -->
        <div class="modal-shell py-5 flex-grow space-y-5 modal-body-panel">
          <!-- CONTAINER BARIS PROSEDUR -->
          <div
            id="prosedurContainer"
            class="space-y-3 w-full section-panel"
          >
            <!-- Baris 1: Default (Sudah Terisi seperti di gambar) -->
            <div
              class="prosedur-row w-full relative"
            >
              <!-- Nama Prosedur -->
              <div class="field-prosedur relative">
                <label class="label-small">Nama Prosedur *</label>
                <div class="search-field">
                  <!-- Search Icon -->
                  <svg
                    class="w-4 h-4 search-icon"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    ></path>
                  </svg>
                  <input
                    type="text"
                    placeholder="Cari Prosedur..."
                    class="input-underline pr-6 search-prosedur search-input w-full"
                    autocomplete="off"
                  />
                  <!-- Clear Icon (X) -->
                  <button
                    class="absolute right-0 bottom-1.5 text-gray-400 hover:text-gray-600 hidden"
                  >
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                      ></path>
                    </svg>
                  </button>
                  <!-- Container Dropdown Hasil Pencarian -->
                  <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden res-container-prosedur max-h-48 overflow-y-auto">
                      <!-- Hasil pencarian akan muncul di sini -->
                  </div>
                </div>
              </div>

              <!-- No. Gigi (Auto-complete Multiple) -->
              <div class="field-gigi input-gigi-wrapper relative">
                <label class="label-small">No. Gigi</label>
                <div class="relative w-full">
                    <input
                      type="text"
                      placeholder="Cari (11)..."
                      class="input-underline text-center input-no-gigi search-gigi cursor-text bg-transparent w-full"
                      autocomplete="off"
                    />
                    <!-- Dropdown Content -->
                    <div class="absolute left-0 bottom-full mb-1 w-[220px] bg-white border border-gray-200 shadow-xl z-50 rounded hidden res-container-gigi max-h-48 overflow-y-auto">
                        <!-- Hasil pencarian akan muncul di sini -->
                    </div>
                </div>
              </div>

              <!-- Qty -->
              <div class="field-qty">
                <label class="label-small">Qty *</label>
                <input
                  type="number"
                  value="1"
                  class="input-underline text-center"
                />
              </div>

              <!-- Harga Jual -->
              <div class="field-price">
                <label class="label-small">Harga Jual *</label>
                <input
                  type="text"
                  value="Rp0"
                  class="input-underline text-gray-400 input-harga-jual"
                  readonly
                />
              </div>

              <div class="field-doctor-share">
                <label class="label-small">% Dokter</label>
                <div class="input-underline text-center bg-[#f7f3ef] font-semibold doctor-percent-value"><div class="text-[11px] text-[#8e6a45] font-semibold">Rp0</div></div>
              </div>

              <!-- Diskon -->
              <div class="field-actions action-pack">
                <div>
                  <label class="label-small">Discount</label>
                  <input type="text" class="input-underline input-diskon" value="0" />
                </div>
                <span class="fix-label">Fix</span>

                <!-- Icon Tong Sampah Merah (Hapus Baris) -->
                <button
                  class="text-red-500 hover:text-red-700 icon-btn"
                  onclick="hapusBarisProsedur(this)"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button>

                <!-- Chevron Icon -->
                <button class="text-gray-400 icon-btn">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 15l7-7 7 7"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <!-- AKHIR CONTAINER BARIS PROSEDUR -->

          <div class="pt-0.5">
            <a
              href="#"
              onclick="tambahBarisProsedur(event)"
              class="inline-flex items-center text-blue-500 action-link font-medium hover:underline"
            >
              + Tambah Prosedur
            </a>
          </div>

          <!-- ============================================== -->
          <!-- CONTAINER BARIS OBAT DINAMIS -->
          <!-- ============================================== -->
          <div class="section-panel" style="margin-top: 12px; margin-bottom: 8px;">
            <div id="obatContainer" class="space-y-3 w-full">
              <!-- Baris Obat 1 (Default) -->
              <div class="obat-row w-full relative">
                <!-- Nama Obat -->
                <div class="field-obat">
                  <label class="label-small text-gray-400">Obat yang dipakai</label>
                    <div class="search-field">
                      <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                      <input type="text" placeholder="Cari obat..." class="input-underline w-full search-obat search-input" autocomplete="off" />
                    <!-- Container Dropdown Hasil Pencarian -->
                    <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden res-container max-h-48 overflow-y-auto">
                        <!-- Hasil pencarian akan muncul di sini -->
                    </div>
                  </div>
                </div>
                <!-- Qty Obat -->
                <div class="field-obat-qty">
                  <label class="label-small text-gray-400">Qty</label>
                  <input type="number" value="0" class="input-underline text-center w-full" />
                </div>
                <!-- Hapus Baris Obat -->
                <button class="field-obat-delete text-red-500 hover:text-red-700 icon-btn" onclick="hapusBarisObat(this)">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
            </div>

            <!-- TOMBOL PEMICU TAMBAH OBAT -->
            <a
              href="#"
              onclick="tambahBarisObat(event)"
              class="inline-flex items-center text-blue-500 action-link mt-2 font-medium hover:underline"
            >
              + Tambah Obat
            </a>
          </div>
          <!-- AKHIR CONTAINER OBAT -->

          <!-- ============================================== -->
          <!-- CONTAINER BARIS BHP DINAMIS -->
          <!-- ============================================== -->
          <div class="section-panel" style="margin-top: 12px; margin-bottom: 8px;">
            <div id="bhpContainer" class="space-y-3 w-full">
              <!-- Baris BHP 1 (Default) -->
              <div class="bhp-row w-full relative">
                <div class="field-bhp">
                  <label class="label-small text-gray-400">BHP yang dipakai</label>
                  <div class="search-field">
                    <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <input type="text" placeholder="Cari BHP..." class="input-underline w-full search-bhp search-input" autocomplete="off" />
                    <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden bhp-res-container max-h-48 overflow-y-auto"></div>
                  </div>
                </div>
                <div class="field-bhp-qty">
                  <label class="label-small text-gray-400">Qty</label>
                  <input type="number" value="0" class="input-underline text-center w-full" min="0" />
                </div>
                <button class="field-bhp-delete text-red-500 hover:text-red-700 icon-btn" onclick="hapusBarisBhp(this)">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
            </div>

            <a
              href="#"
              onclick="tambahBarisBhp(event)"
              class="inline-flex items-center text-blue-500 action-link mt-2 font-medium hover:underline"
            >
              + Tambah BHP
            </a>
          </div>
          <!-- AKHIR CONTAINER BHP -->

          <!-- Baris: Catatan -->
          <div class="section-panel info-shift" style="margin-top: 16px;">
            <label class="section-heading">Catatan</label>
            <input
              type="text"
              id="prosedur-notes"
              placeholder="Catatan"
              class="input-underline text-sm placeholder-gray-400"
            />
          </div>

          <!-- Baris: Tenaga Medis & Trigger Tambah Prosedur -->
          <div class="section-panel medis-panel info-shift" style="margin-top: 16px;">
            <div>
              <label class="section-heading">Tenaga Medis Utama</label>
              <select
                id="prosedur-doctor-select"
                onchange="syncAssistantDoctorChoices(); hitungTotalHarga();"
                class="input-underline text-sm cursor-pointer appearance-none bg-white font-medium"
              >
                <option value="">-- Pilih Tenaga Medis --</option>
                @foreach(\App\Models\Doctor::where('is_active', true)->orderBy('full_name')->get() as $doc)
                    <option value="{{ $doc->id }}" data-fee-percentage="{{ (float) ($doc->default_fee_percentage ?? 0) }}">{{ $doc->full_name }}</option>
                @endforeach
              </select>

            </div>

            <div>
              <label class="section-heading asisten-title">Asisten Tenaga Medis</label>
              <div id="assistantContainer" class="space-y-2"></div>
              <button
                type="button"
                onclick="addAssistantRow()"
                class="add-assistant-btn"
              >
                + Tambah Asisten
              </button>
            </div>
          </div>
        </div>

        <!-- FOOTER MODAL (Tetap / Sticky) -->
        <div class="modal-shell py-5 flex-shrink-0 modal-footer-panel">
          <div class="footer-layout flex justify-between items-center w-full px-2">
            <div class="total-box">
              <p class="text-xs text-gray-500 mb-0">Total Harga</p>
              <p class="text-2xl font-bold text-gray-800" id="totalHargaDisplay">Rp0</p>
            </div>
            <div class="save-box">
              <button
                onclick="toggleConfirmModal(true)"
                class="bg-[#A67C52] text-white font-bold text-sm tracking-wider py-3 px-10 rounded-xl shadow-md transition-colors primary-save-btn"
              >
                SIMPAN
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ======================================================= -->
    <!-- 2. MODAL KONFIRMASI -->
    <!-- ======================================================= -->
    <div
      id="modalConfirm"
      class="hidden fixed inset-0 flex items-center justify-center transition-opacity duration-200"
      style="z-index: 2147483001; background-color: rgba(0, 0, 0, 0.5);"
    >
      <div
        class="bg-white rounded-2xl p-8 shadow-2xl flex flex-col justify-center items-center gap-8 transform scale-100"
        style="width: 400px; height: 400px;"
      >
        <div class="flex justify-center">
          <svg class="w-20 h-20" style="color: #8e6a45;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        
        <p class="text-lg font-semibold text-center leading-relaxed px-4" style="color: #3b331e;">
          Apakah sudah tidak ada prosedur lagi yang ingin ditambahkan?
        </p>

        <div class="flex justify-center gap-4 w-full px-4 mt-2">
          <button
            onclick="toggleConfirmModal(false)"
            class="w-full text-sm font-bold py-3 rounded-xl border-2 transition"
            style="border-color: #d8c7b2; color: #8e6a45; background-color: transparent;"
            onmouseover="this.style.backgroundColor='#fef0e5'"
            onmouseout="this.style.backgroundColor='transparent'"
          >
            KEMBALI
          </button>
          <button
            onclick="submitAll()"
            class="w-full text-sm font-bold py-3 rounded-xl shadow-md transition text-white"
            style="background-color: #3b331e;"
            onmouseover="this.style.backgroundColor='#241f12'"
            onmouseout="this.style.backgroundColor='#3b331e'"
          >
            IYA, SIMPAN
          </button>
        </div>
      </div>
    </div>

    <!-- SCRIPT JAVASCRIPT -->
    <script>
      const modalMain = document.getElementById("modalTambahProsedur");
      const modalConfirm = document.getElementById("modalConfirm");
      const prosedurContainer = document.getElementById("prosedurContainer");
      const obatContainer = document.getElementById("obatContainer");
      const bhpContainer = document.getElementById("bhpContainer");
      const assistantContainer = document.getElementById('assistantContainer');

      // Pindahkan modal ke body agar tidak kena stacking context parent layout.
      if (modalMain && modalMain.parentElement !== document.body) {
        document.body.appendChild(modalMain);
      }
      if (modalConfirm && modalConfirm.parentElement !== document.body) {
        document.body.appendChild(modalConfirm);
      }

      function renderAssistantSelect(selectedId = '') {
        return `
          <div class="assistant-row flex items-center gap-2">
            <select class="input-underline text-sm assistant-doctor-select" onchange="handleAssistantDoctorChange(this)">
              <option value="">-- Pilih Asisten --</option>
              @foreach(\App\Models\Doctor::where('is_active', true)->orderBy('full_name')->get() as $doc)
                <option value="{{ $doc->id }}" ${selectedId === '{{ $doc->id }}' ? 'selected' : ''}>{{ $doc->full_name }}</option>
              @endforeach
            </select>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeAssistantRow(this)">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        `;
      }

      function addAssistantRow(selectedId = '') {
        if (!assistantContainer) return;
        const wrapper = document.createElement('div');
        wrapper.innerHTML = renderAssistantSelect(selectedId);
        assistantContainer.appendChild(wrapper.firstElementChild);
      }

      function removeAssistantRow(btn) {
        const row = btn.closest('.assistant-row');
        if (row) row.remove();
      }

      function getAssistantDoctorIds() {
        return Array.from(document.querySelectorAll('.assistant-doctor-select'))
          .map(el => el.value)
          .filter(Boolean);
      }

      function handleAssistantDoctorChange(selectEl) {
        const primaryDoctorId = document.getElementById('prosedur-doctor-select')?.value || '';
        if (!selectEl) return;

        if (primaryDoctorId && selectEl.value && selectEl.value === primaryDoctorId) {
          alert('Tenaga medis utama tidak boleh sama dengan asisten.');
          selectEl.value = '';
        }
      }

      function syncAssistantDoctorChoices() {
        const primaryDoctorId = document.getElementById('prosedur-doctor-select')?.value || '';
        document.querySelectorAll('.assistant-doctor-select').forEach(selectEl => {
          if (primaryDoctorId && selectEl.value === primaryDoctorId) {
            selectEl.value = '';
          }
        });
      }

      function hasAtLeastOneProcedureOrMedicine() {
        const prosedurRows = document.querySelectorAll('.prosedur-row');
        const hasProcedure = Array.from(prosedurRows).some(row => {
          const inputProsedur = row.querySelector('.search-prosedur');
          const qtyInput = row.querySelectorAll('input[type="number"]')[0];
          const qty = parseInt(qtyInput ? qtyInput.value : 1, 10) || 0;
          return !!(inputProsedur && inputProsedur.dataset.masterId && qty > 0);
        });

        if (hasProcedure) return true;

        const obatRows = document.querySelectorAll('.obat-row');
        const hasMedicine = Array.from(obatRows).some(row => {
          const inputObat = row.querySelector('.search-obat');
          const qtyInput = row.querySelector('input[type="number"]');
          const qty = parseInt(qtyInput ? qtyInput.value : 0, 10) || 0;
          return !!(inputObat && inputObat.dataset.medicineId && qty > 0);
        });

        if (hasMedicine) return true;

        const bhpRows = document.querySelectorAll('.bhp-row');
        const hasBhp = Array.from(bhpRows).some(row => {
          const inputBhp = row.querySelector('.search-bhp');
          const qtyInput = row.querySelector('input[type="number"]');
          const qty = parseInt(qtyInput ? qtyInput.value : 0, 10) || 0;
          return !!(inputBhp && inputBhp.dataset.bhpId && qty > 0);
        });

        return hasBhp;
      }

      function formatRupiah(value) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(Number(value || 0));
      }

      function fillProcedureRowFromData(row, item) {
        if (!row || !item) return;

        const prosedurInput = row.querySelector('.search-prosedur');
        const gigiInput = row.querySelector('.input-no-gigi');
        const qtyInput = row.querySelectorAll('input[type="number"]')[0];
        const hargaInput = row.querySelector('.input-harga-jual');
        const diskonInput = row.querySelector('.input-diskon');

        const procedureName = item.master_procedure?.procedure_name || item.master_procedure?.name || '';
        const unitPrice = Number(item.unit_price || 0);
        const quantity = Number(item.quantity || 1);
        const discountValue = Number(item.discount_value || 0);

        if (prosedurInput) {
          prosedurInput.value = procedureName;
          prosedurInput.dataset.masterId = item.master_procedure_id || '';
          prosedurInput.dataset.basePrice = String(unitPrice);
        }
        if (gigiInput) gigiInput.value = item.tooth_numbers || '';
        if (qtyInput) qtyInput.value = quantity > 0 ? String(quantity) : '1';
        if (hargaInput) hargaInput.value = formatRupiah(unitPrice);
        if (diskonInput) diskonInput.value = String(discountValue);
      }

      function fillMedicineRowFromData(row, item) {
        if (!row || !item) return;

        const obatInput = row.querySelector('.search-obat');
        const qtyInput = row.querySelector('input[type="number"]');

        if (obatInput) {
          obatInput.value = item.medicine?.medicine_name || '';
          obatInput.dataset.medicineId = item.medicine_id || '';
          obatInput.dataset.price = String(item.medicine?.selling_price_general || 0);
        }
        if (qtyInput) qtyInput.value = String(Number(item.quantity_used || 0));
      }

      function fillBhpRowFromData(row, item) {
        if (!row || !item) return;

        const bhpInput = row.querySelector('.search-bhp');
        const qtyInput = row.querySelector('input[type="number"]');

        if (bhpInput) {
          bhpInput.value = item.item?.item_name || '';
          bhpInput.dataset.bhpId = item.bhp_id || '';
          bhpInput.dataset.price = String(item.item?.general_price || item.unit_price || 0);
        }
        if (qtyInput) qtyInput.value = String(Number(item.quantity_used || 0));
      }

      function parseSavedToothMap() {
        try {
          const storedMap = sessionStorage.getItem('emr_last_saved_tooth_numbers_by_registration');
          if (!storedMap) return {};
          const parsed = JSON.parse(storedMap);
          return parsed && typeof parsed === 'object' ? parsed : {};
        } catch (error) {
          return {};
        }
      }

      function getSavedToothNumbersByRegistration(registrationId) {
        const regKey = String(registrationId || '').trim();
        if (!regKey) return [];

        const inMemoryMap = window.lastSavedToothNumbersByRegistration;
        if (inMemoryMap && Array.isArray(inMemoryMap[regKey])) {
          return inMemoryMap[regKey];
        }

        const storedMap = parseSavedToothMap();
        return Array.isArray(storedMap[regKey]) ? storedMap[regKey] : [];
      }

      function getSavedToothNumbersText(registrationId) {
        const cachedNumbers = getSavedToothNumbersByRegistration(registrationId);

        if (!Array.isArray(cachedNumbers) || cachedNumbers.length === 0) {
          return '';
        }

        return cachedNumbers
          .map(value => String(value).trim())
          .filter(Boolean)
          .join(', ');
      }

      function applySavedToothNumbersToAllEmptyRows(registrationId) {
        const toothText = getSavedToothNumbersText(registrationId);
        if (!toothText) return;

        const rows = prosedurContainer.querySelectorAll('.prosedur-row');
        rows.forEach(row => {
          const toothInput = row.querySelector('.input-no-gigi');
          if (!toothInput) return;

          const currentValue = String(toothInput.value || '').trim();
          if (!currentValue || currentValue === '') {
            toothInput.value = toothText;
            toothInput.dispatchEvent(new Event('input', { bubbles: true }));
          }
        });
      }

      async function loadExistingProcedureForRegistration(registrationId) {
        if (!registrationId) {
          resetProsedurForm();
          return false;
        }

        const currentLoadedRegId = document.getElementById('prosedur-registration-id')?.dataset?.lastLoadedRegId;
        if (currentLoadedRegId === registrationId) {
            // Sudah dimuat sebelumnya untuk registrasi yang sama, jangan reset/reload paksa
            // agar data sementara (WIP) tidak hilang.
            return true; 
        }

        const res = await fetch(`/api/medical-procedures/check-registration/${registrationId}`, {
          headers: { 'Accept': 'application/json' }
        });
        const payload = await res.json();

        resetProsedurForm();
        
        // Simpan marker bahwa data untuk registrasi ini sudah dimuat.
        const regIdInput = document.getElementById('prosedur-registration-id');
        if (regIdInput) regIdInput.dataset.lastLoadedRegId = registrationId;

        if (!res.ok || !payload.success || !payload.data) {
          return false;
        }

        const record = payload.data;

        const noteEl = document.getElementById('prosedur-notes');
        if (noteEl) noteEl.value = record.notes || '';

        const doctorSelect = document.getElementById('prosedur-doctor-select');
        if (doctorSelect && record.doctor_id) {
          doctorSelect.value = record.doctor_id;
        }

        if (assistantContainer) assistantContainer.innerHTML = '';
        const assistants = Array.isArray(record.assistants) ? record.assistants : [];
        assistants.forEach((assistant) => {
          if (assistant?.doctor_id) addAssistantRow(assistant.doctor_id);
        });
        syncAssistantDoctorChoices();

        const items = Array.isArray(record.items) ? record.items : [];
        items.forEach((item, idx) => {
          if (idx > 0) {
            tambahBarisProsedur({ preventDefault: function() {} });
          }
          const row = prosedurContainer.querySelectorAll('.prosedur-row')[idx];
          fillProcedureRowFromData(row, item);
        });

        if (items.length === 0) {
          applySavedToothNumbersToAllEmptyRows(registrationId);
        }

        const medicines = Array.isArray(record.medicines) ? record.medicines : [];
        medicines.forEach((medicine, idx) => {
          if (idx > 0) {
            tambahBarisObat({ preventDefault: function() {} });
          }
          const row = obatContainer.querySelectorAll('.obat-row')[idx];
          fillMedicineRowFromData(row, medicine);
        });

        const bhpUsages = Array.isArray(record.bhp_usages) ? record.bhp_usages : [];
        bhpUsages.forEach((usage, idx) => {
          if (idx > 0) {
            tambahBarisBhp({ preventDefault: function() {} });
          }
          const row = bhpContainer.querySelectorAll('.bhp-row')[idx];
          fillBhpRowFromData(row, usage);
        });

        hitungTotalHarga();
        return true;
      }

      // Tambahkan parameter 'patientData' di sebelah 'show'
    function toggleProsedureModal(show, patientData = null) {
      if (show) {
        // Kunci scroll halaman utama saat modal prosedur dibuka
        document.body.style.overflow = 'hidden';

        // 1. Tembak data pasien ke dalam modal JIKA datanya dikirim dari partial
        if (patientData) {
            document.getElementById('prosedur-patient-name').innerText = patientData.name || '-';
            document.getElementById('prosedur-patient-demographics').innerHTML = 
                `${patientData.rm || '-'} &middot; ${patientData.gender || '-'} &middot; ${patientData.age || '-'}`;
            document.getElementById('prosedur-patient-payment').innerText = patientData.payment || 'Tunai/Umum';
            
            // Input hidden ini SUPER PENTING biar pas disave masuk ke database yang benar!
            document.getElementById('prosedur-patient-id').value = patientData.patient_id || '';
            document.getElementById('prosedur-registration-id').value = patientData.registration_id || '';
            
            // Set dokter otomatis dari data yang diterima
            const docSelect = document.getElementById('prosedur-doctor-select');
            if (docSelect) {
                // Coba set via doctor_id dulu
                if (patientData.doctor_id) {
                    docSelect.value = patientData.doctor_id;
                }
                // Jika doctor_id tidak ada (misal dari Odontogram), cari berdasarkan doctor_name
                if ((!patientData.doctor_id || docSelect.value !== patientData.doctor_id) && patientData.doctor_name) {
                    for (let i = 0; i < docSelect.options.length; i++) {
                        if (docSelect.options[i].text === patientData.doctor_name) {
                            docSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
        }

        syncAssistantDoctorChoices();

        // 2. Set tanggal hari ini secara otomatis (biar nggak statis)
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('prosedur-date-display').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

        // 2b. Jika sudah ada record pada registration yang sama, load untuk mode edit.
        // Jika belum ada, baru prefill no. gigi dari odontogram terakhir.
        const registrationId = document.getElementById('prosedur-registration-id')?.value;
        loadExistingProcedureForRegistration(registrationId)
          .then((hasExisting) => {
            if (!hasExisting) {
              applySavedToothNumbersToAllEmptyRows(registrationId);
            }
          })
          .catch(() => {
            resetProsedurForm();
          });

        // 3. Tampilkan modal
        modalMain.classList.remove("hidden");
      } else {
        // Buka kembali scroll halaman utama dan sembunyikan modal
        document.body.style.overflow = '';
        modalMain.classList.add("hidden");
      }
    }

      function toggleConfirmModal(show) {
        if (show) {
          if (!hasAtLeastOneProcedureOrMedicine()) {
            alert('Minimal isi 1 prosedur, 1 obat, atau 1 BHP sebelum menyimpan.');
            return;
          }
          modalConfirm.classList.remove("hidden");
        } else {
          modalConfirm.classList.add("hidden");
        }
      }

      async function submitAll() {
        toggleConfirmModal(false);

        if (!hasAtLeastOneProcedureOrMedicine()) {
          alert('Tidak bisa simpan. Minimal harus ada 1 prosedur, 1 obat, atau 1 BHP yang terisi.');
            return;
        }

        try {
            // Hitung total amount (opsional, berdasarkan form input)
            let totalAmount = 0;
            const prosedurRows = document.querySelectorAll('.prosedur-row');
            prosedurRows.forEach(row => {
                const inputProsedur = row.querySelector('.search-prosedur');
                if (inputProsedur && inputProsedur.dataset.masterId) {
                    const qtyInput = row.querySelectorAll('input[type="number"]')[0];
                    const diskonInput = row.querySelector('.input-diskon');
                    
                    const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
                    const basePrice = parseFloat(inputProsedur.dataset.basePrice || 0);
                    const diskonVal = parseFloat(diskonInput ? diskonInput.value : 0) || 0;
                    totalAmount += (basePrice * qty) - diskonVal;
                }
            });

            // Hitung biaya obat dan tambahkan ke totalAmount
            const allObatRows = document.querySelectorAll('.obat-row');
            allObatRows.forEach(function(row) {
                const inputObat = row.querySelector('.search-obat');
                if (inputObat && inputObat.dataset.medicineId) {
                    const price = parseFloat(inputObat.dataset.price || 0);
                    const qtyObat = row.querySelector('input[type="number"]');
                    const qty = parseInt(qtyObat ? qtyObat.value : 0) || 0;
                    totalAmount += (price * qty);
                }
            });

                const allBhpRows = document.querySelectorAll('.bhp-row');
                allBhpRows.forEach(function(row) {
                  const inputBhp = row.querySelector('.search-bhp');
                  if (inputBhp && inputBhp.dataset.bhpId) {
                    const price = parseFloat(inputBhp.dataset.price || 0);
                    const qtyBhp = row.querySelector('input[type="number"]');
                    const qty = parseInt(qtyBhp ? qtyBhp.value : 0) || 0;
                    totalAmount += (price * qty);
                  }
                });

            const itemsPayload = [];
            for (let row of prosedurRows) {
              const inputProsedur = row.querySelector('.search-prosedur');
              const masterId = inputProsedur?.dataset?.masterId;
              if (!masterId) continue;

              const qtyInput = row.querySelectorAll('input[type="number"]')[0];
              const diskonInput = row.querySelector('.input-diskon');
              const gigiInp = row.querySelector('.input-no-gigi');

              const qty = parseInt(qtyInput ? qtyInput.value : 1, 10) || 1;
              const basePrice = parseFloat(inputProsedur.dataset.basePrice || 0) || 0;
              const diskonVal = parseFloat(diskonInput ? diskonInput.value : 0) || 0;

              itemsPayload.push({
                master_procedure_id: masterId,
                tooth_numbers: gigiInp ? gigiInp.value : null,
                quantity: qty,
                unit_price: basePrice,
                discount_type: diskonVal > 0 ? 'fix' : 'none',
                discount_value: diskonVal,
                subtotal: Math.max(0, (basePrice * qty) - diskonVal)
              });
            }

            const medicinesPayload = [];
            const obatRows = document.querySelectorAll('.obat-row');
            for (let row of obatRows) {
              const inputObat = row.querySelector('.search-obat');
              if (!inputObat) continue;

              const medicineId = inputObat.dataset.medicineId;
              if (!medicineId) continue;

              const qtyInput = row.querySelectorAll('input[type="number"]')[0];
              const qty = parseInt(qtyInput ? qtyInput.value : 0, 10) || 0;
              if (qty <= 0) continue;

              medicinesPayload.push({
                medicine_id: medicineId,
                quantity_used: qty
              });
            }

            const bhpsPayload = [];
            const bhpRows = document.querySelectorAll('.bhp-row');
            for (let row of bhpRows) {
              const inputBhp = row.querySelector('.search-bhp');
              if (!inputBhp) continue;

              const bhpId = inputBhp.dataset.bhpId;
              if (!bhpId) continue;

              const qtyInput = row.querySelectorAll('input[type="number"]')[0];
              const qty = parseInt(qtyInput ? qtyInput.value : 0, 10) || 0;
              if (qty <= 0) continue;

              bhpsPayload.push({
                bhp_id: bhpId,
                quantity_used: qty,
                unit_price: parseFloat(inputBhp.dataset.price || 0) || 0,
                usage_type: 'umum'
              });
            }

            // Simpan Medical Procedure (upsert by registration_id)
            const payloadParent = {
                'registration_id': document.getElementById('prosedur-registration-id').value,
                'patient_id': document.getElementById('prosedur-patient-id').value,
                'doctor_id': document.getElementById('prosedur-doctor-select').value,
              'assistant_doctor_ids': getAssistantDoctorIds(),
                'discount_type': 'none',
                'discount_value': 0,
                'total_amount': totalAmount > 0 ? totalAmount : 0,
              'notes': document.getElementById('prosedur-notes').value,
              'items': itemsPayload,
                'medicines': medicinesPayload,
                'bhps': bhpsPayload
            };

            const resParent = await fetch('/api/medical-procedures', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payloadParent)
            });
            const parentData = await resParent.json();
            
            if (!parentData.success || !parentData.data) {
                throw new Error(parentData.message || 'Gagal menyimpan data parent');
            }
           const successMsg = document.createElement('div');
            
            // Perhatikan: px-6 diganti jadi px-16, dan ditambah justify-center
            successMsg.className = 'fixed top-10 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-16 py-3 rounded-none shadow-2xl z-[99999] flex items-center justify-center space-x-3 transition-all duration-500 opacity-0 translate-y-[-20px]';
            
            successMsg.innerHTML = `
                <svg class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-bold tracking-wide">Prosedur Berhasil Disimpan!</span>
            `;
            
            document.body.appendChild(successMsg);
            
            // Animasi masuk
            requestAnimationFrame(() => {
                successMsg.classList.remove('opacity-0', 'translate-y-[-20px]');
                successMsg.classList.add('opacity-100', 'translate-y-0');
            });
            
            // Animasi keluar
            setTimeout(() => {
                successMsg.classList.remove('opacity-100', 'translate-y-0');
                successMsg.classList.add('opacity-0', 'translate-y-[-20px]');
                setTimeout(() => successMsg.remove(), 500);
            }, 3500);
            
            // Reset form dan tutup modal
            if (typeof clearOdontogramState === 'function') clearOdontogramState();
            if (typeof resetProsedurForm === 'function') resetProsedurForm();
            toggleProsedureModal(false);

            // Refresh detail pasien aktif agar tab Record > Rekam Medis langsung menampilkan asisten terbaru.
            const activePatientLink = document.querySelector('.js-emr-patient-link .patient-card.active')?.closest('a');
            if (activePatientLink) {
              activePatientLink.click();
            }

        } catch (e) {
            // Pesan Error Estetika
            const errMsg = document.createElement('div');
            errMsg.className = 'fixed top-10 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-xl shadow-2xl z-[99999] flex items-center space-x-3 transition-all duration-500 opacity-0 translate-y-[-20px]';
            errMsg.innerHTML = `
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold tracking-wide">${e.message}</span>
            `;
            document.body.appendChild(errMsg);
            requestAnimationFrame(() => { errMsg.classList.remove('opacity-0', 'translate-y-[-20px]'); errMsg.classList.add('opacity-100', 'translate-y-0'); });
            setTimeout(() => { errMsg.classList.remove('opacity-100', 'translate-y-0'); errMsg.classList.add('opacity-0', 'translate-y-[-20px]'); setTimeout(() => errMsg.remove(), 500); }, 4000);
        }
      }

      // =======================================================
      // FUNGSI UNTUK MENAMBAH BARIS PROSEDUR BARU
      // =======================================================
      function tambahBarisProsedur(e) {
        e.preventDefault();

        const newRow = document.createElement("div");
        newRow.className =
          "prosedur-row w-full relative mt-4";

        newRow.innerHTML = `
                <!-- Nama Prosedur -->
                <div class="field-prosedur relative">
                    <label class="label-small text-gray-400">Nama Prosedur *</label>
                  <div class="search-field">
                    <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari Prosedur *" class="input-underline pr-6 search-prosedur search-input w-full" autocomplete="off">
                        <!-- Container Dropdown Hasil Pencarian -->
                        <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden res-container-prosedur max-h-48 overflow-y-auto">
                        </div>
                    </div>
                </div>

                <!-- No. Gigi (Auto-complete Multiple) -->
                <div class="field-gigi input-gigi-wrapper relative">
                    <label class="label-small text-gray-400">No. Gigi</label>
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari (11)..." class="input-underline text-center input-no-gigi search-gigi cursor-text bg-transparent w-full" autocomplete="off">
                        <div class="absolute left-0 bottom-full mb-1 w-[220px] bg-white border border-gray-200 shadow-xl z-50 rounded hidden res-container-gigi max-h-48 overflow-y-auto">
                        </div>
                    </div>
                </div>

                <!-- Qty -->
                <div class="field-qty">
                    <label class="label-small text-gray-400">Qty *</label>
                  <input type="number" value="1" class="input-underline text-center">
                </div>

                <!-- Harga Jual -->
                <div class="field-price">
                    <label class="label-small text-gray-400">Harga Jual *</label>
                    <input type="text" value="Rp0" class="input-underline text-gray-400 input-harga-jual" readonly>
                </div>

                <div class="field-doctor-share">
                  <label class="label-small text-gray-400">% Dokter</label>
                  <div class="input-underline text-center bg-[#f7f3ef] font-semibold doctor-percent-value"><div class="text-[11px] text-[#8e6a45] font-semibold">Rp0</div></div>
                </div>

                <!-- Diskon -->
                <div class="field-actions action-pack">
                  <div>
                        <label class="label-small text-gray-400">Discount</label>
                        <input type="text" class="input-underline input-diskon" value="0">
                    </div>
                  <span class="fix-label">Fix</span>

                    <!-- Icon Tong Sampah Merah (Hapus Baris) -->
                  <button class="text-red-500 hover:text-red-700 icon-btn" onclick="hapusBarisProsedur(this)">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </button>

                    <!-- Chevron Icon -->
                  <button class="text-gray-400 icon-btn" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                    </button>
                </div>
            `;

        prosedurContainer.appendChild(newRow);
        scrollToBottom();
      }

      function hapusBarisProsedur(buttonElement) {
        const row = buttonElement.closest(".prosedur-row");

        if (prosedurContainer.querySelectorAll(".prosedur-row").length > 1) {
          row.remove();
        } else {
          const inputs = row.querySelectorAll("input");
          inputs[0].value = ""; // Nama Prosedur
          delete inputs[0].dataset.masterId;
          delete inputs[0].dataset.basePrice;

          inputs[1].value = ""; // No. Gigi
          const qtyInput = row.querySelector('input[type="number"]');
          if(qtyInput) qtyInput.value = "1"; // Qty default 1
          
          const hargaInput = row.querySelector('.input-harga-jual');
          if(hargaInput) hargaInput.value = "Rp0"; // Harga
          
          const diskonInput = row.querySelector('.input-diskon');
          if(diskonInput) diskonInput.value = "0"; // Discount
        }
        
        hitungTotalHarga();
      }

      function hitungTotalHarga() {
          let total = 0;
          const doctorSelect = document.getElementById('prosedur-doctor-select');
          const selectedDoctorOption = doctorSelect?.selectedOptions?.[0] || null;
          const doctorFeePercent = Number(selectedDoctorOption?.dataset?.feePercentage || 0);

          const prosedurRows = document.querySelectorAll('.prosedur-row');
          prosedurRows.forEach(row => {
              const inputProsedur = row.querySelector('.search-prosedur');
              const doctorPercentEle = row.querySelector('.doctor-percent-value');

              if (inputProsedur && inputProsedur.dataset.masterId) {
                  const qtyInput = row.querySelectorAll('input[type="number"]')[0];
                  const diskonInput = row.querySelector('.input-diskon');
                  
                  const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
                  const basePrice = parseFloat(inputProsedur.dataset.basePrice || 0);
                  const diskonVal = parseFloat(diskonInput ? diskonInput.value : 0) || 0;
              const grossSubtotal = basePrice * qty;
                  
              let subtotal = grossSubtotal - diskonVal;
                  if (subtotal < 0) subtotal = 0;
                  
                  total += subtotal;

              if (doctorPercentEle) {
                const doctorIncomePerRow = grossSubtotal * (doctorFeePercent / 100);
                doctorPercentEle.innerHTML = `<div class="text-[11px] text-[#8e6a45] font-semibold">Rp${new Intl.NumberFormat('id-ID').format(doctorIncomePerRow)}</div>`;
              }
            } else if (doctorPercentEle) {
              doctorPercentEle.innerHTML = `<div class="text-[11px] text-[#8e6a45] font-semibold">Rp0</div>`;
              }
          });
          
          // Tambahkan biaya obat
          const semuaObatRows = document.querySelectorAll('.obat-row');
          semuaObatRows.forEach(function(row) {
              const inputObat = row.querySelector('.search-obat');
              if (inputObat && inputObat.dataset.medicineId) {
                  const price = parseFloat(inputObat.dataset.price || 0);
                  const qtyInput = row.querySelector('input[type="number"]');
                  const qty = parseInt(qtyInput ? qtyInput.value : 0) || 0;
                  total += (price * qty);
              }
          });

            const semuaBhpRows = document.querySelectorAll('.bhp-row');
            semuaBhpRows.forEach(function(row) {
              const inputBhp = row.querySelector('.search-bhp');
              if (inputBhp && inputBhp.dataset.bhpId) {
                const price = parseFloat(inputBhp.dataset.price || 0);
                const qtyInput = row.querySelector('input[type="number"]');
                const qty = parseInt(qtyInput ? qtyInput.value : 0) || 0;
                total += (price * qty);
              }
            });
          
          const totalEle = document.getElementById('totalHargaDisplay');
          if (totalEle) {
              totalEle.innerText = "Rp" + new Intl.NumberFormat('id-ID').format(total);
          }
      }

      // =======================================================
      // AUTOCOMPLETE PENCARIAN GIGI (MENDUKUNG MULTI-SELECT)
      // =======================================================
      window.currentPatientTeeth = [];
      const ALL_TEETH = Array.from({length: 85}, (_, i) => i + 1).filter(n => {
          const first = Math.floor(n / 10);
          const second = n % 10;
          return [1,2,3,4,5,6,7,8].includes(first) && [1,2,3,4,5,6,7,8].includes(second);
      });

      function renderGigiDropdown(inputEl) {
          const container = inputEl.closest('.input-gigi-wrapper').querySelector('.res-container-gigi');
          const fullText = inputEl.value;
          const parts = fullText.split(',');
          // Fokus pada teks setelah koma terakhir
          const query = parts[parts.length - 1].trim().toLowerCase();

          // Kumpulkan gigi yg dicari khusus DARI ODONTOGRAM
          let recordMatches = window.currentPatientTeeth.filter(t => t.tooth_number.toString().includes(query));
          
          // Kumpulkan sisa gigi NORMAL
          let normalMatches = ALL_TEETH.filter(tNum => {
              return tNum.toString().includes(query) && 
                     !window.currentPatientTeeth.some(pt => pt.tooth_number === tNum);
          });
          
          let html = '';
          
          // 1. Tampilkan Gigi dari Record Odontogram (Prioritas Utama)
          recordMatches.slice(0, 15).forEach(problem => {
              const tNum = problem.tooth_number;
              let condHtml = `<div class="text-[10px] text-red-600 font-bold bg-white px-1.5 py-0.5 rounded border border-red-200 mt-1 inline-block shadow-sm">${problem.condition_label || 'Bermasalah'}</div>`;
              
              html += `
                  <div class="res-item bg-red-50 hover:bg-red-100 p-2 cursor-pointer border-b text-sm gigi-item" data-val="${tNum}">
                      <div class="font-bold text-red-700 flex justify-between items-center">
                          <span>Gigi ${tNum}</span>
                          <span class="text-[10px] text-red-400 font-normal">Odontogram</span>
                      </div>
                      ${condHtml}
                  </div>
              `;
          });

          // 2. Tampilkan Gigi Lainnya (Sebagai Fallback)
          const remainingSlots = 15 - recordMatches.length;
          if (remainingSlots > 0 && normalMatches.length > 0) {
              if (recordMatches.length > 0 && query === '') {
                   html += `<div class="text-[10px] bg-gray-100 px-2 py-1.5 text-gray-500 font-bold uppercase tracking-wider">Semua Gigi Normal</div>`;
              } else if (recordMatches.length > 0) {
                   html += `<div class="text-[10px] bg-gray-100 px-2 py-1.5 text-gray-500 font-bold uppercase tracking-wider">Hasil Lainnya</div>`;
              }
              
              normalMatches.slice(0, remainingSlots).forEach(tNum => {
                  html += `
                      <div class="res-item hover:bg-f3f4f6 p-2 cursor-pointer border-b text-sm gigi-item" data-val="${tNum}">
                          <div class="font-bold text-gray-700">Gigi ${tNum}</div>
                      </div>
                  `;
              });
          }

          if (html === '') {
              html = `<div class="p-3 text-xs text-center text-gray-500">Tidak ditemukan</div>`;
          }
          
          container.innerHTML = html;
          container.classList.remove('hidden');
      }

      // Hide dropdown apabila area lain diklik
      document.addEventListener('click', function(e) {
          document.querySelectorAll('.res-container-gigi').forEach(container => {
              if (!container.contains(e.target) && !e.target.classList.contains('search-gigi')) {
                  container.classList.add('hidden');
              }
          });
      });

      // Menimpa nilai input ketika dropdown dipilih
      document.addEventListener('click', function(e) {
          const gigiItem = e.target.closest('.gigi-item');
          if (gigiItem) {
              const wrapper = gigiItem.closest('.input-gigi-wrapper');
              const input = wrapper.querySelector('.search-gigi');
              const valToAdd = gigiItem.dataset.val;

              let parts = input.value.split(',');
              parts.pop(); // Buang ketikan sebagian terakhir
              parts.push(valToAdd); // Lempar gigi utuh
              
              input.value = parts.map(s => s.trim()).filter(Boolean).join(', ') + ', ';
              input.focus();
              
              const container = wrapper.querySelector('.res-container-gigi');
              container.classList.add('hidden');
          }
      });

      // Listen pada pengetikan atau focus input
      document.addEventListener('input', function(e) {
          if (e.target.classList.contains('search-gigi')) {
              renderGigiDropdown(e.target);
          }
      });
      document.addEventListener('focusin', function(e) {
          if (e.target.classList.contains('search-gigi')) {
              renderGigiDropdown(e.target);
          }
      });

      // =======================================================
      // FUNGSI UNTUK MENAMBAH BARIS OBAT BARU
      // =======================================================
      function tambahBarisObat(e) {
        e.preventDefault();

        const newRow = document.createElement("div");
        newRow.className = "obat-row w-full relative mt-4";
        newRow.innerHTML = `
            <div class="field-obat">
              <label class="label-small text-gray-400">Obat yang dipakai</label>
              <div class="search-field">
                <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                <input type="text" placeholder="Cari obat..." class="input-underline w-full search-obat search-input" autocomplete="off" data-medicine-id="" />
                <div class="res-container absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[999] hidden max-h-48 overflow-y-auto"></div>
              </div>
            </div>
            <div class="field-obat-qty">
                <label class="label-small text-gray-400">Qty</label>
                <input type="number" value="0" class="input-underline text-center w-full" min="0" />
            </div>
            <button class="field-obat-delete text-red-500 hover:text-red-700 icon-btn" onclick="hapusBarisObat(this)">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
            </button>
        `;
        obatContainer.appendChild(newRow);
        scrollToBottom();
      }

      function hapusBarisObat(buttonElement) {
        const row = buttonElement.closest(".obat-row");

        if (obatContainer.querySelectorAll(".obat-row").length > 1) {
          row.remove();
        } else {
          const inputs = row.querySelectorAll("input");
          inputs[0].value = "";
          inputs[1].value = "0";
        }
      }

      function tambahBarisBhp(e) {
        e.preventDefault();

        const newRow = document.createElement("div");
        newRow.className = "bhp-row w-full relative mt-4";
        newRow.innerHTML = `
            <div class="field-bhp">
              <label class="label-small text-gray-400">BHP yang dipakai</label>
              <div class="search-field">
                <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                <input type="text" placeholder="Cari BHP..." class="input-underline w-full search-bhp search-input" autocomplete="off" data-bhp-id="" />
                <div class="bhp-res-container absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[999] hidden max-h-48 overflow-y-auto"></div>
              </div>
            </div>
            <div class="field-bhp-qty">
                <label class="label-small text-gray-400">Qty</label>
                <input type="number" value="0" class="input-underline text-center w-full" min="0" />
            </div>
            <button class="field-bhp-delete text-red-500 hover:text-red-700 icon-btn" onclick="hapusBarisBhp(this)">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
            </button>
        `;
        bhpContainer.appendChild(newRow);
        scrollToBottom();
      }

      function hapusBarisBhp(buttonElement) {
        const row = buttonElement.closest(".bhp-row");

        if (bhpContainer.querySelectorAll(".bhp-row").length > 1) {
          row.remove();
        } else {
          const inputs = row.querySelectorAll("input");
          inputs[0].value = "";
          inputs[1].value = "0";
          delete inputs[0].dataset.bhpId;
          delete inputs[0].dataset.price;
        }
      }

      // FUNGSI HELPER UNTUK SCROLL KE BAWAH SAAT ITEM BARU DITAMBAHKAN
      function scrollToBottom() {
        const modalBody = document.querySelector("#modalTambahProsedur .overflow-y-auto");
        modalBody.scrollTop = modalBody.scrollHeight;
      }
    // =======================================================
    // RESET FORM PROSEDUR (Ketik Ganti Pasien)
    // =======================================================
    function resetProsedurForm() {
        const procRows = document.querySelectorAll('.prosedur-row');
        procRows.forEach((row, i) => {
            if (i > 0) row.remove();
        });
        const firstRow = document.querySelector('.prosedur-row');
        if (firstRow) {
            const inputs = firstRow.querySelectorAll('input');
            inputs.forEach(inp => inp.value = '');
            const hargaInp = firstRow.querySelector('.input-harga-jual');
            if(hargaInp) hargaInp.value = 'Rp0';
            const qtyInp = firstRow.querySelector('input[type="number"]');
            if(qtyInp) qtyInp.value = '1';
            const diskonInp = firstRow.querySelector('.input-diskon');
            if(diskonInp) diskonInp.value = '0';
            const searchInp = firstRow.querySelector('.search-prosedur');
            if (searchInp) {
                searchInp.dataset.masterId = '';
                searchInp.dataset.basePrice = '0';
            }
        }
        
        const obatRows = document.querySelectorAll('.obat-row');
        obatRows.forEach((row, i) => {
            if (i > 0) row.remove();
        });
        const firstObat = document.querySelector('.obat-row');
        if (firstObat) {
            const inputs = firstObat.querySelectorAll('input');
            inputs.forEach(inp => inp.value = '');
            const qtyInp = firstObat.querySelector('input[type="number"]');
            if(qtyInp) qtyInp.value = '0';
            const searchInp = firstObat.querySelector('.search-obat');
            if (searchInp) {
                searchInp.dataset.medicineId = '';
            }
        }

          const bhpRows = document.querySelectorAll('.bhp-row');
          bhpRows.forEach((row, i) => {
            if (i > 0) row.remove();
          });
          const firstBhp = document.querySelector('.bhp-row');
          if (firstBhp) {
            const inputs = firstBhp.querySelectorAll('input');
            inputs.forEach(inp => inp.value = '');
            const qtyInp = firstBhp.querySelector('input[type="number"]');
            if(qtyInp) qtyInp.value = '0';
            const searchInp = firstBhp.querySelector('.search-bhp');
            if (searchInp) {
              searchInp.dataset.bhpId = '';
              searchInp.dataset.price = '0';
            }
          }

        const totalEle = document.getElementById('totalHargaDisplay');
        if (totalEle) totalEle.innerText = 'Rp0';

        if (assistantContainer) {
          assistantContainer.innerHTML = '';
        }
    }

    // Debounce function untuk membatasi request API
    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    // Event delegation untuk handle input obat (karena baris bisa bertambah)
    document.addEventListener('input', debounce(function(e) {
        if (e.target.classList.contains('search-obat')) {
            const input = e.target;
            const query = input.value;
            const container = input.closest('.relative').querySelector('.res-container');

            if (query.length < 2) {
                container.classList.add('hidden');
                return;
            }

            const medicineUrl = '{{ url("/api/medicine") }}' + '?search=' + encodeURIComponent(query);
            fetch(medicineUrl, { headers: { 'Accept': 'application/json' } })
                .then(function(res) {
                    if (!res.ok) throw new Error('HTTP error: ' + res.status);
                    return res.json();
                })
                .then(function(res) {
                    const items = (res.data && res.data.data) ? res.data.data : (res.data ? res.data : []);
                    let html = '';

                    if (items && items.length > 0) {
                        items.forEach(function(item) {
                            const harga = item.selling_price_general || 0;
                            const stockColor = item.current_stock > 0 ? 'text-green-600' : 'text-red-600';
                            html += '<div class="res-item medicine-suggestion-item hover:bg-gray-50 p-2 cursor-pointer border-b text-sm"' +
                                ' data-id="' + item.id + '"' +
                                ' data-nama="' + item.medicine_name + '"' +
                                ' data-price="' + harga + '">' +
                                '<div class="flex justify-between items-center">' +
                                '<div>' +
                                '<div class="font-bold text-gray-800">' + item.medicine_name + '</div>' +
                                '<div class="text-[10px] text-gray-500">' + (item.medicine_code || '') + ' &middot; ' + (item.category || 'Obat') + '</div>' +
                                '<div class="text-xs text-blue-600 font-bold">Rp' + new Intl.NumberFormat('id-ID').format(harga) + '</div>' +
                                '</div>' +
                                '<div class="text-right">' +
                                '<div class="text-xs font-bold ' + stockColor + '">Stok: ' + (item.current_stock || 0) + '</div>' +
                                '<div class="text-[10px] text-gray-400">' + (item.unit || '') + '</div>' +
                                '</div></div></div>';
                        });
                    } else {
                        html = '<div class="p-4 text-xs text-center text-gray-400 italic">Obat tidak ditemukan</div>';
                    }

                    container.innerHTML = html;
                    container.classList.remove('hidden');
                })
                .catch(function(err) { console.error('Error fetching medicine:', err); });
            } else if (e.target.classList.contains('search-bhp')) {
              const input = e.target;
              const query = input.value;
              const container = input.closest('.relative').querySelector('.bhp-res-container');

              if (query.length < 2) {
                container.classList.add('hidden');
                return;
              }

              const bhpUrl = '{{ url("/api/bhp/items") }}' + '?search=' + encodeURIComponent(query);
              fetch(bhpUrl, { headers: { 'Accept': 'application/json' } })
                .then(function(res) {
                  if (!res.ok) throw new Error('HTTP error: ' + res.status);
                  return res.json();
                })
                .then(function(res) {
                  const items = Array.isArray(res.data) ? res.data : [];
                  let html = '';

                  if (items && items.length > 0) {
                    items.forEach(function(item) {
                      const harga = item.general_price || 0;
                      const stockColor = item.current_stock > 0 ? 'text-green-600' : 'text-red-600';
                      html += '<div class="res-item bhp-suggestion-item hover:bg-gray-50 p-2 cursor-pointer border-b text-sm"' +
                        ' data-id="' + item.id + '"' +
                        ' data-nama="' + item.item_name + '"' +
                        ' data-price="' + harga + '">' +
                        '<div class="flex justify-between items-center">' +
                        '<div>' +
                        '<div class="font-bold text-gray-800">' + item.item_name + '</div>' +
                        '<div class="text-[10px] text-gray-500">' + (item.item_code || '') + ' &middot; ' + (item.brand || 'BHP') + '</div>' +
                        '<div class="text-xs text-blue-600 font-bold">Rp' + new Intl.NumberFormat('id-ID').format(harga) + '</div>' +
                        '</div>' +
                        '<div class="text-right">' +
                        '<div class="text-xs font-bold ' + stockColor + '">Stok: ' + (item.current_stock || 0) + '</div>' +
                        '<div class="text-[10px] text-gray-400">' + (item.min_stock !== undefined ? 'Min ' + item.min_stock : '') + '</div>' +
                        '</div></div></div>';
                    });
                  } else {
                    html = '<div class="p-4 text-xs text-center text-gray-400 italic">BHP tidak ditemukan</div>';
                  }

                  container.innerHTML = html;
                  container.classList.remove('hidden');
                })
                .catch(function(err) { console.error('Error fetching BHP:', err); });
        }
    }));

    // Handle klik pada hasil pencarian
    document.addEventListener('click', function(e) {
        // --- KLIK HASIL PENCARIAN OBAT ---
        const itemObat = e.target.closest('.medicine-suggestion-item');
        if (itemObat) {
            const row = itemObat.closest('.obat-row');
            if (!row) return;
            const inputName = row.querySelector('.search-obat');
            const container = inputName.closest('.relative').querySelector('.res-container');
            const inputQty = row.querySelector('input[type="number"]');

            // Set nama, ID, dan harga obat yang dipilih
            inputName.value = itemObat.dataset.nama;
            inputName.dataset.medicineId = itemObat.dataset.id;
            inputName.dataset.price = itemObat.dataset.price;
            
            // Set qty ke 1 jika masih 0 atau kosong
            if (inputQty && (!inputQty.value || inputQty.value === '0' || inputQty.value === '')) {
                inputQty.value = 1;
            }

            // Hitung ulang total setelah obat dipilih
            hitungTotalHarga();

            // Sembunyikan dropdown
            if (container) container.classList.add('hidden');
            return;
        }

          const itemBhp = e.target.closest('.bhp-suggestion-item');
          if (itemBhp) {
            const row = itemBhp.closest('.bhp-row');
            if (!row) return;
            const inputName = row.querySelector('.search-bhp');
            const container = inputName.closest('.relative').querySelector('.bhp-res-container');
            const inputQty = row.querySelector('input[type="number"]');

            inputName.value = itemBhp.dataset.nama;
            inputName.dataset.bhpId = itemBhp.dataset.id;
            inputName.dataset.price = itemBhp.dataset.price;

            if (inputQty && (!inputQty.value || inputQty.value === '0' || inputQty.value === '')) {
              inputQty.value = 1;
            }

            hitungTotalHarga();

            if (container) container.classList.add('hidden');
            return;
          }

        // --- KLIK HASIL PENCARIAN PROSEDUR ---
        const itemProsedur = e.target.closest('.prosedur-row .res-item');
        if (itemProsedur) {
            const row = itemProsedur.closest('.prosedur-row');
            const inputName = row.querySelector('.search-prosedur');
            const inputHargaJual = row.querySelector('.input-harga-jual');
            const inputDiskon = row.querySelector('.input-diskon');
            const inputQty = row.querySelector('input[type="number"]');
            const container = itemProsedur.closest('.res-container-prosedur');

            inputName.value = itemProsedur.dataset.nama;
            inputName.dataset.masterId = itemProsedur.dataset.id;
            inputName.dataset.basePrice = itemProsedur.dataset.harga;
            
            // Set default qty = 1 automatically
            if (inputQty && (!inputQty.value || inputQty.value === "0" || inputQty.value === "")) {
                inputQty.value = 1;
            }
            
            if (inputHargaJual) {
                inputHargaJual.value = "Rp" + new Intl.NumberFormat('id-ID').format(itemProsedur.dataset.harga);
            }
            
            if (inputDiskon) {
                inputDiskon.value = "0"; // Reset discount
            }

            container.classList.add('hidden');
            hitungTotalHarga();
        }

        // Klik di luar dropdown untuk menutup
        if (!e.target.classList.contains('search-obat')) {
            document.querySelectorAll('.res-container').forEach(el => el.classList.add('hidden'));
        }
        if (!e.target.classList.contains('search-bhp')) {
          document.querySelectorAll('.bhp-res-container').forEach(el => el.classList.add('hidden'));
        }
        if (!e.target.classList.contains('search-prosedur')) {
            document.querySelectorAll('.res-container-prosedur').forEach(el => el.classList.add('hidden'));
        }
    });

    // EVENT LISTENER UNTUK PERUBAHAN QTY/DISKON (HITUNG TOTAL OTOMATIS)
    document.addEventListener('input', function(e) {
        // Hitung ulang total saat qty prosedur, diskon, atau qty obat berubah
        const inProsedurRow = e.target.closest('.prosedur-row');
        const inObatRow = e.target.closest('.obat-row');
      const inBhpRow = e.target.closest('.bhp-row');
      if ((inProsedurRow || inObatRow || inBhpRow) && (e.target.type === 'number' || e.target.classList.contains('input-diskon'))) {
            hitungTotalHarga();
        }
    });

    // EVENT DELEGATION UNTUK PENCARIAN PROSEDUR
    document.addEventListener('input', debounce(function(e) {
        if (e.target.classList.contains('search-prosedur')) {
            const input = e.target;
            const query = input.value;
            const container = input.parentElement.querySelector('.res-container-prosedur');

            if (query.length < 2) {
                container.classList.add('hidden');
                return;
            }

            fetch(`/api/master-procedure?search=${query}`)
                .then(res => res.json())
                .then(res => {
                    const items = res.data.data;
                    let html = '';

                    if (items && items.length > 0) {
                        items.forEach(item => {
                            html += `
                                <div class="res-item hover:bg-f3f4f6 p-2 cursor-pointer border-b text-sm" data-id="${item.id}" data-nama="${item.procedure_name}" data-harga="${item.base_price}">
                                    <div class="font-medium">${item.procedure_name}</div>
                                    <div class="text-xs text-gray-500">Rp${new Intl.NumberFormat('id-ID').format(item.base_price)}</div>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="p-3 text-xs text-gray-400">Prosedur tidak ditemukan</div>';
                    }

                    container.innerHTML = html;
                    container.classList.remove('hidden');
                })
                .catch(err => console.error('Error fetching prosedur:', err));
        }
    }));

    window.addAssistantRow = addAssistantRow;
    window.removeAssistantRow = removeAssistantRow;

    // LISTENER UNTUK DATA ODONTOGRAM YANG BARU DISIMPAN
    window.addEventListener('odontogram-saved', function(e) {
        const { registration_id, tooth_numbers } = e.detail;
        const currentRegId = document.getElementById('prosedur-registration-id')?.value;
        
        // Hanya sinkron jika ini registrasi yang sama
        if (registration_id && currentRegId && registration_id === currentRegId) {
            console.log("EMR: Menangkap update odontogram, sinkronisasi ke tabel prosedur...");
            applySavedToothNumbersToAllEmptyRows(registration_id);
            
            // Beri visual feedback singkat jika modal sedang terbuka
            const modal = document.getElementById('modalTambahProsedur');
            if (modal && !modal.classList.contains('hidden')) {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg z-[99999] text-xs font-bold animate-bounce';
                toast.innerText = 'No. Gigi disinkronkan dari Odontogram';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        }
    });

    </script>
