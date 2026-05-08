@extends('layouts.app')

@section('header_title', 'Riwayat Login User')

@section('content')
<div class="space-y-6">
    {{-- Header Card --}}
    <div class="bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden relative">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#6b21a8] to-[#be123c] absolute top-0 left-0"></div>
        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-purple-100 to-rose-100 p-3.5 rounded-2xl shadow-inner border border-white">
                        <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 21a9.994 9.994 0 007.137-3.003l.053.09a2.43 2.43 0 01-.115 2.502A2.674 2.674 0 0116.92 21H7.08a2.674 2.674 0 01-2.155-1.411 2.43 2.43 0 01-.115-2.502zM12 7a3 3 0 100-6 3 3 0 000 6z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-[#6b21a8] to-[#be123c] tracking-tight uppercase">Riwayat Login</h3>
                        <p class="text-[11px] text-slate-500 font-bold uppercase tracking-[0.1em] mt-1">LOG AKTIVITAS MASUK SISTEM RBTV</p>
                    </div>
                </div>
                <a href="{{ route('admin.history.export', ['date' => request('date')]) }}" class="bg-emerald-600 px-6 py-2.5 rounded-xl text-xs font-black text-white hover:bg-emerald-700 transition-all shadow-lg flex items-center gap-2 uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export CSV
                </a>
            </div>

            {{-- Form Filter --}}
            <form action="{{ route('admin.history') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4 bg-slate-50/50 p-2 rounded-2xl border border-slate-100">
                <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-5 py-3 w-full lg:w-auto shadow-sm">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Tanggal:</span>
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="bg-transparent text-sm font-black text-slate-700 border-none p-0 focus:ring-0 w-[130px] cursor-pointer text-center">
                </div>

                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau Email User..." class="w-full bg-white border border-slate-200 rounded-xl pl-12 pr-4 py-3.5 text-sm font-semibold text-slate-700 outline-none focus:border-purple-400 transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/></svg>
                </div>
                <button type="submit" class="bg-slate-800 text-white px-8 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all">Cari</button>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">User</th>
                        <th class="px-8 py-5">Role</th>
                        <th class="px-8 py-5">IP Address</th>
                        <th class="px-8 py-5">Waktu Login</th>
                        <th class="px-8 py-5">Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($histories as $log)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="px-8 py-6">
                            <div class="font-black text-slate-800 uppercase">{{ $log->user->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold">{{ $log->user->email }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="{{ $log->user->role === 'admin' ? 'bg-purple-600' : 'bg-blue-600' }} text-white px-4 py-1.5 rounded-lg text-[10px] font-black uppercase shadow-md">
                                {{ $log->user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6 font-mono text-xs text-slate-600 font-black tracking-tighter">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-8 py-6 text-slate-700 font-black">
                            {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </td>
                        <td class="px-8 py-6 text-[10px] text-slate-400 font-medium max-w-xs truncate" title="{{ $log->user_agent }}">
                            {{ $log->user_agent ?? 'Tidak Terdeteksi' }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-24 text-center text-slate-300 font-black uppercase italic tracking-widest">Tidak ada riwayat ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- PAGINATION LINKS --}}
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection