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

<aside class="sidebar">
    {{-- Logo Container --}}
    <div class="sidebar-logo">
        <img src="/images/logo-hds.png" alt="HDS">
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        @foreach ($menuItems as $item)
            {{-- Mengecek apakah item ini adalah garis pemisah --}}
            @if (isset($item['is_divider']) && $item['is_divider'])
                <div class="sidebar-divider"></div>
            @else
                {{-- Jika bukan garis pemisah, render icon seperti biasa --}}
                <a href="{{ route($item['route']) }}"
                    class="sidebar-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    @if (isset($item['is_image']) && $item['is_image'])
                        {{-- Untuk icon yang merupakan file SVG --}}
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

    .sidebar-nav::-webkit-scrollbar {
        display: none;
    }

    .sidebar-nav {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

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
    }

    .sidebar-item svg {
        width: 24px;
        height: 24px;
    }

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

    .logout-btn {
        color: var(--color-warning, #EF4444);
    }

    .sidebar .logout-btn:hover,
    .sidebar .logout-btn:active,
    .sidebar .logout-btn:focus-visible {
        background-color: var(--color-background-secondary, #E5D6C5) !important;
        color: var(--color-warning, #EF4444) !important;
    }
</style>
