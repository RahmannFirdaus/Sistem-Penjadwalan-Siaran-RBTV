<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - RBTV Camkoha</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_tayanganKu.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center justify-between font-sans relative overflow-hidden" style="background: linear-gradient(to right, #0b092b 0%, #b8061c 50%, #0b092b 100%);">

    {{-- KONTEN UTAMA (CARD) --}}
    <div class="w-full flex-grow flex flex-col items-center justify-center p-4 z-10">
        {{-- Card dibuat lebih compact dengan p-8 dan max-w-sm --}}
        <div class="w-full max-w-sm bg-white/10 backdrop-blur-md border border-white/20 rounded-[2rem] p-8 shadow-2xl flex flex-col items-center text-center transition-all hover:bg-white/15">
            
            {{-- Logo diperkecil dari w-48 ke w-32 agar card tidak terlalu panjang --}}
            <img src="{{ asset('img/RBTV_Bengkulu.webp') }}" alt="Logo RBTV" class="w-32 h-32 object-contain mb-2 drop-shadow-xl">
            
            <h1 class="text-white text-2xl font-black italic tracking-tight uppercase mb-1">RBTV Camkoha</h1>
            <p class="text-white/70 text-[11px] font-medium mb-8">Sistem Manajemen Penjadwalan Siaran</p>

            @if ($errors->any())
                <div class="w-full bg-rose-500/20 border border-rose-500/50 text-rose-200 p-3 rounded-xl text-[10px] font-bold mb-6 flex items-center gap-2 backdrop-blur-sm">
                    <span class="text-left">{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="w-full">
                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-slate-50 text-slate-800 font-black py-4 px-6 rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 group text-xs">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
            </div>
        </div>
    </div>

{{-- FOOTER --}}
<div class="w-full p-6 z-10">
    <div class="flex flex-col items-center justify-center relative gap-4">
        <p class="text-white/40 text-[10px] tracking-[0.2em] uppercase font-black text-center">
            © 2026 RBTV Bengkulu
        </p>
    </div>
</div>

</body>
</html>