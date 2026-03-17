@extends('admin.layout.admin')
@section('title', 'Registration')

@section('navbar')
    @include('admin.components.navbarPendaftaranBaru', ['title' => 'Registration'])
@endsection

@section('content')
<div class="reg-container">
    {{-- Page Header --}}
    <div class="reg-header">
        <div class="reg-title-area">
            <h1 class="reg-title">Registration</h1>
            <p class="reg-subtitle">hanglekiu dental specialist</p>
        </div>
    </div>

    <div class="reg-layout">

        {{-- Konten Utama Kanan --}}
        <div class="reg-main">
            <div class="reg-card">
                
                <div class="reg-card-header">
                    <h2 class="reg-card-title">
                        Rawat Jalan Poli <i class="fas fa-desktop" style="color: #C58F59; margin-left: 8px;"></i>
                    </h2>
                    <div class="reg-card-actions">
                        <button class="reg-icon-btn" title="Informasi"><i class="fas fa-info-circle"></i></button>
                        <button class="reg-btn-outline">EXPORT</button>
                        <button class="reg-icon-btn" title="Print">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; color: currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.25 7.034V3.375" /></svg>
                        </button>
                    </div>
                </div>

                {{-- Filter Pencarian --}}
                <div class="reg-filters">
                    <div class="reg-filter-row">
                        <div class="reg-input-group" style="flex: 1;">
                            <label>Tanggal Kunjungan</label>
                            <div class="reg-date-wrapper">
                                <input type="date" class="reg-input" value="2026-02-25">
                                <button class="reg-btn-icon-small"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        
                        <div class="reg-input-group" style="flex: 1.5;">
                            <label>Poli *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    <span class="reg-select-text">Semua Poli</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option is-selected" data-value="semua">Semua Poli</div>
                                    <div class="reg-option" data-value="gigi">Poli Gigi</div>
                                    <div class="reg-option" data-value="umum">Poli Umum</div>
                                </div>
                                <input type="hidden" name="filter_poli" value="semua">
                            </div>
                        </div>
                    </div>

                    <div class="reg-filter-row">
                        <div class="reg-input-group">
                            <label>Tenaga Medis *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    <span class="reg-select-text">Semua Tenaga Medis</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option is-selected" data-value="semua">Semua Tenaga Medis</div>
                                    <div class="reg-option" data-value="dinda">drg. Dinda Tegar Jelita Sp.Ortho</div>
                                    <div class="reg-option" data-value="ria">drg. Ria Budiati Sp. Ortho</div>
                                    <div class="reg-option" data-value="wenny">DR. drg. Wenny Yulvie Sp.BM</div>
                                    <div class="reg-option" data-value="aditya">drg. Aditya Putra</div>
                                    <div class="reg-option" data-value="may">drg . MAY Lewerissa Sp.Perio</div>
                                    <div class="reg-option" data-value="fanny">drg. Fanny Arditya M. Sp.Prost</div>
                                </div>
                                <input type="hidden" name="filter_dokter" value="semua">
                            </div>
                        </div>
                        
                        <div class="reg-input-group">
                            <label>Metode Pembayaran *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    <span class="reg-select-text">Semua Metode Pembayaran</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option is-selected" data-value="semua">Semua Metode Pembayaran</div>
                                    <div class="reg-option" data-value="umum">Umum / Tunai</div>
                                    <div class="reg-option" data-value="asuransi">Asuransi</div>
                                    <div class="reg-option" data-value="bpjs">BPJS Kesehatan</div>
                                </div>
                                <input type="hidden" name="filter_bayar" value="semua">
                            </div>
                        </div>
                        
                        <div class="reg-input-group" style="flex: 1.5; justify-content: flex-end;">
                            <div class="reg-search-box">
                                <input type="text" placeholder="Nama Pasien, Nomor MR">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wrapper Tabel --}}
                <div class="reg-table-wrapper">
                    <table class="reg-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Tanggal<br>Kunjungan</th>
                                <th>Tanggal<br>Dibuat</th>
                                <th>No</th>
                                <th>Poli</th>
                                <th>Nama Pasien</th>
                                <th>Rencana<br>Tindakan</th>
                                <th>Dokter Pemeriksa</th>
                                <th>Metode Bayar</th>
                                <th>Catatan Medis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Status"><span class="reg-status succeed">Succeed</span></td>
                                <td data-label="Tanggal Kunjungan">25/02/2026,<br>13:00</td>
                                <td data-label="Tanggal Dibuat">25/02/2026,<br>19:32</td>
                                <td data-label="No">1</td>
                                <td data-label="Poli">Gigi</td>
                                <td data-label="Nama Pasien">Bpk Johndoe,<br>MR000096,<br>40 Tahun</td>
                                <td data-label="Rencana Tindakan">-</td>
                                <td data-label="Dokter Pemeriksa">drg. Hanglekiu</td>
                                <td data-label="Metode Bayar">Asuransi</td>
                                <td data-label="Catatan Medis">Pembersihan Karang Gigi</td>
                                <td data-label="Aksi"><button class="reg-btn-outline" style="padding: 4px 8px;">Detail</button></td>
                            </tr>
                            <tr>
                                <td data-label="Status"><span class="reg-status succeed">Succeed</span></td>
                                <td data-label="Tanggal Kunjungan">25/02/2026,<br>14:00</td>
                                <td data-label="Tanggal Dibuat">25/02/2026,<br>20:32</td>
                                <td data-label="No">2</td>
                                <td data-label="Poli">Gigi</td>
                                <td data-label="Nama Pasien">Bpk Budi,<br>MR000099,<br>40 Tahun</td>
                                <td data-label="Rencana Tindakan">-</td>
                                <td data-label="Dokter Pemeriksa">drg. Hanglekiu</td>
                                <td data-label="Metode Bayar">Asuransi</td>
                                <td data-label="Catatan Medis">Pembersihan Karang Gigi</td>
                                <td data-label="Aksi"><button class="reg-btn-outline" style="padding: 4px 8px;">Detail</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="reg-pagination">
                    <div class="reg-page-size">
                        <span>Jumlah baris perhalaman:</span>
                        <select>
                            <option>8</option>
                            <option>15</option>
                            <option>50</option>
                        </select>
                    </div>
                    <div class="reg-page-info">
                        1-2 Dari 2 Data
                    </div>
                    <div class="reg-page-controls">
                        <button class="reg-page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <button class="reg-page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* ============================================
       DESKTOP — tidak diubah sama sekali
    ============================================ */
    .reg-container {
        padding: 0 0px 24px 0px;
        font-family: 'Instrument Sans', sans-serif;
    }

    .reg-container * {
        font-size: 13px;
    }

    .reg-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 24px;
    }

    .reg-title {
        font-size: 30px !important;
        font-weight: 700;
        color: #582C0C;
    }

    .reg-subtitle {
        font-size: 18.75px;
        color: #C58F59;
    }

    .reg-btn-warning {
        background-color: #F59E0B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
    }

    .reg-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .reg-main {
        flex: 1;
        min-width: 0;
    }

    .reg-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.08);
        border: 1px solid #E5D6C5;
    }

    .reg-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #E5D6C5;
    }

    .reg-card-title {
        font-size: 18.75px !important;
        font-weight: 700;
        color: #582C0C;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .reg-card-title i { font-size: 18.75px !important; }

    .reg-card-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .reg-btn-outline {
        border: 1px solid #C58F59;
        background: white;
        color: #582C0C;
        padding: 6px 16px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
    }

    .reg-icon-btn {
        background: none;
        border: none;
        color: #6B513E;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .reg-icon-btn:hover { color: #C58F59; }

    .reg-filters {
        padding: 20px 24px;
        border-bottom: 1px solid #E5D6C5;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .reg-filter-row {
        display: flex;
        gap: 20px;
        align-items: flex-end;
    }

    .reg-input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }

    .reg-input-group label { color: #A38C7A; }

    .reg-input {
        border: none;
        border-bottom: 1px solid #C58F59;
        padding: 8px 0;
        color: #582C0C;
        outline: none;
        background: transparent;
    }

    .reg-date-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #C58F59;
    }

    .reg-date-wrapper input {
        border: none;
        outline: none;
        padding: 8px 0;
        color: #582C0C;
        flex: 1;
    }

    .reg-btn-icon-small {
        background: none;
        border: none;
        color: #582C0C;
        cursor: pointer;
    }

    .reg-search-box {
        display: flex;
        align-items: center;
        border: 1px solid #C58F59;
        border-radius: 4px;
        padding: 6px 12px;
    }

    .reg-search-box input {
        border: none;
        outline: none;
        width: 100%;
        color: #582C0C;
    }

    .reg-search-box i { color: #C58F59; }

    .reg-custom-select { position: relative; width: 100%; }

    .reg-select-trigger {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 8px 0;
        border-bottom: 1px solid #C58F59;
        cursor: pointer;
        background: transparent;
    }

    .reg-select-text {
        color: #582C0C;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 10px;
    }

    .reg-select-icon {
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }

    .reg-custom-select.open .reg-select-icon { transform: rotate(180deg); }

    .reg-options {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(88, 44, 12, 0.08);
        padding: 6px;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        max-height: 250px;
        overflow-y: auto;
    }

    .reg-options::-webkit-scrollbar { width: 6px; }
    .reg-options::-webkit-scrollbar-track { background: transparent; }
    .reg-options::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 4px; }
    .reg-options::-webkit-scrollbar-thumb:hover { background: #C58F59; }

    .reg-custom-select.open .reg-options {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .reg-option {
        padding: 10px 14px;
        color: #6B513E;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 2px;
    }

    .reg-option:hover { background-color: #FCFAF8; color: #C58F59; }
    .reg-option.is-selected { background-color: #FDF8F4; color: #582C0C; font-weight: 700; }

    .reg-table-wrapper {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 8px;
    }

    .reg-table-wrapper::-webkit-scrollbar { height: 8px; }
    .reg-table-wrapper::-webkit-scrollbar-track { background: #F9FAFB; border-radius: 4px; }
    .reg-table-wrapper::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 4px; }
    .reg-table-wrapper::-webkit-scrollbar-thumb:hover { background: #C58F59; }

    .reg-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: collapse;
        text-align: left;
    }

    .reg-table th {
        background-color: #FDF8F4;
        color: #582C0C;
        font-weight: 600;
        padding: 14px 20px;
        border-bottom: 2px solid #E5D6C5;
        white-space: nowrap;
    }

    .reg-table td {
        padding: 14px 20px;
        color: #374151;
        border-bottom: 1px solid #E5E7EB;
        vertical-align: top;
        white-space: nowrap;
    }

    .reg-table tr:hover td { background-color: #FAFAF9; }

    .reg-status { font-weight: 600; }
    .reg-status.succeed { color: #65A30D; }

    .reg-pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 16px 24px;
        gap: 24px;
        color: #6B7280;
    }

    .reg-page-size select {
        border: none;
        outline: none;
        font-weight: 600;
        color: #582C0C;
        margin-left: 8px;
        cursor: pointer;
    }

    .reg-page-controls { display: flex; gap: 8px; }

    .reg-page-btn {
        background: none;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
    }

    .reg-page-btn:not([disabled]):hover { color: #582C0C; }

    /* ============================================
       MOBILE TAMBAHAN — mulai dari sini
    ============================================ */

    /* Filter stack vertikal */
    @media (max-width: 1024px) {
        .reg-layout { flex-direction: column; }
        .reg-filter-row {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }
    }

    /* Tabel jadi card layout di mobile */
    @media (max-width: 768px) {
        .reg-table,
        .reg-table thead,
        .reg-table tbody,
        .reg-table tr,
        .reg-table th,
        .reg-table td {
            display: block;
            width: 100%;
        }

        .reg-table thead { display: none; }
        .reg-table { min-width: unset; }

        .reg-table tbody tr {
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #E5D6C5;
            box-shadow: 0 2px 8px rgba(88, 44, 12, 0.06);
            overflow: hidden;
        }

        .reg-table td {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 14px;
            border: none;
            border-bottom: 1px solid #F5EDE0;
            white-space: normal;
        }

        .reg-table td:last-child { border-bottom: none; }
        .reg-table td:first-child { background: #FDF8F4; }

        /* Label dari data-label */
        .reg-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #C58F59;
            font-size: 11px;
            min-width: 110px;
            flex-shrink: 0;
            padding-top: 1px;
        }

        .reg-filters { padding: 14px 16px; }
        .reg-card-header { padding: 14px 16px; flex-wrap: wrap; gap: 10px; }
        .reg-pagination { padding: 12px 14px; flex-wrap: wrap; justify-content: space-between; }
    }

    @media (max-width: 480px) {
        .reg-table td::before { min-width: 90px; font-size: 10px; }
        .reg-table td { font-size: 12px; padding: 8px 12px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customSelects = document.querySelectorAll('.reg-custom-select');

        customSelects.forEach(dropdown => {
            const trigger = dropdown.querySelector('.reg-select-trigger');
            const options = dropdown.querySelectorAll('.reg-option');
            const textDisplay = dropdown.querySelector('.reg-select-text');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                customSelects.forEach(other => {
                    if (other !== dropdown) other.classList.remove('open');
                });
                dropdown.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    options.forEach(opt => opt.classList.remove('is-selected'));
                    this.classList.add('is-selected');
                    textDisplay.textContent = this.textContent;
                    if (hiddenInput) hiddenInput.value = this.dataset.value;
                    dropdown.classList.remove('open');
                });
            });
        });

        window.addEventListener('click', function() {
            customSelects.forEach(dropdown => dropdown.classList.remove('open'));
        });
    });
</script>
@endsection