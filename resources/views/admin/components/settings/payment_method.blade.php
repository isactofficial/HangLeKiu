@include('admin.components.settings.master_crud_template', [
    'title'             => 'Manajemen Payment',
    'subtitle'          => 'Kelola data payment di sistem hanglekiu',
    'itemLabel'         => 'Payment',
    'apiUrl'            => '/api/master-payment',
    'searchPlaceholder' => 'Cari payment method...',
    'inputLabel'        => 'Payment method',
    'inputPlaceholder'  => 'Masukkan payment method',
])
