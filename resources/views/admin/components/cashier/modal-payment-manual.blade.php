{{-- =============================================
     MODAL: PEMBAYARAN MANUAL
     ============================================= --}}
<link rel="stylesheet" href="{{ asset('css/admin/pages/cashier-mobile.css') }}">

<div id="modalPembayaranManual" class="modal-overlay">
    <div class="modal-container" style="background:#fff; border-radius:12px; width:100%; max-width:880px; max-height:94vh; overflow-y:auto; box-shadow:0 24px 72px rgba(88,44,12,0.22); display:flex; flex-direction:column;">

        {{-- ===== HEADER ===== --}}
        <div style="display:flex; justify-content:center; align-items:center; padding:22px 28px 16px; position:relative; border-bottom:1px solid #f0e6dd;">
            <h2 style="margin:0; font-size:22px; font-weight:800; color:#A67C52; letter-spacing:0.3px;">Pembayaran Manual</h2>
            <button onclick="closeModalManual()" style="position:absolute; right:20px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; font-size:20px; line-height:1; padding:4px 8px; border-radius:4px; transition:color 0.2s;"
                onmouseover="this.style.color='#582C0C'" onmouseout="this.style.color='#9ca3af'">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div style="padding:20px 28px; display:flex; flex-direction:column; gap:20px;">

            {{-- ===== DETAIL PASIEN ===== --}}
            <div class="pm-section">
                <div class="pm-section-header"><i class="fa fa-user" style="margin-right:8px;"></i>Detail Pasien</div>
                <div class="pm-section-body">
                    <div style="position:relative;">
                        <i class="fa fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#C58F59; font-size:14px;"></i>
                        <input type="text" id="pm-search-pasien" placeholder="Cari Nama Lengkap Pasien / No. Rekam Medis..." autocomplete="off" oninput="searchPasienManual(this.value)"
                            style="width:100%; padding:11px 14px 11px 38px; border:1.5px solid #E5D6C5; border-radius:8px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff; outline:none; box-sizing:border-box; transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#A67C52'" onblur="this.style.borderColor='#E5D6C5'">
                        <div id="pm-pasien-dropdown" style="display:none; position:absolute; top:calc(100% + 4px); left:0; right:0; background:#fff; border:1.5px solid #E5D6C5; border-radius:8px; box-shadow:0 8px 24px rgba(88,44,12,0.12); z-index:100; max-height:200px; overflow-y:auto;"></div>
                    </div>
                    <div id="pm-pasien-info" style="display:none; margin-top:14px;">
                        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; background:#fdfaf8; border:1px solid #f0e6dd; border-radius:8px; padding:14px 16px;">
                            <div><div class="pm-info-label">No. Rekam Medis</div><div id="pm-info-rm" class="pm-info-value">-</div></div>
                            <div><div class="pm-info-label">Nama Lengkap</div><div id="pm-info-nama" class="pm-info-value">-</div></div>
                            <div><div class="pm-info-label">Tanggal Lahir</div><div id="pm-info-dob" class="pm-info-value">-</div></div>
                            <div><div class="pm-info-label">No. Telepon</div><div id="pm-info-telp" class="pm-info-value">-</div></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== REVIEW INVOICE ===== --}}
            <div class="pm-section">
                <div class="pm-section-header"><i class="fa fa-file-invoice" style="margin-right:8px;"></i>Review Invoice</div>
                <div class="pm-section-body">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:16px;">
                        <div>
                            <div style="font-size:18px; font-weight:800; color:#582C0C; letter-spacing:0.5px;">INVOICE SUMMARY</div>
                            <div style="font-size:12px; color:#9ca3af; margin-top:4px;"><span style="font-weight:600; color:#C58F59;">(Nomor invoice otomatis)</span></div>
                        </div>
                        <div style="display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
                            <div>
                                <label style="font-size:10px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Pilih Depot</label>
                                <select id="pm-depot" style="padding:8px 32px 8px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23A67C52'/%3E%3C/svg%3E\") no-repeat right 10px center; cursor:pointer; outline:none; appearance:none; min-width:130px;">
                                    <option value="apotek">Apotek</option>
                                    <option value="klinik">Klinik Gigi</option>
                                    <option value="lab">Laboratorium</option>
                                </select>
                            </div>
                            <div style="position:relative;">
                                <input type="text" id="pm-search-item" placeholder="Cari tindakan/obat/bahan..." oninput="searchItemManual(this.value)" autocomplete="off"
                                    style="padding:8px 36px 8px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; width:220px; outline:none; transition:border-color 0.2s;"
                                    onfocus="this.style.borderColor='#A67C52'" onblur="this.style.borderColor='#E5D6C5'">
                                <i class="fa fa-search" style="position:absolute; right:11px; top:50%; transform:translateY(-50%); color:#C58F59; font-size:13px; pointer-events:none;"></i>
                                <div id="pm-item-dropdown" style="display:none; position:absolute; top:calc(100% + 4px); left:0; background:#fff; border:1.5px solid #E5D6C5; border-radius:8px; box-shadow:0 8px 24px rgba(88,44,12,0.12); z-index:100; max-height:220px; overflow-y:auto; min-width:280px;"></div>
                            </div>
                        </div>
                    </div>
                    <div style="height:1px; background:linear-gradient(to right,#E5D6C5,transparent); margin-bottom:14px;"></div>
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; font-size:12px;">
                            <thead>
                                <tr style="border-bottom:2px solid #E5D6C5;">
                                    <th style="padding:9px 10px; text-align:left; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Tindakan / Obat</th>
                                    <th style="padding:9px 10px; text-align:center; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Depot</th>
                                    <th style="padding:9px 10px; text-align:center; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Jumlah</th>
                                    <th style="padding:9px 10px; text-align:right; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Harga</th>
                                    <th style="padding:9px 10px; text-align:right; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Diskon</th>
                                    <th style="padding:9px 10px; text-align:right; font-size:11px; font-weight:700; color:#A67C52; white-space:nowrap;">Total Harga</th>
                                    <th style="padding:9px 10px; text-align:center; font-size:11px; font-weight:700; color:#A67C52;"></th>
                                </tr>
                            </thead>
                            <tbody id="pm-items-tbody">
                                <tr id="pm-empty-row">
                                    <td colspan="7" style="text-align:center; padding:28px 20px; color:#C58F59; font-size:13px; font-style:italic;">
                                        <i class="fa fa-plus-circle" style="margin-right:6px; opacity:0.5;"></i>Cari dan tambahkan tindakan / obat / bahan di atas
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="display:flex; justify-content:flex-end; align-items:center; gap:20px; margin-top:14px; padding-top:12px; border-top:1px solid #f0ebe4;">
                        <div style="font-size:13px; color:#6B513E;">Total : <span id="pm-grand-total" style="font-size:20px; font-weight:800; color:#582C0C; margin-left:6px;">Rp0</span></div>
                        
                    </div>
                </div>
            </div>

            {{-- ===== METODE PEMBAYARAN ===== --}}
            <div class="pm-section">
                <div class="pm-section-header"><i class="fa fa-credit-card" style="margin-right:8px;"></i>Metode Pembayaran</div>
                <div class="pm-section-body">

                    {{-- Checkbox Multi Payment --}}
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#6B513E; cursor:pointer; margin-bottom:18px; width:fit-content; user-select:none;">
                        <input type="checkbox" id="pm-cb-multi" value="1" onchange="pmToggleMultiPayment()" style="width:15px; height:15px; accent-color:#A67C52; cursor:pointer;">
                        <span style="font-weight:600;">Gunakan Multi Payment <em style="font-size:11px; font-weight:400; color:#A67C52;">(Split Bill)</em></span>
                    </label>

                    {{-- Pembayaran Pertama --}}
                    <div style="margin-bottom:6px; font-size:11px; font-weight:700; color:#A67C52; text-transform:uppercase; letter-spacing:0.6px;">Pembayaran Pertama</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px 20px; padding:16px; background:#fdfaf8; border:1px solid #f0e6dd; border-radius:8px; margin-bottom:16px;">

                        {{-- Kolom 1: Tipe + Metode + Akun --}}
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label class="pm-field-label">Tipe Pembayaran</label>
                                <select id="pm-metode" style="width:100%; padding:9px 32px 9px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23A67C52'/%3E%3C/svg%3E\") no-repeat right 10px center; cursor:pointer; outline:none; appearance:none;">
                                    <option value="Langsung">Langsung (Full Payment)</option>
                                    <option value="Cicilan">Cicilan</option>
                                </select>
                            </div>
                            <div>
                                <label class="pm-field-label">Metode Bayar <span style="color:#ef4444;">*</span></label>
                                <select id="pm-jenis-bayar" style="width:100%; padding:9px 32px 9px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23A67C52'/%3E%3C/svg%3E\") no-repeat right 10px center; cursor:pointer; outline:none; appearance:none;">
                                    @foreach(\App\Models\MasterPaymentMethod::where('is_active', true)->get() as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="pm-field-label">Akun Kas</label>
                                <select id="pm-akun" style="width:100%; padding:9px 32px 9px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23A67C52'/%3E%3C/svg%3E\") no-repeat right 10px center; cursor:pointer; outline:none; appearance:none;">
                                    <option value="Kas Utama Klinik">Kas Utama Klinik</option>
                                    <option value="Kas Kecil">Kas Kecil</option>
                                    <option value="Rekening BCA">Rekening BCA</option>
                                    <option value="Rekening Mandiri">Rekening Mandiri</option>
                                </select>
                            </div>
                        </div>

                        {{-- Kolom 2: Nominal + Kembalian + Hutang --}}
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label class="pm-field-label">Diterima (Bayar 1) <span style="color:#ef4444;">*</span></label>
                                <div style="display:flex; align-items:center; border:1.5px solid #E5D6C5; border-radius:7px; overflow:hidden; background:#fff;">
                                    <span style="padding:9px 10px; background:#fdf8f3; border-right:1px solid #E5D6C5; font-size:13px; font-weight:600; color:#6B513E; white-space:nowrap;">Rp</span>
                                    <input type="text" id="pm-input-bayar" placeholder="0" oninput="pmHitungKembalian()"
                                        style="flex:1; padding:9px 10px; border:none; outline:none; font-size:14px; font-weight:700; color:#374151; font-family:'Instrument Sans',sans-serif; background:transparent;">
                                </div>
                            </div>
                            <div>
                                <label class="pm-field-label">Kembalian</label>
                                <div style="padding:9px 12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:7px; font-size:14px; font-weight:700; color:#15803d;">
                                    <span id="pm-kembalian">Rp0</span>
                                </div>
                            </div>
                            <div>
                                <label class="pm-field-label">Hutang / Kurang</label>
                                <div style="padding:9px 12px; background:#fef2f2; border:1px solid #fecaca; border-radius:7px; font-size:14px; font-weight:700; color:#dc2626;">
                                    <span id="pm-hutang">Rp0</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom 3: Dibayar Oleh --}}
                        <div>
                            <label class="pm-field-label">Dibayar Oleh <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="pm-pembayar" placeholder="Nama pembayar..."
                                style="width:100%; padding:9px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; color:#374151; font-family:'Instrument Sans',sans-serif; outline:none; box-sizing:border-box; transition:border-color .2s;"
                                onfocus="this.style.borderColor='#A67C52'" onblur="this.style.borderColor='#E5D6C5'">
                        </div>
                    </div>

                    {{-- Pembayaran Kedua (hidden by default) --}}
                    <div id="pm-multi-section" style="display:none; border-top:2px dashed #E5D6C5; padding-top:16px;">
                        <div style="margin-bottom:10px; font-size:11px; font-weight:700; color:#A67C52; text-transform:uppercase; letter-spacing:0.6px; display:flex; align-items:center; gap:8px;">
                            <span style="background:#A67C52; color:#fff; padding:2px 8px; border-radius:4px; font-size:10px;">2</span>
                            Pembayaran Kedua
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px 20px; padding:16px; background:#fdf8f3; border:1px solid #f0e6dd; border-radius:8px;">

                            {{-- Metode ke-2 & Akun ke-2 --}}
                            <div style="display:flex; flex-direction:column; gap:12px;">
                                <div>
                                    <label class="pm-field-label">Metode Bayar Ke-2 <span style="color:#ef4444;">*</span></label>
                                    <select id="pm-jenis-bayar-2" style="width:100%; padding:9px 32px 9px 12px; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-family:'Instrument Sans',sans-serif; color:#582C0C; background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23A67C52'/%3E%3C/svg%3E\") no-repeat right 10px center; cursor:pointer; outline:none; appearance:none;">
                                        <option value="">-- Pilih Metode Ke-2 --</option>
                                        @foreach(\App\Models\MasterPaymentMethod::where('is_active', true)->get() as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            {{-- Nominal ke-2 --}}
                            <div>
                                <label class="pm-field-label">Diterima (Bayar 2) <span style="color:#ef4444;">*</span></label>
                                <div style="display:flex; align-items:center; border:1.5px solid #E5D6C5; border-radius:7px; overflow:hidden; background:#fff;">
                                    <span style="padding:9px 10px; background:#fdf8f3; border-right:1px solid #E5D6C5; font-size:13px; font-weight:600; color:#6B513E; white-space:nowrap;">Rp</span>
                                    <input type="text" id="pm-input-bayar-2" placeholder="0" oninput="pmHitungKembalian()"
                                        style="flex:1; padding:9px 10px; border:none; outline:none; font-size:14px; font-weight:700; color:#374151; font-family:'Instrument Sans',sans-serif; background:transparent;">
                                </div>
                                <p style="font-size:11px; color:#9ca3af; margin:6px 0 0; line-height:1.4;">Nominal bayar kedua akan dijumlahkan otomatis dengan bayar pertama.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- ===== FOOTER ===== --}}
        <div style="display:flex; justify-content:flex-end; gap:10px; padding:16px 28px; border-top:1px solid #f0e6dd; background:#fafaf9; border-radius:0 0 12px 12px; position:sticky; bottom:0;">
            <button onclick="closeModalManual()" style="padding:10px 28px; background:#fff; color:#6B513E; border:1.5px solid #E5D6C5; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Instrument Sans',sans-serif; transition:all 0.2s;"
                onmouseover="this.style.borderColor='#A67C52'" onmouseout="this.style.borderColor='#E5D6C5'">Batal</button>
            <button id="pm-btn-bayar" onclick="pmProsesBayar()" style="padding:10px 32px; background:#A67C52; color:#fff; border:none; border-radius:7px; font-size:13px; font-weight:700; cursor:pointer; font-family:'Instrument Sans',sans-serif; display:flex; align-items:center; gap:8px; transition:background 0.2s;"
                onmouseover="this.style.background='#8d6945'" onmouseout="this.style.background='#A67C52'">
                <i class="fa fa-check-circle"></i> Bayar
            </button>
        </div>
    </div>
</div>

{{-- ===== STYLES ===== --}}
<style>
.pm-section { border-radius:8px;  border:1px solid #E5D6C5; }
.pm-section-header { background:#A67C52; color:#fff; padding:9px 16px; font-size:12px; font-weight:700; letter-spacing:0.6px; text-transform:uppercase; }
.pm-section-body { padding:16px; background:#fff; }
.pm-info-label { font-size:10px; font-weight:700; color:#A67C52; text-transform:uppercase; margin-bottom:4px; letter-spacing:0.4px; }
.pm-info-value { font-size:13px; color:#374151; font-weight:600; }
.pm-field-label { font-size:11px; font-weight:700; color:#A67C52; text-transform:uppercase; display:block; margin-bottom:6px; letter-spacing:0.4px; }
#pm-pasien-dropdown::-webkit-scrollbar, #pm-item-dropdown::-webkit-scrollbar { width:5px; }
#pm-pasien-dropdown::-webkit-scrollbar-track, #pm-item-dropdown::-webkit-scrollbar-track { background:#f9f6f3; }
#pm-pasien-dropdown::-webkit-scrollbar-thumb, #pm-item-dropdown::-webkit-scrollbar-thumb { background:#E5D6C5; border-radius:3px; }
#pm-multi-section { transition: opacity .25s; }
</style>

{{-- ===== SCRIPT ===== --}}
<script>
let pmSelectedPatient = null;
let pmItems           = [];
let pmGrandTotal      = 0;

// ── Open / Close ───────────────────────────────────────────────
function openModalManual() { pmResetModal(); document.getElementById('modalPembayaranManual').classList.add('open'); }
function closeModalManual() { document.getElementById('modalPembayaranManual').classList.remove('open'); }

function pmResetModal() {
    pmSelectedPatient = null; pmItems = []; pmGrandTotal = 0;
    ['pm-search-pasien','pm-input-bayar','pm-input-bayar-2','pm-pembayar'].forEach(id => { const el=document.getElementById(id); if(el){el.value=''; delete el.dataset.touched;} });
    document.getElementById('pm-pasien-info').style.display = 'none';
    document.getElementById('pm-pasien-dropdown').style.display = 'none';
    document.getElementById('pm-item-dropdown').style.display = 'none';
    document.getElementById('pm-kembalian').innerText = 'Rp0';
    document.getElementById('pm-hutang').innerText    = 'Rp0';
    document.getElementById('pm-grand-total').innerText = 'Rp0';
    const cb = document.getElementById('pm-cb-multi'); if(cb) cb.checked = false;
    document.getElementById('pm-multi-section').style.display = 'none';
    const s2 = document.getElementById('pm-jenis-bayar-2'); if(s2) s2.value = '';
    pmRenderItems();
}

// ── Toggle Multi Payment ───────────────────────────────────────
function pmToggleMultiPayment() {
    const cb = document.getElementById('pm-cb-multi');
    const section = document.getElementById('pm-multi-section');
    const input2  = document.getElementById('pm-input-bayar-2');
    if (cb.checked) {
        section.style.opacity = '0';
        section.style.display = 'block';
        requestAnimationFrame(() => { section.style.opacity = '1'; });
    } else {
        section.style.display = 'none';
        if (input2) input2.value = '';
        pmHitungKembalian();
    }
}

// ── Search Pasien ──────────────────────────────────────────────
let pmSearchDebounce = null;
function searchPasienManual(query) {
    clearTimeout(pmSearchDebounce);
    const dd = document.getElementById('pm-pasien-dropdown');
    if (!query || query.length < 2) { dd.style.display='none'; return; }
    pmSearchDebounce = setTimeout(async () => {
        try {
            const resp = await fetch(`/admin/cashier/search-patient?q=${encodeURIComponent(query)}`,{headers:{'Accept':'application/json'}});
            const data = await resp.json();
            dd.innerHTML = data && data.length > 0
                ? data.map(p=>`<div onclick='pmSelectPatient(${JSON.stringify(p)})' style="padding:10px 14px;cursor:pointer;border-bottom:1px solid #f5f0eb;transition:background .15s;font-size:13px;" onmouseover="this.style.background='#fdf8f5'" onmouseout="this.style.background='#fff'"><div style="font-weight:600;color:#582C0C;">${p.full_name}</div><div style="font-size:11px;color:#A67C52;margin-top:2px;">${p.medical_record_no??'-'} &bull; ${p.phone_number??'-'}</div></div>`).join('')
                : `<div style="padding:12px 14px;color:#9ca3af;font-size:13px;text-align:center;">Pasien tidak ditemukan</div>`;
            dd.style.display = 'block';
        } catch(e) { console.error(e); }
    }, 350);
}
function pmSelectPatient(p) {
    pmSelectedPatient = p;
    document.getElementById('pm-search-pasien').value = p.full_name;
    document.getElementById('pm-pasien-dropdown').style.display = 'none';
    document.getElementById('pm-info-rm').innerText   = p.medical_record_no ?? '-';
    document.getElementById('pm-info-nama').innerText = p.full_name ?? '-';
    document.getElementById('pm-info-dob').innerText  = p.date_of_birth ?? '-';
    document.getElementById('pm-info-telp').innerText = p.phone_number ?? '-';
    document.getElementById('pm-pasien-info').style.display = 'block';
    document.getElementById('pm-pembayar').value = p.full_name + ' (Pribadi)';
}

// ── Search Item ────────────────────────────────────────────────
let pmItemDebounce = null;
function searchItemManual(query) {
    clearTimeout(pmItemDebounce);
    const dd = document.getElementById('pm-item-dropdown');
    if (!query || query.length < 2) { dd.style.display='none'; return; }
    const depot = document.getElementById('pm-depot').value;
    pmItemDebounce = setTimeout(async () => {
        try {
            const resp = await fetch(`/admin/cashier/search-item?q=${encodeURIComponent(query)}&depot=${encodeURIComponent(depot)}`,{headers:{'Accept':'application/json'}});
            const data = await resp.json();
            dd.innerHTML = data && data.length > 0
                ? data.map(item=>`<div onclick='pmAddItem(${JSON.stringify(item)})' style="padding:10px 14px;cursor:pointer;border-bottom:1px solid #f5f0eb;transition:background .15s;" onmouseover="this.style.background='#fdf8f5'" onmouseout="this.style.background='#fff'"><div style="font-weight:600;font-size:13px;color:#582C0C;">${item.name} <span style="font-size:10px;background:#f0e6dd;color:#A67C52;padding:1px 6px;border-radius:3px;margin-left:4px;">${item.type??''}</span></div><div style="font-size:11px;color:#A67C52;margin-top:2px;">Rp${Number(item.price).toLocaleString('id-ID')}</div></div>`).join('')
                : `<div style="padding:12px 14px;color:#9ca3af;font-size:13px;text-align:center;">Item tidak ditemukan</div>`;
            dd.style.display = 'block';
        } catch(e) { console.error(e); }
    }, 350);
}
function pmAddItem(item) {
    const depotEl = document.getElementById('pm-depot');
    pmItems.push({name:item.name, type:item.type??'', depot:depotEl.options[depotEl.selectedIndex].text, qty:1, price:parseFloat(item.price)||0, discount:0, subtotal:parseFloat(item.price)||0});
    document.getElementById('pm-search-item').value = '';
    document.getElementById('pm-item-dropdown').style.display = 'none';
    pmRecalc();
}

// ── Render Items ───────────────────────────────────────────────
function pmRenderItems() {
    const tbody = document.getElementById('pm-items-tbody');
    if (pmItems.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:28px 20px;color:#C58F59;font-size:13px;font-style:italic;"><i class="fa fa-plus-circle" style="margin-right:6px;opacity:.5;"></i>Cari dan tambahkan tindakan / obat di atas</td></tr>`;
        return;
    }
    tbody.innerHTML = pmItems.map((item,i) => `
        <tr style="border-bottom:1px solid #f0ebe4;">
            <td style="padding:9px 10px;font-size:12px;color:#374151;font-weight:600;">${item.name}${item.type?`<span style="font-size:10px;background:#f0e6dd;color:#A67C52;padding:1px 6px;border-radius:3px;margin-left:4px;">${item.type}</span>`:''}</td>
            <td style="padding:9px 10px;text-align:center;font-size:12px;color:#6B513E;">${item.depot}</td>
            <td style="padding:9px 10px;text-align:center;">
                <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                    <button onclick="pmChangeQty(${i},-1)" style="width:20px;height:20px;border-radius:4px;border:1px solid #E5D6C5;background:#fff;cursor:pointer;color:#A67C52;display:flex;align-items:center;justify-content:center;">−</button>
                    <span style="min-width:24px;text-align:center;font-size:12px;font-weight:700;">${item.qty}</span>
                    <button onclick="pmChangeQty(${i},1)" style="width:20px;height:20px;border-radius:4px;border:1px solid #E5D6C5;background:#fff;cursor:pointer;color:#A67C52;display:flex;align-items:center;justify-content:center;">+</button>
                </div>
            </td>
            <td style="padding:9px 10px;text-align:right;font-size:12px;color:#6b7280;">Rp${Number(item.price).toLocaleString('id-ID')}</td>
            <td style="padding:9px 10px;text-align:right;"><input type="number" value="${item.discount}" min="0" onchange="pmChangeDiskon(${i},this.value)" style="width:70px;padding:3px 6px;border:1px solid #e5e7eb;border-radius:4px;font-size:12px;text-align:right;outline:none;color:#9ca3af;"></td>
            <td style="padding:9px 10px;text-align:right;font-size:12px;color:#582C0C;font-weight:700;">Rp${Number(item.subtotal).toLocaleString('id-ID')}</td>
            <td style="padding:9px 10px;text-align:center;"><button onclick="pmRemoveItem(${i})" style="background:none;border:none;cursor:pointer;color:#fca5a5;font-size:13px;transition:color .2s;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#fca5a5'"><i class="fa fa-trash"></i></button></td>
        </tr>`).join('');
}
function pmChangeQty(i,d){pmItems[i].qty=Math.max(1,(pmItems[i].qty||1)+d);pmItems[i].subtotal=pmItems[i].price*pmItems[i].qty-pmItems[i].discount;pmRecalc();}
function pmChangeDiskon(i,v){pmItems[i].discount=parseFloat(v)||0;pmItems[i].subtotal=Math.max(0,pmItems[i].price*pmItems[i].qty-pmItems[i].discount);pmRecalc();}
function pmRemoveItem(i){pmItems.splice(i,1);pmRecalc();}

function pmRecalc() {
    pmGrandTotal = pmItems.reduce((s,item)=>s+item.subtotal,0);
    document.getElementById('pm-grand-total').innerText = 'Rp'+Number(pmGrandTotal).toLocaleString('id-ID');
    const inp = document.getElementById('pm-input-bayar');
    if (!inp.dataset.touched) inp.value = pmGrandTotal > 0 ? pmGrandTotal : '';
    pmRenderItems();
    pmHitungKembalian();
}

// ── Hitung Kembalian & Hutang ──────────────────────────────────
function pmHitungKembalian() {
    const bayar1 = parseFloat((document.getElementById('pm-input-bayar').value||'0').replace(/[^0-9]/g,''))||0;
    const isMulti = document.getElementById('pm-cb-multi')?.checked||false;
    const bayar2  = isMulti ? (parseFloat((document.getElementById('pm-input-bayar-2').value||'0').replace(/[^0-9]/g,''))||0) : 0;
    const total   = bayar1 + bayar2;
    const kembalian = total - pmGrandTotal;
    const hutang    = pmGrandTotal - total;
    document.getElementById('pm-kembalian').innerText = kembalian>0 ? 'Rp'+Number(kembalian).toLocaleString('id-ID') : 'Rp0';
    document.getElementById('pm-hutang').innerText    = hutang>0    ? 'Rp'+Number(hutang).toLocaleString('id-ID')    : 'Rp0';
}

// Tandai input bayar sudah diubah manual
document.addEventListener('DOMContentLoaded',()=>{
    const inp=document.getElementById('pm-input-bayar');
    if(inp) inp.addEventListener('input',()=>{inp.dataset.touched='1';});
});

// Close dropdown on outside click
document.addEventListener('click',function(e){
    const ps=document.getElementById('pm-search-pasien'), pd=document.getElementById('pm-pasien-dropdown');
    if(ps&&pd&&!ps.contains(e.target)&&!pd.contains(e.target)) pd.style.display='none';
    const is=document.getElementById('pm-search-item'), id=document.getElementById('pm-item-dropdown');
    if(is&&id&&!is.contains(e.target)&&!id.contains(e.target)) id.style.display='none';
});

function pmPrintPreview() {
    if(pmItems.length===0){alert('Tambahkan minimal satu item terlebih dahulu.');return;}
    alert('Fitur print preview untuk pembayaran manual akan segera tersedia.');
}

// ── Proses Bayar ───────────────────────────────────────────────
async function pmProsesBayar() {
    if (!pmSelectedPatient) { alert('Silakan pilih pasien terlebih dahulu.'); document.getElementById('pm-search-pasien').focus(); return; }
    if (pmItems.length===0) { alert('Tambahkan minimal satu item tindakan/obat terlebih dahulu.'); return; }

    const bayar1 = parseFloat((document.getElementById('pm-input-bayar').value||'0').replace(/[^0-9]/g,''))||0;
    if (bayar1<=0) { alert('Silakan masukkan nominal pembayaran.'); document.getElementById('pm-input-bayar').focus(); return; }

    const isMulti = document.getElementById('pm-cb-multi')?.checked||false;
    let bayar2=0, secondPaymentMethodName=null;
    if (isMulti) {
        bayar2 = parseFloat((document.getElementById('pm-input-bayar-2').value||'0').replace(/[^0-9]/g,''))||0;
        if (bayar2<=0) { alert('Silakan masukkan nominal pembayaran kedua.'); document.getElementById('pm-input-bayar-2').focus(); return; }
        const sel2 = document.getElementById('pm-jenis-bayar-2');
        // Ambil nama metode bayar ke-2
        secondPaymentMethodName = sel2?.options[sel2.selectedIndex]?.text||null;
        if (!secondPaymentMethodName) { alert('Silakan pilih metode pembayaran kedua.'); sel2.focus(); return; }
    }

    const totalBayar   = bayar1 + bayar2;
    const changeAmount = Math.max(0, totalBayar - pmGrandTotal);
    const debtAmount   = Math.max(0, pmGrandTotal - totalBayar);
    const status       = debtAmount > 0 ? 'partial' : 'paid';

    const sel1 = document.getElementById('pm-jenis-bayar');
    const paymentMethodName = sel1?.options[sel1.selectedIndex]?.text || sel1?.value || '';
    const payload = {
        patient_id:            pmSelectedPatient.id,
        items:                 pmItems,
        total:                 pmGrandTotal,
        amount_paid:           totalBayar,
        change_amount:         changeAmount,
        debt_amount:           debtAmount,
        status,
        payment_method:        paymentMethodName,
        payment_type:          document.getElementById('pm-metode').value,
        cash_account:          document.getElementById('pm-akun').value,
        paid_by:               document.getElementById('pm-pembayar').value,
        is_multi_payment:      isMulti ? 1 : 0,
        second_payment_method_id: secondPaymentMethodName,
        second_payment_amount: bayar2 > 0 ? bayar2 : null,
    };

    const btn=document.getElementById('pm-btn-bayar'), orig=btn.innerHTML;
    btn.innerHTML='<i class="fa fa-spinner fa-spin"></i> Memproses...'; btn.disabled=true;

    try {
        const resp = await fetch('/admin/cashier/store-manual-payment',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||'','Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify(payload)});
        const result = await resp.json();
        if (result.success) {
            closeModalManual();
            alert('✓ Pembayaran Manual Berhasil!\nNo. Invoice: '+result.invoice_number);
            window.location.reload();
        } else {
            alert('Gagal: '+result.message);
            btn.innerHTML=orig; btn.disabled=false;
        }
    } catch(err) {
        console.error(err);
        alert('Terjadi kesalahan koneksi.');
        btn.innerHTML=orig; btn.disabled=false;
    }
}
</script>