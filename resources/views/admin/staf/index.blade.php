@extends('layouts.app')

@section('header_title', 'Whitelist Staf RBTV')
@section('header_subtitle', 'Kelola hak akses login aplikasi untuk para staf.')

@section('content')
<div class="space-y-6">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in duration-300 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 px-6 py-4 rounded-xl font-bold shadow-sm animate-in fade-in duration-300">
            <ul class="list-disc list-inside text-xs font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="h-1.5 w-full bg-gradient-to-r from-purple-600 to-rose-600 absolute top-0 left-0"></div>
        <div class="p-8 md:p-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-3xl font-black bg-clip-text text-transparent bg-gradient-to-r from-purple-700 to-rose-600 uppercase tracking-tighter leading-none mb-2">
                    Manajemen<br>Staf
                </h2>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em]">
                    Whitelist Email Staf<br>Untuk Login 
                </p>
            </div>
            
            <button onclick="toggleModal('modalTambahStaf')" class="bg-slate-800 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-slate-700 transition-all active:scale-95 flex items-center gap-3 whitespace-nowrap w-full md:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Staf
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] text-slate-500 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                        <th class="px-8 py-6">Nama Staf</th>
                        <th class="px-8 py-6">Email Google</th>
                        <th class="px-8 py-6 text-center">Hak Akses</th>
                        <th class="px-8 py-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($staf as $item)
                    <tr class="hover:bg-slate-50/80 transition duration-200">
                        <td class="px-8 py-6">
                            <span class="text-base font-black text-slate-800 uppercase tracking-tight">{{ $item->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-500">{{ $item->email }}</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($item->role === 'admin')
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Admin</span>
                            @else
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Staf</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- PENGAMANAN: Cek apakah data ini BUKAN milik user yang sedang login --}}
                                @if($item->id !== auth()->user()->id)
                                    
                                    {{-- Tombol Edit (Hanya muncul untuk akun orang lain) --}}
                                    <button onclick="openEditModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->email }}', '{{ $item->role }}')" class="bg-blue-50 text-blue-600 p-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm group relative" title="Edit Akun">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    {{-- Form Hapus Data (Hanya muncul untuk akun orang lain) --}}
                                    <form action="{{ route('admin.staf.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut akses staf ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-600 p-2.5 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm group relative" title="Hapus Akses">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>

                                @else
                                    {{-- Label "Akun Anda" sebagai pengganti tombol Edit & Hapus --}}
                                    <span class="bg-slate-100 text-slate-400 p-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center h-10 px-4 cursor-not-allowed border border-slate-200/50" title="Anda tidak bisa mengubah akun yang sedang digunakan">
                                        Akun Anda
                                    </span>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                            Belum ada staf yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL TAMBAH STAF --}}
<div id="modalTambahStaf" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200 relative">
        <div class="h-1.5 w-full bg-slate-800 absolute top-0 left-0"></div>
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white mt-1">
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Whitelist Staf Baru</h3>
            <button onclick="toggleModal('modalTambahStaf')" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.staf.store') }}" method="POST" class="p-8 text-left">
            @csrf 
            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" required placeholder="Masukkan nama staf" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-sm shadow-sm text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email Google (@gmail.com) *</label>
                    <input type="email" name="email" required placeholder="contoh@gmail.com" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-sm shadow-sm text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Hak Akses (Role) *</label>
                    <select name="role" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-sm shadow-sm text-slate-700">
                        <option value="staf">Staf Biasa</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex gap-3 pt-6 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-slate-800 text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-700 shadow-lg transition-all active:scale-[0.98]">
                    Simpan & Whitelist
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT STAF --}}
<div id="modalEditStaf" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200 relative">
        <div class="h-1.5 w-full bg-blue-600 absolute top-0 left-0"></div>
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white mt-1">
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Edit Akun</h3>
            <button onclick="toggleModal('modalEditStaf')" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="formEditStaf" method="POST" class="p-8 text-left">
            @csrf 
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap *</label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 font-bold text-sm text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email Google *</label>
                    <input type="email" id="edit_email" name="email" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 font-bold text-sm text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Hak Akses (Role) *</label>
                    <select id="edit_role" name="role" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 font-bold text-sm text-slate-700">
                        <option value="staf">Staf Biasa</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex gap-3 pt-6 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 shadow-lg transition-all active:scale-[0.98]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function toggleModal(id) { 
        const el = document.getElementById(id);
        if(el) el.classList.toggle('hidden'); 
    }

    function openEditModal(id, name, email, role) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('formEditStaf').action = '/admin/staf/' + id;
        toggleModal('modalEditStaf');
    }
</script>
@endsection