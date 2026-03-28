@push('styles')
    <style>
      /* Hilangkan panah spinner pada input number */
      input[type="number"]::-webkit-inner-spin-button,
      input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Style khusus untuk input bergaris bawah */
      .input-underline {
        width: 100%;
        border: none;
        border-bottom: 1.5px solid #d1d5db;
        padding: 4px 0;
        outline: none;
        background-color: transparent;
        font-size: 14px;
        color: #1f2937;
        transition: border-color 0.2s;
      }
      .input-underline:focus {
        border-bottom-color: #3b82f6;
      }
      .input-underline:disabled,
      .input-underline[readonly] {
        color: #6b7280;
        border-bottom-color: #e5e7eb;
      }

      /* Label kecil di atas input */
      .label-small {
        display: block;
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 2px;
        font-weight: 500;
      }

      /* Custom scrollbar untuk area form */
      ::-webkit-scrollbar {
        width: 6px;
      }
      ::-webkit-scrollbar-track {
        background: transparent;
      }
      ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
      }
    </style>
@endpush

<div
      id="modalTambahProsedur"
      class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] transition-opacity duration-300"
    >
      <div
        class="bg-white rounded-lg shadow-2xl w-11/12 max-w-4xl max-h-[90vh] flex flex-col relative transform transition-all scale-100"
      >
        <!-- Tombol Close (X) -->
        <button
          onclick="toggleProsedureModal(false)"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 z-10"
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
        <div class="px-8 pt-8 pb-4 border-b border-gray-100 flex-shrink-0">
          <h2 class="text-2xl font-bold text-brown-500 text-center mb-6">
            Tambah Prosedur
          </h2>

          <!-- Info Pasien -->
          <div>
            <p class="text-xs text-gray-500 mb-1">Jumat, 13 Maret 2026</p>
            <div class="flex items-end space-x-3">
              <span class="text-lg font-bold text-gray-800"
                >Rameyza Alya S</span
              >
              <span class="text-sm text-gray-500 mb-0.5">Tunai</span>
              <span class="text-xs text-gray-400 mb-1 ml-4"
                >230785 · Perempuan · 21 Tahun</span
              >
            </div>
          </div>
        </div>

        <!-- BODY MODAL (Bisa di-scroll) -->
        <div class="p-8 overflow-y-auto flex-grow space-y-6">
          <!-- CONTAINER BARIS PROSEDUR -->
          <div
            id="prosedurContainer"
            class="space-y-6 w-full border-b border-gray-100 pb-6"
          >
            <!-- Baris 1: Default (Sudah Terisi seperti di gambar) -->
            <div
              class="prosedur-row flex flex-wrap md:flex-nowrap items-end gap-4 w-full relative"
            >
              <!-- Nama Prosedur -->
              <div class="flex-grow relative w-full md:w-auto">
                <label class="label-small">Nama Prosedur *</label>
                <div class="relative w-full flex items-center">
                  <!-- Search Icon -->
                  <svg
                    class="w-4 h-4 text-gray-400 mr-2 left-0 bottom-2"
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
                    value="kontrol Ortho damon Ria Medianto"
                    class="input-underline pl-6 pr-6"
                    autocomplete="off"
                  />
                  <!-- Clear Icon (X) -->
                  <button
                    class="absolute right-0 bottom-1.5 text-gray-400 hover:text-gray-600"
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
                </div>
              </div>

              <!-- No. Gigi -->
              <div class="w-16">
                <label class="label-small">No. Gigi</label>
                <input
                  type="text"
                  placeholder="-"
                  class="input-underline text-center"
                />
              </div>

              <!-- Qty -->
              <div class="w-16">
                <label class="label-small">Qty *</label>
                <input
                  type="number"
                  value="1"
                  class="input-underline text-center"
                />
              </div>

              <!-- Harga Jual -->
              <div class="w-32">
                <label class="label-small">Harga Jual *</label>
                <input
                  type="text"
                  value="Rp500.000"
                  class="input-underline text-gray-400"
                  readonly
                />
              </div>

              <!-- Diskon -->
              <div class="w-40 flex items-center space-x-2">
                <div class="flex-grow">
                  <label class="label-small">Discount</label>
                  <input type="text" class="input-underline" />
                </div>
                <span class="text-gray-500 text-sm mt-3">Fix</span>

                <!-- Icon Tong Sampah Merah (Hapus Baris) -->
                <button
                  class="text-red-500 hover:text-red-700 mt-3 px-1"
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
                <button class="text-gray-400 mt-3">
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

          <!-- Baris: ICD 9 CM -->
          <div class="flex items-end gap-4 w-full mt-4">
            <div class="flex-grow relative">
              <div class="relative w-full flex items-center">
                <svg
                  class="w-4 h-4 text-gray-400 mr-2 left-0 bottom-2"
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
                  placeholder="Cari ICD 9 CM"
                  class="input-underline pl-6 text-sm"
                />
              </div>
            </div>
            <button
              class="border border-blue-400 text-blue-500 rounded px-3 py-1 text-xs font-semibold hover:bg-blue-50 flex items-center space-x-1"
            >
              <span>✨ AI</span>
            </button>
          </div>

          <!-- ============================================== -->
          <!-- CONTAINER BARIS OBAT DINAMIS -->
          <!-- ============================================== -->
          <div class="mt-8 border-t border-gray-100 pt-6">
            <div id="obatContainer" class="space-y-4 w-full">
              <!-- Baris Obat 1 (Default) -->
              <div class="obat-row flex items-end gap-4 w-full relative">
                <!-- Nama Obat -->
                <div class="flex-grow">
                  <label class="label-small text-gray-400">Obat yang dipakai</label>
                  <div class="relative w-full flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <input type="text" placeholder="Cari obat..." class="input-underline w-full" autocomplete="off" />
                  </div>
                </div>
                <!-- Qty Obat -->
                <div class="w-20">
                  <label class="label-small text-gray-400">Qty</label>
                  <input type="number" value="0" class="input-underline text-center w-full" />
                </div>
                <!-- Hapus Baris Obat -->
                <button class="text-red-500 hover:text-red-700 mt-3 px-1 mb-1" onclick="hapusBarisObat(this)">
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
              class="text-blue-500 text-xs mt-3 inline-block font-medium hover:underline"
            >
              + Tambah Obat
            </a>
          </div>
          <!-- AKHIR CONTAINER OBAT -->

          <!-- Baris: Catatan -->
          <div class="mt-4">
            <label class="label-small text-gray-400 opacity-0">Catatan</label>
            <input
              type="text"
              placeholder="Catatan"
              class="input-underline text-sm placeholder-gray-400"
            />
          </div>

          <!-- Baris: Tenaga Medis & Trigger Tambah Prosedur -->
          <div class="flex justify-between items-end pt-4 pb-4">
            <div class="w-1/2">
              <label class="label-small">Tenaga Medis Utama</label>
              <select
                class="input-underline text-sm cursor-pointer appearance-none"
              >
                <option>drg. Ria Budiati Sp. Ortho</option>
              </select>

              <!-- TOMBOL PEMICU TAMBAH BARIS PROSEDUR -->
              <a
                href="#"
                onclick="tambahBarisProsedur(event)"
                class="text-blue-500 text-xs mt-3 inline-block font-medium hover:underline"
              >
                + Tambah Prosedur
              </a>
            </div>

            <div>
              <button
                class="text-gray-600 text-xs font-bold hover:text-gray-800 tracking-wide"
              >
                + TAMBAH ASISTEN TENAGA MEDIS
              </button>
            </div>
          </div>
        </div>

        <!-- FOOTER MODAL (Tetap / Sticky) -->
        <div
          class="px-8 py-5 border-t border-gray-100 flex-shrink-0 flex justify-end items-center space-x-6 bg-gray-50 rounded-b-lg"
        >
          <div class="text-right">
            <p class="text-xs text-gray-500 mb-0.5">Total Harga</p>
            <p class="text-xl font-bold text-gray-700">Rp500.000</p>
          </div>
          <button
            onclick="toggleConfirmModal(true)"
            class="bg-[#3b331e] hover:bg-slate-900 text-white font-medium py-2.5 px-8 rounded text-sm shadow transition-colors"
          >
            SIMPAN
          </button>
        </div>
      </div>
    </div>

    <!-- ======================================================= -->
    <!-- 2. MODAL KONFIRMASI -->
    <!-- ======================================================= -->
    <div
      id="modalConfirm"
      class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[10000] transition-opacity duration-200"
    >
      <div
        class="bg-white rounded p-6 w-[400px] shadow-2xl transform scale-100"
      >
        <p
          class="text-[15px] font-medium text-gray-800 leading-relaxed pr-8 mb-8"
        >
          Apakah sudah tidak ada prosedur lagi yang ingin ditambahkan?
        </p>
        <div class="flex justify-end space-x-6">
          <button
            onclick="toggleConfirmModal(false)"
            class="text-[13px] font-bold text-indigo-700 hover:text-indigo-900 tracking-wide"
          >
            KEMBALI
          </button>
          <button
            onclick="submitAll()"
            class="text-[13px] font-bold text-indigo-700 hover:text-indigo-900 tracking-wide"
          >
            IYA
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

      function toggleProsedureModal(show) {
        if (show) {
          modalMain.classList.remove("hidden");
        } else {
          modalMain.classList.add("hidden");
        }
      }

      function toggleConfirmModal(show) {
        if (show) {
          modalConfirm.classList.remove("hidden");
        } else {
          modalConfirm.classList.add("hidden");
        }
      }

      function submitAll() {
        toggleConfirmModal(false);
        toggleProsedureModal(false);
        alert("Data disimpan!");
      }

      // =======================================================
      // FUNGSI UNTUK MENAMBAH BARIS PROSEDUR BARU
      // =======================================================
      function tambahBarisProsedur(e) {
        e.preventDefault();

        const newRow = document.createElement("div");
        newRow.className =
          "prosedur-row flex flex-wrap md:flex-nowrap items-end gap-4 w-full relative mt-4 pt-4 border-t border-gray-100"; // Menambah pemisah antar prosedur

        newRow.innerHTML = `
                <!-- Nama Prosedur -->
                <div class="flex-grow relative w-full md:w-auto">
                    <label class="label-small text-gray-400">Nama Prosedur *</label>
                    <div class="relative w-full flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2 left-0 bottom-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Nama Prosedur *" class="input-underline pl-6 pr-6" autocomplete="off">
                    </div>
                </div>

                <!-- No. Gigi -->
                <div class="w-16">
                    <label class="label-small text-gray-400">No. Gigi</label>
                    <input type="text" placeholder="-" class="input-underline text-center">
                </div>

                <!-- Qty -->
                <div class="w-16">
                    <label class="label-small text-gray-400">Qty *</label>
                    <input type="number" value="0" class="input-underline text-center">
                </div>

                <!-- Harga Jual -->
                <div class="w-32">
                    <label class="label-small text-gray-400">Harga Jual *</label>
                    <input type="text" value="Rp0" class="input-underline text-gray-400" readonly>
                </div>

                <!-- Diskon -->
                <div class="w-40 flex items-center space-x-2">
                    <div class="flex-grow">
                        <label class="label-small text-gray-400">Discount</label>
                        <input type="text" class="input-underline">
                    </div>
                    <span class="text-gray-500 text-sm mt-3">Fix</span>

                    <!-- Icon Tong Sampah Merah (Hapus Baris) -->
                    <button class="text-red-500 hover:text-red-700 mt-3 px-1" onclick="hapusBarisProsedur(this)">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </button>

                    <!-- Chevron Icon -->
                    <button class="text-gray-400 mt-3">
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
          inputs[1].value = ""; // No. Gigi
          inputs[2].value = "0"; // Qty
          inputs[3].value = "Rp0"; // Harga
          inputs[4].value = ""; // Discount
        }
      }

      // =======================================================
      // FUNGSI UNTUK MENAMBAH BARIS OBAT BARU
      // =======================================================
      function tambahBarisObat(e) {
        e.preventDefault();

        const newRow = document.createElement("div");
        newRow.className = "obat-row flex items-end gap-4 w-full relative mt-4";

        newRow.innerHTML = `
                <div class="flex-grow">
                  <div class="relative w-full flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <input type="text" placeholder="Cari obat..." class="input-underline w-full" autocomplete="off" />
                  </div>
                </div>
                <div class="w-20">
                  <input type="number" value="0" class="input-underline text-center w-full" />
                </div>
                <button class="text-red-500 hover:text-red-700 mt-3 px-1 mb-1" onclick="hapusBarisObat(this)">
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

      // FUNGSI HELPER UNTUK SCROLL KE BAWAH SAAT ITEM BARU DITAMBAHKAN
      function scrollToBottom() {
        const modalBody = document.querySelector("#modalTambahProsedur .overflow-y-auto");
        modalBody.scrollTop = modalBody.scrollHeight;
      }
    </script>
