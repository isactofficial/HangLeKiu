@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Custom scrollbar untuk modal */
      ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
      }
      ::-webkit-scrollbar-track {
        background: #f1f1f1;
      }
      ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
      }

      .tooth-surface:hover {
        fill: #e2e8f0;
        cursor: pointer;
      }
    </style>
@endpush

<!-- OVERLAY MODAL (Ditambahkan ID dan class 'hidden') -->
    <div
      id="modalOdontogramOverlay"
      class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999]"
    >
      <!-- KONTEN MODAL -->
      <div
        class="bg-white rounded-lg shadow-xl w-11/12 max-w-5xl h-[90vh] flex flex-col relative"
        id="modalContainer"
      >
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b flex-shrink-0 relative">
          <!-- Tombol Close (X) -->
          <button
            onclick="toggleOdontogramModal(false)"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
          >
            <svg
              class="w-6 h-6"
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

          <h2 class="text-2xl font-bold text-brown-500 text-center mb-4">
            Tambah Odontogram
          </h2>
          <!-- Input hidden untuk menampung PARENT ID (Patient ID) -->
          <input type="hidden" id="odontogramPatientId" value="dummy-patient-id" />
          <input type="hidden" id="odontogramVisitId" value="" />
          <input type="hidden" id="odontogramExaminedBy" value="" />

          <div class="flex justify-between items-end text-sm text-gray-600">
            <div>
              <p id="odonto-date-display">Tanggal Hari ini</p>
              <p class="font-bold text-gray-800 flex items-center gap-2">
                <span id="odonto-patient-name">Nama Pasien</span>
                <span id="odonto-patient-payment" class="text-xs font-normal bg-gray-100 px-2 py-0.5 rounded">Jenis Pembayaran</span>
                <span id="odonto-patient-mr" class="text-gray-500 font-normal">No. RM</span>
                <span id="odonto-patient-demographics" class="text-gray-500 font-normal">&middot; Jenis Kelamin &middot; Umur</span>
              </p>
            </div>
            <button class="text-blue-500 hover:text-blue-700 text-xs text-nowrap" onclick="clearOdontogramState()">
              Clear all notes
            </button>
          </div>
        </div>

        <!-- Body Modal (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-grow relative" id="modalBody">
          <!-- Contoh Tabel Atas -->
          <div class="border border-gray-200 text-xs mb-8">
            <div class="grid grid-cols-2 divide-x divide-gray-200">
              <!-- Kiri -->
              <div class="grid grid-cols-2 divide-x divide-y divide-gray-200">
                <div class="p-2 text-center font-semibold bg-gray-50">
                  11 [51]
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  12 [52]
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  13 [53]
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  14 [54]
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  15 [55]
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">16</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">17</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">18</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
              </div>
              <!-- Kanan -->
              <div class="grid grid-cols-2 divide-x divide-y divide-gray-200">
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  [61] 21
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  [62] 22
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  [63] 23
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  [64] 24
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">
                  [65] 25
                </div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">26</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">27</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">28</div>
              </div>
            </div>
          </div>

          <!-- ODONTOGRAM MAP (Peta Gigi) -->
          <div
            class="flex flex-col items-center justify-center space-y-4 mb-8 w-full"
          >
            <!-- Baris 1: Gigi Dewasa Atas -->
            <div class="flex space-x-8 w-full max-w-4xl justify-center">
              <div
                class="flex space-x-1 w-1/2 justify-end"
                id="gigi-atas-kanan"
              ></div>
              <div
                class="flex space-x-1 w-1/2 justify-start"
                id="gigi-atas-kiri"
              ></div>
            </div>

            <!-- Baris 2: Gigi Susu / Anak (Tengah) -->
            <div class="flex space-x-8 w-full max-w-4xl justify-center">
              <div
                class="flex space-x-1 w-1/2 justify-end"
                id="gigi-tengah-kanan"
              ></div>
              <div
                class="flex space-x-1 w-1/2 justify-start"
                id="gigi-tengah-kiri"
              ></div>
            </div>

            <div class="flex items-center text-blue-500 py-2">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 10l5-5 5 5H5z" />
              </svg>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 10l5 5 5-5H5z" />
              </svg>
            </div>

            <!-- Baris 3: Gigi Dewasa Bawah -->
            <div class="flex space-x-8 w-full max-w-4xl justify-center">
              <div
                class="flex space-x-1 w-1/2 justify-end"
                id="gigi-bawah-kanan"
              ></div>
              <div
                class="flex space-x-1 w-1/2 justify-start"
                id="gigi-bawah-kiri"
              ></div>
            </div>
          </div>

          <!-- Contoh Tabel Bawah -->
          <div class="border border-gray-200 text-xs mb-8">
            <div class="grid grid-cols-2 divide-x divide-gray-200">
              <!-- Kiri -->
              <div class="grid grid-cols-2 divide-x divide-y divide-gray-200">
                <div class="p-2 text-center font-semibold bg-gray-50">48</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">47</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">46</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">45 [85]</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">44 [84]</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">43 [83]</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">42 [82]</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">41 [81]</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
              </div>
              <!-- Kanan -->
              <div class="grid grid-cols-2 divide-x divide-y divide-gray-200">
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">38</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">37</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">36</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">[75] 35</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">[74] 34</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">[73] 33</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">[72] 32</div>
                <div class="p-2">
                  <input type="text" class="w-full outline-none" />
                </div>
                <div class="p-2 text-center font-semibold bg-gray-50">[71] 31</div>
              </div>
            </div>
          </div>

          <!-- Form Tambahan Bawah -->
          <div
            class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700"
          >
            <div>
              <label class="block text-gray-500 mb-1">Occlusi</label>
              <select name="occlusi" class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
                <option value="Normal">Normal</option>
                <option value="Kelainan">Kelainan</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Torus Palatinus</label>
              <select name="torus_palatinus" class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kecil">Kecil</option>
                <option value="Sedang">Sedang</option>
                <option value="Besar">Besar</option>
                <option value="Multiple">Multiple</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Diastema</label>
              <input
                type="text"
                name="diastema"
                placeholder="(Diastema) Dijelaskan dimana dan berapa lebarnya"
                class="w-full mt-2 border-b border-gray-300 outline-none text-xs text-gray-400 pb-1"
              />
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Torus Mandibularis</label>
              <select name="torus_mandibularis" class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Kiri">Kiri</option>
                <option value="Kanan">Kanan</option>
                <option value="Bilateral">Bilateral</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Palatum</label>
              <select name="palatum" class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
                <option value="Dalam">Dalam</option>
                <option value="Sedang">Sedang</option>
                <option value="Rendah">Rendah</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Gigi Anomali</label>
              <input
                type="text"
                name="anomali"
                placeholder="(Anomali) Dijelaskan gigi yang mana, dan bentuknya"
                class="w-full mt-2 border-b border-gray-300 outline-none text-xs text-gray-400 pb-1"
              />
            </div>
          </div>

          <div class="mt-6 flex space-x-4 w-1/4">
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">D</label>
              <input type="text" name="odonto_d" class="border-b border-gray-300 outline-none"/>
            </div>
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">M</label>
              <input type="text" name="odonto_m" class="border-b border-gray-300 outline-none"/>
            </div>
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">F</label>
              <input type="text" name="odonto_f" class="border-b border-gray-300 outline-none"/>
            </div>
          </div>

          <div class="mt-6">
            <label class="block text-xs text-gray-500 mb-1"
              >Catatan Lainnya</label>
            <textarea
              name="odonto_notes"
              class="w-full border-b border-gray-300 outline-none resize-none"
              rows="2"
            ></textarea>
          </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-4 border-t flex justify-end">
          <button
            onclick="submitOdontogram()"
            class="bg-amber-950 hover:bg-amber-800 text-white px-6 py-2 rounded font-medium shadow-sm transition-colors"
          >
            SIMPAN
          </button>
        </div>

        <!-- FLOATING TOOLBAR -->
        <div
          id="toolbar"
          class="hidden absolute bg-white shadow-2xl rounded-lg border border-gray-200 w-64 z-50 text-sm flex flex-col"
          style="top: 250px; left: 50%"
        >
          <div
            class="p-3 border-b border-gray-100 flex items-center justify-between bg-gray-50 rounded-t-lg"
          >
            <span class="font-semibold text-gray-600">Toolbar</span>
            <div class="flex items-center space-x-2">
              <div
                class="w-8 h-4 bg-pink-500 rounded-full relative cursor-pointer"
              >
                <div
                  class="absolute right-0.5 top-0.5 w-3 h-3 bg-white rounded-full"
                ></div>
              </div>
              <span
                class="text-blue-600 cursor-pointer font-medium hover:underline text-xs"
                onclick="applyCondition('clear')"
                >Clear</span
              >
            </div>
          </div>
          <div class="p-2 border-b border-gray-100">
            <input
              type="text"
              id="toolbarSearch"
              placeholder="Search"
              class="w-full outline-none text-gray-600 px-1"
              oninput="filterToolbar(event)"
            />
          </div>
          <div class="overflow-y-auto max-h-56 p-2 space-y-1" id="toolbarList">
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('clear')">
              <div class="w-6 h-6 border border-gray-600 bg-white"></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">Hapus</p>
                <p class="text-[10px] text-gray-400">Hapus catatan gigi</p>
              </div>
            </div>

            <!-- PERMUKAAN (SURFACES) -->
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('mesial')">
              <div class="w-6 h-6 border border-gray-600 flex relative"><div class="absolute left-0 top-0 bottom-0 w-2 bg-purple-800"></div></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">M</p>
                <p class="text-[10px] text-gray-400">Permukaan Mesial</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('distal')">
              <div class="w-6 h-6 border border-gray-600 flex relative"><div class="absolute right-0 top-0 bottom-0 w-2 bg-purple-800"></div></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">D</p>
                <p class="text-[10px] text-gray-400">Permukaan Distal</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('occlusal')">
              <div class="w-6 h-6 border border-gray-600 flex relative items-center justify-center"><div class="w-2.5 h-2.5 bg-purple-800"></div></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">O</p>
                <p class="text-[10px] text-gray-400">Permukaan Occlusal</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('buccal')">
              <div class="w-6 h-6 border border-gray-600 flex relative"><div class="absolute left-0 right-0 top-0 h-2 bg-purple-800"></div></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">B / L</p>
                <p class="text-[10px] text-gray-400">Buccal / Labial</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('lingual')">
              <div class="w-6 h-6 border border-gray-600 flex relative"><div class="absolute left-0 right-0 bottom-0 h-2 bg-purple-800"></div></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">L / P</p>
                <p class="text-[10px] text-gray-400">Lingual / Palatal</p>
              </div>
            </div>

            <!-- KONDISI SPESIFIK (CONDITIONS) -->
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('caries')">
              <div class="w-6 h-6 bg-red-500 rounded-full"></div>
              <div>
                <p class="font-medium text-red-600 leading-tight">Karies</p>
                <p class="text-[10px] text-gray-400">Lubang pada gigi</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('tambalan')">
              <div class="w-6 h-6 bg-green-500 rounded-full"></div>
              <div>
                <p class="font-medium text-green-600 leading-tight">Tambalan</p>
                <p class="text-[10px] text-gray-400">Restorasi / Composite</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('missing')">
              <div class="w-6 h-6 flex items-center justify-center text-black font-bold">X</div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">Gigi Hilang</p>
                <p class="text-[10px] text-gray-400">Missing / Ekstraksi</p>
              </div>
            </div>
            <div class="toolbar-item flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer" onclick="applyCondition('sisa_akar')">
               <div class="w-6 h-6 bg-orange-500 rounded-full border-2 border-orange-700"></div>
              <div>
                <p class="font-medium text-orange-600 leading-tight">Sisa Akar</p>
                <p class="text-[10px] text-gray-400">Gigi tersisa akar saja</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
      // ==========================================
      // FUNGSI UNTUK BUKA/TUTUP MODAL UTAMA
      // ==========================================
      function toggleOdontogramModal(show) {
        const modal = document.getElementById("modalOdontogramOverlay");
        const toolbar = document.getElementById("toolbar"); // Tutup toolbar sekalian
        if (show) {
          modal.classList.remove("hidden");
        } else {
          modal.classList.add("hidden");
          toolbar.classList.add("hidden");
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

      function createToothGraphic(number, isBottom = false) {
        const labelTop = !isBottom
          ? `<span class="text-[10px] font-medium text-gray-500 mb-2">${number}</span>`
          : "";
        const labelBottom = isBottom
          ? `<span class="text-[10px] font-medium text-gray-500 mt-2">${number}</span>`
          : "";

        return `
            <div id="tooth-${number}" class="flex flex-col items-center justify-center cursor-pointer p-1 rounded hover:bg-gray-100 transition-colors tooth" onclick="openToolbar(event, this, ${number})">
                ${labelTop}
                <svg width="28" height="28" viewBox="0 0 40 40" class="tooth-svg">
                    <polygon points="0,0 40,0 30,10 10,10" fill="white" stroke="#334155" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-top" />
                    <polygon points="40,0 40,40 30,30 30,10" fill="white" stroke="#334155" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-right" />
                    <polygon points="0,40 40,40 30,30 10,30" fill="white" stroke="#334155" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-bottom" />
                    <polygon points="0,0 0,40 10,30 10,10" fill="white" stroke="#334155" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-left" />
                    <rect x="10" y="10" width="20" height="20" fill="white" stroke="#334155" stroke-width="1.5" stroke-linejoin="round" class="tooth-surface surface-center" />
                </svg>
                ${labelBottom}
            </div>
        `;
      }

      // Render peta gigi ke DOM
      document.getElementById("gigi-atas-kanan").innerHTML = urTeeth
        .map((num) => createToothGraphic(num))
        .join("");
      document.getElementById("gigi-atas-kiri").innerHTML = ulTeeth
        .map((num) => createToothGraphic(num))
        .join("");
      document.getElementById("gigi-tengah-kanan").innerHTML = mrTeeth
        .map((num) => createToothGraphic(num))
        .join("");
      document.getElementById("gigi-tengah-kiri").innerHTML = mlTeeth
        .map((num) => createToothGraphic(num))
        .join("");
      document.getElementById("gigi-bawah-kanan").innerHTML = lrTeeth
        .map((num) => createToothGraphic(num, true))
        .join("");
      document.getElementById("gigi-bawah-kiri").innerHTML = llTeeth
        .map((num) => createToothGraphic(num, true))
        .join("");

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
          const cells = document.querySelectorAll('#modalOdontogramOverlay .font-semibold.bg-gray-50');
          cells.forEach(labelDiv => {
             const text = labelDiv.innerText.trim();
             // Cari angka utama (contoh: dari "11 [51]" ambil 11)
             const match = text.match(/\d+/);
             if (match) {
                 const toothNum = parseInt(match[0]);
                 const input = labelDiv.nextElementSibling?.querySelector('input');
                 if (input) {
                     input.dataset.tooth = toothNum; // Ini memudahkan reset value nanti
                     input.addEventListener('input', function(e) {
                         initToothState(toothNum);
                         teethState[toothNum].notes = e.target.value;
                     });
                 }
             }
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
      let activeToothElement = null;
      let activeToothNumber = null;

      // Buka toolbar
      function openToolbar(event, element, number) {
        event.stopPropagation();
        activeToothElement = element;
        activeToothNumber = number;

        const modalRect = modalBody.getBoundingClientRect();
        const elRect = element.getBoundingClientRect();

        let topPos = elRect.top - modalRect.top + modalBody.scrollTop + 40;
        let leftPos = elRect.left - modalRect.left + 20;

        if (leftPos + 256 > modalBody.clientWidth) {
          leftPos = modalBody.clientWidth - 270;
        }

        toolbar.style.top = topPos + "px";
        toolbar.style.left = leftPos + "px";
        toolbar.classList.remove("hidden");
      }

      // Terapkan kondisi dari toolbar ke gigi
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
            
            const noteInput = document.querySelector(`input[data-tooth="${toothNumber}"]`);
            if (noteInput) noteInput.value = "";

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
                return;
            }

            // Bila pengguna klik surface pertama kali setelah mengklik Masalah Full-Tooth
            if (state.surfaces.length === 0 && state.condition_code) {
                surfaces.forEach((s) => s.setAttribute("fill", "white"));
            }
            
            activeToothElement.querySelector(selector).setAttribute("fill", drawColor);
            state.surfaces.push(flag);
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
          
          const dVal = document.querySelector('input[name="odonto_d"]')?.value || '0';
          const mVal = document.querySelector('input[name="odonto_m"]')?.value || '0';
          const fVal = document.querySelector('input[name="odonto_f"]')?.value || '0';
          const mainNotes = document.querySelector('textarea[name="odonto_notes"]')?.value || '';

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

          const payload = {
              patient_id: patientId,
              visit_id: document.getElementById('odontogramVisitId')?.value || null,
              examined_by: document.getElementById('odontogramExaminedBy')?.value || null,
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
                      // Buka modal prosedur
                      toggleProsedureModal(true);

                      setTimeout(() => {
                          // Ambil nomor gigi unik yang ada catatannya / kondisinya
                          // Parsing array objek gigi dari respon JSON
                          let savedTeeth = [];
                          if (data.data && data.data.teeth) {
                              // Buang duplikasi jika satu gigi disubmit banyak kondisi
                              const uniqueTeeth = new Set(data.data.teeth.map(t => t.tooth_number));
                              savedTeeth = Array.from(uniqueTeeth);
                          }
                          if (savedTeeth.length === 0) return;
                          
                          const prosedurRows = document.querySelectorAll('.prosedur-row');
                          if (prosedurRows.length === 0) return;

                          let lastRow = prosedurRows[prosedurRows.length - 1];
                          const searchInput = lastRow.querySelector('.search-prosedur');
                          const noGigiInput = lastRow.querySelector('.input-no-gigi');
                          if (noGigiInput) {
                              noGigiInput.value = savedTeeth.join(', ');
                          }
                      }, 200);
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
      modalBody.addEventListener("click", function (e) {
        if (!toolbar.contains(e.target)) {
          toolbar.classList.add("hidden");
        }
      });
    </script>
