{{-- =====================================================
     FamiFinance — Modern Sidebar Component
     Font: Plus Jakarta Sans (via Google Fonts)
     ===================================================== --}}

@once
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    

    /* ── Sidebar base ── */
    .ff-sidebar {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── Glowing orbs (decorative) ── */
    .ff-sidebar::before {
        content: '';
        position: absolute;
        top: -60px; left: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .ff-sidebar::after {
        content: '';
        position: absolute;
        bottom: 80px; right: -50px;
        width: 160px; height: 160px;
        background: radial-gradient(circle, rgba(52,211,153,0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Logo icon ── */
    .ff-logo-icon {
        box-shadow: 0 4px 18px rgba(99,102,241,0.45), 0 0 0 1px rgba(255,255,255,0.1) inset;
    }

    /* ── Active nav: left accent bar ── */
    .ff-nav-active {
        position: relative;
        background: linear-gradient(135deg, rgba(99,102,241,0.22) 0%, rgba(139,92,246,0.12) 100%) !important;
        border: 1px solid rgba(99,102,241,0.30) !important;
        color: #ffffff !important;
    }
    .ff-nav-active::before {
        content: '';
        position: absolute;
        left: 0; top: 22%; bottom: 22%;
        width: 3px;
        background: linear-gradient(180deg, #6366f1, #8b5cf6);
        border-radius: 0 3px 3px 0;
    }

    /* ── Icon wrapper ── */
    .ff-nav-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: all 0.18s ease;
    }
    .ff-nav-active .ff-nav-icon {
        background: rgba(99,102,241,0.25);
        box-shadow: 0 2px 10px rgba(99,102,241,0.28);
    }

    /* ── Amber & Emerald icon accent variants ── */
    .ff-nav-active.ff-icon-amber .ff-nav-icon {
        background: rgba(251,191,36,0.15);
        box-shadow: 0 2px 8px rgba(251,191,36,0.22);
    }
    .ff-nav-active.ff-icon-emerald .ff-nav-icon {
        background: rgba(52,211,153,0.15);
        box-shadow: 0 2px 8px rgba(52,211,153,0.22);
    }

    /* ── Section divider label ── */
    .ff-section-label::before {
        content: '';
        display: inline-block;
        width: 16px; height: 1px;
        background: rgba(129,140,248,0.35);
        vertical-align: middle;
        margin-right: 6px;
    }

    /* ── User card ── */
    .ff-user-avatar {
        box-shadow: 0 2px 10px rgba(99,102,241,0.42);
    }

    /* ── Scrollbar ── */
    .ff-scroll::-webkit-scrollbar { width: 4px; }
    .ff-scroll::-webkit-scrollbar-track { background: transparent; }
    .ff-scroll::-webkit-scrollbar-thumb {
        background: rgba(99,102,241,0.25);
        border-radius: 4px;
    }
    .ff-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(99,102,241,0.45);
    }
</style>
@endonce

<aside
    class="fixed inset-y-0 left-0 bg-slate-900 text-white z-50 flex flex-col border-r border-slate-800 transition-all duration-300 shadow-xl"
    :class="sidebarOpen ? 'w-64 translate-x-0' : 'md:w-20 -translate-x-full md:translate-x-0'">

    <div class="h-16 flex items-center px-6 border-b border-slate-800 justify-between overflow-hidden">
        {{-- Logo Icon --}}
        <div
            class="ff-logo-icon h-10 w-10 rounded-xl flex items-center justify-center flex-shrink-0"
            style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #34d399 100%);"
        >
            <i class="fa-solid fa-wallet text-white text-base"></i>
        </div>

        {{-- Brand Name --}}
        <span
            class="font-extrabold text-lg tracking-tight whitespace-nowrap overflow-hidden"
            style="color: #f1f5f9;"
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-2"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-end="opacity-0 -translate-x-2"
        >
            Family<span style="background: linear-gradient(90deg, #818cf8, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Finance</span>
        </span>
    </div>

    {{-- ──────────────────────────────────────────
         NAV LINKS
    ────────────────────────────────────────── --}}
    <div class="ff-scroll flex-1 overflow-y-auto py-4 px-2.5 space-y-1">

        {{-- Dashboard --}}
        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-2.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 group
                {{ request()->routeIs('dashboard')
                    ? 'ff-nav-active'
                    : 'hover:bg-white/5' }}"
            style="{{ !request()->routeIs('dashboard') ? 'color: rgba(148,163,184,0.8);' : '' }}"
        >
            <div class="ff-nav-icon"
                style="{{ request()->routeIs('dashboard') ? 'color: #818cf8;' : 'color: rgba(100,116,139,0.9);' }}"
            >
                <i class="fa-solid fa-chart-pie text-base transition-transform duration-200 group-hover:scale-110"></i>
            </div>
            <span
                class="tracking-wide whitespace-nowrap overflow-hidden"
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
            >
                Dashboard Keuangan
            </span>
        </a>
        <a href="{{ route('transaction-reports') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-xl font-bold text-sm transition group {{ request()->routeIs('transaction-reports') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-file-invoice-dollar text-lg transition group-hover:scale-110"></i>
            <span x-show="sidebarOpen" x-transition>Laporan Transaksi</span>
        </a>

        {{-- ── ADMIN SECTION ── --}}
        @if(Auth::user()->role === 'admin')

            {{-- Section Divider --}}
            <div
                class="ff-section-label pt-4 pb-1 px-2.5 whitespace-nowrap overflow-hidden"
                style="font-size: 9.5px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(129,140,248,0.6);"
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0"
            >
                Halaman Kontrol
            </div>

            {{-- Manage Budgets --}}
            <a
                href="{{ route('manage-budgets') }}"
                class="flex items-center gap-3 px-2.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 group ff-icon-amber
                    {{ request()->routeIs('manage-budgets')
                        ? 'ff-nav-active'
                        : 'hover:bg-white/5' }}"
                style="{{ !request()->routeIs('manage-budgets') ? 'color: rgba(148,163,184,0.8);' : '' }}"
            >
                <div class="ff-nav-icon"
                    style="{{ request()->routeIs('manage-budgets') ? 'color: #fbbf24;' : 'color: rgba(100,116,139,0.9);' }}"
                >
                    <i class="fa-solid fa-shield-halved text-base transition-transform duration-200 group-hover:scale-110 {{ !request()->routeIs('manage-budgets') ? 'group-hover:text-amber-400' : '' }}"></i>
                </div>
                <span
                    class="tracking-wide whitespace-nowrap overflow-hidden"
                    x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                >
                    Set Anggaran
                </span>
            </a>

            {{-- Manage Categories (NEW MENU - Kategori) --}}
            <a
                href="{{ route('manage-categories') }}"
                class="flex items-center gap-3 px-2.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 group ff-icon-purple
                    {{ request()->routeIs('manage-categories')
                        ? 'ff-nav-active'
                        : 'hover:bg-white/5' }}"
                style="{{ !request()->routeIs('manage-categories') ? 'color: rgba(148,163,184,0.8);' : '' }}"
            >
                <div class="ff-nav-icon"
                    style="{{ request()->routeIs('manage-categories') ? 'color: #a855f7;' : 'color: rgba(100,116,139,0.9);' }}"
                >
                    <i class="fa-solid fa-tags text-base transition-transform duration-200 group-hover:scale-110 {{ !request()->routeIs('manage-categories') ? 'group-hover:text-purple-400' : '' }}"></i>
                </div>
                <span
                    class="tracking-wide whitespace-nowrap overflow-hidden"
                    x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                >
                    Kelola Kategori
                </span>
            </a>

            {{-- Manage Users --}}
            <a
                href="{{ route('manage-users') }}"
                class="flex items-center gap-3 px-2.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 group ff-icon-emerald
                    {{ request()->routeIs('manage-users')
                        ? 'ff-nav-active'
                        : 'hover:bg-white/5' }}"
                style="{{ !request()->routeIs('manage-users') ? 'color: rgba(148,163,184,0.8);' : '' }}"
            >
                <div class="ff-nav-icon"
                    style="{{ request()->routeIs('manage-users') ? 'color: #34d399;' : 'color: rgba(100,116,139,0.9);' }}"
                >
                    <i class="fa-solid fa-users text-base transition-transform duration-200 group-hover:scale-110 {{ !request()->routeIs('manage-users') ? 'group-hover:text-emerald-400' : '' }}"></i>
                </div>
                <span
                    class="tracking-wide whitespace-nowrap overflow-hidden"
                    x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                >
                    Kelola User
                </span>
            </a>

        @endif

    </div>

    {{-- ──────────────────────────────────────────
         FOOTER — User Info & Logout
    ────────────────────────────────────────── --}}
    <div
        class="p-2.5 space-y-1.5"
        style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.18);"
    >
        {{-- User Info Card --}}
        <div
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-xl overflow-hidden"
            style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);"
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
        >
            {{-- Avatar --}}
            <div
                class="ff-user-avatar h-9 w-9 rounded-[10px] flex items-center justify-center text-white font-extrabold text-xs uppercase flex-shrink-0"
                style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); letter-spacing: 0.05em;"
            >
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            {{-- Info --}}
            <div class="truncate">
                <p class="text-xs font-bold truncate leading-tight" style="color: #e2e8f0;">
                    {{ Auth::user()->name }}
                </p>
                <p class="font-semibold uppercase mt-0.5" style="font-size: 10px; letter-spacing: 0.08em; color: #818cf8;">
                    {{ Auth::user()->role }}
                </p>
            </div>
        </div>

        {{-- Collapsed Avatar (only visible when sidebar is closed) --}}
        <div
            class="flex justify-center py-1"
            x-show="!sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
        >
            <div
                class="ff-user-avatar h-9 w-9 rounded-[10px] flex items-center justify-center text-white font-extrabold text-xs uppercase"
                style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); letter-spacing: 0.05em;"
            >
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
        </div>

        {{-- Logout --}}
        <form method="POST" action="/logout">
            @csrf
            <button
                type="submit"
                class="w-full flex items-center gap-3 px-2.5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group"
                style="color: rgba(148,163,184,0.6);"
                onmouseover="this.style.background='rgba(239,68,68,0.08)'; this.style.color='#f87171';"
                onmouseout="this.style.background='transparent'; this.style.color='rgba(148,163,184,0.6)';"
            >
                <div
                    class="ff-nav-icon transition-transform duration-150 group-hover:translate-x-0.5"
                    style="color: inherit; background: rgba(239,68,68,0.07); border-radius: 9px;"
                >
                    <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                </div>
                <span
                    class="tracking-wide whitespace-nowrap overflow-hidden"
                    x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                >
                    Keluar Aplikasi
                </span>
            </button>
        </form>

    </div>

</aside>