<div id="modalPayment" class="fixed inset-0 bg-black/50 z-[9999] hidden flex items-center justify-center p-4 no-print">
    
    {{-- Container Modal: max-h-[95vh] memastikan kotak putih tidak melebihi batas layar, overflow-y-auto bikin scroll di dalamnya --}}
    <div class="bg-white rounded shadow-2xl w-full max-w-5xl max-h-[95vh] overflow-y-auto font-sans text-sm relative flex flex-col">
        
       <div class="p-4 flex justify-between items-center border-b border-[#A67C52]/20 bg-[#fdfaf8] rounded-t flex-shrink-0">
            <h2 class="text-[#8e6a45] text-xl font-bold uppercase tracking-wider">Review & Proses Pembayaran</h2>
            
            {{-- Tombol Close X yang sudah disempurnakan --}}
            <button onclick="closePayment()" class="w-8 h-8 flex items-center justify-center rounded-full text-[#8e6a45] hover:bg-[#8e6a45] hover:text-white transition-all focus:outline-none">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        {{-- Konten Utama --}}
        <div class="p-6 bg-white flex-shrink-0">
            
            {{-- SEKSI 1: DETAIL PASIEN --}}
            <div class="bg-[#8e6a45] text-white p-2 text-xs font-semibold mb-2 rounded-t uppercase tracking-wide">Detail Pasien</div>
            <div class="grid grid-cols-5 gap-4 mb-8 text-xs border border-[#A67C52]/30 border-t-0 p-4 rounded-b bg-[#fdfaf8]">
                <div>
                    <div class="text-[#A67C52] font-bold mb-1 uppercase tracking-wider">ID</div>
                    <div class="text-[#A67C52] font-medium" id="m-pasien-id">-</div>
                </div>
                <div>
                    <div class="text-[#A67C52] font-bold mb-1 uppercase tracking-wider">Nama Lengkap</div>
                    <div class="text-[#A67C52] font-medium" id="m-pasien-nama">-</div>
                </div>
                <div>
                    <div class="text-[#A67C52] font-bold mb-1 uppercase tracking-wider">Usia</div>
                    <div class="text-[#A67C52] font-medium" id="m-pasien-usia">-</div>
                </div>
                <div>
                    <div class="text-[#A67C52] font-bold mb-1 uppercase tracking-wider">Nomor HP / WA</div>
                    <div class="text-[#A67C52] font-medium" id="m-pasien-hp">-</div>
                </div>
                <div>
                    <div class="text-[#A67C52] font-bold mb-1 uppercase tracking-wider">Nama Dokter</div>
                    <div class="text-[#A67C52] font-medium" id="m-pasien-dokter">-</div>
                </div>
            </div>

            {{-- SEKSI 2: REVIEW INVOICE & PROSEDUR --}}
            <div class="bg-[#8e6a45] text-white p-2 text-xs font-semibold mb-2 flex justify-between items-center rounded-t uppercase tracking-wide">
                <span>Review Invoice</span>
            </div>

            <div class="flex justify-between items-start mb-4 mt-4 px-2">
                <div>
                    <h3 class="text-xl font-black text-[#8e6a45] tracking-tight">INVOICE</h3>
                    <p class="text-[#A67C52] text-sm font-medium"><span id="m-inv-no"></span></p>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-3 px-2">
                <input type="checkbox" id="edit-tenaga" class="rounded text-[#A67C52] focus:ring-[#A67C52] border-[#A67C52]">
                <label for="edit-tenaga" class="text-xs text-[#A67C52] font-medium cursor-pointer">Edit tenaga medis utama dan pembantu</label>
            </div>

            {{-- Wrapper Tabel --}}
            <div class="overflow-x-auto border border-[#A67C52]/30 rounded mb-4 shadow-sm">
                <table class="w-full text-xs text-left whitespace-nowrap">
                    <thead class="bg-[#fdfaf8]">
                        <tr class="text-[#A67C52] border-b border-[#A67C52]/30">
                            <th class="p-3 font-bold uppercase tracking-wider w-28">Tanggal Tindakan</th>
                            <th class="p-3 font-bold uppercase tracking-wider">Tindakan</th>
                            <th class="p-3 font-bold uppercase tracking-wider text-center w-20">Gigi</th>
                            <th class="p-3 font-bold uppercase tracking-wider text-center w-16">Jumlah</th>
                            <th class="p-3 font-bold uppercase tracking-wider w-28 text-right">Harga</th>
                            <th class="p-3 font-bold uppercase tracking-wider w-24 text-right">Diskon</th>
                            <th class="p-3 font-bold uppercase tracking-wider w-32 text-right">Total Harga</th>
                            <th class="p-3 w-10 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="m-items" class="divide-y divide-[#A67C52]/20">
                        {{-- Diisi via JS --}}
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mb-6 px-2">
                <div class="text-base font-black flex items-center gap-3">
                    <span class="text-[#A67C52] uppercase text-xs tracking-widest font-bold">Total:</span> 
                    <span id="m-grand-total" class="text-2xl text-[#8e6a45]">Rp0</span>
                    <span class="text-white bg-[#8e6a45] px-3 py-1.5 rounded text-[10px] font-bold cursor-pointer ml-4 uppercase hover:bg-[#7a5938] transition-colors shadow-sm tracking-wider">
                        <i class="fa fa-print mr-1"></i> Print Preview
                    </span>
                </div>
            </div>

            <div class="border border-[#A67C52]/30 rounded mb-8 shadow-sm">
                <div class="bg-[#fdfaf8] text-[#A67C52] p-2.5 text-xs font-bold border-b border-[#A67C52]/30 uppercase tracking-wider">Catatan Invoice</div>
                <textarea id="m-notes" class="w-full p-3 text-xs outline-none resize-none h-16 text-[#A67C52] focus:bg-[#fdfaf8] transition-colors placeholder-[#A67C52]/50" placeholder="Tambahkan catatan khusus untuk pembayaran ini (Opsional)..."></textarea>
            </div>

            {{-- SEKSI 3: METODE PEMBAYARAN --}}
            <div class="bg-[#8e6a45] text-white p-2 text-xs font-semibold mb-4 rounded-t uppercase tracking-wide">Metode Pembayaran</div>

            <div class="flex items-center gap-6 mb-6 px-2">
                <label class="flex items-center gap-2 text-xs text-[#A67C52] font-medium cursor-pointer">
                    <input type="checkbox" checked class="rounded text-[#A67C52] focus:ring-[#A67C52] border-[#A67C52]"> 
                    Tampilkan detail harga per-item pada struk
                </label>
                <label class="flex items-center gap-2 text-xs text-[#A67C52] font-medium cursor-pointer">
                    <input type="checkbox" class="rounded text-[#A67C52] focus:ring-[#A67C52] border-[#A67C52]"> 
                    Multi type payment (Split Bill)
                </label>
            </div>

            <div class="grid grid-cols-2 gap-10 mt-2 px-2 pb-4">
                {{-- Kiri: Pilihan Metode --}}
                <div class="space-y-5">
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider mb-1.5 block">Tipe Pembayaran</label>
                        <select class="w-2/3 border border-[#A67C52]/30 rounded p-2 text-xs text-[#A67C52] font-semibold outline-none focus:border-[#A67C52] bg-[#fdfaf8]">
                            <option>Langsung (Full Payment)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider mb-1.5 block">Metode</label>
                        <select id="m-metode" class="w-full border border-[#A67C52]/30 rounded p-2 text-sm outline-none text-[#A67C52] focus:border-[#A67C52] bg-[#fdfaf8] font-semibold">
                            @if(isset($paymentMethods))
                                @foreach($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                @endforeach
                            @else
                                <option>Tunai</option>
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider mb-1 block">Akun Kas</label>
                        <select class="w-full border-b-2 border-[#A67C52]/30 py-1.5 text-sm outline-none text-[#A67C52] font-semibold focus:border-[#A67C52] bg-transparent">
                            <option>Kas Utama Klinik</option>
                        </select>
                    </div>
                </div>

                {{-- Kanan: Kalkulasi --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider flex items-center gap-1 mb-1">Diterima (Bayar) <span class="text-red-500">*</span></label>
                        <div class="relative border-b-2 border-[#A67C52]/30 py-1 focus-within:border-[#A67C52] transition-colors">
                            <span class="absolute left-0 top-1 text-sm font-bold text-[#A67C52]">Rp</span>
                            <input type="text" id="m-input-bayar" onkeyup="hitungKembalian()" class="w-full pl-6 text-lg font-black text-[#A67C52] outline-none bg-transparent" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider flex items-center gap-1 mb-1">Dibayar Oleh <span class="text-red-500">*</span></label>
                        <input type="text" id="m-input-pembayar" class="w-full border-b-2 border-[#A67C52]/30 py-1 text-sm font-bold outline-none text-[#A67C52] focus:border-[#A67C52] bg-transparent transition-colors" value="Pribadi">
                    </div>
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider mb-1 block">Kembalian</label>
                        <div class="bg-green-50 border border-green-200 p-2 text-sm font-black text-[#8e6a45] rounded shadow-sm" id="m-kembalian">Rp0</div>
                    </div>
                    <div>
                        <label class="text-[#A67C52] text-xs font-bold uppercase tracking-wider mb-1 block">Hutang / Kurang</label>
                        <div class="bg-red-50 border border-red-200 p-2 text-sm font-black text-[#8e6a45] rounded shadow-sm" id="m-hutang">Rp0</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div class="p-4 bg-[#fdfaf8] border-t border-[#A67C52]/20 flex justify-end gap-3 rounded-b flex-shrink-0">
            <button onclick="closePayment()" class="px-6 py-2.5 bg-white border border-[#A67C52]/40 rounded text-[#A67C52] font-bold text-xs uppercase tracking-wider hover:bg-[#A67C52]/10 transition-colors shadow-sm">Batal</button>
            <button onclick="prosesDone()" class="px-8 py-2.5 bg-[#8e6a45] text-white rounded font-bold text-xs uppercase tracking-wider hover:bg-[#7a5938] flex items-center gap-2 shadow-md transition-all active:scale-95 border border-[#8e6a45]">
                <i class="fa fa-check-circle text-lg"></i> Simpan Pembayaran
            </button>
        </div>

    </div>
</div>