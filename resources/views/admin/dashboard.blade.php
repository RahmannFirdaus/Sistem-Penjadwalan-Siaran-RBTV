@extends('layouts.app')

@section('header_title', 'Dashboard Panel')
@section('header_subtitle', 'Selamat datang! Kelola data siaran dan staf Anda dengan mudah.')

@section('content')
<div class="space-y-8">
    
    {{-- Banner Selamat Datang --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-12 text-white shadow-2xl shadow-blue-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-2xl">
            <h2 class="text-4xl font-black tracking-tighter leading-tight">
                Selamat Datang di Dashboard TayanganKu! 📺
            </h2>
            <p class="mt-4 text-blue-100 font-medium text-lg leading-relaxed">
                Kelola jadwal siaran, program TV, dan data staf Anda dengan mudah dalam satu platform.
            </p>

            <div class="flex flex-wrap gap-4 mt-10">
                <a href="{{ route('admin.jadwal') }}" class="bg-white text-blue-600 px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-slate-50 transition active:scale-95 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Lihat Jadwal
                </a>

                @if(auth()->user()->role === 'admin')
                <button onclick="window.location.href='{{ route('admin.jadwal') }}'" class="bg-blue-800/40 text-white border border-white/20 backdrop-blur-md px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-800/60 transition active:scale-95 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                    Tambah Program
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Statistik Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Total Program --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Program</p>
                <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $totalProgram }}</h3>
            </div>
            <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>

        {{-- Siaran Hari Ini --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siaran Hari Ini</p>
                <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $siaranHariIni }}</h3>
            </div>
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        {{-- Staf Aktif --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
            <div>
                {{-- UBAH DISINI: Dari "Staf Aktif" menjadi "Total Staf" --}}
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Staf</p>
                <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $totalStaf }}</h3>
            </div>
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Jadwal Terdekat Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-10">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-black text-slate-800 tracking-tighter uppercase">Jadwal Terdekat</h3>
            <a href="{{ route('admin.jadwal') }}" class="bg-blue-50 text-blue-600 px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse($jadwalTerdekat as $jadwal)
                <div class="flex items-center justify-between p-6 bg-slate-50/50 rounded-2xl border border-slate-100 hover:border-blue-200 transition-all group">
                    <div class="flex items-center gap-6">
                        <div class="bg-white shadow-sm border border-slate-100 p-3 rounded-xl text-blue-600 font-black text-sm">
                            {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }}
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 uppercase tracking-tight">{{ $jadwal->program_name }}</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest">DURASI: {{ $jadwal->duration }} MENIT</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Segera</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 border-2 border-dashed border-slate-100 rounded-3xl">
                    <p class="text-slate-300 font-bold uppercase tracking-widest text-xs">Belum ada jadwal dalam waktu dekat</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection