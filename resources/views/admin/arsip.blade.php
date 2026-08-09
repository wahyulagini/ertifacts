@extends('layouts.admin')

@section('title', 'Arsip Sejarah')
@section('page-title', 'Arsip Sejarah')
@section('page-subtitle', 'Dokumen, naskah, dan rekaman bersejarah koleksi museum')

@section('content')
{{-- Back Button --}}
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-800 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
            <i class="fa-solid fa-scroll text-emerald-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-brand-900">Arsip Sejarah</h1>
            <p class="text-brand-400 text-xs">{{ $arsip->total() }} arsip terdaftar</p>
        </div>
    </div>
    <a href="{{ route('admin.arsip.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
        <i class="fa-solid fa-plus"></i> Tambah Arsip
    </a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if($arsip->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-scroll text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada arsip terdaftar</p>
        <a href="{{ route('admin.arsip.create') }}" class="btn-primary mt-4 inline-flex">Tambah Sekarang</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($arsip as $item)
        @php
            $jenisColors = [
                'Naskah Kuno'           => ['bg'=>'bg-amber-100','text'=>'text-amber-700','border'=>'border-amber-200'],
                'Foto Bersejarah'       => ['bg'=>'bg-purple-100','text'=>'text-purple-700','border'=>'border-purple-200'],
                'Peta Kuno'             => ['bg'=>'bg-blue-100','text'=>'text-blue-700','border'=>'border-blue-200'],
                'Surat / Dokumen Resmi' => ['bg'=>'bg-orange-100','text'=>'text-orange-700','border'=>'border-orange-200'],
                'Rekaman Audio'         => ['bg'=>'bg-pink-100','text'=>'text-pink-700','border'=>'border-pink-200'],
                'Rekaman Video'         => ['bg'=>'bg-red-100','text'=>'text-red-700','border'=>'border-red-200'],
                'Laporan Arkeologi'     => ['bg'=>'bg-teal-100','text'=>'text-teal-700','border'=>'border-teal-200'],
                'Lainnya'               => ['bg'=>'bg-gray-100','text'=>'text-gray-700','border'=>'border-gray-200'],
            ];
            $color = $jenisColors[$item->jenis_koleksi] ?? $jenisColors['Lainnya'];
        @endphp
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group flex flex-col">
            {{-- Thumbnail / Icon area --}}
            <div class="relative h-36 overflow-hidden bg-gradient-to-br from-brand-50 to-brand-100">
                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul_arsip }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                {{-- Icon Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent flex items-end p-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fa-solid {{ $item->jenis_icon }} text-white text-sm"></i>
                        </div>
                        <span class="text-white text-xs font-bold">{{ $item->jenis_koleksi }}</span>
                    </div>
                </div>
                {{-- Publik Badge --}}
                @if($item->tersedia_publik)
                    <div class="absolute top-3 right-3">
                        <span class="bg-emerald-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">Publik</span>
                    </div>
                @else
                    <div class="absolute top-3 right-3">
                        <span class="bg-gray-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">Tertutup</span>
                    </div>
                @endif
            </div>

            <div class="p-4 flex flex-col flex-1">
                <p class="text-[10px] font-mono text-brand-400 mb-0.5">{{ $item->kode_arsip }}</p>
                <h3 class="font-bold text-brand-900 text-sm leading-snug mb-2">{{ $item->judul_arsip }}</h3>

                @if($item->deskripsi_isi)
                    <p class="text-xs text-brand-500 leading-relaxed line-clamp-3 flex-1">{{ $item->deskripsi_isi }}</p>
                @endif

                <div class="mt-3 pt-3 border-t border-brand-50 grid grid-cols-2 gap-1 text-[10px] text-brand-400">
                    @if($item->tahun_dokumen)
                        <span><i class="fa-solid fa-calendar-days mr-1 text-brand-300"></i>{{ $item->tahun_dokumen }}</span>
                    @endif
                    @if($item->asal_instansi)
                        <span class="truncate"><i class="fa-solid fa-building-columns mr-1 text-brand-300"></i>{{ $item->asal_instansi }}</span>
                    @endif
                    @if($item->bahasa)
                        <span><i class="fa-solid fa-language mr-1 text-brand-300"></i>{{ $item->bahasa }}</span>
                    @endif
                    @if($item->kondisi_fisik)
                        <span class="truncate"><i class="fa-solid fa-shield mr-1 text-brand-300"></i>{{ $item->kondisi_fisik }}</span>
                    @endif
                </div>
                <div class="mt-2 pt-2 border-t border-brand-50 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.arsip.edit', $item->id) }}" class="text-brand-500 hover:text-brand-700" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.arsip.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus arsip ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex justify-center">{{ $arsip->links() }}</div>
@endif
@endsection
