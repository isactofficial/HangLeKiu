@push('styles')
    <style>
      /* ===== MODAL ODONTOGRAM OVERLAY ===== */
      #modalOdontogramOverlay {
        backdrop-filter: blur(10px);
        background-color: rgba(15, 23, 42, 0.25); /* soft dark overlay, not full black */
        overflow-y: auto;
        padding: 16px;
      }

      #modalOdontogramOverlay > div {
        border-radius: 16px;
        box-shadow: 0 24px 55px rgba(0, 0, 0, 0.22);
        overflow: hidden;
        max-height: calc(100vh - 32px);
        width: min(100%, 64rem);
      }

      /* ===== MODAL HEADER ===== */
      #modalOdontogramOverlay .odonto-header {
        background: linear-gradient(180deg, #fdf7f1 0%, #ffffff 100%);
        padding: 20px 24px;
        border-bottom: 1px solid #f0e5d8;
      }

      #modalOdontogramOverlay .odonto-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #3b331e;
        letter-spacing: 0.01em;
        text-align: center;
        margin-bottom: 14px;
      }

      #modalOdontogramOverlay .odonto-close-btn {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #8e6a45;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 16px;
        right: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
      }

      #modalOdontogramOverlay .odonto-close-btn:hover {
        color: #6b4b2f;
        background: transparent;
      }

      /* ===== MODAL BODY ===== */
      #modalOdontogramOverlay .odonto-body {
        background: #fffdfa;
        min-height: 0;
        overflow-y: auto;
        padding: 20px 24px;
        max-height: calc(100vh - 220px);
      }

      #modalOdontogramOverlay .odonto-patient-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0e5d8;
        flex-wrap: wrap;
      }

      #modalOdontogramOverlay .odonto-patient-left {
        flex: 1;
        min-width: 250px;
      }

      #modalOdontogramOverlay .odonto-date {
        font-size: 12px;
        color: #7a5536;
        margin: 0 0 4px 0;
        font-weight: 600;
      }

      #modalOdontogramOverlay .odonto-patient-name {
        font-size: 14px;
        color: #3b331e;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      #modalOdontogramOverlay .odonto-patient-badge {
        font-size: 10px;
        font-weight: 600;
        background: #fef0e5;
        color: #8e6a45;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-block;
      }

      #modalOdontogramOverlay .odonto-patient-meta {
        font-size: 11px;
        color: #7a5536;
        display: flex;
        gap: 12px;
      }

      #modalOdontogramOverlay .odonto-clear-btn {
        padding: 6px 12px;
        background: transparent;
        border: 1px solid #d8c7b2;
        border-radius: 6px;
        font-size: 11px;
        color: #8e6a45;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        font-weight: 600;
      }

      #modalOdontogramOverlay .odonto-clear-btn:hover {
        background: #fef0e5;
        border-color: #c58f59;
      }

      /* ===== MODAL FOOTER ===== */
      #modalOdontogramOverlay .odonto-footer {
        background: #ffffff;
        border-top: 1px solid #f0e5d8;
        padding: 16px 24px;
        display: flex;
        justify-content: flex-end;
      }

      #modalOdontogramOverlay .odonto-save-btn {
        background: #3b331e;
        border: 0;
        border-radius: 6px;
        color: white;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(59, 51, 30, 0.2);
      }

      #modalOdontogramOverlay .odonto-save-btn:hover {
        background: #241f12;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(59, 51, 30, 0.25);
      }

      /* ===== CUSTOM SCROLLBAR ===== */
      #modalOdontogramOverlay ::-webkit-scrollbar {
        width: 6px;
      }
      #modalOdontogramOverlay ::-webkit-scrollbar-track {
        background: transparent;
      }
      #modalOdontogramOverlay ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 6px;
      }
      #modalOdontogramOverlay ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
      }

      /* ===== TOOLBAR SCROLLBAR ===== */
      #toolbarList::-webkit-scrollbar {
        width: 10px;
      }
      #toolbarList::-webkit-scrollbar-track {
        background: #fef0e5;
        border-radius: 8px;
      }
      #toolbarList::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #a87c4a 0%, #8e6a45 100%);
        border-radius: 8px;
      }
      #toolbarList::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #8e6a45 0%, #7a5a38 100%);
      }

      .tooth-surface:hover {
        fill: #e2e8f0;
        cursor: pointer;
      }

      /* ===== STYLING UNTUK INPUT TEETH TABLE ===== */
      #modalOdontogramOverlay input[data-tooth] {
        color: #3b331e !important;
        background-color: white !important;
        padding: 6px 8px !important;
        border: 1px solid #d8c7b2 !important;
        border-radius: 3px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-align: center !important;
        transition: all 0.15s ease !important;
      }

      #modalOdontogramOverlay input[data-tooth]:focus {
        border-color: #8e6a45 !important;
        background-color: #fefbf8 !important;
        box-shadow: 0 0 0 2px rgba(142, 106, 69, 0.1) !important;
      }

      #modalOdontogramOverlay input[data-tooth]::placeholder {
        color: #c9a885 !important;
      }

      /* Nomor gigi di tabel kanan-kiri atas-bawah selalu center. */
      #modalOdontogramOverlay .odonto-body .grid > div[style*="background-color: #fef0e5"] {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        text-align: center;
      }

      /* ===== EXTRA FORM (RAPIH) ===== */
      #modalOdontogramOverlay .odonto-extra-section {
        margin-top: 18px;
        padding: 16px;
        border: 1px solid #eadfd3;
        border-radius: 10px;
        background: #fff;
      }

      #modalOdontogramOverlay .odonto-extra-title {
        margin: 0 0 14px 0;
        font-size: 13px;
        font-weight: 700;
        color: #8e6a45;
      }

      #modalOdontogramOverlay .odonto-extra-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
      }

      #modalOdontogramOverlay .odonto-field {
        min-width: 0;
      }

      #modalOdontogramOverlay .odonto-field label {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #8e6a45;
      }

      #modalOdontogramOverlay .odonto-control {
        width: 100%;
        border: 1px solid #d8c7b2;
        border-radius: 8px;
        padding: 8px 10px;
        font-size: 12px;
        color: #3b331e;
        background: #fffdfa;
        outline: none;
      }

      #modalOdontogramOverlay .odonto-control:focus {
        border-color: #a67c52;
        box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.12);
        background: #fff;
      }

      #modalOdontogramOverlay .odonto-dmf-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
      }

      #modalOdontogramOverlay .odonto-dmf-row .odonto-field {
        width: 120px;
      }

      #modalOdontogramOverlay .odonto-notes-area {
        min-height: 96px;
        resize: vertical;
      }

      @media (max-width: 768px) {
        #modalOdontogramOverlay .odonto-extra-grid {
          grid-template-columns: 1fr;
        }

        #modalOdontogramOverlay .odonto-dmf-row .odonto-field {
          width: 100%;
        }
      }
    </style>
@endpush

<!-- OVERLAY MODAL -->
    <div
      id="modalOdontogramOverlay"
      class="hidden fixed inset-0 flex items-start md:items-center justify-center transition-opacity duration-300"
      style="z-index:2147483000;"
    >
      <!-- KONTEN MODAL -->
      <div
        class="bg-white rounded-lg shadow-2xl w-full flex flex-col relative transform transition-all scale-100"
        id="modalContainer"
      >
        <!-- Header Modal -->
        <div class="odonto-header flex-shrink-0 relative">
          <!-- Tombol Close (X) -->
          <button
            onclick="toggleOdontogramModal(false)"
            class="odonto-close-btn"
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

          <h2 class="odonto-title">
            Tambah Odontogram
          </h2>

          <!-- Input hidden untuk menampung PARENT ID (Patient ID) -->
          <input type="hidden" id="odontogramPatientId" value="dummy-patient-id" />
          <input type="hidden" id="odontogramVisitId" value="" />
          <input type="hidden" id="odontogramExaminedBy" value="" />

          <!-- Patient Info Section -->
          <div class="odonto-patient-info">
            <div class="odonto-patient-left">
              <p class="odonto-date" id="odonto-date-display">Tanggal Hari ini</p>
              <p class="odonto-patient-name">
                <span id="odonto-patient-name">Nama Pasien</span>
                <span class="odonto-patient-badge" id="odonto-patient-payment">Jenis Pembayaran</span>
              </p>
              <div class="odonto-patient-meta">
                <span id="odonto-patient-rm">No. RM</span>
                <span id="odonto-patient-demographics">&middot; Jenis Kelamin &middot; Umur</span>
              </div>
            </div>
            <button 
              class="odonto-clear-btn" 
              onclick="clearOdontogramState()"
              type="button"
            >
              Clear all notes
            </button>
          </div>
        </div>

        <!-- Body Modal (Scrollable) -->
        <div class="odonto-body flex-grow relative" id="modalBody">
          <!-- Tabel Gigi Atas - 4 Kolom: No Gigi | Isian | Isian | No Gigi -->
          <div class="text-xs mb-12" style="padding: 12px; background-color: #ffffff; border: 1px solid #d8c7b2; border-radius: 4px;">
            <div class="grid" style="grid-template-columns: 1fr 2fr 2fr 1fr; gap: 8px;">
              <!-- Row 1: 18 | input | input | 21 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">18</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="18" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="21" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">21 [61]</div>

              <!-- Row 2: 17 | input | input | 22 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">17</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="17" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="22" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">22 [62]</div>

              <!-- Row 3: 16 | input | input | 23 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">16</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="16" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="23" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">23 [63]</div>

              <!-- Row 4: 15 [55] | input | input | 24 [64] -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">15 [55]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="15" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="24" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">24 [64]</div>

              <!-- Row 5: 14 [54] | input | input | 25 [65] -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">14 [54]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="14" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="25" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">25 [65]</div>

              <!-- Row 6: 13 [53] | input | input | 26 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">13 [53]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="13" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="26" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">26</div>

              <!-- Row 7: 12 [52] | input | input | 27 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">12 [52]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="12" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="27" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">27</div>

              <!-- Row 8: 11 [51] | input | input | 28 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">11 [51]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="11" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="28" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">28</div>
            </div>
          </div>

          <!-- ODONTOGRAM MAP (Peta Gigi) -->
        <div class="flex flex-col items-center justify-center w-full overflow-x-auto py-4 mb-6">
            
            <div class="flex w-fit mx-auto justify-center gap-2 mb-6 px-2">
              <div class="flex justify-center gap-1.5" id="gigi-atas-kanan"></div>
              <div class="flex justify-center gap-1.5" id="gigi-atas-kiri"></div>
            </div>

            <div class="flex w-fit mx-auto justify-center gap-2 mb-4 px-2">
              <div class="flex justify-center gap-1.5" id="gigi-tengah-kanan"></div>
              <div class="flex justify-center gap-1.5" id="gigi-tengah-kiri"></div>
            </div>

            <div class="flex w-fit mx-auto justify-center gap-2 mb-6 px-2">
              <div class="flex justify-center gap-1.5" id="gigi-bawah-kanan"></div>
              <div class="flex justify-center gap-1.5" id="gigi-bawah-kiri"></div>
            </div>

          </div>

            <!-- TEMPLATE GIGI: HTML dipisah dari script -->
            <template id="toothTemplate">
              <div class="flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors tooth rounded p-0.5">
                <span data-role="label-top" class="text-[11px] font-bold text-gray-700 mb-1"></span>
                <svg width="32" height="32" viewBox="0 0 40 40" class="tooth-svg drop-shadow-sm">
                  <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#3b331e" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-top" />
                  <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#3b331e" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-right" />
                  <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#3b331e" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-bottom" />
                  <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#3b331e" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-left" />
                  <rect x="12" y="12" width="16" height="16" fill="white" stroke="#3b331e" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-center" />
                </svg>
                <span data-role="label-bottom" class="text-[11px] font-bold text-gray-700 mt-1"></span>
              </div>
            </template>
          

          <!-- Tabel Gigi Bawah - 4 Kolom: No Gigi | Isian | Isian | No Gigi -->
          <div class="text-xs mb-12" style="padding: 12px; background-color: #ffffff; border: 1px solid #d8c7b2; border-radius: 4px;">
            <div class="grid" style="grid-template-columns: 1fr 2fr 2fr 1fr; gap: 8px;">
              <!-- Row 1: 48 | input | input | 31 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">48</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="48" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="31" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">31 [71]</div>

              <!-- Row 2: 47 | input | input | 32 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">47</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="47" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="32" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">32 [72]</div>

              <!-- Row 3: 46 | input | input | 33 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">46</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="46" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="33" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">33 [73]</div>

              <!-- Row 4: 45 [85] | input | input | 34 [74] -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">45 [85]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="45" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="34" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">34 [74]</div>

              <!-- Row 5: 44 [84] | input | input | 35 [75] -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">44 [84]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="44" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="35" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">35 [75]</div>

              <!-- Row 6: 43 [83] | input | input | 36 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">43 [83]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="43" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="36" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">36</div>

              <!-- Row 7: 42 [82] | input | input | 37 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">42 [82]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="42" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="37" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">37</div>

              <!-- Row 8: 41 [81] | input | input | 38 -->
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">41 [81]</div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="41" readonly /></div>
              <div class="p-2"><input type="text" class="w-full outline-none" data-tooth="38" readonly /></div>
              <div class="p-3 text-center font-semibold" style="background-color: #fef0e5; color: #8e6a45;">38</div>
            </div>
          </div>

          <!-- Form Tambahan Bawah -->
          <div class="odonto-extra-section">
            <h3 class="odonto-extra-title">Informasi Tambahan</h3>
            <div class="odonto-extra-grid">
              <div class="odonto-field">
                <label>Occlusi</label>
                <select name="occlusi" class="odonto-control">
                  <option></option>
                  <option value="Normal">Normal</option>
                  <option value="Kelainan">Kelainan</option>
                </select>
              </div>
              <div class="odonto-field">
                <label>Torus Palatinus</label>
                <select name="torus_palatinus" class="odonto-control">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kecil">Kecil</option>
                <option value="Sedang">Sedang</option>
                <option value="Besar">Besar</option>
                <option value="Multiple">Multiple</option>
              </select>
            </div>
              <div class="odonto-field">
                <label>Diastema</label>
                <input
                  type="text"
                  name="diastema"
                  placeholder="Dijelaskan dimana dan berapa lebarnya"
                  class="odonto-control"
                />
              </div>
              <div class="odonto-field">
                <label>Torus Mandibularis</label>
                <select name="torus_mandibularis" class="odonto-control">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kiri">Kiri</option>
                <option value="Kanan">Kanan</option>
                <option value="Bilateral">Bilateral</option>
              </select>
            </div>
              <div class="odonto-field">
                <label>Palatum</label>
                <select name="palatum" class="odonto-control">
                  <option></option>
                  <option value="Dalam">Dalam</option>
                  <option value="Sedang">Sedang</option>
                  <option value="Rendah">Rendah</option>
                </select>
              </div>
              <div class="odonto-field">
                <label>Gigi Anomali</label>
                <input
                  type="text"
                  name="anomali"
                  placeholder="Dijelaskan gigi mana dan bentuknya"
                  class="odonto-control"
                />
              </div>
            </div>
          </div>

          <div class="odonto-extra-section">
            <div class="odonto-dmf-row">
              <div class="odonto-field">
                <label>D (Distal)</label>
                <input type="text" name="odonto_d" class="odonto-control" />
              </div>
              <div class="odonto-field">
                <label>M (Mesial)</label>
                <input type="text" name="odonto_m" class="odonto-control" />
              </div>
              <div class="odonto-field">
                <label>F (Facial)</label>
                <input type="text" name="odonto_f" class="odonto-control" />
              </div>
            </div>
          </div>

          <div class="odonto-extra-section">
            <label style="display:block; margin-bottom:8px; font-size:11px; font-weight:700; color:#8e6a45;">Catatan Lainnya</label>
            <textarea
              name="odonto_notes"
              class="odonto-control odonto-notes-area"
              rows="3"
            ></textarea>
          </div>

        </div>

 

        <!-- Footer Modal -->
        <div class="odonto-footer flex-shrink-0">
          <button
            onclick="submitOdontogram()"
            class="odonto-save-btn"
            type="button"
          >
            SIMPAN
          </button>
        </div>

        </div>
       
      </div>
    </div>

    <!-- TOOLBAR ODONTOGRAM -->
   <div
    id="toolbar"
    class="hidden fixed bg-white shadow-2xl rounded-xl border-0 text-sm flex flex-col overflow-hidden"
    style="z-index:2147483642; width: 450px; height: 450px; border: 3px solid #8e6a45; padding: 12px;"
  >
    
    <div id="toolbarHeader" class="px-4 py-3 flex items-center bg-gradient-to-r rounded-lg cursor-grab active:cursor-grabbing mb-3" style="background: linear-gradient(135deg, #8e6a45 0%, #a87c4a 100%); flex-shrink: 0; user-select: none;">
      <div class="w-6"></div> 
      <span class="flex-1 font-bold text-white text-sm flex items-center justify-center gap-2">
        Toolbar Odontogram
      </span>
      <button onclick="document.getElementById('toolbar').classList.add('hidden'); document.getElementById('toolbarToothPicker')?.classList.add('hidden');" class="w-6 text-white hover:bg-white hover:bg-opacity-20 p-1 rounded transition flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <div class="px-3 py-2.5 border-b rounded-lg mb-3" style="border-color: #f0e5d8; flex-shrink: 0; background: #fef0e5;">
      <input
        type="text"
        id="toolbarSearch"
        placeholder="Cari ketentuan..."
        class="w-full outline-none px-3 py-2 rounded text-sm" 
        style="background-color: #ffffff; border: 1px solid #e5d1b8; color: #3b331e;"
        oninput="filterToolbar(event)"
      />
    </div>

    

    <div class="overflow-y-auto py-2 px-2 space-y-2 flex-1 min-h-0" id="toolbarList" style="border-bottom: 2px solid #f0e5d8; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; border-radius: 8px;">
      
      <div class="grid gap-2">

      <div id="toolbarToothPicker" class="hidden px-3 py-2.5 border-b rounded-lg mb-3" style="border-color: #f0e5d8; flex-shrink: 0; background: #fffaf5; border: 1px solid #e5d1b8;">
      <div id="toolbarToothPickerLabel" class="text-sm font-bold mb-2" style="color:#8e6a45;">Pilih nomor gigi</div>
      <div id="toolbarToothPickerOptions" class="flex gap-2 flex-wrap text-sm"></div>
      </div>
        
        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="background-color: #fef0e5; border: 2px solid #d8c7b2;" onclick="applyCondition('clear')">
          <div class="text-xl font-black flex items-center justify-center w-9 h-9 bg-white rounded flex-shrink-0" style="color: #8e6a45; border: 1px solid #e5d1b8;">✕</div>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px]" style="color: #3b331e;">Reset Kondisi</p>
            <p class="text-[11px] leading-tight text-gray-600 mt-0.5">Bersihkan semua tanda pada gigi ini</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #7c70ab; background-color: #f3f0ff;" onclick="applyCondition('mesial')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#7c70ab" stroke="#6f639e" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-800">Mesial <span class="font-normal text-gray-600">(M)</span></p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Sisi dekat garis wajah</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #5e88c9; background-color: #f0f7ff;" onclick="applyCondition('distal')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#5e88c9" stroke="#5275b8" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-800">Distal <span class="font-normal text-gray-600">(D)</span></p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Sisi jauh garis wajah</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #50c878; background-color: #f0fdf4;" onclick="applyCondition('occlusal')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#50c878" stroke="#3da85f" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-800">Occlusal <span class="font-normal text-gray-600">(O)</span></p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Permukaan kunyah</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #f59e0b; background-color: #fffbf0;" onclick="applyCondition('buccal')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#f59e0b" stroke="#e59d00" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-800">Buccal <span class="font-normal text-gray-600">(B)</span></p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Sisi mengarah pipi</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #ec4899; background-color: #fdf2f8;" onclick="applyCondition('lingual')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#ec4899" stroke="#d93680" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-800">Lingual <span class="font-normal text-gray-600">(L)</span></p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Sisi mengarah lidah</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #ef4444; background-color: #fef2f2;" onclick="applyCondition('caries')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-red-700">Karies <span class="font-normal text-red-600">(CAR)</span></p>
            <p class="text-[11px] text-red-500 leading-tight mt-0.5">Gigi berlubang / busuk</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #22c55e; background-color: #f0fdf4;" onclick="applyCondition('tambalan')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-green-700">Tambalan <span class="font-normal text-green-600">(FIL)</span></p>
            <p class="text-[11px] text-green-600 leading-tight mt-0.5">Gigi sudah ditambal</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #f97316; background-color: #fef3f2;" onclick="applyCondition('sisa_akar')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-orange-600">Sisa Akar <span class="font-normal text-orange-500">(ROT)</span></p>
            <p class="text-[11px] text-orange-500 leading-tight mt-0.5">Mahkota hilang, sisa akar</p>
          </div>
        </div>

        <div class="toolbar-item flex flex-row items-center p-3 hover:shadow-lg rounded-lg cursor-pointer transition gap-6" style="border: 2px solid #000; background-color: #f5f5f5;" onclick="applyCondition('missing')">
          <svg width="36" height="36" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <line x1="4" y1="4" x2="36" y2="36" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
            <line x1="36" y1="4" x2="4" y2="36" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          <div class="flex flex-col text-left">
            <p class="font-bold text-[13px] text-gray-900">Gigi Hilang <span class="font-normal text-gray-600">(MIS)</span></p>
            <p class="text-[11px] text-gray-600 leading-tight mt-0.5">Telah dicabut / tidak ada</p>
          </div>
        </div>

      </div>
    </div>
  </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
    
      // Pastikan overlay Odontogram berada langsung di dalam <body>
      (function() {
        const modal = document.getElementById("modalOdontogramOverlay");
        if (modal && modal.parentElement !== document.body) {
          document.body.appendChild(modal);
        }
      })();

     // ==========================================
      // FUNGSI UNTUK BUKA/TUTUP MODAL UTAMA
      // ==========================================
      function toggleOdontogramModal(show, patientData = null) {
        const modal = document.getElementById("modalOdontogramOverlay");
        const toolbar = document.getElementById("toolbar");

        if (show) {
            // KUNCI MATI SCROLL HALAMAN UTAMA (EMR) AGAR TIDAK BOCOR
            document.body.style.overflow = "hidden";

            // Tembak data pasien ke dalam modal jika datanya dikirim
            if (patientData) {
                // Simpan data pasien secara global agar bisa dipakai saat pindah ke modal prosedur
                window.lastOdontoPatientData = patientData;

                document.getElementById('odonto-patient-name').innerText = patientData.name || '-';
                document.getElementById('odonto-patient-rm').innerText = patientData.rm || '-';
                document.getElementById('odonto-patient-demographics').innerHTML = 
                    `&middot; ${patientData.gender || '-'} &middot; ${patientData.age || '-'}`;
                document.getElementById('odonto-patient-payment').innerText = patientData.payment || 'Umum';
                
                // Input hidden untuk proses simpan ke database
                document.getElementById('odontogramPatientId').value = patientData.patient_id || '';
                document.getElementById('odontogramVisitId').value = patientData.registration_id || '';
              
              // Set dokter otomatis (Nama Dokter)
              if (patientData.doctor_name) {
                  const exInp = document.getElementById('odontogramExaminedBy');
                  if (exInp) exInp.value = patientData.doctor_name;
              }
            }

          // 2. Set tanggal hari ini
          const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
          document.getElementById('odonto-date-display').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

          const patientIdToLoad = document.getElementById('odontogramPatientId')?.value;
          clearOdontogramState();
          if (patientIdToLoad) {
            loadLatestOdontogramToForm(patientIdToLoad);
          }

          modal.classList.remove("hidden");
        } else {
          // BUKA KEMBALI SCROLL HALAMAN UTAMA SAAT MODAL DITUTUP
          document.body.style.overflow = "";

          modal.classList.add("hidden");
          if (toolbar) toolbar.classList.add("hidden");
        }
      }

      // ==========================================
      // LOGIKA ODONTOGRAM MAP
      // ==========================================
      const urTeeth = [18, 17, 16, 15, 14, 13, 12, 11]; // Atas Kanan
      const ulTeeth = [21, 22, 23, 24, 25, 26, 27, 28]; // Atas Kiri
      const mrTeeth = [55, 54, 53, 52, 51]; // Tengah Kanan (Susu)
      const mlTeeth = [61, 62, 63, 64, 65]; // Tengah Kiri (Susu)
      const lrTeeth = [48, 47, 46, 45, 44, 43, 42, 41]; // Bawah Kanan
      const llTeeth = [31, 32, 33, 34, 35, 36, 37, 38]; // Bawah Kiri
      const toothTemplate = document.getElementById("toothTemplate");

      function createToothGraphic(number, isBottom = false) {
        if (!toothTemplate) return null;

        const toothEl = toothTemplate.content.firstElementChild.cloneNode(true);
        toothEl.id = `tooth-${number}`;

        const labelTop = toothEl.querySelector('[data-role="label-top"]');
        const labelBottom = toothEl.querySelector('[data-role="label-bottom"]');

        if (labelBottom) labelBottom.remove();
        if (labelTop) labelTop.textContent = number;

        toothEl.addEventListener("click", function(event) {
          openToolbar(event, toothEl, number);
        });

        return toothEl;
      }

      function renderToothRow(containerId, teeth, isBottom = false) {
        const container = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = "";
        teeth.forEach((num) => {
          const toothNode = createToothGraphic(num, isBottom);
          if (toothNode) container.appendChild(toothNode);
        });
      }

      // Render peta gigi ke DOM
      renderToothRow("gigi-atas-kanan", urTeeth);
      renderToothRow("gigi-atas-kiri", ulTeeth);
      renderToothRow("gigi-tengah-kanan", mrTeeth);
      renderToothRow("gigi-tengah-kiri", mlTeeth);
      renderToothRow("gigi-bawah-kanan", lrTeeth, true);
      renderToothRow("gigi-bawah-kiri", llTeeth, true);

      // ==========================================
      // STATE MANAGEMENT PERGIGIAN
      // ==========================================
      let teethState = {};

      function initToothState(number) {
        if (!teethState[number]) {
            teethState[number] = {
                surfaces: [],
            surface_colors: {},
                condition_code: null,
                condition_label: null,
                color_code: null,
                notes: ""
            };
        }
      }

      // Memasang event listener untuk setiap input pada Tabel Atas/Bawah
      document.addEventListener('DOMContentLoaded', function() {
          // Setup event listeners untuk semua input teeth
          const allToothInputs = document.querySelectorAll('#modalOdontogramOverlay input[data-tooth]');
          allToothInputs.forEach(input => {
            // Aktifkan input tabel agar bisa diketik langsung.
            input.removeAttribute('readonly');

            const openToolbarFromInput = function(e) {
              const selectedTooth = pickToothNumberForInput(this, e.type === 'click');
              if (selectedTooth === null) return;

              const toothGraphic = document.getElementById(`tooth-${selectedTooth}`);
              openToolbar(e, toothGraphic || null, selectedTooth, this);
            };

            input.addEventListener('focus', openToolbarFromInput);
            input.addEventListener('click', openToolbarFromInput);

              input.addEventListener('input', function(e) {
                  const selectedTooth = pickToothNumberForInput(this, false);
                  if (selectedTooth === null) return;

                  setToothNoteValue(selectedTooth, e.target.value);
                  
                  // Real-time display: update textarea display jika ada
                  const displayArea = document.getElementById('odonto-notes-display');
                  if (displayArea) {
                      let allNotes = [];
                      Object.keys(teethState).forEach(tooth => {
                          if (teethState[tooth].notes) {
                              allNotes.push(`Gigi ${tooth}: ${teethState[tooth].notes}`);
                          }
                      });
                      displayArea.value = allNotes.join('\n');
                  }
              });
          });
      });

      // ==========================================
      // FUNGSI RESET KONDISI / CLEAR NOTES
      // ==========================================
      function clearOdontogramState() {
          teethState = {}; // Kosongkan dictionary memory
          
          // Reset semua polygon warna ke putih
          const allSurfaces = document.querySelectorAll('#modalOdontogramOverlay .tooth-surface');
          allSurfaces.forEach(s => {
              // Abaikan X mark jika missing
              if(s.tagName === 'polygon' || s.tagName === 'path' || s.tagName === 'rect' || s.tagName === 'circle') {
                  s.setAttribute("fill", "white");
              }
          });
          
          // Reset input notes di tabel
          const tableInputs = document.querySelectorAll('#modalOdontogramOverlay input[data-tooth]');
          tableInputs.forEach(input => {
            input.value = '';
            delete input.dataset.selectedTooth;
            input.title = '';
          });
          
          // Reset dropdown dan text input pada "Form Tambahan Bawah"
          const allSelects = document.querySelectorAll('#modalOdontogramOverlay select');
          allSelects.forEach(sel => sel.selectedIndex = 0);
          
          // Reset D, M, F & form lain
          const allInputs = document.querySelectorAll('#modalOdontogramOverlay input[type="text"]:not(#toolbarSearch)');
          allInputs.forEach(input => input.value = '');
          
          // Reset textarea Catatan Lainnya
          const allTextAreas = document.querySelectorAll('#modalOdontogramOverlay textarea');
          allTextAreas.forEach(ta => ta.value = '');

            activeInputElement = null;
            if (toolbarToothPicker) toolbarToothPicker.classList.add('hidden');
      }

      function colorForSurfaceFlag(flag) {
        if (flag === 'M') return '#7c70ab';
        if (flag === 'D') return '#5e88c9';
        if (flag === 'O' || flag === 'C') return '#50c878';
        if (flag === 'B') return '#f59e0b';
        if (flag === 'L') return '#ec4899';
        return '#d8c7b2';
      }

      function paintToothFromState(toothNumber) {
        const toothEl = document.getElementById(`tooth-${toothNumber}`);
        const state = teethState[toothNumber];
        if (!toothEl || !state) return;

        const surfaces = toothEl.querySelectorAll('.tooth-surface');
        surfaces.forEach((s) => s.setAttribute('fill', 'white'));

        if (state.condition_code && state.surfaces.length === 0 && state.color_code) {
          surfaces.forEach((s) => s.setAttribute('fill', state.color_code));
          return;
        }

        state.surfaces.forEach((flag) => {
          const drawColor = state.color_code || colorForSurfaceFlag(flag);
          if (flag === 'M') toothEl.querySelector('.surface-left')?.setAttribute('fill', drawColor);
          if (flag === 'D') toothEl.querySelector('.surface-right')?.setAttribute('fill', drawColor);
          if (flag === 'O' || flag === 'C') toothEl.querySelector('.surface-center')?.setAttribute('fill', drawColor);
          if (flag === 'B') toothEl.querySelector('.surface-top')?.setAttribute('fill', drawColor);
          if (flag === 'L') toothEl.querySelector('.surface-bottom')?.setAttribute('fill', drawColor);
        });
      }

      function fillExtraFieldsFromRecord(record) {
        const notesText = String(record?.notes || '');
        const getLineValue = (label) => {
          const escaped = label.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
          const match = notesText.match(new RegExp(`^${escaped}:\\s*(.*)$`, 'mi'));
          return match ? match[1].trim() : '';
        };

        const setValue = (selector, value) => {
          const el = document.querySelector(selector);
          if (!el) return;
          el.value = value || '';
        };

        setValue('select[name="occlusi"]', getLineValue('Occlusi'));
        setValue('select[name="torus_palatinus"]', getLineValue('Torus Palatinus'));
        setValue('input[name="diastema"]', getLineValue('Diastema'));
        setValue('select[name="torus_mandibularis"]', getLineValue('Torus Mandibularis'));
        setValue('select[name="palatum"]', getLineValue('Palatum'));
        setValue('input[name="anomali"]', getLineValue('Gigi Anomali'));

        const dmfMatch = notesText.match(/^\s*D:\s*([^,\n]*),\s*M:\s*([^,\n]*),\s*F:\s*([^\n\r]*)/mi);
        if (dmfMatch) {
          const cleanD = (dmfMatch[1] || '').trim();
          const cleanM = (dmfMatch[2] || '').trim();
          const cleanF = (dmfMatch[3] || '')
            .replace(/\s*Catatan\s+Tambahan\s*:?\s*$/i, '')
            .trim();

          setValue('input[name="odonto_d"]', cleanD);
          setValue('input[name="odonto_m"]', cleanM);
          setValue('input[name="odonto_f"]', cleanF);
        }

        const extraNoteMatch = notesText.match(/(?:^|\n)\s*Catatan Tambahan:\s*([\s\S]*)$/i);
        const cleanExtraNotes = (extraNoteMatch ? extraNoteMatch[1] : '')
          .replace(/^\s*Catatan\s+Tambahan\s*:\s*/i, '')
          .trim();
        setValue('textarea[name="odonto_notes"]', cleanExtraNotes);
      }

      function hydrateOdontogramFromRecord(record) {
        if (!record) return;

        clearOdontogramState();
        fillExtraFieldsFromRecord(record);

        const exInp = document.getElementById('odontogramExaminedBy');
        if (exInp) exInp.value = record.examined_by || exInp.value || '';

        const teeth = Array.isArray(record.teeth) ? record.teeth : [];
        teeth.forEach((toothRow) => {
          const toothNumber = parseInt(toothRow.tooth_number, 10);
          if (Number.isNaN(toothNumber)) return;

          const surfacesArray = String(toothRow.surfaces || '')
            .split(',')
            .map((v) => v.trim())
            .filter(Boolean);

          teethState[toothNumber] = {
            surfaces: surfacesArray,
            surface_colors: {},
            condition_code: toothRow.condition_code || null,
            condition_label: toothRow.condition_label || null,
            color_code: toothRow.color_code || null,
            notes: toothRow.notes || ''
          };

          syncToothNoteValue(toothNumber);
          paintToothFromState(toothNumber);
        });
      }

      async function loadLatestOdontogramToForm(patientId) {
        if (!patientId || patientId === 'dummy-patient-id') return;

        try {
          const response = await fetch(`/api/odontogram/patient/${patientId}`, {
            headers: { 'Accept': 'application/json' }
          });
          const data = await response.json();

          if (!response.ok || data.status !== 'success') {
            throw new Error(data.message || 'Gagal memuat odontogram terakhir');
          }

          const records = Array.isArray(data.data) ? data.data : [];
          if (records.length > 0) {
            hydrateOdontogramFromRecord(records[0]);
          }
        } catch (err) {
          console.warn('Gagal memuat data odontogram terakhir:', err?.message || err);
        }
      }

     // Variabel penampung state Toolbar
      const toolbar = document.getElementById("toolbar");
      const modalBody = document.getElementById("modalBody");
      const toolbarList = document.getElementById("toolbarList");
        const toolbarToothPicker = document.getElementById("toolbarToothPicker");
        const toolbarToothPickerLabel = document.getElementById("toolbarToothPickerLabel");
        const toolbarToothPickerOptions = document.getElementById("toolbarToothPickerOptions");
      let activeToothElement = null;
      let activeToothNumber = null;
        let activeInputElement = null;

      // ==========================================
      // FUNGSI MEMBUKA TOOLBAR
      // ==========================================
      
      // Fungsi untuk mengatur posisi awal dan batas layer
      function openToolbar(event, element, number, anchorElement = null) {
        if (!toolbar) return;
        event.stopPropagation();
        activeToothElement = element || document.getElementById(`tooth-${number}`) || null;
        activeToothNumber = number;
        activeInputElement = (anchorElement && anchorElement.matches && anchorElement.matches('input[data-tooth]')) ? anchorElement : null;
        renderToolbarToothPicker(activeInputElement);

        // Tampilkan toolbar
        toolbar.classList.remove("hidden");
        toolbar.style.transform = "none";

        // Sesuaikan ukuran toolbar agar tidak melebihi viewport (khususnya layar kecil/mobile)
        const viewportPadding = 16;
        const maxToolbarWidth = Math.max(280, window.innerWidth - (viewportPadding * 2));
        const maxToolbarHeight = Math.max(260, window.innerHeight - (viewportPadding * 2));
        toolbar.style.width = `${Math.min(450, maxToolbarWidth)}px`;
        toolbar.style.height = `${Math.min(450, maxToolbarHeight)}px`;

        const anchor = anchorElement || element;
        const elRect = anchor.getBoundingClientRect();
        const toolbarWidth = toolbar.offsetWidth || 320;
        const toolbarHeight = toolbar.offsetHeight || 320;

        // Posisi default: di bawah gigi, posisi tengah sejajar dengan gigi
        let topPos = elRect.bottom + 8; 
        let leftPos = elRect.left - (toolbarWidth / 2) + (elRect.width / 2);

        // KOREKSI BATAS LAYAR (Agar tidak keluar/melebihi batas browser)
        if (leftPos + toolbarWidth > window.innerWidth - viewportPadding) {
          leftPos = window.innerWidth - toolbarWidth - viewportPadding;
        }
        if (leftPos < viewportPadding) {
          leftPos = viewportPadding;
        }

        // Jika muncul di bawah melebihi layar, pindahkan ke atas anchor
        if (topPos + toolbarHeight > window.innerHeight - viewportPadding) {
          topPos = elRect.top - toolbarHeight - 8;
        }

        // Clamp terakhir agar tetap berada dalam viewport
        if (topPos < viewportPadding) {
          topPos = viewportPadding;
        }
        if (topPos + toolbarHeight > window.innerHeight - viewportPadding) {
          topPos = window.innerHeight - toolbarHeight - viewportPadding;
        }
        if (leftPos + toolbarWidth > window.innerWidth - viewportPadding) {
          leftPos = window.innerWidth - toolbarWidth - viewportPadding;
        }
        if (leftPos < viewportPadding) {
          leftPos = viewportPadding;
        }

        // Set posisi absolute-nya
        toolbar.style.top = topPos + "px";
        toolbar.style.left = leftPos + "px";
      }

      // ==========================================
      // LOGIKA DRAG AND DROP TOOLBAR
      // ==========================================
      const toolbarHeader = document.getElementById("toolbarHeader");
      let isDragging = false;
      let startX, startY, initialLeft, initialTop;

      if (toolbarHeader && toolbar) {
          // Event untuk Mouse (PC)
          toolbarHeader.addEventListener("mousedown", dragStart);
          document.addEventListener("mousemove", drag);
          document.addEventListener("mouseup", dragEnd);

          // Event untuk Layar Sentuh (HP)
          toolbarHeader.addEventListener("touchstart", dragStart, {passive: false});
          document.addEventListener("touchmove", drag, {passive: false});
          document.addEventListener("touchend", dragEnd);
      }

      function dragStart(e) {
          // PENTING: Jangan aktifkan drag jika user mengklik tombol Close (X)
          if (e.target.closest('button')) return;

          if (e.type === "touchstart") {
              startX = e.touches[0].clientX;
              startY = e.touches[0].clientY;
          } else {
              startX = e.clientX;
              startY = e.clientY;
          }
          
          const rect = toolbar.getBoundingClientRect();
          initialLeft = rect.left;
          initialTop = rect.top;
          
          isDragging = true;
          toolbarHeader.classList.add("cursor-grabbing");
      }

      function drag(e) {
          if (!isDragging) return;
          
          // Mencegah background ikut terscroll HANYA saat sedang aktif nge-drag header
          e.preventDefault(); 

          let currentX, currentY;
          if (e.type === "touchmove") {
              currentX = e.touches[0].clientX;
              currentY = e.touches[0].clientY;
          } else {
              currentX = e.clientX;
              currentY = e.clientY;
          }

          const dx = currentX - startX;
          const dy = currentY - startY;

          let newLeft = initialLeft + dx;
          let newTop = initialTop + dy;

          // Batasi agar tidak digeser jauh ke luar layar
          const rect = toolbar.getBoundingClientRect();
          if (newLeft < 0) newLeft = 0;
          if (newTop < 0) newTop = 0;
          if (newLeft + rect.width > window.innerWidth) newLeft = window.innerWidth - rect.width;
          if (newTop + rect.height > window.innerHeight) newTop = window.innerHeight - rect.height;

          toolbar.style.left = newLeft + "px";
          toolbar.style.top = newTop + "px";
      }

      function dragEnd(e) {
          isDragging = false;
          if (toolbarHeader) {
            toolbarHeader.classList.remove("cursor-grabbing");
          }
      }
      
      // ==========================================
      // KUNCI SCROLL TOOLBAR (100% ANTI TEMBUS)
      // ==========================================
      if (toolbar) {
          // Tangkap Mouse Wheel (PC)
          toolbar.addEventListener('wheel', function(e) {
              const list = document.getElementById("toolbarList");
              
              // Jika kursor di luar list (misal di header), bunuh scroll
              if (!list.contains(e.target)) {
                  e.preventDefault();
                  return;
              }

              // Jika di dalam list, cek mentok atas/bawah
              const isAtTop = list.scrollTop === 0;
              const isAtBottom = Math.abs(list.scrollHeight - list.scrollTop - list.clientHeight) < 1;

              if (e.deltaY < 0 && isAtTop) e.preventDefault(); // Mentok atas
              if (e.deltaY > 0 && isAtBottom) e.preventDefault(); // Mentok bawah
              
              e.stopPropagation(); // Jangan teruskan event ke modal
          }, { passive: false });

          // Tangkap Touch (HP/Tablet)
          let tsY = 0;
          toolbar.addEventListener('touchstart', function(e) { 
              tsY = e.touches[0].clientY; 
          }, { passive: true });

          toolbar.addEventListener('touchmove', function(e) {
              if (isDragging) return; // Biarkan jika sedang ditarik/drag

              const list = document.getElementById("toolbarList");
              if (!list.contains(e.target)) {
                  e.preventDefault();
                  return;
              }

              const currentY = e.touches[0].clientY;
              const isAtTop = list.scrollTop === 0;
              const isAtBottom = Math.abs(list.scrollHeight - list.scrollTop - list.clientHeight) < 1;

              if (isAtTop && currentY > tsY) e.preventDefault();
              if (isAtBottom && currentY < tsY) e.preventDefault();
              
              e.stopPropagation();
          }, { passive: false });
      }
      // Terapkan kondisi dari toolbar ke gigi
      const toothFieldAliasMap = {
        55: 15,
        54: 14,
        53: 13,
        52: 12,
        51: 11,
        61: 21,
        62: 22,
        63: 23,
        64: 24,
        65: 25,
        85: 45,
        84: 44,
        83: 43,
        82: 42,
        81: 41,
        71: 31,
        72: 32,
        73: 33,
        74: 34,
        75: 35
      };

      function getToothInputTargets(toothNumber) {
        const targets = [toothNumber];
        const aliasTarget = toothFieldAliasMap[toothNumber];
        if (aliasTarget && aliasTarget !== toothNumber) {
          targets.push(aliasTarget);
        }
        return targets;
      }

      function getToothNumbersForTarget(targetToothNumber) {
        const target = parseInt(targetToothNumber, 10);
        if (Number.isNaN(target)) return [];

        const related = new Set([target]);
        Object.entries(toothFieldAliasMap).forEach(([from, to]) => {
          const fromNum = parseInt(from, 10);
          const toNum = parseInt(to, 10);
          if (toNum === target) related.add(fromNum);
          if (fromNum === target) related.add(toNum);
        });

        return Array.from(related);
      }

      function getToothDisplayToken(toothNumber) {
        const tooth = teethState[toothNumber];
        if (!tooth) return "";

        const hasCondition = !!tooth.condition_code;
        const hasSurfaces = Array.isArray(tooth.surfaces) && tooth.surfaces.length > 0;
        const hasNotes = typeof tooth.notes === "string" && tooth.notes.trim() !== "";

        if (!hasCondition && !hasSurfaces && !hasNotes) {
          return "";
        }

        const base = [];
        if (hasCondition) base.push(tooth.condition_code);
        if (hasSurfaces) base.push(tooth.surfaces.join('+'));
        if (hasNotes) base.push(tooth.notes.trim());

        return base.join('.');
      }

      function syncToothInputsByTarget(targetToothNumber) {
        const inputs = document.querySelectorAll(`input[data-tooth="${targetToothNumber}"]`);
        if (!inputs.length) return;

        const relatedTeeth = getToothNumbersForTarget(targetToothNumber);
        const tokens = relatedTeeth
          .map((toothNumber) => {
            const token = getToothDisplayToken(toothNumber);
            if (!token) return "";

            // Jika 1 field mewakili 2 gigi (contoh 11[51]), tampilkan nomor gigi agar tidak saling timpa.
            return `${toothNumber}:${token}`;
          })
          .filter(Boolean);

        const value = tokens.join(' + ');
        inputs.forEach((input) => {
          input.value = value;
        });
      }

      function syncToothNoteValue(toothNumber) {
        getToothInputTargets(toothNumber).forEach((targetToothNumber) => {
          syncToothInputsByTarget(targetToothNumber);
        });
      }

      function getToothNoteInputs(toothNumber) {
        const inputs = [];
        getToothInputTargets(toothNumber).forEach((target) => {
          const found = document.querySelectorAll(`input[data-tooth="${target}"]`);
          found.forEach((input) => inputs.push(input));
        });
        return inputs;
      }

      function setToothNoteValue(toothNumber, value) {
        const toothNum = parseInt(toothNumber, 10);
        if (!Number.isNaN(toothNum)) {
          initToothState(toothNum);
          teethState[toothNum].notes = value || "";
          syncToothNoteValue(toothNum);
        }
      }

      function renderToolbarToothPicker(inputEl) {
        if (!toolbarToothPicker || !toolbarToothPickerOptions || !toolbarToothPickerLabel) return;

        if (!inputEl) {
          toolbarToothPicker.classList.add('hidden');
          toolbarToothPickerOptions.innerHTML = '';
          return;
        }

        const targetTooth = parseInt(inputEl.getAttribute('data-tooth'), 10);
        const relatedTeeth = getToothNumbersForTarget(targetTooth).sort((a, b) => a - b);

        if (relatedTeeth.length <= 1) {
          toolbarToothPicker.classList.add('hidden');
          toolbarToothPickerOptions.innerHTML = '';
          return;
        }

        toolbarToothPicker.classList.remove('hidden');
        toolbarToothPickerLabel.textContent = `Pilih nomor gigi (${relatedTeeth.join('/')})`;

        let selected = parseInt(inputEl.dataset.selectedTooth || '', 10);
        if (Number.isNaN(selected) || !relatedTeeth.includes(selected)) {
          selected = relatedTeeth[0];
          inputEl.dataset.selectedTooth = String(selected);
        }

        inputEl.title = `Sedang mengisi gigi ${selected} (field gabungan: ${relatedTeeth.join('/')})`;

        toolbarToothPickerOptions.innerHTML = '';
        relatedTeeth.forEach((toothNumber) => {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'px-3 py-1.5 rounded text-sm font-semibold border transition';

          if (toothNumber === selected) {
            btn.style.background = '#8e6a45';
            btn.style.color = '#ffffff';
            btn.style.borderColor = '#8e6a45';
            btn.textContent = `${toothNumber} ✓`;
          } else {
            btn.style.background = '#ffffff';
            btn.style.color = '#8e6a45';
            btn.style.borderColor = '#d8c7b2';
            btn.textContent = String(toothNumber);
          }

          btn.addEventListener('click', function(ev) {
            ev.stopPropagation();
            inputEl.dataset.selectedTooth = String(toothNumber);
            inputEl.title = `Sedang mengisi gigi ${toothNumber} (field gabungan: ${relatedTeeth.join('/')})`;

            activeToothNumber = toothNumber;
            activeToothElement = document.getElementById(`tooth-${toothNumber}`);
            renderToolbarToothPicker(inputEl);
          });

          toolbarToothPickerOptions.appendChild(btn);
        });
      }

      function pickToothNumberForInput(inputEl, forcePick = false) {
        const targetTooth = parseInt(inputEl.getAttribute('data-tooth'), 10);
        if (Number.isNaN(targetTooth)) return null;

        const relatedTeeth = getToothNumbersForTarget(targetTooth).sort((a, b) => a - b);
        if (relatedTeeth.length <= 1) {
          inputEl.dataset.selectedTooth = String(targetTooth);
          inputEl.title = `Input gigi ${targetTooth}`;
          renderToolbarToothPicker(inputEl);
          return targetTooth;
        }

        let selected = parseInt(inputEl.dataset.selectedTooth || '', 10);
        if (Number.isNaN(selected) || !relatedTeeth.includes(selected)) {
          selected = relatedTeeth[0];
          inputEl.dataset.selectedTooth = String(selected);
        }

        inputEl.title = `Sedang mengisi gigi ${selected} (field gabungan: ${relatedTeeth.join('/')})`;
        renderToolbarToothPicker(inputEl);
        return selected;
      }

      function applyCondition(condition) {
        if (activeToothNumber === null || Number.isNaN(parseInt(activeToothNumber, 10))) {
          alert("Pilih gigi terlebih dahulu!");
          return;
        }

        const toothNumber = parseInt(activeToothNumber, 10);
        initToothState(toothNumber);
        const state = teethState[toothNumber];

        const surfaces = activeToothElement ? activeToothElement.querySelectorAll(".tooth-surface") : [];

        if (condition === "clear") {
          if (activeToothElement) {
            surfaces.forEach((s) => {
              if(s.tagName === "polygon" || s.tagName === "path" || s.tagName === "rect" || s.tagName === "circle") {
                s.setAttribute("fill", "white");
              }
            });
            const crossLines = activeToothElement.querySelectorAll("line");
            crossLines.forEach((l) => l.remove());
          }
            
            teethState[toothNumber] = {
                surfaces: [],
              surface_colors: {},
                condition_code: null,
                condition_label: null,
                color_code: null,
                notes: ""
            };

            syncToothNoteValue(toothNumber);

            const searchInput = document.getElementById('toolbarSearch');
            if (searchInput) {
                searchInput.value = '';
                filterToolbar({target: searchInput});
            }
            toolbar.classList.add("hidden");
            return;
        }

        // --- HELPER UNTUK MASALAH GIGI ---
        const applyDisease = (hexColor, code, label) => {
          if (activeToothElement) {
            const crossLines = activeToothElement.querySelectorAll("line");
            crossLines.forEach((l) => l.remove());
          }

          if (activeToothElement) {
            if (state.surfaces.length > 0) {
              surfaces.forEach((s) => s.setAttribute("fill", "white")); // Reset sisa warna default
              state.surfaces.forEach(sMode => {
                if (sMode === "M") activeToothElement.querySelector(".surface-left")?.setAttribute("fill", hexColor);
                if (sMode === "O") activeToothElement.querySelector(".surface-center")?.setAttribute("fill", hexColor);
                if (sMode === "D") activeToothElement.querySelector(".surface-right")?.setAttribute("fill", hexColor);
                if (sMode === "B") activeToothElement.querySelector(".surface-top")?.setAttribute("fill", hexColor);
                if (sMode === "L") activeToothElement.querySelector(".surface-bottom")?.setAttribute("fill", hexColor);
              });
            } else {
              surfaces.forEach((s) => s.setAttribute("fill", hexColor));
            }
            }
            state.condition_code = code;
            state.condition_label = label;
            state.color_code = hexColor;
            
            // AUTO-FILL INPUT FIELD DI TABEL
            const noteInputs = getToothNoteInputs(toothNumber);
            noteInputs.forEach(input => {
                if (state.surfaces.length > 0) {
                    input.value = `${code}.${state.surfaces.join('+')}`;
                } else {
                    input.value = code;
                }
            });
        };

        // --- HELPER UNTUK PERMUKAAN GIGI ---
        const addSurface = (flag, selector, surfaceColor) => {
          const drawColor = state.color_code || surfaceColor;
            
            if (activeToothElement) {
                const crossLines = activeToothElement.querySelectorAll("line");
                crossLines.forEach((l) => l.remove());
            }

            // TOGGLE MATI (Jika di-klik lagi)
            if (state.surfaces.includes(flag)) {
                state.surfaces = state.surfaces.filter(s => s !== flag);
              delete state.surface_colors[flag];
                if (activeToothElement) {
                    activeToothElement.querySelector(selector)?.setAttribute("fill", "white");
                }
                
                // Jika semua surface sudah dimatikan tapi kondisi masih ada, warnai seluruh gigi lagi
                if(activeToothElement && state.surfaces.length === 0 && state.color_code) {
                    surfaces.forEach((s) => s.setAttribute("fill", state.color_code));
                }
                
                // UPDATE INPUT FIELD KETIKA SURFACE DI-TOGGLE OFF
                syncToothNoteValue(toothNumber);
                return;
            }

            // Bila pengguna klik surface pertama kali setelah mengklik Masalah Full-Tooth
            if (activeToothElement && state.surfaces.length === 0 && state.condition_code) {
                surfaces.forEach((s) => s.setAttribute("fill", "white"));
            }
            
            if (activeToothElement) {
              activeToothElement.querySelector(selector)?.setAttribute("fill", drawColor);
            }
            state.surfaces.push(flag);
            state.surface_colors[flag] = drawColor;
            
            // UPDATE INPUT FIELD KETIKA SURFACE DI-TOGGLE ON
            syncToothNoteValue(toothNumber);
        };

        if (condition === "caries") {
            applyDisease("#ef4444", "CAR", "Karies");
        } else if (condition === "tambalan") {
            applyDisease("#22c55e", "FIL", "Tambalan");
        } else if (condition === "sisa_akar") {
            applyDisease("#f97316", "ROT", "Sisa Akar");
        } else if (condition === "missing") {
            applyDisease("#000000", "MIS", "Gigi Hilang");
        } 
        else if (condition === "mesial")   { addSurface("M", ".surface-left", "#7c70ab"); }
        else if (condition === "occlusal") { addSurface("O", ".surface-center", "#50c878"); }
        else if (condition === "center")   { addSurface("C", ".surface-center", "#50c878"); }
        else if (condition === "distal")   { addSurface("D", ".surface-right", "#5e88c9"); }
        else if (condition === "buccal")   { addSurface("B", ".surface-top", "#f59e0b"); }
        else if (condition === "lingual")  { addSurface("L", ".surface-bottom", "#ec4899"); }

        // Sinkronkan field setelah semua perubahan kondisi.
        syncToothNoteValue(toothNumber);

        // Reset search field when applied
        const searchInput = document.getElementById('toolbarSearch');
        if (searchInput) {
            searchInput.value = '';
            filterToolbar({target: searchInput});
        }
        toolbar.classList.add("hidden");
      }

      // Filter fungsi untuk search toolbar
      function filterToolbar(e) {
          const query = (e.target.value || '').toLowerCase();
          const items = document.querySelectorAll('#toolbarList .toolbar-item');
          items.forEach(item => {
              if (item.innerText.toLowerCase().includes(query)) {
                  item.classList.remove('hidden');
                  // we use class hidden instead of display none assuming tailwind handles it
                  item.style.display = 'flex';
              } else {
                  item.classList.add('hidden');
                  item.style.display = 'none';
              }
          });
      }

      // ==========================================
      // FUNGSI SUBMIT KE BACKEND
      // ==========================================
      async function submitOdontogram() {
          const patientId = document.getElementById('odontogramPatientId').value;
          
          if (!patientId || patientId === 'dummy-patient-id') {
              console.warn("Peringatan: ID Pasien masih bersifat dummy. Nanti pastikan integrasikan dengan antarmuka yang mengirim ID riwayat medis asli.");
          }

          // Kumpulkan form tambahan jadi satu string `notes` (Parent)
          const occlusi = document.querySelector('select[name="occlusi"]')?.value || '-';
          const torusP = document.querySelector('select[name="torus_palatinus"]')?.value || '-';
          const diastema = document.querySelector('input[name="diastema"]')?.value || '-';
          const torusM = document.querySelector('select[name="torus_mandibularis"]')?.value || '-';
          const palatum = document.querySelector('select[name="palatum"]')?.value || '-';
          const anomali = document.querySelector('input[name="anomali"]')?.value || '-';
          
          const dValEl = document.querySelector('input[name="odonto_d"]');
          const dVal = dValEl ? dValEl.value : '0';
          
          const mValEl = document.querySelector('input[name="odonto_m"]');
          const mVal = mValEl ? mValEl.value : '0';
          
          const fValEl = document.querySelector('input[name="odonto_f"]');
          const fVal = fValEl ? fValEl.value : '0';
          
          const mainNotesEl = document.querySelector('textarea[name="odonto_notes"]');
          const mainNotes = mainNotesEl ? mainNotesEl.value : '';

          const extraNotesTemplate = `Occlusi: ${occlusi}\nTorus Palatinus: ${torusP}\nDiastema: ${diastema}\nTorus Mandibularis: ${torusM}\nPalatum: ${palatum}\nGigi Anomali: ${anomali}\nD: ${dVal}, M: ${mVal}, F: ${fVal}\n\nCatatan Tambahan:\n${mainNotes}`;

          // Format child record gigi
          let teethArray = [];
          Object.keys(teethState).forEach(numStr => {
              let tooth = teethState[numStr];
              if (tooth.surfaces.length > 0 || tooth.notes !== "" || tooth.condition_code) {
                  teethArray.push({
                      tooth_number: parseInt(numStr),
                      surfaces: tooth.surfaces.join(","),
                      condition_code: tooth.condition_code || null,
                      condition_label: tooth.condition_label || null,
                      color_code: tooth.color_code || null,
                      notes: tooth.notes || null,
                  });
              }
          });

          const visitIdEl = document.getElementById('odontogramVisitId');
          const examinedByEl = document.getElementById('odontogramExaminedBy');

          const payload = {
              patient_id: patientId,
              visit_id: visitIdEl ? visitIdEl.value : null,
              examined_by: examinedByEl ? examinedByEl.value : null,
              notes: extraNotesTemplate,
              teeth: teethArray
          };

          try {
              const res = await fetch('/api/odontogram', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                  body: JSON.stringify(payload)
              });
              
              const data = await res.json();
              if (res.ok && data.status === 'success') {
                  // Extract and store tooth numbers for procedure modal
                  let savedTeethNumbers = [];
                  if (data.data && data.data.teeth) {
                      const uniqueTeeth = new Set(data.data.teeth.map(function(t) { return t.tooth_number; }));
                      savedTeethNumbers = Array.from(uniqueTeeth);
                  }
                  window.lastSavedToothNumbers = savedTeethNumbers;
                  
                  toggleOdontogramModal(false);
                  
                  // Reset form Odontogram usai sukses submit
                  clearOdontogramState();
              } else {
                  // Munculkan detail validasi laravel jika ada
                  const errMsg = data.message || JSON.stringify(data.errors || "Unknown Error");
                  alert("Gagal menyimpan data: " + errMsg);
              }
          } catch(e) {
              alert("Terjadi kesalahan sistem: " + e.message);
          }
      }

      // Tutup toolbar jika mengklik area lain
      if (modalBody && toolbar) {
        modalBody.addEventListener("click", function (e) {
          if (!toolbar.contains(e.target)) {
            toolbar.classList.add("hidden");
            activeInputElement = null;
            if (toolbarToothPicker) toolbarToothPicker.classList.add('hidden');
          }
        });
      }
    </script>
