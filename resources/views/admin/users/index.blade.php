@extends('layouts.admin')

@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')
@section('page-subtitle', 'Kelola semua akun pengguna di sistem')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-brand-900">Data Pengguna</h1>
        <p class="text-brand-500 text-sm">Daftar pengunjung, tenant, dan admin</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-600 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Nama Lengkap</th>
                <th class="text-left px-5 py-3">Email</th>
                <th class="text-left px-5 py-3">No. HP</th>
                <th class="text-center px-5 py-3">Peran (Role)</th>
                <th class="text-left px-5 py-3">Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
                <tr class="border-t border-brand-50 hover:bg-brand-50 transition">
                    <td class="px-5 py-3 font-semibold text-brand-800">{{ $u->name }}</td>
                    <td class="px-5 py-3 text-brand-600">{{ $u->email }}</td>
                    <td class="px-5 py-3 text-brand-500">{{ $u->phone ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $roleColors = [
                                'admin' => 'bg-red-100 text-red-700',
                                'tenant' => 'bg-amber-100 text-amber-700',
                                'pengunjung' => 'bg-emerald-100 text-emerald-700',
                            ];
                            $color = $roleColors[$u->role] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="{{ $color }} text-[10px] font-bold px-2 py-1 rounded-md uppercase">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-brand-500 text-xs">
                        {{ $u->created_at->format('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-brand-400">
                        <i class="fa-solid fa-users text-3xl mb-2 opacity-50 block"></i>
                        Belum ada data pengguna
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-brand-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
