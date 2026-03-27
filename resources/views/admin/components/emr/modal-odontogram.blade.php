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

          <div class="flex justify-between items-end text-sm text-gray-600">
            <div>
              <p class="mb-1">Jumat, 13 Maret 2026</p>
              <p>
                <span class="font-bold text-gray-800 text-lg mr-2">Kama</span>
                <span class="font-light text-gray-800 text-lg mr-2">Tunai</span>
                MR000025 · Laki - laki · 13 Tahun
              </p>
            </div>
          </div>
          <a
            href="#"
            class="text-blue-500 text-sm hover:underline mt-2 inline-block"
            >Clear all notes</a
          >
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
              <select class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Torus Palatinus</label>
              <select class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Diastema</label>
              <input
                type="text"
                placeholder="(Diastema) Dijelaskan dimana dan berapa lebarnya"
                class="w-full mt-2 border-b border-gray-300 outline-none text-xs text-gray-400 pb-1"
              />
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Torus Mandibularis</label>
              <select class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Palatum</label>
              <select class="w-full border-b border-gray-300 pb-1 outline-none">
                <option></option>
              </select>
            </div>
            <div>
              <label class="block text-gray-500 mb-1">Gigi Anomali</label>
              <input
                type="text"
                placeholder="(Anomali) Dijelaskan gigi yang mana, dan bentuknya"
                class="w-full mt-2 border-b border-gray-300 outline-none text-xs text-gray-400 pb-1"
              />
            </div>
          </div>

          <div class="mt-6 flex space-x-4 w-1/4">
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">D</label
              ><input
                type="text"
                class="border-b border-gray-300 outline-none"
              />
            </div>
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">M</label
              ><input
                type="text"
                class="border-b border-gray-300 outline-none"
              />
            </div>
            <div class="flex flex-col w-1/3">
              <label class="text-xs text-gray-500">F</label
              ><input
                type="text"
                class="border-b border-gray-300 outline-none"
              />
            </div>
          </div>

          <div class="mt-6">
            <label class="block text-xs text-gray-500 mb-1"
              >Catatan Lainnya</label
            >
            <textarea
              class="w-full border-b border-gray-300 outline-none resize-none"
              rows="2"
            ></textarea>
          </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-4 border-t flex justify-end">
          <button
            onclick="toggleOdontogramModal(false)"
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
              placeholder="Search"
              class="w-full outline-none text-gray-600 px-1"
            />
          </div>
          <div class="overflow-y-auto max-h-48 p-2 space-y-1">
            <div
              class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer"
              onclick="applyCondition('clear')"
            >
              <div class="w-6 h-6 border border-gray-600 bg-white"></div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">Hapus</p>
                <p class="text-[10px] text-gray-400">Hapus catatan gigi</p>
              </div>
            </div>
            <div
              class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer"
              onclick="applyCondition('mesial')"
            >
              <div class="w-6 h-6 border border-gray-600 flex relative">
                <div
                  class="absolute left-0 top-0 bottom-0 w-2 bg-purple-800"
                ></div>
              </div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">M</p>
                <p class="text-[10px] text-gray-400">Mesial</p>
              </div>
            </div>
            <div
              class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded cursor-pointer"
              onclick="applyCondition('occlusal')"
            >
              <div
                class="w-6 h-6 border border-gray-600 flex relative items-center justify-center"
              >
                <div class="w-2.5 h-2.5 bg-purple-800"></div>
              </div>
              <div>
                <p class="font-medium text-gray-700 leading-tight">O</p>
                <p class="text-[10px] text-gray-400">Occlusal</p>
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
            <div class="flex flex-col items-center justify-center cursor-pointer p-1 rounded hover:bg-gray-100 transition-colors" onclick="openToolbar(event, this, ${number})">
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

      // Variabel penampung state Toolbar
      const toolbar = document.getElementById("toolbar");
      const modalBody = document.getElementById("modalBody");
      let activeToothElement = null;

      // Buka toolbar
      function openToolbar(event, element, number) {
        event.stopPropagation();
        activeToothElement = element;

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
        if (!activeToothElement) return;

        const surfaces = activeToothElement.querySelectorAll(".tooth-surface");
        const colorOcclusal = "#6b21a8";

        surfaces.forEach((s) => s.setAttribute("fill", "white"));

        if (condition === "mesial") {
          activeToothElement
            .querySelector(".surface-left")
            .setAttribute("fill", colorOcclusal);
        } else if (condition === "occlusal") {
          activeToothElement
            .querySelector(".surface-center")
            .setAttribute("fill", colorOcclusal);
        }

        toolbar.classList.add("hidden");
      }

      // Tutup toolbar jika mengklik area lain
      modalBody.addEventListener("click", function (e) {
        if (!toolbar.contains(e.target)) {
          toolbar.classList.add("hidden");
        }
      });
    </script>
