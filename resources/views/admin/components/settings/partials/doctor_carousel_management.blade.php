<!DOCTYPE html>
<style>
  /* Full CSS from provided HTML - extracted for partial */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #F5F3EF; color: #1a1a1a; font-size: 14px; }
  a { text-decoration: none; }

  /* Stats */
  .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
  .stat-card { background: #fff; border: 0.5px solid #e0dbd4; border-radius: 10px; padding: 14px 16px; }
  .stat-label { font-size: 11px; color: #9B7B62; margin-bottom: 6px; font-weight: 500; }
  .stat-value { font-size: 26px; font-weight: 500; color: #1a1a1a; }
  .stat-sub { font-size: 11px; color: #B0998A; margin-top: 3px; }

  /* Buttons */
  .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; border: 0.5px solid #d4ccc5; background: #fff; color: #1a1a1a; transition: all 0.15s; line-height: 1; }
  .btn:hover { background: #F5F3EF; }
  .btn-primary { background: #C58F59; color: #fff; border-color: #C58F59; }
  .btn-primary:hover { background: #A0703E; border-color: #A0703E; }
  .btn-ghost { background: transparent; border-color: transparent; color: #6B513E; }
  .btn-ghost:hover { background: #FAF6F2; }
  .btn-danger { background: #FEF2F2; color: #B91C1C; border-color: #FECACA; }
  .btn-danger:hover { background: #FEE2E2; }
  .btn-sm { padding: 5px 10px; font-size: 12px; }

  /* Table card */
  .table-card { background: #fff; border: 0.5px solid #e0dbd4; border-radius: 12px; overflow: hidden; }
  .table-toolbar { display: flex; gap: 10px; align-items: center; padding: 14px 16px; border-bottom: 0.5px solid #e0dbd4; }
  .search-wrap { position: relative; flex: 1; }
  .search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #B0998A; pointer-events: none; }
  .search-input { width: 100%; padding: 8px 12px 8px 32px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #FAF8F5; color: #1a1a1a; outline: none; transition: border 0.15s; }
  .search-input:focus { border-color: #C58F59; background: #fff; }
  .filter-select { padding: 8px 12px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #FAF8F5; color: #6B513E; outline: none; cursor: pointer; }
  .filter-select:focus { border-color: #C58F59; }

  table { width: 100%; border-collapse: collapse; table-layout: fixed; }
  col.c-no { width: 44px; }
  col.c-dokter { width: 220px; }
  col.c-spec { width: 150px; }
  col.c-lulus { width: 170px; }
  col.c-exp { width: 100px; }
  col.c-urut { width: 80px; }
  col.c-status { width: 80px; }
  col.c-aksi { width: 140px; }
  th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; color: #9B7B62; text-transform: uppercase; letter-spacing: 0.05em; background: #FAF8F5; border-bottom: 0.5px solid #e0dbd4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  td { padding: 13px 14px; border-bottom: 0.5px solid #F0EBE5; color: #1a1a1a; vertical-align: middle; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  tr:last-child td { border-bottom: none; }
  tbody tr:hover td { background: #FDFAF7; }

  .avatar { width: 34px; height: 34px; border-radius: 50%; background: #E5D6C5; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #582C0C; flex-shrink: 0; }
  .doc-info { display: flex; align-items: center; gap: 10px; }
  .doc-name { font-weight: 500; font-size: 13px; color: #1a1a1a; }
  .doc-str { font-size: 11px; color: #9B7B62; margin-top: 1px; }
  .badge { display: inline-block; padding: 3px 9px; border-radius: 99px; font-size: 11px; font-weight: 500; }
  .badge-spec { background: #FAF0E4; color: #7A4C1D; }
  .badge-active { background: #F0FDF4; color: #15803D; }
  .badge-inactive { background: #F9FAFB; color: #6B7280; }
  .actions { display: flex; gap: 5px; }

  /* Empty state */
  .empty-state { text-align: center; padding: 60px 20px; }
  .empty-icon { width: 48px; height: 48px; margin: 0 auto 14px; background: #FAF0E4; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
  .empty-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 6px; }
  .empty-sub { font-size: 13px; color: #9B7B62; margin-bottom: 20px; }

  /* Pagination */
  .pagination { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 0.5px solid #e0dbd4; }
  .page-info { font-size: 12px; color: #9B7B62; }
  .page-btns { display: flex; gap: 4px; }
  .page-btn { padding: 5px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; border: 0.5px solid #d4ccc5; background: #fff; color: #6B513E; transition: all 0.15s; }
  .page-btn:hover { background: #FAF6F2; }
  .page-btn.active { background: #C58F59; color: #fff; border-color: #C58F59; }
  .page-btn:disabled { opacity: 0.4; cursor: default; }

  /* Modal overlay */
  .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 200; align-items: center; justify-content: center; padding: 16px; }
  .overlay.open { display: flex; }

  /* Modal box */
  .modal { background: #fff; border-radius: 14px; border: 0.5px solid #e0dbd4; width: 100%; max-width: 560px; max-height: 92vh; display: flex; flex-direction: column; }
  .modal-sm { max-width: 400px; }
  .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 0.5px solid #e0dbd4; flex-shrink: 0; }
  .modal-title { font-size: 15px; font-weight: 500; color: #1a1a1a; }
  .modal-close { background: none; border: none; font-size: 18px; cursor: pointer; color: #9B7B62; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: background 0.15s; }
  .modal-close:hover { background: #F5F3EF; }
  .modal-body { padding: 20px; overflow-y: auto; flex: 1; }
  .modal-footer { padding: 14px 20px; border-top: 0.5px solid #e0dbd4; display: flex; justify-content: flex-end; gap: 8px; flex-shrink: 0; }

  /* Form */
  .form-section { margin-bottom: 20px; }
  .form-section-title { font-size: 11px; font-weight: 600; color: #9B7B62; text-transform: uppercase; letter-spacing: 0.06em; padding-bottom: 8px; border-bottom: 0.5px solid #e0dbd4; margin-bottom: 14px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; }
  .form-label { font-size: 12px; font-weight: 500; color: #6B513E; }
  .form-input { padding: 8px 12px; border: 0.5px solid #d4ccc5; border-radius: 8px; font-size: 13px; background: #fff; color: #1a1a1a; outline: none; transition: border 0.15s, box-shadow 0.15s; font-family: inherit; }
  .form-input:focus { border-color: #C58F59; box-shadow: 0 0 0 3px rgba(197,143,89,0.12); }
  textarea.form-input { resize: vertical; min-height: 76px; line-height: 1.5; }
  select.form-input { cursor: pointer; }
  .form-hint { font-size: 11px; color: #B0998A; }

  /* Upload box */
  .upload-box { border: 1px dashed #d4ccc5; border-radius: 8px; padding: 18px 12px; text-align: center; cursor: pointer; background: #FAF8F5; transition: border-color 0.15s, background 0.15s; }
  .upload-box:hover { border-color: #C58F59; background: #FAF0E4; }
  .upload-label { font-size: 12px; font-weight: 500; color: #6B513E; margin-top: 8px; display: block; }
  .upload-hint { font-size: 11px; color: #B0998A; margin-top: 2px; }

  /* Delete confirm */
  .delete-body { text-align: center; padding: 24px 20px 20px; }
  .delete-icon-wrap { width: 48px; height: 48px; border-radius: 50%; background: #FEF2F2; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
  .delete-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 8px; }
  .delete-msg { font-size: 13px; color: #6B7280; line-height: 1.6; }

  /* Detail view */
  .detail-header { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
  .detail-avatar { width: 50px; height: 50px; border-radius: 50%; background: #E5D6C5; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 600; color: #582C0C; flex-shrink: 0; }
  .detail-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .detail-table td { padding: 9px 0; border-bottom: 0.5px solid #F0EBE5; }
  .detail-table td:first-child { color: #9B7B62; width: 38%; }
  .detail-table td:last-child { font-weight: 500; color: #1a1a1a; }
  .detail-table tr:last-child td { border-bottom: none; }
  .detail-bio { margin-top: 16px; padding: 14px; background: #FAF8F5; border-radius: 8px; font-size: 13px; color: #3D2B1F; line-height: 1.6; }
</style>

<div class="doctor-management">

  <!-- Top title (matches project style) -->
  <div style="margin-bottom: 24px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin: 0 0 8px 0;">Manajemen Dokter Carousel</h2>
    <p style="font-size: 14px; color: #9B7B62; margin: 0;">Kelola dokter yang ditampilkan di homepage carousel</p>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-label">Total Dokter</div>
      <div class="stat-value" id="statTotal">3</div>
      <div class="stat-sub">Terdaftar di sistem</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Spesialisasi</div>
      <div class="stat-value" id="statSpec">5</div>
      <div class="stat-sub">Bidang keahlian</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Aktif di Carousel</div>
      <div class="stat-value" id="statActive">2</div>
      <div class="stat-sub">Ditampilkan di homepage</div>
    </div>
  </div>

  <!-- Table -->
  <div class="table-card">
    <div class="table-toolbar">
      <div class="search-wrap">
        <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" type="text" id="searchInput" placeholder="Cari nama atau spesialisasi..." oninput="filterTable()">
      </div>
      <select class="filter-select" id="filterSpec" onchange="filterTable()">
        <option value="">Semua Spesialisasi</option>
        <option value="Orthodonti">Orthodonti</option>
        <option value="Konservasi">Konservasi Gigi</option>
        <option value="Periodonti">Periodonti</option>
        <option value="Bedah">Bedah Mulut</option>
        <option value="Prostodonti">Prostodonti</option>
      </select>
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
          <col class="c-exp"><col class="c-urut"><col class="c-status"><col class="c-aksi">
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Dokter</th>
            <th>Spesialisasi</th>
            <th>Lulusan</th>
            <th>Pengalaman</th>
            <th>Urutan</th>
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
      <div class="empty-sub">Tambahkan dokter pertama untuk ditampilkan di carousel homepage.</div>
      <button class="btn btn-primary" onclick="openAdd()">+ Tambah Dokter</button>
    </div>

    <div class="pagination" id="pagination">
      <div class="page-info" id="pageInfo">Menampilkan 3 dokter</div>
      <div class="page-btns" id="pageBtns"></div>
    </div>
  </div>

</div>

<!-- MODAL: ADD / EDIT -->
<div class="overlay" id="formOverlay">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="formTitle">Tambah Dokter</div>
      <button class="modal-close" onclick="closeOverlay('formOverlay')">&times;</button>
    </div>
    <div class="modal-body">
      <!-- Full form from HTML - all sections -->
      <div class="form-section">
        <div class="form-section-title">Informasi Dasar</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap & Gelar <span style="color:#C58F59;">*</span></label>
            <input class="form-input" type="text" id="f_name" placeholder="contoh: Jenny Wilson Sp.Ort">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor STR</label>
            <input class="form-input" type="text" id="f_str" placeholder="3122100318012345">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Spesialisasi</label>
            <select class="form-input" id="f_spec">
              <option value="Spesialis Orthodonti">Orthodonti</option>
              <option value="Spesialis Konservasi Gigi">Konservasi Gigi</option>
              <option value="Spesialis Periodonti">Periodonti</option>
              <option value="Spesialis Bedah Mulut">Bedah Mulut</option>
              <option value="Spesialis Prostodonti">Prostodonti</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Pengalaman</label>
            <input class="form-input" type="text" id="f_exp" placeholder="contoh: 12+ tahun">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Lulusan / Almamater</label>
          <input class="form-input" type="text" id="f_lulus" placeholder="contoh: Universitas Indonesia, University of Adelaide">
        </div>
        <div class="form-group">
          <label class="form-label">Bio / Deskripsi</label>
          <textarea class="form-input" id="f_bio" placeholder="Deskripsi singkat latar belakang dan keahlian dokter..."></textarea>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Foto & Aset Visual</div>
        <div class="form-row">
          <div>
            <label class="form-label" style="margin-bottom:6px;display:block;">Foto Dokter (PNG transparan)</label>
            <div class="upload-box" onclick="triggerUpload('upFoto')">
              <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span class="upload-label" id="upFotoLabel">Klik untuk upload</span>
              <span class="upload-hint">PNG, maks 2 MB</span>
              <input type="file" id="upFoto" accept="image/png" style="display:none;" onchange="setUploadLabel('upFoto','upFotoLabel')">
            </div>
          </div>
          <div>
            <label class="form-label" style="margin-bottom:6px;display:block;">Bayangan / Shadow</label>
            <div class="upload-box" onclick="triggerUpload('upShadow')">
              <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span class="upload-label" id="upShadowLabel">Klik untuk upload</span>
              <span class="upload-hint">PNG, maks 2 MB</span>
              <input type="file" id="upShadow" accept="image/png" style="display:none;" onchange="setUploadLabel('upShadow','upShadowLabel')">
            </div>
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Badge Lulusan (maks 2 logo universitas)</div>
        <div class="form-row">
          <div>
            <label class="form-label" style="margin-bottom:6px;display:block;">Badge 1</label>
            <div class="upload-box" onclick="triggerUpload('upBadge1')">
              <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
              <span class="upload-label" id="upBadge1Label">Logo universitas 1</span>
              <span class="upload-hint">PNG, maks 500 KB</span>
              <input type="file" id="upBadge1" accept="image/*" style="display:none;" onchange="setUploadLabel('upBadge1','upBadge1Label')">
            </div>
          </div>
          <div>
            <label class="form-label" style="margin-bottom:6px;display:block;">Badge 2</label>
            <div class="upload-box" onclick="triggerUpload('upBadge2')">
              <svg width="22" height="22" fill="none" stroke="#C58F59" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
              <span class="upload-label" id="upBadge2Label">Logo universitas 2</span>
              <span class="upload-hint">PNG, maks 500 KB</span>
              <input type="file" id="upBadge2" accept="image/*" style="display:none;" onchange="setUploadLabel('upBadge2','upBadge2Label')">
            </div>
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Media Sosial</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Instagram URL</label>
            <input class="form-input" type="url" id="f_ig" placeholder="https://instagram.com/...">
          </div>
          <div class="form-group">
            <label class="form-label">LinkedIn URL</label>
            <input class="form-input" type="url" id="f_li" placeholder="https://linkedin.com/in/...">
          </div>
        </div>
      </div>

      <div class="form-section" style="margin-bottom:0;">
        <div class="form-section-title">Pengaturan Carousel</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Urutan Tampil</label>
            <input class="form-input" type="number" id="f_order" placeholder="1" min="1" max="99">
            <span class="form-hint">Angka lebih kecil = tampil lebih dahulu</span>
          </div>
          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-input" id="f_status">
              <option value="active">Aktif — ditampilkan di carousel</option>
              <option value="inactive">Nonaktif — disembunyikan</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeOverlay('formOverlay')">Batal</button>
      <button class="btn btn-primary" onclick="saveDoctor()">Simpan Dokter</button>
    </div>
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
      <div class="delete-msg" id="deleteMsg">Data akan dihapus permanen dan tidak lagi ditampilkan di carousel homepage.</div>
    </div>
    <div class="modal-footer" style="justify-content:center; gap:10px;">
      <button class="btn" onclick="closeOverlay('deleteOverlay')">Batal</button>
      <button class="btn btn-danger" onclick="confirmDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- MODAL: VIEW DETAIL -->
<div class="overlay" id="viewOverlay">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Detail Dokter</div>
      <button class="modal-close" onclick="closeOverlay('viewOverlay')">&times;</button>
    </div>
    <div class="modal-body" id="viewContent"></div>
    <div class="modal-footer">
      <button class="btn" onclick="closeOverlay('viewOverlay')">Tutup</button>
      <button class="btn btn-primary" id="editFromViewBtn">Edit Dokter</button>
    </div>
  </div>
</div>

<script>
let doctors = [
  {
    id: 1,
    name: 'Jenny Wilson Sp.Ort',
    str: '3122100318012345',
    spec: 'Spesialis Orthodonti',
    exp: '12+ tahun',
    lulus: 'Universitas Indonesia, University of Adelaide',
    bio: 'Spesialis orthodonti dengan pengalaman lebih dari 12 tahun dalam perawatan gigi berengsel dan koreksi maloklusi.',
    order: 1,
    status: 'active'
  },
  {
    id: 2,
    name: 'Albert Flores Sp.KG',
    str: '3122100318012346',
    spec: 'Spesialis Konservasi Gigi',
    exp: '15+ tahun',
    lulus: 'Universitas Gadjah Mada',
    order: 2,
    status: 'active'
  },
  {
    id: 3,
    name: 'Sarah Johnson Sp.Per',
    str: '3122100318012347',
    spec: 'Spesialis Periodonti',
    exp: '8+ tahun',
    lulus: 'Universitas Airlangga',
    order: 3,
    status: 'inactive'
  }
];
let editingId = null;
let deletingId = null;
let nextId = 4;

function initials(name) {
  if (!name) return '?';
  return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
}

function updateStats() {
  document.getElementById('statTotal').textContent = doctors.length;
  document.getElementById('statSpec').textContent = [...new Set(doctors.map(d => d.spec))].length;
  document.getElementById('statActive').textContent = doctors.filter(d => d.status === 'active').length;
}

function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const spec = document.getElementById('filterSpec').value;
  const status = document.getElementById('filterStatus').value;
  const filtered = doctors.filter(d =>
    (!q || d.name.toLowerCase().includes(q) || d.spec.toLowerCase().includes(q)) &&
    (!spec || d.spec.includes(spec)) &&
    (!status || d.status === status)
  );
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
          <div class="avatar">${initials(d.name)}</div>
          <div>
            <div class="doc-name">${d.name || '—'}</div>
            <div class="doc-str">STR: ${d.str || '—'}</div>
          </div>
        </div>
      </td>
      <td><span class="badge badge-spec">${d.spec.replace('Spesialis ', '')}</span></td>
      <td style="font-size:12px;color:#6B513E;">${d.lulus || '—'}</td>
      <td style="font-size:12px;color:#6B513E;">${d.exp || '—'}</td>
      <td style="font-size:12px;color:#6B513E;text-align:center;">#${d.order}</td>
      <td><span class="badge ${d.status === 'active' ? 'badge-active' : 'badge-inactive'}">${d.status === 'active' ? 'Aktif' : 'Nonaktif'}</span></td>
      <td>
        <div class="actions">
          <button class="btn btn-sm btn-ghost" onclick="viewDoctor(${d.id})">Lihat</button>
          <button class="btn btn-sm" onclick="openEdit(${d.id})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="openDelete(${d.id})">Hapus</button>
        </div>
      </td>
    </tr>
  `).join('');

  updateStats();
}

function openAdd() {
  editingId = null;
  document.getElementById('formTitle').textContent = 'Tambah Dokter';
  ['f_name','f_str','f_exp','f_lulus','f_bio','f_ig','f_li'].forEach(id => document.getElementById(id).value = '');
  document.getElementById('f_order').value = doctors.length + 1;
  document.getElementById('f_spec').value = 'Spesialis Orthodonti';
  document.getElementById('f_status').value = 'active';
  ['upFotoLabel','upShadowLabel','upBadge1Label','upBadge2Label'].forEach(id => document.getElementById(id).textContent = ['Klik untuk upload','Klik untuk upload','Logo universitas 1','Logo universitas 2'][id.match(/Badge|Foto|Shadow/)[0] === 'Badge' ? 2 : 0] || 'Klik untuk upload');
  openOverlay('formOverlay');
}

function openEdit(id) {
  editingId = id;
  const d = doctors.find(x => x.id === id);
  document.getElementById('formTitle').textContent = 'Edit Dokter';
  document.getElementById('f_name').value = d.name;
  document.getElementById('f_str').value = d.str || '';
  document.getElementById('f_spec').value = d.spec;
  document.getElementById('f_exp').value = d.exp || '';
  document.getElementById('f_lulus').value = d.lulus || '';
  document.getElementById('f_bio').value = d.bio || '';
  document.getElementById('f_ig').value = d.ig || '';
  document.getElementById('f_li').value = d.li || '';
  document.getElementById('f_order').value = d.order;
  document.getElementById('f_status').value = d.status;
  openOverlay('formOverlay');
}

function saveDoctor() {
  const name = document.getElementById('f_name').value.trim();
  if (!name) { alert('Nama dokter wajib diisi.'); return; }
  const data = {
    name,
    str: document.getElementById('f_str').value.trim(),
    spec: document.getElementById('f_spec').value,
    exp: document.getElementById('f_exp').value.trim(),
    lulus: document.getElementById('f_lulus').value.trim(),
    bio: document.getElementById('f_bio').value.trim(),
    ig: document.getElementById('f_ig').value.trim(),
    li: document.getElementById('f_li').value.trim(),
    order: parseInt(document.getElementById('f_order').value) || 1,
    status: document.getElementById('f_status').value,
  };
  if (editingId) {
    const idx = doctors.findIndex(d => d.id === editingId);
    doctors[idx] = { ...doctors[idx], ...data };
  } else {
    doctors.push({ id: nextId++, ...data });
  }
  closeOverlay('formOverlay');
  filterTable();
}

function openDelete(id) {
  deletingId = id;
  const d = doctors.find(x => x.id === id);
  document.getElementById('deleteMsg').textContent = `"${d.name}" akan dihapus permanen dan tidak lagi ditampilkan di carousel homepage.`;
  openOverlay('deleteOverlay');
}

function confirmDelete() {
  doctors = doctors.filter(d => d.id !== deletingId);
  closeOverlay('deleteOverlay');
  filterTable();
}

function viewDoctor(id) {
  const d = doctors.find(x => x.id === id);
  document.getElementById('viewContent').innerHTML = `
    <div class="detail-header">
      <div class="detail-avatar">${initials(d.name)}</div>
      <div>
        <div style="font-size:16px;font-weight:500;color:#1a1a1a;">${d.name}</div>
        <div style="font-size:12px;color:#9B7B62;margin-top:3px;">${d.spec}</div>
      </div>
    </div>
    <table class="detail-table">
      <tr><td>No. STR</td><td>${d.str || '—'}</td></tr>
      <tr><td>Pengalaman</td><td>${d.exp || '—'}</td></tr>
      <tr><td>Lulusan</td><td>${d.lulus || '—'}</td></tr>
      <tr><td>Instagram</td><td>${d.ig ? '<a href="'+d.ig+'" style="color:#C58F59;">'+d.ig+'</a>' : '—'}</td></tr>
      <tr><td>LinkedIn</td><td>${d.li ? '<a href="'+d.li+'" style="color:#C58F59;">'+d.li+'</a>' : '—'}</td></tr>
      <tr><td>Urutan carousel</td><td>#${d.order}</td></tr>
      <tr><td>Status</td><td><span class="badge ${d.status==='active'?'badge-active':'badge-inactive'}">${d.status==='active'?'Aktif':'Nonaktif'}</span></td></tr>
    </table>
    ${d.bio ? `<div class="detail-bio">${d.bio}</div>` : ''}
  `;
  document.getElementById('editFromViewBtn').onclick = () => { closeOverlay('viewOverlay'); openEdit(id); };
  openOverlay('viewOverlay');
}

function openOverlay(id) { document.getElementById(id).classList.add('open'); }
function closeOverlay(id) { document.getElementById(id).classList.remove('open'); }

function triggerUpload(inputId) { document.getElementById(inputId).click(); }
function setUploadLabel(inputId, labelId) {
  const f = document.getElementById(inputId).files[0];
  if (f) document.getElementById(labelId).textContent = f.name;
}

// Init
renderTable(doctors);
updateStats();

// Close modals on overlay click / escape
document.querySelectorAll('.overlay').forEach(el => {
  el.addEventListener('click', function(e) { if (e.target === this) closeOverlay(this.id); });
});
document.addEventListener('keydown', e => { 
  if (e.key === 'Escape') document.querySelectorAll('.overlay.open').forEach(el => el.classList.remove('open')); 
});
</script>

