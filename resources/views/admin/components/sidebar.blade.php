@php
    $menuItems = [
        // 1. Dashboard
        [
            'route' => 'admin.dashboard',
            'filled' => false,
            'icon' => '/images/dashboard.svg',
            'is_image' => true,
        ],
        // 2. Outpatient
        [
            'route' => 'admin.outpatient',
            'filled' => true,
            'icon' => '/images/outpatient.svg',
            'is_image' => true,
        ],
        // 3. Registration
        [
            'route' => 'admin.registration',
            'filled' => false,
            'icon' => '/images/register.svg',
            'is_image' => true,
        ],
        // 4. EMR
        [
            'route' => 'admin.emr',
            'filled' => false,
            'icon' => '/images/emr.svg',
            'is_image' => true,
        ],
        // 5. Pharmacy
        [
            'route' => 'admin.pharmacy',
            'filled' => false,
            'icon' => '/images/pharmacy.svg',
            'is_image' => true,
        ],
        // 6. Cashier
        [
            'route' => 'admin.cashier',
            'filled' => false,
            'icon' => '/images/cashier.svg',
            'is_image' => true,
        ],
        // 7. profile
        [
            'route' => 'admin.profile',
            'filled' => false,
            'icon' => '/images/profile.svg',
            'is_image' => true,
        ],
        // 8. Messages
        [
            'route' => 'admin.messages',
            'filled' => false,
            'icon' => '/images/messages.svg',
            'is_image' => true,
        ],

        // --- GARIS PEMISAH ---
        [
            'is_divider' => true,
        ],

        // 9. office
        [
            'route' => 'admin.office',
            'filled' => false,
            'icon' => '/images/office.svg',
            'is_image' => true,
        ],
        // 10. Settings / Gear
        [
            'route' => 'admin.settings',
            'filled' => false,
            'icon' =>
                '<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />',
        ],
    ];
@endphp

{{-- Backdrop --}}
<div id="sidebarBackdrop" class="sidebar-backdrop"></div>

<aside class="sidebar" id="appSidebar">
    {{-- Logo Container --}}
    <div class="sidebar-logo">
        <img src="/images/logo-hds.png" alt="HDS">
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        @foreach ($menuItems as $item)
            @if (isset($item['is_divider']) && $item['is_divider'])
                <div class="sidebar-divider"></div>
            @else
                <a href="{{ route($item['route']) }}"
                    class="sidebar-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    @if (isset($item['is_image']) && $item['is_image'])
                        <img src="{{ $item['icon'] }}" alt="icon" class="sidebar-icon-img">
                    @elseif ($item['filled'] ?? false)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            {!! $item['icon'] !!}
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            {!! $item['icon'] !!}
                        </svg>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle   = document.getElementById('sidebarToggle');
    const sidebar  = document.getElementById('appSidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    if (!toggle || !sidebar) return;

    function open()  {
        sidebar.classList.add('open');
        if (backdrop) backdrop.classList.add('show');
        toggle.style.opacity = '0';
        toggle.style.pointerEvents = 'none';
    }
    function close() {
        sidebar.classList.remove('open');
        if (backdrop) backdrop.classList.remove('show');
        toggle.style.opacity = '1';
        toggle.style.pointerEvents = 'auto';
    }

    toggle.addEventListener('click', () => sidebar.classList.contains('open') ? close() : open());
    if (backdrop) backdrop.addEventListener('click', close);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
    document.querySelectorAll('.sidebar-item').forEach(el => el.addEventListener('click', close));
});
</script>