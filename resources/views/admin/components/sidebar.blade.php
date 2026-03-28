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
            'route' => 'admin.rawat-jalan',
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

<style>
    /* ── TIDAK ADA YANG BERUBAH DARI SINI ── */
    .sidebar {
        width: 72px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background-color: var(--font-color-primary, #582C0C);
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 100;
        padding: 24px 0;
        transition: transform 0.25s ease; /* tambahan kecil untuk animasi mobile */
    }

    .sidebar-logo {
        width: 44px;
        height: 44px;
        background-color: var(--color-background-primary, #F7F7F7);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
        position: relative;
        z-index: 2;
    }

    .sidebar-logo img {
        width: 40px;
        height: auto;
        filter: sepia(1) saturate(3) hue-rotate(345deg) brightness(0.5);
    }

    .sidebar-nav {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
        align-items: center;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-nav::-webkit-scrollbar { display: none; }
    .sidebar-nav { -ms-overflow-style: none; scrollbar-width: none; }

    .sidebar-nav .sidebar-divider {
        display: block;
        width: 36px;
        min-height: 2px;
        height: 2px;
        flex-shrink: 0;
        background-color: rgba(247, 247, 247, 0.65);
        border-radius: 999px;
        margin: 6px 0;
    }

    @media (min-width: 1024px) {
        .sidebar-nav .sidebar-divider {
            display: block !important;
            width: 40px;
            opacity: 1;
        }
    }

    .sidebar-item {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: var(--color-background-primary, #F7F7F7);
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
        text-decoration: none;
    }

    .sidebar-item svg { width: 24px; height: 24px; }

    .sidebar-item .sidebar-icon-img {
        width: 24px;
        height: 24px;
        filter: invert(100%) brightness(1.1);
    }

    .sidebar-item:is(:hover, :focus-visible, :active, .active) .sidebar-icon-img {
        filter: invert(15%) sepia(50%) brightness(0.7) saturate(1.2);
    }

    .sidebar .sidebar-item:hover,
    .sidebar .sidebar-item:focus-visible {
        background-color: rgba(229, 214, 197, 0.5) !important;
        color: var(--font-color-primary, #582C0C) !important;
    }

    .sidebar .sidebar-item:active,
    .sidebar .sidebar-item.active {
        background-color: var(--color-background-secondary, #E5D6C5) !important;
        color: var(--font-color-primary, #582C0C) !important;
    }

    .sidebar-bottom {
        width: 100%;
        display: flex;
        justify-content: center;
        padding-top: 24px;
    }

    .logout-btn { color: var(--color-warning, #EF4444); }

    .sidebar .logout-btn:hover,
    .sidebar .logout-btn:active,
    .sidebar .logout-btn:focus-visible {
        background-color: var(--color-background-secondary, #E5D6C5) !important;
        color: var(--color-warning, #EF4444) !important;
    }

    /* ── TAMBAHAN MOBILE ── */
    .sidebar-hamburger {
        display: none;
        position: fixed;
        left: 16px;
        top: 18px;
        z-index: 200;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        background: white;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        padding: 7px;
        width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(88,44,12,0.10);
    }

    @media (max-width: 768px) {
        .sidebar-hamburger {
            position: static;
            display: none; /* diatur ulang oleh navbar-left via flex */
            z-index: auto;
            top: auto;
            left: auto;
            box-shadow: none;
            flex-shrink: 0;
        }
    }

    .sidebar-hamburger span {
        display: block;
        width: 18px;
        height: 2px;
        background: #582C0C;
        border-radius: 2px;
    }

    .sidebar-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 99;
        opacity: 0;
        transition: opacity 0.25s;
        pointer-events: none;
    }

    .sidebar-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }

    @media (max-width: 768px) {
        .sidebar { 
            transform: translateX(-100%) !important;
            z-index: 150;

        }
        .sidebar.open { 
            transform: translateX(0) !important;
        
        }

        .sidebar-backdrop { display: block; }
    }
</style>

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