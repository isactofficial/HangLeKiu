<div id="modalPayment" class="fixed inset-0 bg-black/50 z-[9999] hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden text-xs">
        <div class="bg-[#A67C52] p-3 flex justify-between items-center text-white">
            <h2 class="font-bold uppercase tracking-widest">Review & Proses Pembayaran</h2>
            <button onclick="closePayment()" class="text-2xl font-bold leading-none">&times;</button>
        </div>
        <div class="p-6">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-700">INVOICE <span id="m-inv-no" class="text-gray-400 font-normal"></span></h3>
                <select class="border rounded p-1"><option>Apotek</option></select>
            </div>

            <table class="w-full border mb-4">
                <thead class="bg-gray-50 text-[#A67C52] font-bold uppercase">
                    <tr>
                        <th class="p-2 text-left">Tindakan</th>
                        <th class="p-2 text-center">Qty</th>
                        <th class="p-2 text-right">Harga</th>
                        <th class="p-2 text-right">Disc</th>
                        <th class="p-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody id="m-items"></tbody>
            </table>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div class="space-y-4">
                    <p class="text-[#A67C52] font-bold uppercase tracking-tighter">Metode Pembayaran</p>
                    <select id="m-metode" class="w-full border-b-2 border-[#A67C52] py-1 font-bold text-sm text-[#A67C52] outline-none">
                        <option>Langsung - Tunai</option>
                        <option>Langsung - Debit</option>
                        <option>Langsung - Transfer</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[#A67C52] font-bold uppercase">Bayar (Rp)</p>
                        <input type="number" id="m-bayar" class="w-full border-b border-gray-400 py-1 font-bold text-sm outline-none">
                    </div>
                    <div>
                        <p class="text-[#A67C52] font-bold uppercase">Diskon (Rp)</p>
                        <input type="number" id="m-disc" value="0" class="w-full border-b border-gray-400 py-1 font-bold text-sm outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8 gap-3 border-t pt-4">
                <button onclick="closePayment()" class="px-6 py-2 border rounded font-bold text-gray-400 uppercase hover:bg-gray-50">Batal</button>
                <button onclick="prosesDone()" class="px-10 py-2 btn-cokelat rounded font-bold shadow-lg uppercase tracking-wider">Done (Proses)</button>
            </div>
        </div>
    </div>
</div>