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
        transition: all 0.15s ease !important;
      }

      #modalOdontogramOverlay input[data-tooth]:focus {
        border-color: #8e6a45 !important;
        background-color: #fefbf8 !important;
        box-shadow: 0 0 0 2px rgba(142, 106, 69, 0.1) !important;
      }

      #modalOdontogramOverlay input[data-tooth][readonly] {
        background-color: #fef0e5 !important;
        color: #8e6a45 !important;
        cursor: not-allowed !important;
      }

      #modalOdontogramOverlay input[data-tooth][readonly]:focus {
        border-color: #d8c7b2 !important;
        background-color: #fef0e5 !important;
        box-shadow: none !important;
      }

      #modalOdontogramOverlay input[data-tooth]::placeholder {
        color: #c9a885 !important;
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
          <div class="mt-8 pt-6 border-t" style="border-color: #d8c7b2;">
            <h3 class="text-sm font-semibold mb-6" style="color: #8e6a45;">Informasi Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Occlusi</label>
                <select name="occlusi" class="w-full border-b pb-2 outline-none" style="border-color: #d8c7b2; color: #3b331e;">
                  <option></option>
                  <option value="Normal">Normal</option>
                  <option value="Kelainan">Kelainan</option>
                </select>
              </div>
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Torus Palatinus</label>
                <select name="torus_palatinus" class="w-full border-b pb-2 outline-none" style="border-color: #d8c7b2; color: #3b331e;">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kecil">Kecil</option>
                <option value="Sedang">Sedang</option>
                <option value="Besar">Besar</option>
                <option value="Multiple">Multiple</option>
              </select>
            </div>
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Diastema</label>
                <input
                  type="text"
                  name="diastema"
                  placeholder="Dijelaskan dimana dan berapa lebarnya"
                  class="w-full border-b pb-2 outline-none text-xs" style="border-color: #d8c7b2; color: #3b331e;"
                />
              </div>
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Torus Mandibularis</label>
                <select name="torus_mandibularis" class="w-full border-b pb-2 outline-none" style="border-color: #d8c7b2; color: #3b331e;">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kiri">Kiri</option>
                <option value="Kanan">Kanan</option>
                <option value="Bilateral">Bilateral</option>
              </select>
            </div>
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Palatum</label>
                <select name="palatum" class="w-full border-b pb-2 outline-none" style="border-color: #d8c7b2; color: #3b331e;">
                  <option></option>
                  <option value="Dalam">Dalam</option>
                  <option value="Sedang">Sedang</option>
                  <option value="Rendah">Rendah</option>
                </select>
              </div>
              <div>
                <label class="block font-medium mb-2" style="color: #8e6a45;">Gigi Anomali</label>
                <input
                  type="text"
                  name="anomali"
                  placeholder="Dijelaskan gigi mana dan bentuknya"
                  class="w-full border-b pb-2 outline-none text-xs" style="border-color: #d8c7b2; color: #3b331e;"
                />
              </div>
            </div>
          </div>

          <div class="mt-8 pt-6 border-t" style="border-color: #d8c7b2;">
            <div class="flex space-x-6 w-1/2">
              <div class="flex flex-col">
                <label class="text-xs font-medium mb-2" style="color: #8e6a45;">D (Distal)</label>
                <input type="text" name="odonto_d" class="border-b pb-1 outline-none text-sm" style="border-color: #d8c7b2; color: #3b331e; width: 100px;"/>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-medium mb-2" style="color: #8e6a45;">M (Mesial)</label>
                <input type="text" name="odonto_m" class="border-b pb-1 outline-none text-sm" style="border-color: #d8c7b2; color: #3b331e; width: 100px;"/>
              </div>
              <div class="flex flex-col">
                <label class="text-xs font-medium mb-2" style="color: #8e6a45;">F (Facial)</label>
                <input type="text" name="odonto_f" class="border-b pb-1 outline-none text-sm" style="border-color: #d8c7b2; color: #3b331e; width: 100px;"/>
              </div>
            </div>
          </div>

          <div class="mt-8 pt-6 border-t" style="border-color: #d8c7b2;">
            <label class="block text-xs font-medium mb-3" style="color: #8e6a45;">Catatan Lainnya</label>
            <textarea
              name="odonto_notes"
              class="w-full border-b pb-2 outline-none resize-none text-sm" style="border-color: #d8c7b2; color: #3b331e;"
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
      style="z-index:2147483642; width: 200px; height: 300px; border-bottom: 3px solid #8e6a45;"
    >
      
    <div id="toolbarHeader" class="px-4 py-3 flex items-center bg-gradient-to-r rounded-t-xl cursor-grab active:cursor-grabbing" style="background: linear-gradient(135deg, #8e6a45 0%, #a87c4a 100%); flex-shrink: 0; user-select: none;">
  
      <div class="w-6"></div> 

      <span class="flex-1 font-bold text-white text-xs flex items-center justify-center gap-2">
        
        Toolbar
      </span>

      <button onclick="document.getElementById('toolbar').classList.add('hidden')" class="w-6 text-white hover:bg-white hover:bg-opacity-20 p-1 rounded transition flex items-center justify-center">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      
    </div>

      <div class="px-3 py-2.5 border-b" style="border-color: #f0e5d8; flex-shrink: 0;">
        <input
          type="text"
          id="toolbarSearch"
          placeholder="Cari..."
          class="w-full outline-none px-2 py-1.5 rounded text-xs" 
          style="background-color: #fef0e5; border: 1px solid #e5d1b8; color: #3b331e;"
          oninput="filterToolbar(event)"
        />
      </div>

      <div class="overflow-y-auto p-2 space-y-2 flex-1 min-h-0" id="toolbarList" style="border-bottom: 2px solid #f0e5d8; overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
        
        <div class="grid grid-cols-4 gap-2">
          <div class="toolbar-item flex items-center space-x-2 p-2.5 hover:bg-gray-50 rounded cursor-pointer transition mb-2" style="background-color: #fef0e5;" onclick="applyCondition('clear')">
              <div class="w-6 h-6 rounded flex items-center justify-center text-xs flex-shrink-0" style="background-color: #d8c7b2; color: #8e6a45;">✕</div>
              <div>
                <p class="font-semibold text-[11px] leading-tight" style="color: #3b331e;">Reset</p>
                <p class="text-[9px] leading-tight text-gray-500">Bersihkan</p>
              </div>
            </div>

        
        
        
          <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #7c70ab; background-color: #f3f0ff;" onclick="applyCondition('mesial')">
            <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
              <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,0 0,40 12,28 12,12" fill="#7c70ab" stroke="#6f639e" stroke-width="1.5" stroke-linejoin="round" />
              <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            </svg>
            <p class="font-semibold text-[10px] text-gray-800">Mesial (M)</p>
          </div>

          <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #5e88c9; background-color: #f0f7ff;" onclick="applyCondition('distal')">
            <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
              <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="40,0 40,40 28,28 28,12" fill="#5e88c9" stroke="#5275b8" stroke-width="1.5" stroke-linejoin="round" />
              <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            </svg>
            <p class="font-semibold text-[10px] text-gray-800">Distal (D)</p>
          </div>

          <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #50c878; background-color: #f0fdf4;" onclick="applyCondition('occlusal')">
            <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
              <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <rect x="12" y="12" width="16" height="16" fill="#50c878" stroke="#3da85f" stroke-width="1.5" stroke-linejoin="round" />
            </svg>
            <p class="font-semibold text-[10px] text-gray-800">Occlusal (O)</p>
          </div>

          <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #f59e0b; background-color: #fffbf0;" onclick="applyCondition('buccal')">
            <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
              <polygon points="0,0 40,0 28,12 12,12" fill="#f59e0b" stroke="#e59d00" stroke-width="1.5" stroke-linejoin="round" />
              <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,40 40,40 28,28 12,28" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            </svg>
            <p class="font-semibold text-[10px] text-gray-800">Buccal (B)</p>
          </div>

          <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #ec4899; background-color: #fdf2f8;" onclick="applyCondition('lingual')">
            <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
              <polygon points="0,0 40,0 28,12 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="40,0 40,40 28,28 28,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <polygon points="0,40 40,40 28,28 12,28" fill="#ec4899" stroke="#d93680" stroke-width="1.5" stroke-linejoin="round" />
              <polygon points="0,0 0,40 12,28 12,12" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
              <rect x="12" y="12" width="16" height="16" fill="white" stroke="#ccc" stroke-width="1" stroke-linejoin="round" />
            </svg>
            <p class="font-semibold text-[10px] text-gray-800">Lingual (L)</p>
          </div>
        

        

        <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #ef4444; background-color: #fef2f2;" onclick="applyCondition('caries')">
          <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#ef4444" stroke="#dc2626" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <p class="font-semibold text-[10px] text-red-700">Karies (CAR)</p>
        </div>

        <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #22c55e; background-color: #f0fdf4;" onclick="applyCondition('tambalan')">
          <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#22c55e" stroke="#16a34a" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <p class="font-semibold text-[10px] text-green-700">Tambalan (FIL)</p>
        </div>

        <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #f97316; background-color: #fef3f2;" onclick="applyCondition('sisa_akar')">
          <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#f97316" stroke="#ea580c" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          <p class="font-semibold text-[10px] text-orange-600">Sisa Akar (ROT)</p>
        </div>

        <div class="toolbar-item flex items-center space-x-2 p-1.5 hover:shadow-md rounded cursor-pointer transition border" style="border-color: #000; background-color: #f5f5f5;" onclick="applyCondition('missing')">
          <svg width="24" height="24" viewBox="0 0 40 40" class="flex-shrink-0">
            <polygon points="0,0 40,0 28,12 12,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="40,0 40,40 28,28 28,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,40 40,40 28,28 12,28" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <polygon points="0,0 0,40 12,28 12,12" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <rect x="12" y="12" width="16" height="16" fill="#000" stroke="#000" stroke-width="1.5" stroke-linejoin="round" />
            <line x1="4" y1="4" x2="36" y2="36" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
            <line x1="36" y1="4" x2="4" y2="36" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          <p class="font-semibold text-[10px] text-gray-900">Gigi Hilang (MIS)</p>
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
              input.addEventListener('input', function(e) {
                  const toothNum = this.getAttribute('data-tooth');
                  initToothState(toothNum);
                  teethState[toothNum].notes = e.target.value;
                  
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
          tableInputs.forEach(input => input.value = '');
          
          // Reset dropdown dan text input pada "Form Tambahan Bawah"
          const allSelects = document.querySelectorAll('#modalOdontogramOverlay select');
          allSelects.forEach(sel => sel.selectedIndex = 0);
          
          // Reset D, M, F & form lain
          const allInputs = document.querySelectorAll('#modalOdontogramOverlay input[type="text"]:not(#toolbarSearch)');
          allInputs.forEach(input => input.value = '');
          
          // Reset textarea Catatan Lainnya
          const allTextAreas = document.querySelectorAll('#modalOdontogramOverlay textarea');
          allTextAreas.forEach(ta => ta.value = '');
      }

     // Variabel penampung state Toolbar
      const toolbar = document.getElementById("toolbar");
      const modalBody = document.getElementById("modalBody");
      const toolbarList = document.getElementById("toolbarList");
      let activeToothElement = null;
      let activeToothNumber = null;

      // ==========================================
      // FUNGSI MEMBUKA TOOLBAR
      // ==========================================
      
      // Fungsi untuk mengatur posisi awal dan batas layer
      function openToolbar(event, element, number) {
        if (!toolbar) return;
        event.stopPropagation();
        activeToothElement = element;
        activeToothNumber = number;

        // Tampilkan toolbar
        toolbar.classList.remove("hidden");
        toolbar.style.transform = "none";

        const elRect = element.getBoundingClientRect();
        const toolbarWidth = toolbar.offsetWidth || 320;
        const toolbarHeight = toolbar.offsetHeight;

        // Posisi default: di bawah gigi, posisi tengah sejajar dengan gigi
        let topPos = elRect.bottom + 8; 
        let leftPos = elRect.left - (toolbarWidth / 2) + (elRect.width / 2);

        // KOREKSI BATAS LAYAR (Agar tidak keluar/melebihi batas browser)
        if (leftPos + toolbarWidth > window.innerWidth - 16) {
          leftPos = window.innerWidth - toolbarWidth - 16;
        }
        if (leftPos < 16) {
          leftPos = 16;
        }
        // Jika numbur di bawah, pindahkan ke atas gigi
        if (topPos + toolbarHeight > window.innerHeight - 16) {
          topPos = elRect.top - toolbarHeight - 8;
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

      function getToothNoteInputs(toothNumber) {
        const inputs = [];
        getToothInputTargets(toothNumber).forEach((target) => {
          const found = document.querySelectorAll(`input[data-tooth="${target}"]`);
          found.forEach((input) => inputs.push(input));
        });
        return inputs;
      }

      function setToothNoteValue(toothNumber, value) {
        const noteInputs = getToothNoteInputs(toothNumber);
        noteInputs.forEach((input) => {
          input.value = value;
        });
      }

      function applyCondition(condition) {
        if (!activeToothElement) {
          alert("Pilih gigi terlebih dahulu!");
          return;
        }

        const toothNumber = parseInt(activeToothElement.id.replace("tooth-", ""));
        initToothState(toothNumber);
        const state = teethState[toothNumber];

        const surfaces = activeToothElement.querySelectorAll(".tooth-surface");

        if (condition === "clear") {
            surfaces.forEach((s) => {
                if(s.tagName === "polygon" || s.tagName === "path" || s.tagName === "rect" || s.tagName === "circle") {
                    s.setAttribute("fill", "white");
                }
            });
            const crossLines = activeToothElement.querySelectorAll("line");
            crossLines.forEach((l) => l.remove());
            
            teethState[toothNumber] = {
                surfaces: [],
                condition_code: null,
                condition_label: null,
                color_code: null,
                notes: ""
            };

            setToothNoteValue(toothNumber, "");

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
            const crossLines = activeToothElement.querySelectorAll("line");
            crossLines.forEach((l) => l.remove());

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
        const addSurface = (flag, selector) => {
            // Jika belum ada kondisi, gunakan biru muda sebagai indikator visual (bukan hitam)
            const drawColor = state.color_code || "#60a5fa";
            
            const crossLines = activeToothElement.querySelectorAll("line");
            crossLines.forEach((l) => l.remove());

            // TOGGLE MATI (Jika di-klik lagi)
            if (state.surfaces.includes(flag)) {
                state.surfaces = state.surfaces.filter(s => s !== flag);
                activeToothElement.querySelector(selector).setAttribute("fill", "white");
                
                // Jika semua surface sudah dimatikan tapi kondisi masih ada, warnai seluruh gigi lagi
                if(state.surfaces.length === 0 && state.color_code) {
                    surfaces.forEach((s) => s.setAttribute("fill", state.color_code));
                }
                
                // UPDATE INPUT FIELD KETIKA SURFACE DI-TOGGLE OFF
                const noteInputs = getToothNoteInputs(toothNumber);
                noteInputs.forEach(input => {
                    if (state.surfaces.length > 0 && state.condition_code) {
                        input.value = `${state.condition_code}.${state.surfaces.join('+')}`;
                    } else if (state.condition_code) {
                        input.value = state.condition_code;
                    } else {
                        input.value = '';
                    }
                });
                return;
            }

            // Bila pengguna klik surface pertama kali setelah mengklik Masalah Full-Tooth
            if (state.surfaces.length === 0 && state.condition_code) {
                surfaces.forEach((s) => s.setAttribute("fill", "white"));
            }
            
            activeToothElement.querySelector(selector).setAttribute("fill", drawColor);
            state.surfaces.push(flag);
            
            // UPDATE INPUT FIELD KETIKA SURFACE DI-TOGGLE ON
            const noteInputs = getToothNoteInputs(toothNumber);
            noteInputs.forEach(input => {
                if (state.condition_code) {
                    input.value = `${state.condition_code}.${state.surfaces.join('+')}`;
                } else {
                    input.value = state.surfaces.join('+');
                }
            });
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
        else if (condition === "mesial")   { addSurface("M", ".surface-left"); }
        else if (condition === "occlusal") { addSurface("O", ".surface-center"); }
        else if (condition === "center")   { addSurface("C", ".surface-center"); }
        else if (condition === "distal")   { addSurface("D", ".surface-right"); }
        else if (condition === "buccal")   { addSurface("B", ".surface-top"); }
        else if (condition === "lingual")  { addSurface("L", ".surface-bottom"); }

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
                  const ask = confirm("Data Odontogram berhasil disimpan!\n\nApakah Anda ingin langsung merekomendasikan/mencatat tindakan tambahan pada gigi-gigi tersebut ke Form Prosedur?");
                  toggleOdontogramModal(false);

                  if (ask && typeof toggleProsedureModal === "function") {
                      // Buka modal prosedur dengan membawa data pasien & dokter dari odontogram
                      toggleProsedureModal(true, window.lastOdontoPatientData);

                      setTimeout(() => {
                          let savedTeethNumbers = [];
                          if (data.data && data.data.teeth) {
                              const uniqueTeeth = new Set(data.data.teeth.map(function(t) { return t.tooth_number; }));
                              savedTeethNumbers = Array.from(uniqueTeeth);
                          }
                          
                          if (savedTeethNumbers.length === 0) return;

                          const toothNumbersStr = savedTeethNumbers.join(', ');
                          const noGigiInput = document.querySelector('.input-no-gigi');
                          if (noGigiInput) {
                              noGigiInput.value = toothNumbersStr;
                              if (typeof hitungTotalHarga === "function") hitungTotalHarga();
                          }
                      }, 300);
                  }
                  
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
          }
        });
      }
    </script>
