<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TayanganKu - RBTV Camkoha</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_tayanganKu.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f1f5f9] font-sans text-slate-900 overflow-x-hidden">

    <div class="flex min-h-screen relative">
        
        @if(Auth::check() && Auth::user()->role === 'admin')
        
        {{-- OVERLAY GELAP UNTUK MOBILE --}}
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

        {{-- SIDEBAR UTAMA --}}
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-[#6b21a8] to-[#be123c] text-white flex flex-col fixed h-full shadow-2xl z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    
                    {{-- LOGO RBTV TANPA KOTAK CARD --}}
                    <img src="{{ asset('img/RBTV_Bengkulu.webp') }}" alt="Logo RBTV" class="w-12 h-auto object-contain drop-shadow-lg">

                    <div>
                        <h1 class="font-bold text-lg leading-tight tracking-tight">TayanganKu</h1>
                        <p class="text-[9px] text-white/60 font-bold tracking-widest uppercase mt-0.5">Admin Panel</p>
                    </div>
                </div>
                
                {{-- TOMBOL TUTUP KHUSUS MOBILE --}}
                <button onclick="toggleSidebar()" class="md:hidden p-2 text-white/70 hover:text-white bg-white/10 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-6 overflow-y-auto">
                {{-- MENU DASHBOARD --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.dashboard') ? 'bg-white text-purple-900 font-bold shadow-lg shadow-black/10 scale-[1.02]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span class="text-sm">Dashboard</span>
                </a>

                {{-- MENU JADWAL --}}
                <a href="{{ route('admin.jadwal') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.jadwal*') ? 'bg-white text-purple-900 font-bold shadow-lg shadow-black/10 scale-[1.02]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm">Jadwal Siaran</span>
                </a>

                {{-- MENU RIWAYAT LOGIN --}}
                <a href="{{ route('admin.history') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.history*') ? 'bg-white text-purple-900 font-bold shadow-lg shadow-black/10 scale-[1.02]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm">Riwayat Login</span>
                </a>

                {{-- MENU MANAJEMEN STAF --}}
                <a href="{{ route('admin.staf.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.staf*') ? 'bg-white text-purple-900 font-bold shadow-lg shadow-black/10 scale-[1.02]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-sm">Manajemen Staf</span>
                </a>
            </nav>

            <div class="mt-auto p-6 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 px-4 py-3 bg-white/10 hover:bg-rose-500 text-white rounded-xl w-full transition-all duration-200 font-bold uppercase text-xs tracking-widest shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>
        @endif

        {{-- AREA KONTEN UTAMA --}}
        <main class="flex-1 w-full flex flex-col min-h-screen transition-all duration-300 {{ (Auth::check() && Auth::user()->role === 'admin') ? 'md:ml-64' : '' }}">
            
            @if(Auth::check() && Auth::user()->role === 'admin')
            <header class="bg-white/80 backdrop-blur-md p-4 flex justify-between items-center px-4 md:px-10 sticky top-0 z-30 border-b border-slate-100">
                
                <div class="flex items-center gap-4">
                    {{-- TOMBOL HAMBURGER MOBILE --}}
                    <button onclick="toggleSidebar()" class="md:hidden p-2.5 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    
                    <div>
                        <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight uppercase line-clamp-1">@yield('header_title')</h2>
                        <p class="text-[10px] md:text-[11px] text-slate-400 font-bold uppercase hidden sm:block">@yield('header_subtitle')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none mb-1">
                            Admin System
                        </p>
                        <p class="text-sm font-black text-slate-800">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md uppercase border-2 border-white ring-2 ring-slate-100">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>
            @endif

            <div class="p-4 md:p-10 flex-1">
                @yield('content')
            </div>
            
            @if(Auth::check() && Auth::user()->role === 'admin')
            <footer class="mt-auto px-10 py-6 border-t border-slate-100 bg-white/50 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">&copy; {{ date('Y') }} TayanganKu RBTV</p>
            </footer>
            @endif
        </main>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK TOGGLE MENU MOBILE --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }
    </script>
</body>
</html>