{{-- resources/views/admin/settings/info_tenaga_medis.blade.php --}}

<style>
    .itm-toolbar { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
    .itm-search-box {
        flex: 1; min-width: 200px;
        display: flex; align-items: center;
        border: 1.5px solid #E5D6C5; border-radius: 6px;
        padding: 9px 14px; gap: 10px; background: #fff; transition: border-color .2s;
    }
    .itm-search-box:focus-within { border-color: #C58F59; }
    .itm-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; flex: 1; font-family: inherit; }
    .itm-search-box input::placeholder { color: #b09a88; }

    .itm-btn-filter {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 14px; border: 1.5px solid #E5D6C5; border-radius: 6px;
        background: #fff; color: #582C0C; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: inherit; white-space: nowrap; transition: all .2s;
    }
    .itm-btn-filter:hover { border-color: #C58F59; color: #C58F59; }

    .itm-btn-tambah {
        background: #C58F59; color: #fff; border: none; padding: 9px 18px; border-radius: 6px;
        font-size: 13px; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        font-family: inherit; white-space: nowrap; transition: background .2s;
    }
    .itm-btn-tambah:hover { background: #b07d4a; }

    /* Card grid */
    .itm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .itm-card {
        background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
        padding: 18px 20px;
        display: flex; align-items: flex-start; gap: 16px;
        box-shadow: 0 1px 3px rgba(88,44,12,.05);
        transition: border-color .2s;
    }
    .itm-card:hover { border-color: #C58F59; }

    /* Photo placeholder */
    .itm-photo {
        width: 72px; height: 72px; flex-shrink: 0;
        border: 1.5px solid #E5D6C5; border-radius: 6px;
        background: #fdf8f4;
        display: flex; align-items: center; justify-content: center;
        color: #C58F59;
    }

    .itm-info { flex: 1; min-width: 0; }
    .itm-name { font-size: 13px; font-weight: 700; color: #582C0C; margin: 0 0 4px; }
    .itm-role { font-size: 13px; color: #6B513E; margin: 0 0 4px; }
    .itm-show-more { font-size: 13px; color: #C58F59; font-weight: 600; cursor: pointer; text-decoration: none; }
    .itm-show-more:hover { text-decoration: underline; }

    .itm-btn-edit {
        margin-top: 14px;
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border: 1.5px solid #E5D6C5; border-radius: 5px;
        background: #fff; color: #582C0C; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all .2s;
    }
    .itm-btn-edit:hover { border-color: #C58F59; color: #C58F59; }
</style>

<div class="itm-toolbar">
    <div class="itm-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Search Name, STR or SIP">
    </div>
    <button class="itm-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        FILTER
    </button>
    <button class="itm-btn-tambah">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
        + TAMBAH DATA TENAGA MEDIS
    </button>
</div>

<div class="itm-grid">

    @foreach ([
        ['drg. Dinda Tegar Jelita Sp.Ortho', 'Dokter Gigi'],
        ['drg. Ria Budiati Sp. Ortho',       'Dokter Gigi Spesialis Ortodonsia'],
        ['DR. drg. Wenny Yulvie Sp.BM',      'Dokter Gigi Spesialis Bedah Mulut'],
        ['drg. Aditya Putra',                'Dokter Gigi Umum'],
        ['drg . MAY Lewerissa Sp.Perio',     'Dokter Gigi Spesialis Periodonsia'],
        ['drg. Fanny Arditya M. Sp.Prost',   'Dokter Gigi Spesialis Prostodensia'],
    ] as [$name, $role])
        <div>
            <div class="itm-card">
                <div class="itm-photo">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M8.5 12.5 L12 8 L15.5 12.5"/>
                        <circle cx="9" cy="9" r="1"/>
                    </svg>
                </div>
                <div class="itm-info">
                    <p class="itm-name">{{ $name }}</p>
                    <p class="itm-role">{{ $role }}</p>
                    <a href="#" class="itm-show-more">Show More</a>
                    <div>
                        <button class="itm-btn-edit">
                            EDIT PROFIL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
