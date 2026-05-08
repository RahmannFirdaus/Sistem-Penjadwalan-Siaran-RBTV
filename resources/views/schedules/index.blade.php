@extends('layouts.app')

@section('header_title', 'Manajemen Jadwal Siaran')

@section('content')
@php
    $canManage = auth()->user()->role === 'admin';
@endphp

<div class="space-y-6">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in duration-300 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Gagal/Error (DITAMBAHKAN) --}}
    @if($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in duration-300">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-semibold ml-8">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header Card --}}
    <div class="bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden relative">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#6b21a8] to-[#be123c] absolute top-0 left-0"></div>
        
        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-purple-100 to-rose-100 p-3.5 rounded-2xl shadow-inner border border-white">
                        <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-[#6b21a8] to-[#be123c] tracking-tight uppercase">Jadwal Siaran Harian</h3>
                        <p class="text-[11px] text-slate-500 font-bold uppercase tracking-[0.1em] mt-1">
                            MENAMPILKAN {{ $schedules->count() }} PROGRAM • {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3 items-center w-full md:w-auto">
                    @if(!$canManage)
                    <form action="{{ route('logout') }}" method="POST" class="m-0 flex-1 md:flex-none">
                        @csrf
                        <button type="submit" class="w-full justify-center bg-rose-50 border border-rose-200 px-5 py-2.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Keluar
                        </button>
                    </form>
                    @endif

                {{-- TOMBOL EXPORT (DIBUAT TERSEDIA UNTUK ADMIN DAN STAF) --}}
                     @if($canManage)
                        {{-- Tombol Export Milik Admin --}}
                         <a href="{{ route('schedules.export', ['date' => $date]) }}" class="flex-1 md:flex-none justify-center bg-emerald-600 border border-emerald-700 px-5 py-2.5 rounded-xl text-xs font-bold text-white hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export Excel
                         </a>
                    @else
                        {{-- Tombol Export Milik Staf (Mengarah ke rute staf) --}}
                        <a href="{{ route('staf.jadwal.export', ['date' => $date]) }}" class="flex-1 md:flex-none justify-center bg-emerald-500 border border-emerald-600 px-5 py-2.5 rounded-xl text-xs font-bold text-white hover:bg-emerald-600 transition-all shadow-sm flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export Excel
                        </a>
                     @endif
                    
                    
                    <button onclick="window.location.reload()" class="justify-center bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </div>
            </div>

            {{-- BARIS FILTER --}}
            <form action="{{ $canManage ? route('admin.jadwal') : route('dashboard') }}" method="GET" id="filterForm" class="flex flex-col lg:flex-row items-center gap-4 bg-slate-50/50 p-2 rounded-2xl border border-slate-100">
                <div class="flex items-center justify-between lg:justify-start gap-4 bg-white border border-slate-200 rounded-xl px-5 py-3 w-full lg:w-auto shadow-sm">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest hidden sm:block">Tanggal:</span>
                    <div class="flex items-center gap-4">
                        @php
                            $prevDate = \Carbon\Carbon::parse($date)->subDay()->toDateString();
                            $nextDate = \Carbon\Carbon::parse($date)->addDay()->toDateString();
                        @endphp
                        <a href="{{ ($canManage ? route('admin.jadwal') : route('dashboard')) . '?date=' . $prevDate }}" class="text-slate-400 hover:text-purple-600 font-bold bg-slate-50 w-6 h-6 flex items-center justify-center rounded-md">&lt;</a>
                        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="bg-transparent text-sm font-black text-slate-700 border-none p-0 focus:ring-0 w-[120px] cursor-pointer text-center">
                        <a href="{{ ($canManage ? route('admin.jadwal') : route('dashboard')) . '?date=' . $nextDate }}" class="text-slate-400 hover:text-purple-600 font-bold bg-slate-50 w-6 h-6 flex items-center justify-center rounded-md">&gt;</a>
                    </div>
                </div>

                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jadwal program..." class="w-full bg-white border border-slate-200 rounded-xl pl-12 pr-4 py-3.5 text-sm font-semibold text-slate-700 outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10 transition-all shadow-sm">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/></svg>
                </div>
                
                @if($canManage)
                <button type="button" onclick="toggleModal('modalTambah')" class="w-full lg:w-auto bg-gradient-to-r from-[#6b21a8] to-[#be123c] text-white px-8 py-3.5 rounded-xl text-xs font-bold shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah
                </button>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-purple-50 to-rose-50 text-slate-700 text-[10px] font-black uppercase tracking-[0.2em] border-b border-purple-100">
                    <tr>
                        <th class="px-8 py-5">Waktu Tayang</th>
                        <th class="px-8 py-5">Nama Program</th>
                        <th class="px-8 py-5">Durasi</th>
                        <th class="px-8 py-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($schedules as $item)
                    @php
                        $now = \Carbon\Carbon::now('Asia/Jakarta');
                        $startTime = \Carbon\Carbon::parse($item->date . ' ' . $item->start_time, 'Asia/Jakarta');
                        $endTime = \Carbon\Carbon::parse($item->date . ' ' . $item->end_time, 'Asia/Jakarta');
                        
                        if ($now->lt($startTime)) { 
                            $statusText = 'SIAP'; 
                            $statusStyle = 'bg-blue-600 text-white shadow-lg';
                            $timeColor = 'text-blue-700';
                        }
                        elseif ($now->between($startTime, $endTime)) { 
                            $statusText = 'BERLANGSUNG'; 
                            $statusStyle = 'bg-rose-600 text-white shadow-xl shadow-rose-400/50 animate-pulse';
                            $timeColor = 'text-rose-600 font-black';
                        }
                        else { 
                            $statusText = 'SELESAI'; 
                            $statusStyle = 'bg-emerald-600 text-white shadow-md';
                            $timeColor = 'text-slate-400';
                        }
                    @endphp
                    <tr @if($canManage) onclick="toggleActions('action-{{ $item->id }}')" @endif class="hover:bg-purple-50/40 transition duration-200 @if($canManage) cursor-pointer @else cursor-default @endif relative group">
                        <td class="px-8 py-6 font-bold {{ $timeColor }} flex items-center gap-3">
                            <div class="bg-white p-2 rounded-lg shadow-sm border border-slate-100">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            </div>
                            <span class="text-base">{{ date('H:i', strtotime($item->start_time)) }} - {{ date('H:i', strtotime($item->end_time)) }}</span>
                        </td>
                        <td class="px-8 py-6 font-black text-slate-800 tracking-tight uppercase text-base">{{ $item->program_name }}</td>
                        <td class="px-8 py-6">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-black italic">
                                {{ $item->duration }} MENIT
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center relative">
                            <span class="{{ $statusStyle }} px-6 py-2.5 rounded-xl text-[10px] font-black uppercase inline-block min-w-[130px] tracking-widest transition-all">
                                {{ $statusText }}
                            </span>
                            
                            @if($canManage)
                            <div id="action-{{ $item->id }}" class="hidden absolute right-4 top-1/2 -translate-y-1/2 bg-white shadow-2xl border border-purple-100 rounded-xl p-1.5 z-10 flex gap-1 animate-in fade-in zoom-in duration-200">
                                <button onclick="event.stopPropagation(); openEditModal({{ json_encode($item) }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>
                                <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal?')" class="inline">@csrf @method('DELETE')<button onclick="event.stopPropagation()" type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-24 text-center text-slate-400 font-bold uppercase tracking-widest">Tidak ada jadwal siaran hari ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
@if($canManage)
<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200 relative">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#6b21a8] to-[#be123c] absolute top-0 left-0"></div>
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white mt-1">
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Tambah Jadwal Baru</h3>
            <button onclick="toggleModal('modalTambah')" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="p-8 bg-slate-50/50 text-left">
            @csrf 
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal *</label><input type="date" name="date" value="{{ $date }}" required class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10 transition-all font-bold text-sm shadow-sm"></div>
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Program *</label><input type="text" name="program_name" required placeholder="Cth: Lintas Sore" class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10 transition-all font-bold text-sm shadow-sm"></div>
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jam Tayang *</label><input type="time" name="start_time" required class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10 transition-all font-bold text-sm shadow-sm"></div>
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Durasi (Menit) *</label><input type="number" name="duration" min="1" required placeholder="60" class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-500/10 transition-all font-bold text-sm shadow-sm"></div>
            </div>
            <div class="mt-8 flex gap-3 pt-6 border-t border-slate-200/60">
                <button type="submit" class="flex-1 bg-gradient-to-r from-[#6b21a8] to-[#be123c] text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:shadow-lg transition-all active:scale-[0.98]">Simpan Data</button>
                <button type="button" onclick="toggleModal('modalTambah')" class="px-8 bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200 animate-in fade-in zoom-in duration-200 relative">
        <div class="h-1.5 w-full bg-blue-600 absolute top-0 left-0"></div>
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white mt-1">
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Update Jadwal</h3>
            <button onclick="toggleModal('modalEdit')" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="formEdit" action="" method="POST" class="p-8 bg-slate-50/50 text-left">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2"><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Program</label><input type="text" name="program_name" id="edit_name" required class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-blue-400 transition-all font-bold text-sm shadow-sm"></div>
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jam Tayang</label><input type="time" name="start_time" id="edit_start" required class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-blue-400 transition-all font-bold text-sm shadow-sm"></div>
                <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Durasi (Menit)</label><input type="number" name="duration" id="edit_duration" min="1" required class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 outline-none focus:border-blue-400 transition-all font-bold text-sm shadow-sm"></div>
            </div>
            <div class="mt-8 flex gap-3 pt-6 border-t border-slate-200/60">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg active:scale-[0.98]">Update Data</button>
                <button type="button" onclick="toggleModal('modalEdit')" class="px-8 bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-[10px] uppercase tracking-widest">Batal</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    function toggleModal(id) { 
        const el = document.getElementById(id);
        if(el) el.classList.toggle('hidden'); 
    }
    
    @if($canManage)
    function toggleActions(id) {
        document.querySelectorAll('[id^="action-"]').forEach(el => { if (el.id !== id) el.classList.add('hidden'); });
        const actionMenu = document.getElementById(id);
        if(actionMenu) actionMenu.classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('tr')) { document.querySelectorAll('[id^="action-"]').forEach(el => el.classList.add('hidden')); }
    });

    function openEditModal(data) {
        document.getElementById('formEdit').action = '/admin/jadwal/' + data.id;
        document.getElementById('edit_name').value = data.program_name;
        document.getElementById('edit_start').value = data.start_time.substring(0, 5);
        document.getElementById('edit_duration').value = data.duration;
        toggleModal('modalEdit');
    }
    @endif
</script>
@endsection