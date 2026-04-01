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

    .res-container {
        max-height: 200px;
        overflow-y: auto;
    }
    .res-item {
        padding: 8px 12px;
        cursor: pointer;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
    }
    .res-item:hover {
        background-color: #f3f8ff;
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
            <p id="prosedur-date-display" class="text-xs text-gray-500 mb-1">Tanggal Hari Ini</p>
            <div class="flex items-end space-x-3">
              <span id="prosedur-patient-name" class="text-lg font-bold text-gray-800"
                >Nama Pasien</span
              >
              <span id="prosedur-patient-payment" class="text-sm text-gray-500 mb-0.5">Metode Pembayaran</span>
              <span id="prosedur-patient-demographics" class="text-xs text-gray-400 mb-1 ml-4"
                >No. RM &middot; Jenis Kelamin &middot; Umur</span
              >
            </div>
          </div>
          
          <!-- Hidden Inputs untuk Data Master -->
          <input type="hidden" id="prosedur-patient-id" value="">
          <input type="hidden" id="prosedur-registration-id" value="">
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
                    placeholder="Cari Prosedur..."
                    class="input-underline pl-6 pr-6 search-prosedur w-full"
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
              <div class="w-24 input-gigi-wrapper relative">
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
                  value="Rp0"
                  class="input-underline text-gray-400 input-harga-jual"
                  readonly
                />
              </div>

              <!-- Diskon -->
              <div class="w-40 flex items-center space-x-2">
                <div class="flex-grow">
                  <label class="label-small">Discount</label>
                  <input type="text" class="input-underline input-diskon" value="0" />
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
                    <input type="text" placeholder="Cari obat..." class="input-underline w-full search-obat" autocomplete="off" />
                    <!-- Container Dropdown Hasil Pencarian -->
                    <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden res-container max-h-48 overflow-y-auto">
                        <!-- Hasil pencarian akan muncul di sini -->
                    </div>
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
              id="prosedur-notes"
              placeholder="Catatan"
              class="input-underline text-sm placeholder-gray-400"
            />
          </div>

          <!-- Baris: Tenaga Medis & Trigger Tambah Prosedur -->
          <div class="flex justify-between items-end pt-4 pb-4">
            <div class="w-1/2">
              <label class="label-small">Tenaga Medis Utama</label>
              <select
                id="prosedur-doctor-select"
                class="input-underline text-sm cursor-pointer appearance-none bg-white font-medium"
              >
                <option value="">-- Pilih Tenaga Medis --</option>
                @foreach(\App\Models\Doctor::where('is_active', true)->orderBy('full_name')->get() as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->full_name }}</option>
                @endforeach
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
            <p class="text-xl font-bold text-gray-700" id="totalHargaDisplay">Rp0</p>
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

      // Tambahkan parameter 'patientData' di sebelah 'show'
    function toggleProsedureModal(show, patientData = null) {
      if (show) {
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

        // 2. Set tanggal hari ini secara otomatis (biar nggak statis)
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('prosedur-date-display').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

        // 3. Tampilkan modal
        modalMain.classList.remove("hidden");
      } else {
        // Sembunyikan modal
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

      async function submitAll() {
        toggleConfirmModal(false);

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

            // 1. Simpan Parent Medical Procedure
            const payloadParent = {
                'registration_id': document.getElementById('prosedur-registration-id').value,
                'patient_id': document.getElementById('prosedur-patient-id').value,
                'doctor_id': document.getElementById('prosedur-doctor-select').value,
                'discount_type': 'none',
                'discount_value': 0,
                'total_amount': totalAmount > 0 ? totalAmount : 0,
                'notes': document.getElementById('prosedur-notes').value
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
            const procedureId = parentData.data.id;

            // 2. Simpan Procedure Items (dan otomatis Tooth Procedure via Controller)
            for (let row of prosedurRows) {
                const inputProsedur = row.querySelector('.search-prosedur');
                const masterId = inputProsedur.dataset.masterId;
                
                if (!masterId) continue;
                
                const qtyInput = row.querySelectorAll('input[type="number"]')[0];
                const diskonInput = row.querySelector('.input-diskon');
                const gigiInp = row.querySelector('.input-no-gigi');
                
                const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
                const basePrice = parseFloat(inputProsedur.dataset.basePrice || 0);
                const diskonVal = parseFloat(diskonInput ? diskonInput.value : 0) || 0;

                const payloadItem = {
                    'procedure_id': procedureId,
                    'master_procedure_id': masterId,
                    'tooth_numbers': gigiInp ? gigiInp.value : null,
                    'quantity': qty,
                    'unit_price': basePrice,
                    'discount_type': diskonVal > 0 ? 'fix' : 'none',
                    'discount_value': diskonVal,
                    'subtotal': (basePrice * qty) - diskonVal
                };

                await fetch('/api/procedure-items', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payloadItem)
                });
            }

            // 3. Simpan Procedure Medicines
            const obatRows = document.querySelectorAll('.obat-row');
            for (let row of obatRows) {
                const inputObat = row.querySelector('.search-obat');
                if (!inputObat) continue;
                
                const medicineId = inputObat.dataset.medicineId;
                if (!medicineId) continue;
                
                const qtyInput = row.querySelectorAll('input[type="number"]')[0];
                const qty = parseInt(qtyInput ? qtyInput.value : 0) || 0;

                if (qty > 0) {
                    const payloadObat = {
                        'procedure_id': procedureId,
                        'medicine_id': medicineId,
                        'quantity_used': qty
                    };

                    const resObat = await fetch('/api/procedure-medicine', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify(payloadObat)
                    });
                    const obatData = await resObat.json();
                    if (!obatData.success) {
                        alert("Gagal mengurangi stok obat: " + (obatData.message || ''));
                    }
                }
            }

            // Pesan sukses Estetika di halaman EMR
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-10 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-xl shadow-2xl z-[99999] flex items-center space-x-3 transition-all duration-500 opacity-0 translate-y-[-20px]';
            successMsg.innerHTML = `
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
          "prosedur-row flex flex-wrap md:flex-nowrap items-end gap-4 w-full relative mt-4 pt-4 border-t border-gray-100"; // Menambah pemisah antar prosedur

        newRow.innerHTML = `
                <!-- Nama Prosedur -->
                <div class="flex-grow relative w-full md:w-auto">
                    <label class="label-small text-gray-400">Nama Prosedur *</label>
                    <div class="relative w-full flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2 left-0 bottom-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Cari Prosedur *" class="input-underline pl-6 pr-6 search-prosedur w-full" autocomplete="off">
                        <!-- Container Dropdown Hasil Pencarian -->
                        <div class="absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[100] hidden res-container-prosedur max-h-48 overflow-y-auto">
                        </div>
                    </div>
                </div>

                <!-- No. Gigi (Auto-complete Multiple) -->
                <div class="w-24 input-gigi-wrapper relative">
                    <label class="label-small text-gray-400">No. Gigi</label>
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari (11)..." class="input-underline text-center input-no-gigi search-gigi cursor-text bg-transparent w-full" autocomplete="off">
                        <div class="absolute left-0 bottom-full mb-1 w-[220px] bg-white border border-gray-200 shadow-xl z-50 rounded hidden res-container-gigi max-h-48 overflow-y-auto">
                        </div>
                    </div>
                </div>

                <!-- Qty -->
                <div class="w-16">
                    <label class="label-small text-gray-400">Qty *</label>
                    <input type="number" value="0" class="input-underline text-center">
                </div>

                <!-- Harga Jual -->
                <div class="w-32">
                    <label class="label-small text-gray-400">Harga Jual *</label>
                    <input type="text" value="Rp0" class="input-underline text-gray-400 input-harga-jual" readonly>
                </div>

                <!-- Diskon -->
                <div class="w-40 flex items-center space-x-2">
                    <div class="flex-grow">
                        <label class="label-small text-gray-400">Discount</label>
                        <input type="text" class="input-underline input-diskon" value="0">
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
          const prosedurRows = document.querySelectorAll('.prosedur-row');
          prosedurRows.forEach(row => {
              const inputProsedur = row.querySelector('.search-prosedur');
              if (inputProsedur && inputProsedur.dataset.masterId) {
                  const qtyInput = row.querySelectorAll('input[type="number"]')[0];
                  const diskonInput = row.querySelector('.input-diskon');
                  
                  const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
                  const basePrice = parseFloat(inputProsedur.dataset.basePrice || 0);
                  const diskonVal = parseFloat(diskonInput ? diskonInput.value : 0) || 0;
                  
                  let subtotal = (basePrice * qty) - diskonVal;
                  if (subtotal < 0) subtotal = 0;
                  
                  total += subtotal;
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
        newRow.className = "obat-row flex items-end gap-4 w-full relative mt-4";
        newRow.innerHTML = `
            <div class="flex-grow">
              <label class="label-small text-gray-400">Obat yang dipakai</label>
              <div class="relative w-full flex items-center">
                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                <input type="text" placeholder="Cari obat..." class="input-underline w-full search-obat" autocomplete="off" data-medicine-id="" />
                <div class="res-container absolute left-0 top-full w-full bg-white shadow-lg rounded-b-md border border-gray-200 z-[999] hidden max-h-48 overflow-y-auto"></div>
              </div>
            </div>
            <div class="w-20">
                <label class="label-small text-gray-400">Qty</label>
                <input type="number" value="0" class="input-underline text-center w-full" min="0" />
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

        const totalEle = document.getElementById('totalHargaDisplay');
        if (totalEle) totalEle.innerText = 'Rp0';
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
        if (!e.target.classList.contains('search-prosedur')) {
            document.querySelectorAll('.res-container-prosedur').forEach(el => el.classList.add('hidden'));
        }
    });

    // EVENT LISTENER UNTUK PERUBAHAN QTY/DISKON (HITUNG TOTAL OTOMATIS)
    document.addEventListener('input', function(e) {
        // Hitung ulang total saat qty prosedur, diskon, atau qty obat berubah
        const inProsedurRow = e.target.closest('.prosedur-row');
        const inObatRow = e.target.closest('.obat-row');
        if ((inProsedurRow || inObatRow) && (e.target.type === 'number' || e.target.classList.contains('input-diskon'))) {
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
    </script>
