<div id="modalPayment" class="modal-overlay">
    <div class="modal-container" style="background:#fff; border-radius:10px; width:100%; max-width:980px; max-height:92vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.25);">

        {{-- ===== HEADER ===== --}}
        <div style="display:flex; justify-content:space-between; align-items:center; padding:18px 24px; border-bottom:1px solid #e5d6c5; position:sticky; top:0; background:#fff; z-index:50; border-radius:10px 10px 0 0; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
            <h2 style="margin:0; font-size:16px; font-weight:800; color:#582C0C; letter-spacing:0.5px;">REVIEW &amp; PROSES PEMBAYARAN</h2>
            <button onclick="closePayment()" style="background:none; border:none; cursor:pointer; color:#8B5E3C; font-size:18px; line-height:1; padding:4px;">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div style="padding:20px 24px; display:flex; flex-direction:column; gap:18px;">

            {{-- ===== DETAIL PASIEN ===== --}}
            <div>
                <div style="background:#8B5E3C; color:#fff; padding:7px 14px; border-radius:5px 5px 0 0; font-size:11px; font-weight:700; letter-spacing:0.8px;">DETAIL PASIEN</div>
                <div style="border:1px solid #e5d6c5; border-top:none; border-radius:0 0 5px 5px; padding:14px 16px;">
                    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px;">
                        <div>
                            <div style="font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; margin-bottom:4px;">ID</div>
                            <div id="m-pasien-id" style="font-size:13px; color:#582C0C; font-weight:600;">-</div>
                        </div>
                        <div>
                            <div style="font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; margin-bottom:4px;">Nama Lengkap</div>
                            <div id="m-pasien-nama" style="font-size:13px; color:#582C0C; font-weight:600;">-</div>
                        </div>
                        <div>
                            <div style="font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; margin-bottom:4px;">Usia</div>
                            <div id="m-pasien-usia" style="font-size:13px; color:#582C0C; font-weight:600;">-</div>
                        </div>
                        <div>
                            <div style="font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; margin-bottom:4px;">Nomor HP / WA</div>
                            <div id="m-pasien-hp" style="font-size:13px; color:#582C0C; font-weight:600;">-</div>
                        </div>
                        <div>
                            <div style="font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; margin-bottom:4px;">Nama Dokter</div>
                            <div id="m-pasien-dokter" style="font-size:13px; color:#582C0C; font-weight:600;">-</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== REVIEW INVOICE ===== --}}
            <div>
                <div style="background:#8B5E3C; color:#fff; padding:7px 14px; border-radius:5px 5px 0 0; font-size:11px; font-weight:700; letter-spacing:0.8px;">REVIEW INVOICE</div>
                <div style="border:1px solid #e5d6c5; border-top:none; border-radius:0 0 5px 5px; padding:14px 16px;">
                    <div style="margin-bottom:10px;">
                        <div style="font-size:11px; font-weight:700; color:#8B5E3C; text-transform:uppercase; letter-spacing:0.5px;">INVOICE</div>
                        <div id="m-inv-no" style="font-size:14px; font-weight:700; color:#582C0C;">-</div>
                    </div>

                    {{-- Tabel Items --}}
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; font-size:12px;">
                            <thead>
                                <tr style="border-bottom:2px solid #e5d6c5;">
                                    <th style="padding:8px 10px; text-align:left; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Tanggal Tindakan</th>
                                    <th style="padding:8px 10px; text-align:left; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Tindakan</th>
                                    <th style="padding:8px 10px; text-align:center; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Gigi</th>
                                    <th style="padding:8px 10px; text-align:center; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Jumlah</th>
                                    <th style="padding:8px 10px; text-align:right; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Harga</th>
                                    <th style="padding:8px 10px; text-align:right; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Diskon</th>
                                    <th style="padding:8px 10px; text-align:right; font-size:11px; font-weight:700; color:#582C0C; white-space:nowrap;">Total Harga</th>
                                    <th style="padding:8px 10px; text-align:center; font-size:11px; font-weight:700; color:#582C0C;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="m-items">
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:20px; color:#8B5E3C;">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Total & Print --}}
                    <div style="display:flex; justify-content:flex-end; align-items:center; gap:16px; margin-top:12px; padding-top:10px; border-top:1px solid #f0ebe4;">
                        <div style="font-size:13px; font-weight:700; color:#582C0C;">
                            TOTAL: <span id="m-grand-total" style="font-size:20px; font-weight:800; color:#C58F59;">Rp0</span>
                        </div>
                        <button onclick="doPrintPreview()" style="background:#8B5E3C; color:#fff; border:none; padding:8px 16px; border-radius:5px; font-size:12px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:6px;">
                            <i class="fa fa-print"></i> PRINT PREVIEW
                        </button>
                    </div>
                </div>
            </div>

            {{-- ===== CATATAN INVOICE ===== --}}
            <div>
                <div style="background:#8B5E3C; color:#fff; padding:7px 14px; border-radius:5px 5px 0 0; font-size:11px; font-weight:700; letter-spacing:0.8px;">CATATAN INVOICE</div>
                <div style="border:1px solid #e5d6c5; border-top:none; border-radius:0 0 5px 5px; padding:10px 14px;">
                    <textarea id="m-notes" rows="3" placeholder="Tambahkan catatan khusus untuk pembayaran ini (Opsional)..."
                        style="width:100%; border:none; outline:none; resize:vertical; font-size:13px; color:#582C0C; font-family:inherit; background:transparent; box-sizing:border-box;"></textarea>
                </div>
            </div>

            {{-- ===== METODE PEMBAYARAN ===== --}}
            <div>
                <div style="background:#8B5E3C; color:#fff; padding:7px 14px; border-radius:5px 5px 0 0; font-size:11px; font-weight:700; letter-spacing:0.8px;">METODE PEMBAYARAN</div>
                <div style="border:1px solid #e5d6c5; border-top:none; border-radius:0 0 5px 5px; padding:16px;">

                    {{-- Checkbox row --}}
                    <div style="display:flex; gap:20px; margin-bottom:12px; align-items:center;">
                        <label style="display:flex; align-items:center; gap:6px; font-size:12px; color:#6B513E; cursor:pointer;">
                            <input type="checkbox" id="m-cb-detail" checked style="cursor:pointer; accent-color:#8B5E3C;">
                            Tampilkan detail harga per-item pada struk
                        </label>
                        <label style="display:flex; align-items:center; gap:6px; font-size:12px; color:#8B5E3C; cursor:default;" title="Fitur ini belum tersedia">
                            <input type="checkbox" disabled style="cursor:not-allowed;">
                            Multi type payment (Split Bill) — <em>Coming soon</em>
                        </label>
                    </div>

                    {{-- Grid 2 kolom utama --}}
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px 24px;">

                        {{-- Kolom kiri: Tipe, Metode, Akun Kas --}}
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Tipe Pembayaran</label>
                                <select id="m-tipe" style="width:100%; padding:8px 10px; border:1px solid #e5d6c5; border-radius:5px; font-size:13px; color:#582C0C; font-family:inherit; background:#fff; cursor:pointer; outline:none;">
                                    <option value="Langsung">Langsung (Full Payment)</option>
                                    <option value="Cicilan">Cicilan</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Metode</label>
                                <select id="m-metode" style="width:100%; padding:8px 10px; border:1px solid #e5d6c5; border-radius:5px; font-size:13px; color:#582C0C; font-family:inherit; background:#fff; cursor:pointer; outline:none;">
                                    <option>Tunai</option>
                                    <option>Kartu Debit</option>
                                    <option>Kartu Kredit</option>
                                    <option>Transfer Bank</option>
                                    <option>QRIS</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Akun Kas</label>
                                <select id="m-akun-kas" style="width:100%; padding:8px 10px; border:1px solid #e5d6c5; border-radius:5px; font-size:13px; color:#582C0C; font-family:inherit; background:#fff; cursor:pointer; outline:none;">
                                    <option value="Kas Utama Klinik">Kas Utama Klinik</option>
                                    <option value="Kas Kecil">Kas Kecil</option>
                                    <option value="Rekening BCA">Rekening BCA</option>
                                    <option value="Rekening Mandiri">Rekening Mandiri</option>
                                </select>
                            </div>
                        </div>

                        {{-- Kolom kanan: Diterima, Dibayar Oleh, Kembalian, Hutang --}}
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px 16px; align-content:start;">
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Diterima (Bayar) <span style="color:#ef4444;">*</span></label>
                                <div style="display:flex; align-items:center; border:1px solid #e5d6c5; border-radius:5px; overflow:hidden; background:#fff;">
                                    <span style="padding:8px 10px; background:#fdf8f3; border-right:1px solid #e5d6c5; font-size:13px; font-weight:600; color:#6B513E;">Rp</span>
                                    <input type="text" id="m-input-bayar" oninput="hitungKembalian()"
                                        style="flex:1; padding:8px 10px; border:none; outline:none; font-size:14px; font-weight:700; color:#582C0C; font-family:inherit; background:transparent;">
                                </div>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Dibayar Oleh <span style="color:#ef4444;">*</span></label>
                                <input type="text" id="m-input-pembayar"
                                    style="width:100%; padding:8px 10px; border:1px solid #e5d6c5; border-radius:5px; font-size:13px; color:#582C0C; font-family:inherit; background:#fff; outline:none; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Kembalian</label>
                                <div style="padding:8px 12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:5px; font-size:14px; font-weight:700; color:#15803d;">
                                    <span id="m-kembalian">Rp0</span>
                                </div>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#6B513E; text-transform:uppercase; display:block; margin-bottom:5px;">Hutang / Kurang</label>
                                <div style="padding:8px 12px; background:#fef2f2; border:1px solid #fecaca; border-radius:5px; font-size:14px; font-weight:700; color:#dc2626;">
                                    <span id="m-hutang">Rp0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== FOOTER BUTTONS ===== --}}
        <div style="display:flex; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #e5d6c5; background:#fdf8f3; border-radius:0 0 10px 10px;">
            <button onclick="closePayment()" style="padding:10px 28px; background:#fff; color:#582C0C; border:1px solid #e5d6c5; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; transition:background 0.2s;">
                Batal
            </button>
            <button onclick="prosesDone()" style="padding:10px 28px; background:#8B5E3C; color:#fff; border:none; border-radius:6px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; display:flex; align-items:center; gap:8px; transition:background 0.2s;">
                <i class="fa fa-check-circle"></i> SIMPAN PEMBAYARAN
            </button>
        </div>

        {{-- ELEMEN TERSEMBUNYI (dibutuhkan oleh JS cashier.blade.php) --}}
        {{-- Sudah dirender secara visible di atas, elemen-elemen ini sebagai fallback/hidden --}}

    </div>
</div>
