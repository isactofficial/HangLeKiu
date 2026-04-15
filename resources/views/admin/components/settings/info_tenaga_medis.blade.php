<!DOCTYPE html>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #F5F3EF; color: #582C0C; font-size: 14px; }
  a { text-decoration: none; }
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
  .stat-card { background: #fff; border: 0.5px solid #e0dbd4; border-radius: 10px; padding: 14px 16px; }
  .stat-label { font-size: 11px; color: #9B7B62; margin-bottom: 6px; font-weight: 500; }
  .stat-value { font-size: 26px; font-weight: 500; color: #582C0C; }
  .stat-sub { font-size: 11px; color: #B0998A; margin-top: 3px; }
  .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; border: 0.5px solid #d4ccc5; background: #fff; color: #582C0C; transition: all 0.15s; line-height: 1; }
  .btn:hover { background: #F5F3EF; }
  .btn-primary { background: #C58F59; color: #fff; border-color: #C58F59; }
  .btn-primary:hover { background: #A0703E; border-color: #A0703E; }
  .btn-ghost { background: transparent; border-color: transparent; color: #6B513E; }
  .btn-ghost:hover { background: #FAF6F2; }
  .btn-danger { background: #FEF2F2; color: #B91C1C; border-color: #FECACA; }
  .btn-danger:hover { background: #FEE2E2; }
  .btn-sm { padding: 5px 10px; font-size: 12px; }
  .table-card { background: #fff; border: 0.5px solid #e0dbd4; border-radius: 12px; overflow: hidden; }
  .table-toolbar { display: flex; gap: 10px; align-items: center; padding: 14px 16px; border-bottom: 0.5px solid #e0dbd4; }
  .search-wrap { position: relative; flex: 1; }
  .search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #B0998A; pointer-events: none; }
  .search-input { width: 100%; padding: 8px 12px 8px 32px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #FAF8F5; color: #582C0C; outline: none; transition: border 0.15s; }
  .search-input:focus { border-color: #C58F59; background: #fff; }
  .filter-select { padding: 8px 12px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #FAF8F5; color: #6B513E; outline: none; cursor: pointer; }
  .filter-select:focus { border-color: #C58F59; }
  table { width: 100%; border-collapse: collapse; table-layout: fixed; }
  col.c-no { width: 44px; }
  col.c-dokter { width: 220px; }
  col.c-spec { width: 150px; }
  col.c-fee { width: 110px; }
  col.c-lulus { width: 170px; }
  col.c-exp { width: 100px; }
  col.c-urut { width: 80px; }
  col.c-status { width: 80px; }
  col.c-aksi { width: 140px; }
  th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; color: #9B7B62; text-transform: uppercase; letter-spacing: 0.05em; background: #FAF8F5; border-bottom: 0.5px solid #e0dbd4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  td { padding: 13px 14px; border-bottom: 0.5px solid #F0EBE5; color: #582C0C; vertical-align: middle; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  tr:last-child td { border-bottom: none; }
  tbody tr:hover td { background: #FDFAF7; }
  .avatar { width: 34px; height: 34px; border-radius: 50%; background: #E5D6C5; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #582C0C; flex-shrink: 0; }
  .doc-info { display: flex; align-items: center; gap: 10px; }
  .doc-name { font-weight: 500; font-size: 13px; color: #582C0C; }
  .doc-str { font-size: 11px; color: #9B7B62; margin-top: 1px; }
  .badge { display: inline-block; padding: 3px 9px; border-radius: 99px; font-size: 11px; font-weight: 500; }
  .badge-spec { background: #FAF0E4; color: #7A4C1D; }
  .badge-active { background: #F0FDF4; color: #15803D; }
  .badge-inactive { background: #F9FAFB; color: #6B7280; }
  .actions { display: flex; gap: 5px; }
  .empty-state { text-align: center; padding: 60px 20px; }
  .empty-icon { width: 48px; height: 48px; margin: 0 auto 14px; background: #FAF0E4; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
  .empty-title { font-size: 15px; font-weight: 500; color: #582C0C; margin-bottom: 6px; }
  .empty-sub { font-size: 13px; color: #9B7B62; margin-bottom: 20px; }
  .pagination { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 0.5px solid #e0dbd4; }
  .page-info { font-size: 12px; color: #9B7B62; }
  .page-btns { display: flex; gap: 4px; }
  .page-btn { padding: 5px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; border: 0.5px solid #d4ccc5; background: #fff; color: #6B513E; transition: all 0.15s; }
  .page-btn:hover { background: #FAF6F2; }
  .page-btn.active { background: #C58F59; color: #fff; border-color: #C58F59; }
  .page-btn:disabled { opacity: 0.4; cursor: default; }
  .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 12000; align-items: center; justify-content: center; padding: 16px; }
  .overlay.open { display: flex; }
  .modal { background: #fff; border-radius: 14px; border: 0.5px solid #e0dbd4; width: 100%; max-width: 900px; max-height: 92vh; display: flex; flex-direction: column; }
  .modal-sm { max-width: 400px; }
  .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 0.5px solid #e0dbd4; flex-shrink: 0; }
  .modal-title { font-size: 15px; font-weight: 500; color: #582C0C; }
  .modal-close { background: none; border: none; font-size: 18px; cursor: pointer; color: #9B7B62; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: background 0.15s; }
  .modal-close:hover { background: #F5F3EF; }
  .modal-body { padding: 0; overflow-y: auto; flex: 1; }
  .modal-footer { padding: 14px 20px; border-top: 0.5px solid #e0dbd4; display: flex; justify-content: flex-end; gap: 8px; flex-shrink: 0; }
  .form-section { margin-bottom: 20px; }
  .form-section-title { font-size: 11px; font-weight: 600; color: #9B7B62; text-transform: uppercase; letter-spacing: 0.06em; padding-bottom: 8px; border-bottom: 0.5px solid #e0dbd4; margin-bottom: 14px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; }
  .form-label { font-size: 12px; font-weight: 500; color: #6B513E; }
  .form-input { padding: 8px 12px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #fff; color: #582C0C; outline: none; transition: border 0.15s, box-shadow 0.15s; font-family: inherit; width: 100%; }
  .form-input:focus { border-color: #C58F59; box-shadow: 0 0 0 3px rgba(197,143,89,0.12); }
  textarea.form-input { resize: vertical; min-height: 76px; line-height: 1.5; }
  select.form-input { cursor: pointer; }
  .form-hint { font-size: 11px; color: #B0998A; }
  .upload-box { border: 1px dashed #d4ccc5; border-radius: 8px; padding: 18px 12px; text-align: center; cursor: pointer; background: #FAF8F5; transition: border-color 0.15s, background 0.15s; }
  .upload-box:hover { border-color: #C58F59; background: #FAF0E4; }
  .upload-label { font-size: 12px; font-weight: 500; color: #6B513E; margin-top: 8px; display: block; }
  .upload-hint { font-size: 11px; color: #B0998A; margin-top: 2px; }
  .delete-body { text-align: center; padding: 24px 20px 20px; }
  .delete-icon-wrap { width: 48px; height: 48px; border-radius: 50%; background: #FEF2F2; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
  .delete-title { font-size: 15px; font-weight: 500; color: #582C0C; margin-bottom: 8px; }
  .delete-msg { font-size: 13px; color: #6B7280; line-height: 1.6; }
  .detail-header { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
  .detail-avatar { width: 50px; height: 50px; border-radius: 50%; background: #E5D6C5; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 600; color: #582C0C; flex-shrink: 0; }
  .detail-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .detail-table td { padding: 9px 0; border-bottom: 0.5px solid #F0EBE5; }
  .detail-table td:first-child { color: #9B7B62; width: 38%; }
  .detail-table td:last-child { font-weight: 500; color: #582C0C; }
  .detail-table tr:last-child td { border-bottom: none; }
  .detail-bio { margin-top: 16px; padding: 14px; background: #FAF8F5; border-radius: 8px; font-size: 13px; color: #582C0C; line-height: 1.6; }
  .ms-modal-form { display: flex; flex-direction: column; flex: 1; min-height: 0; }
  .ms-modal-form input[type="file"] { display: none; }

  @media (max-width: 768px) {
    .overlay {
      align-items: flex-start;
      padding: calc(76px + env(safe-area-inset-top)) 10px 10px;
    }

    .modal {
      max-height: calc(100vh - 86px - env(safe-area-inset-top));
      border-radius: 12px;
    }
  }
</style>

<div class="doctor-management">
  <div class="mc-header-row" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <div>
          <h2 class="mc-title" style="font-size:24px;font-weight:700;color:#582C0C;">Manajemen Tenaga Medis</h2>
          <p class="mc-subtitle" style="color:#C58F59;">Kelola daftar dokter dan jadwal praktek</p>
      </div>
      <button class="btn btn-primary" onclick="openAdd()">+ Tambah Tenaga Medis</button>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-label">Total Dokter</div>
      <div class="stat-value" id="statTotal">0</div>
      <div class="stat-sub">Terdaftar di sistem</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Spesialisasi</div>
      <div class="stat-value" id="statSpec">0</div>
      <div class="stat-sub">Bidang keahlian</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Aktif</div>
      <div class="stat-value" id="statActive">0</div>
      <div class="stat-sub">Beroperasi saat ini</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Di Carousel</div>
      <div class="stat-value" id="statCarousel">0</div>
      <div class="stat-sub">Muncul di Beranda</div>
    </div>
  </div>

  <div class="table-card">
    <div class="table-toolbar">
      <div class="search-wrap">
        <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" type="text" id="searchInput" placeholder="Cari nama atau spesialisasi..." oninput="filterTable()">
      </div>
      <select class="filter-select" id="filterStatus" onchange="filterTable()">
        <option value="">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
      </select>
    </div>

    <div style="overflow-x:auto;">
      <table>
        <colgroup>
          <col class="c-no"><col class="c-dokter"><col class="c-spec"><col class="c-lulus">
          <col class="c-fee"><col class="c-exp"><col class="c-urut"><col class="c-status"><col class="c-aksi">
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Dokter</th>
            <th>Spesialisasi</th>
            <th>Instansi Lulusan</th>
            <th>Fee Dokter</th>
            <th>Pengalaman</th>
            <th>ID / Order</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>

    <div id="emptyState" class="empty-state" style="display:none;">
      <div class="empty-icon">
        <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/></svg>
      </div>
      <div class="empty-title">Belum ada data dokter</div>
      <button class="btn btn-primary" onclick="openAdd()">+ Tambah Dokter</button>
    </div>

    <div class="pagination" id="pagination">
      <div class="page-info" id="pageInfo">Menampilkan 0 dokter</div>
    </div>
  </div>
</div>

<!-- MODAL FORM -->
<div class="overlay" id="formOverlay">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="formTitle">Tambah Tenaga Medis</div>
      <button class="modal-close" onclick="closeOverlay('formOverlay')">&times;</button>
    </div>
    <form id="docForm" onsubmit="saveDoctor(event)" class="ms-modal-form" enctype="multipart/form-data">
        <div class="modal-body">
            <div style="display: flex; flex-wrap: wrap; gap: 30px; padding: 20px;">
                <!-- KIRI -->
                <div style="flex: 1; min-width: 300px;">
                    <div class="form-section">
                        <div class="form-section-title">Informasi Dasar</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap *</label>
                                <input class="form-input" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input class="form-input" name="email" type="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">No. HP</label>
                                <input class="form-input" name="phone_number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gelar Depan</label>
                                <input class="form-input" name="title_prefix">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Spesialisasi</label>
                                <input class="form-input" name="specialization">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jabatan (Job Title)</label>
                                <input class="form-input" name="job_title">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Pengalaman (e.g. 12+ tahun)</label>
                                <input class="form-input" name="experience">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Lulusan / Almamater</label>
                                <input class="form-input" name="alma_mater">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bio Singkat</label>
                            <textarea class="form-input" name="bio"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Urutan Tampil (Carousel)</label>
                                <input class="form-input" name="carousel_order" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tampil di Carousel Depan</label>
                                <select class="form-input" name="show_in_carousel">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Aktif (Bisa Praktik)</label>
                                <select class="form-input" name="is_active">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group">
                            <label class="form-label">Estimasi Konsultasi (Menit)</label>
                            <input class="form-input" name="estimasi_konsultasi" type="number" value="15">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Fee % Doctor</label>
                            <input class="form-input" name="default_fee_percentage" type="number" step="0.01" min="0" max="100" placeholder="Contoh: 35">
                          </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">Legalitas</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">No. STR</label>
                                <input class="form-input" name="str_number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instansi STR</label>
                                <input class="form-input" name="str_institution">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Masa Berlaku STR</label>
                                <input class="form-input" name="str_expiry_date" type="date">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">No. SIP</label>
                                <input class="form-input" name="sip_number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instansi SIP</label>
                                <input class="form-input" name="sip_institution">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Masa Berlaku SIP</label>
                                <input class="form-input" name="sip_expiry_date" type="date">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Lisensi Klinik</label>
                                <input class="form-input" name="license_no">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN -->
                <div style="flex: 1; min-width: 300px;">
                    <div class="form-section" style="background:#fcfcfc; padding:15px; border:1px solid #f0f0f0; border-radius:8px;">
                        <div class="form-section-title">Jadwal Praktek</div>
                        @php
                            $days = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                        @endphp
                        @foreach($days as $key => $label)
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <label style="font-size:13px;"><input type="checkbox" name="schedules[{{ $key }}][is_active]" value="1" id="sch_active_{{ $key }}"> {{ $label }}</label>
                            <div>
                                <input type="time" name="schedules[{{ $key }}][start_time]" id="sch_start_{{ $key }}" class="form-input" style="width: auto; display:inline-block;"> - 
                                <input type="time" name="schedules[{{ $key }}][end_time]" id="sch_end_{{ $key }}" class="form-input" style="width: auto; display:inline-block;">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-section" style="margin-top:20px;">
                        <div class="form-section-title">Upload Gambar</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Foto Profil (Tanpa Background)</label>
                                <div class="upload-box" onclick="triggerUpload('upFoto')">
                                    <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span class="upload-label" id="upFotoLabel">Klik untuk upload</span>
                                    <span class="upload-hint">PNG, maks 2 MB</span>
                                    <input type="file" id="upFoto" name="foto_profil" accept="image/png, image/webp, image/jpeg" style="display:none;" onchange="setUploadLabel('upFoto','upFotoLabel')">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Foto Bayangan (Shadow)</label>
                                <div class="upload-box" onclick="triggerUpload('upShadow')">
                                    <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span class="upload-label" id="upShadowLabel">Klik untuk upload</span>
                                    <span class="upload-hint">PNG, maks 2 MB</span>
                                    <input type="file" id="upShadow" name="shadow_image" accept="image/png, image/webp" style="display:none;" onchange="setUploadLabel('upShadow','upShadowLabel')">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Badge Universitas 1</label>
                                <div class="upload-box" onclick="triggerUpload('upBadge1')">
                                    <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                    <span class="upload-label" id="upBadge1Label">Logo universitas 1</span>
                                    <span class="upload-hint">PNG/JPG, maks 1 MB</span>
                                    <input type="file" id="upBadge1" name="badge_1" accept="image/*" style="display:none;" onchange="setUploadLabel('upBadge1','upBadge1Label')">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Badge Universitas 2</label>
                                <div class="upload-box" onclick="triggerUpload('upBadge2')">
                                    <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                    <span class="upload-label" id="upBadge2Label">Logo universitas 2</span>
                                    <span class="upload-hint">PNG/JPG, maks 1 MB</span>
                                    <input type="file" id="upBadge2" name="badge_2" accept="image/*" style="display:none;" onchange="setUploadLabel('upBadge2','upBadge2Label')">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tanda Tangan Digital (TTD)</label>
                                <div class="upload-box" onclick="triggerUpload('upTtd')">
                                    <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span class="upload-label" id="upTtdLabel">Klik upload tanda tangan</span>
                                    <span class="upload-hint">PNG statis, maks 2 MB</span>
                                    <input type="file" id="upTtd" name="ttd" accept="image/png, image/jpeg, image/webp" style="display:none;" onchange="setUploadLabel('upTtd','upTtdLabel')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" onclick="closeOverlay('formOverlay')">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Dokter</button>
        </div>
    </form>
  </div>
</div>

<!-- MODAL: DELETE CONFIRM -->
<div class="overlay" id="deleteOverlay">
  <div class="modal modal-sm">
    <div class="modal-header">
      <div class="modal-title">Konfirmasi Hapus</div>
      <button class="modal-close" onclick="closeOverlay('deleteOverlay')">&times;</button>
    </div>
    <div class="delete-body">
      <div class="delete-icon-wrap">
        <svg width="20" height="20" fill="none" stroke="#B91C1C" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
      </div>
      <div class="delete-title">Hapus dokter ini?</div>
      <div class="delete-msg" id="deleteMsg">Data akan dihapus permanen.</div>
    </div>
    <div class="modal-footer" style="justify-content:center; gap:10px;">
      <button class="btn" onclick="closeOverlay('deleteOverlay')">Batal</button>
      <button class="btn btn-danger" onclick="confirmDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
let doctors = [];
let editingId = null;
let deletingId = null;

function initials(name) {
  if (!name) return '?';
  return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
}

function updateStats() {
  document.getElementById('statTotal').textContent = doctors.length;
  document.getElementById('statSpec').textContent = [...new Set(doctors.map(d => d.spec).filter(Boolean))].length;
  document.getElementById('statActive').textContent = doctors.filter(d => d.status === 'active').length;
  document.getElementById('statCarousel').textContent = doctors.filter(d => d.show_in_carousel).length;
}

function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const status = document.getElementById('filterStatus').value;
  const filtered = doctors.filter(d => {
    const s1 = d.name ? d.name.toLowerCase().includes(q) : false;
    const s2 = d.spec ? d.spec.toLowerCase().includes(q) : false;
    return (!q || s1 || s2) && (!status || d.status === status);
  });
  renderTable(filtered);
}

function renderTable(data) {
  const tbody = document.getElementById('tableBody');
  const empty = document.getElementById('emptyState');
  const pag = document.getElementById('pagination');
  if (!data.length) {
    tbody.innerHTML = '';
    empty.style.display = 'block';
    pag.style.display = 'none';
    return;
  }
  empty.style.display = 'none';
  pag.style.display = 'flex';
  document.getElementById('pageInfo').textContent = `Menampilkan ${data.length} dari ${doctors.length} dokter`;

  tbody.innerHTML = data.map((d, i) => `
    <tr>
      <td style="color:#B0998A;font-size:12px;">${i + 1}</td>
      <td>
        <div class="doc-info">
          <div class="avatar" ${d.foto ? `style="background:url(${d.foto.startsWith('http') ? d.foto : '/storage/' + d.foto}) center/cover no-repeat; color:transparent;"` : ''}>${initials(d.name)}</div>
          <div>
            <div class="doc-name">${d.name || '—'}</div>
            <div class="doc-str">STR: ${d.str || '—'}</div>
          </div>
        </div>
      </td>
      <td><span class="badge ${d.spec ? 'badge-spec' : ''}">${d.spec ? d.spec.replace('Spesialis ', '') : '-'}</span></td>
      <td style="font-size:12px;color:#6B513E;">${d.lulus || '—'}</td>
      <td style="font-size:12px;color:#6B513E;">${d.fee != null && d.fee !== '' ? `${Number(d.fee).toFixed(2)}%` : '0.00%'}</td>
      <td style="font-size:12px;color:#6B513E;">${d.exp || '—'}</td>
      <td style="font-size:12px;color:#6B513E;text-align:center;">#${d.order || d.id}</td>
      <td>
        <div style="display: flex; flex-direction: column; gap: 4px;">
            <span class="badge ${d.status === 'active' ? 'badge-active' : 'badge-inactive'}">${d.status === 'active' ? 'Aktif' : 'Nonaktif'}</span>
            <span class="badge ${d.show_in_carousel ? 'badge-spec' : 'badge-inactive'}" style="font-size: 10px;">${d.show_in_carousel ? 'Carousel' : 'Sembunyi'}</span>
        </div>
      </td>
      <td>
        <div class="actions">
          <button class="btn btn-sm" onclick="openEdit('${d.id}')">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDelete('${d.id}')">Hapus</button>
        </div>
      </td>
    </tr>
  `).join('');
  updateStats();
}

function openAdd() {
  editingId = null;
  document.getElementById('formTitle').textContent = 'Tambah Tenaga Medis';
  document.getElementById('docForm').reset();
  
  // Reset labels
  document.getElementById('upFotoLabel').textContent = 'Klik untuk upload';
  document.getElementById('upShadowLabel').textContent = 'Klik untuk upload';
  document.getElementById('upBadge1Label').textContent = 'Logo universitas 1';
  document.getElementById('upBadge2Label').textContent = 'Logo universitas 2';
  document.getElementById('upTtdLabel').textContent = 'Klik upload tanda tangan';

  openOverlay('formOverlay');
}

function openEdit(id) {
  editingId = id;
  document.getElementById('formTitle').textContent = 'Edit Tenaga Medis';
  document.getElementById('docForm').reset();
  
  document.getElementById('upFotoLabel').textContent = 'Biarkan jika tidak ganti foto';
  document.getElementById('upShadowLabel').textContent = 'Biarkan jika tidak ganti foto';
  document.getElementById('upBadge1Label').textContent = 'Biarkan jika tidak ganti label';
  document.getElementById('upBadge2Label').textContent = 'Biarkan jika tidak ganti label';
  document.getElementById('upTtdLabel').textContent = 'Biarkan jika tidak ganti TTD';

  openOverlay('formOverlay');
  
  // Ambil detail lengkap dari server
  fetch('/admin/settings/doctor/' + id, { headers: { 'Accept': 'application/json' } })
    .then(res => res.json())
    .then(data => {
       if(data.success && data.doctor) {
          const doc = data.doctor;
          const f = document.getElementById('docForm');
          f.full_name.value = doc.full_name || '';
          f.email.value = doc.email || '';
          f.phone_number.value = doc.phone_number || '';
          f.title_prefix.value = doc.title_prefix || '';
          f.specialization.value = doc.specialization || '';
          f.job_title.value = doc.job_title || '';
          f.experience.value = doc.experience || '';
          f.alma_mater.value = doc.alma_mater || '';
          f.bio.value = doc.bio || '';
          const carouselOrder = doc.carousel_order ?? doc.order;
          f.carousel_order.value = (carouselOrder === 99 || carouselOrder === null || carouselOrder === undefined) ? '' : carouselOrder;
          f.is_active.value = doc.is_active ? "1" : "0";
          f.show_in_carousel.value = doc.show_in_carousel ? "1" : "0";
          f.estimasi_konsultasi.value = doc.estimasi_konsultasi || '15';
          f.default_fee_percentage.value = doc.default_fee_percentage ?? '';
          f.str_number.value = doc.str_number || '';
          f.str_institution.value = doc.str_institution || '';
          if(doc.str_expiry_date) f.str_expiry_date.value = doc.str_expiry_date.split(' ')[0];
          f.sip_number.value = doc.sip_number || '';
          f.sip_institution.value = doc.sip_institution || '';
          if(doc.sip_expiry_date) f.sip_expiry_date.value = doc.sip_expiry_date.split(' ')[0];
          f.license_no.value = doc.license_no || '';

          if(doc.schedules && Array.isArray(doc.schedules)) {
             doc.schedules.forEach(s => {
                 const ds = s.day;
                 const cb = document.getElementById('sch_active_' + ds);
                 if(cb) { cb.checked = true; }
                 const st = document.getElementById('sch_start_' + ds);
                 if(st) { st.value = s.start_time || ''; }
                 const en = document.getElementById('sch_end_' + ds);
                 if(en) { en.value = s.end_time || ''; }
             });
          }
       }
    })
    .catch(console.error);
}

function saveDoctor(e) {
  e.preventDefault();
  const form = document.getElementById('docForm');
  const formData = new FormData(form);

  if (editingId) formData.append('_method', 'PUT');

  const url = editingId ? `/admin/settings/doctor/${editingId}` : '/admin/settings/manajemen-staff/doctor';
  const method = 'POST'; // Since we are using FormData, we send POST with _method=PUT to handle multipart files
  
  fetch(url, {
    method,
    body: formData,
    headers: { 
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    },
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Dokter berhasil disimpan!');
      closeOverlay('formOverlay');
      loadDoctors(); // Reload list
    } else {
      let errorMsg = data.message || 'Gagal simpan';
      if (data.errors) {
        const errs = Object.values(data.errors).flat().join('\n');
        errorMsg += '\n\n' + errs;
      }
      alert('Error: ' + errorMsg);
    }
  })
  .catch(err => {
    alert('Error: ' + err.message);
    console.error(err);
  });
}

function openDelete(id) {
  deletingId = id;
  const d = doctors.find(x => x.id === id);
  if (d) document.getElementById('deleteMsg').textContent = `"${d.name}" akan dihapus permanen.`;
  openOverlay('deleteOverlay');
}

function confirmDelete() {
  fetch(`/admin/settings/doctor/${deletingId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      closeOverlay('deleteOverlay');
      loadDoctors();
    } else alert('Gagal hapus: ' + data.message);
  })
  .catch(err => alert('Error: ' + err.message));
}

function openOverlay(id) { document.getElementById(id).classList.add('open'); }
function closeOverlay(id) { document.getElementById(id).classList.remove('open'); }

function triggerUpload(inputId) { document.getElementById(inputId).click(); }
function setUploadLabel(inputId, labelId) {
  const fileInput = document.getElementById(inputId);
  if (fileInput.files.length > 0) {
    document.getElementById(labelId).textContent = fileInput.files[0].name;
  }
}

function loadDoctors() {
  fetch('/admin/settings', { // The route is /admin/settings for DoctorController@index
    headers: { 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    doctors = data.doctors || [];
    renderTable(doctors);
  })
  .catch(console.error);
}

// Init
loadDoctors();

// Close modals on overlay click / escape
document.querySelectorAll('.overlay').forEach(el => {
  el.addEventListener('click', function(e) { if (e.target === this) closeOverlay(this.id); });
});
document.addEventListener('keydown', e => { 
  if (e.key === 'Escape') document.querySelectorAll('.overlay.open').forEach(el => el.classList.remove('open')); 
});
</script>
