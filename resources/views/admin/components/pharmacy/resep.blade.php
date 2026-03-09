<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px 16px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0; }
    .apt-label { font-size: 13px; color: #6B513E; display: block; margin-bottom: 4px; }
    .apt-input { border: 1px solid #E5D6C5; border-radius: 5px; padding: 8px 10px; font-size: 13px; color: #582C0C; background: #fff; outline: none; width: 100%; font-family: inherit; }
    .apt-input:focus { border-color: #C58F59; }
    .apt-input-line { border: none; border-bottom: 1px solid #E5D6C5; padding: 4px 0; font-size: 13px; color: #582C0C; outline: none; background: transparent; font-family: inherit; }
    .apt-input-line:focus { border-color: #C58F59; }
    .apt-select { border: 1px solid #E5D6C5; border-radius: 5px; padding: 8px 28px 8px 10px; font-size: 13px; color: #582C0C; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23C58F59' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 8px center; outline: none; appearance: none; width: 100%; font-family: inherit; }
    .apt-select:focus { border-color: #C58F59; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; width: 100%; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; flex: 1; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-checkbox { width: 15px; height: 15px; accent-color: #C58F59; cursor: pointer; }
    .apt-btn-print { background: #EF4444; color: #fff; border: none; padding: 9px 28px; border-radius: 5px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; }
    .apt-btn-print:hover { background: #dc2626; }
    .apt-btn-add { background: none; border: none; color: #C58F59; font-size: 13px; font-weight: 600; cursor: pointer; padding: 0; display: inline-flex; align-items: center; gap: 5px; font-family: inherit; }
    .apt-btn-add:hover { color: #b07d4a; }
    .obat-remove { background: #EF4444; border: none; color: #fff; width: 26px; height: 26px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .obat-remove:hover { background: #dc2626; }
    .obat-row { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
    .divider { border: none; border-top: 1px solid #E5D6C5; margin: 4px 0; }
</style>

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
