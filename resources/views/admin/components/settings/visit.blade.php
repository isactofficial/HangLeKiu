@include('admin.components.settings.master_crud_template', [
    'title'             => 'Manajemen Jenis Kunjungan',
    'subtitle'          => 'Kelola data jenis kunjungan di sistem hanglekiu',
    'itemLabel'         => 'Jenis Kunjungan',
    'apiUrl'            => '/api/master-visit-type',
    'searchPlaceholder' => 'Cari jenis kunjungan...',
    'inputLabel'        => 'Nama Jenis Kunjungan',
    'inputPlaceholder'  => 'Masukkan nama jenis kunjungan',
])
