@extends('admin.layout.admin')
@section('title', 'Registration')

@section('navbar')
    @include('admin.components.navbarPendaftaranBaru', ['title' => 'Registration'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration.css') }}">
@endpush

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