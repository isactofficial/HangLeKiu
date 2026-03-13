@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/resep.css') }}">
@endpush


<div class="apt-card">

    <div class="apt-card-header">
        <h2 class="apt-card-title">Cetak Resep Obat</h2>
    </div>

    <div style="padding:18px 20px; display:flex; flex-direction:column; gap:18px;">

        {{-- Tanggal Resep --}}
        <div style="max-width:160px;">
            <label class="apt-label">Tanggal Resep</label>
            <input type="date" value="2026-03-05" class="apt-input-line" style="width:160px;">
        </div>

        {{-- Dokter + Pasien --}}
        <div style="display:flex; gap:16px; flex-wrap:wrap;">
            <div style="flex:1; min-width:180px;">
                <label class="apt-label">Pilih Dokter</label>
                <select class="apt-select">
                    <option>drg. Anisa Putri</option>
                    <option>drg. Budi Raharjo</option>
                    <option>drg. Citra Dewi</option>
                </select>
            </div>
            <div style="flex:1; min-width:180px;">
                <label class="apt-label">Cari Pasien</label>
                <div class="apt-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari Pasien" value="Rina Wulandari">
                </div>
            </div>
        </div>

        {{-- Tipe + Umur + BB + Alamat --}}
        <div style="display:flex; gap:16px; flex-wrap:wrap; align-items:flex-end;">
            <div style="flex:1; min-width:140px;">
                <label class="apt-label">Tipe Resep</label>
                <select class="apt-select">
                    <option>Resep Dokter</option>
                    <option>Resep Bebas</option>
                </select>
            </div>
            <div style="flex:0 0 90px;">
                <label class="apt-label">Umur</label>
                <input type="number" value="28" class="apt-input">
            </div>
            <div style="flex:0 0 120px;">
                <label class="apt-label">Berat Badan</label>
                <div style="display:flex; align-items:center; gap:4px;">
                    <input type="number" value="58" class="apt-input">
                    <span style="font-size:13px; color:#6B513E; white-space:nowrap;">Kg</span>
                </div>
            </div>
            <div style="flex:2; min-width:160px;">
                <label class="apt-label">Alamat</label>
                <input type="text" value="Jl. Mawar No. 12, Malang" class="apt-input">
            </div>
        </div>

        <hr class="divider">

        {{-- Daftar Obat --}}
        <div id="obat-list" style="display:flex; flex-direction:column; gap:10px;">

            <div class="obat-row">
                <div style="flex:2; min-width:140px;">
                    <label class="apt-label">Nama Obat</label>
                    <div class="apt-search-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" value="Amoxicillin 500mg">
                    </div>
                </div>
                <div style="flex:0 0 72px;">
                    <label class="apt-label">Jumlah</label>
                    <input type="number" value="10" class="apt-input">
                </div>
                <div style="flex:0 0 110px;">
                    <label class="apt-label">Signature</label>
                    <input type="text" value="3 x 1" class="apt-input">
                </div>
                <div style="flex:0 0 90px;">
                    <label class="apt-label">Detur</label>
                    <input type="text" value="-" class="apt-input">
                </div>
                <div style="flex:0 0 110px; display:flex; align-items:center; gap:6px; padding-bottom:8px;">
                    <input type="checkbox" class="apt-checkbox">
                    <label style="font-size:13px; color:#6B513E;">Obat Iter</label>
                </div>
                <div style="flex:0 0 60px;">
                    <label class="apt-label">Iter</label>
                    <input type="number" value="0" class="apt-input">
                </div>
                <button class="obat-remove" onclick="removeObatRow(this)" style="margin-bottom:2px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="obat-row">
                <div style="flex:2; min-width:140px;">
                    <label class="apt-label">Nama Obat</label>
                    <div class="apt-search-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" value="Paracetamol 500mg">
                    </div>
                </div>
                <div style="flex:0 0 72px;">
                    <label class="apt-label">Jumlah</label>
                    <input type="number" value="6" class="apt-input">
                </div>
                <div style="flex:0 0 110px;">
                    <label class="apt-label">Signature</label>
                    <input type="text" value="2 x 1" class="apt-input">
                </div>
                <div style="flex:0 0 90px;">
                    <label class="apt-label">Detur</label>
                    <input type="text" value="-" class="apt-input">
                </div>
                <div style="flex:0 0 110px; display:flex; align-items:center; gap:6px; padding-bottom:8px;">
                    <input type="checkbox" class="apt-checkbox" checked>
                    <label style="font-size:13px; color:#6B513E;">Obat Iter</label>
                </div>
                <div style="flex:0 0 60px;">
                    <label class="apt-label">Iter</label>
                    <input type="number" value="1" class="apt-input">
                </div>
                <button class="obat-remove" onclick="removeObatRow(this)" style="margin-bottom:2px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

        </div>

        <button class="apt-btn-add" onclick="addObatRow()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Obat
        </button>

        <hr class="divider">

        <div style="display:flex; justify-content:flex-end;">
            <button class="apt-btn-print">PRINT</button>
        </div>

    </div>
</div>

<script>
function addObatRow() {
    const template = document.querySelector('.obat-row');
    const row = template.cloneNode(true);
    row.querySelectorAll('input[type=text], input[type=number]').forEach(i => i.value = i.type === 'number' ? '0' : '');
    row.querySelectorAll('input[type=checkbox]').forEach(c => c.checked = false);
    row.querySelectorAll('label.apt-label').forEach(l => {});
    document.getElementById('obat-list').appendChild(row);
}
function removeObatRow(btn) {
    const rows = document.querySelectorAll('.obat-row');
    if (rows.length > 1) btn.closest('.obat-row').remove();
}
</script>
