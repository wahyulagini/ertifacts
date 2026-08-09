@extends('layouts.admin')

@section('title', 'Tokoh Penting')
@section('page-title', 'Tokoh Penting')
@section('page-subtitle', 'Tokoh-tokoh bersejarah yang berkaitan dengan Lhokseumawe dan Samudera Pasai')

@section('content')
{{-- Back Button --}}
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-800 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
            <i class="fa-solid fa-person-chalkboard text-blue-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-brand-900">Tokoh Penting</h1>
            <p class="text-brand-400 text-xs">{{ $tokoh->total() }} tokoh terdaftar</p>
        </div>
    </div>
    <a href="{{ route('admin.tokoh.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
        <i class="fa-solid fa-plus"></i> Tambah Tokoh
    </a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if($tokoh->isEmpty())
    <div class="text-center py-20 text-brand-300">
        <i class="fa-solid fa-person-chalkboard text-6xl mb-4 block opacity-30"></i>
        <p class="font-semibold text-brand-400">Belum ada tokoh terdaftar</p>
        <a href="{{ route('admin.tokoh.create') }}" class="btn-primary mt-4 inline-flex">Tambah Sekarang</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($tokoh as $item)
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group">
            {{-- Foto & Identitas --}}
            <div class="relative">
                <div class="h-44 overflow-hidden bg-gradient-to-br from-brand-100 to-brand-200">
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_tokoh }}"
                        class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                </div>
                {{-- Era Badge --}}
                @if($item->era_aktif)
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-brand-900/80 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-full">
                            {{ $item->era_aktif }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-4">
                <h3 class="font-bold text-brand-900 text-base leading-tight">{{ $item->nama_tokoh }}</h3>
                @if($item->nama_julukan)
                    <p class="text-xs text-brand-400 italic mb-1">"{{ $item->nama_julukan }}"</p>
                @endif
                @if($item->gelar)
                    <span class="inline-block text-[10px] bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-full font-semibold mb-2">{{ $item->gelar }}</span>
                @endif

                @if($item->peran)
                    <p class="text-xs font-semibold text-brand-700 mb-2">
                        <i class="fa-solid fa-star text-amber-400 mr-1"></i>{{ $item->peran }}
                    </p>
                @endif

                @if($item->biografi)
                    <p class="text-xs text-brand-500 leading-relaxed line-clamp-3">{{ $item->biografi }}</p>
                @endif

                <div class="mt-3 pt-3 border-t border-brand-50 flex items-center justify-between text-[10px] text-brand-400">
                    <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $item->tempat_asal ?? 'Tidak diketahui' }}</span>
                    <span><i class="fa-solid fa-calendar mr-1"></i>{{ $item->periode_label }}</span>
                </div>
                <div class="mt-2 pt-2 border-t border-brand-50 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.tokoh.edit', $item->id) }}" class="text-brand-500 hover:text-brand-700" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.tokoh.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tokoh ini?');">
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
    <div class="flex justify-center">{{ $tokoh->links() }}</div>
@endif
@endsection
