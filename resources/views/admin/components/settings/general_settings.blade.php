
<style>
    .gs-title { font-size: 18.75px; font-weight: 700; color: #582C0C; margin: 0 0 20px; }
    .gs-list { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(88,44,12,.05); }
    .gs-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 17px 22px; border-bottom: 1px solid #E5D6C5;
        cursor: pointer; transition: background .15s; text-decoration: none;
    }
    .gs-item:last-child { border-bottom: none; }
    .gs-item:hover { background: rgba(197,143,89,.04); }
    .gs-item:hover .gs-item-label { color: #582C0C; }
    .gs-item-label { font-size: 13px; font-weight: 600; color: #C58F59; transition: color .15s; }
    .gs-item-arrow { color: #C58F59; flex-shrink: 0; transition: color .15s; }
</style>

<h2 class="gs-title">General Settings</h2>

<div class="gs-list">
    @foreach ([
        'Bridging Satu Sehat',
        'Bridging Badung Sehat',
        'Bridging BPJS',
        'Bridging Antrean Online',
        'Rawat Jalan',
        'EMR',
        'Apotek',
        'Kasir',
        'Tooltip',
        'Message Center',
        'Manajemen Approval',
        'Reset Data',
        'Notifikasi',
        'Data Masking',
        'Ubah Bahasa',
        'Manajemen Password',
    ] as $item)
        <a href="#" class="gs-item">
            <span class="gs-item-label">{{ $item }}</span>
            <svg class="gs-item-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </a>
    @endforeach
</div>
