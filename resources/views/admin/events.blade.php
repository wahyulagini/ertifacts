@extends('layouts.dashboard')

@section('title', 'Manajemen Event')
@section('page-title', 'Manajemen Event')
@section('page-subtitle', 'Daftar event yang diselenggarakan di area museum')

@section('content')
<div class="bg-white rounded-2xl border border-brand-200 overflow-hidden">
    <div class="p-5 border-b border-brand-100 flex justify-between items-center">
        <h3 class="font-bold text-brand-800">Daftar Event</h3>
        <a href="{{ route('admin.events.create') }}" class="btn-primary py-2 px-4 text-sm">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Event
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-brand-50 border-b border-brand-100">
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Judul Event</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Tanggal</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Status</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Kuota/Sewa</th>
                    <th class="py-3 px-5 text-xs font-bold text-brand-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr class="border-b border-brand-50 hover:bg-brand-50">
                    <td class="py-3 px-5 font-medium text-brand-900">{{ $event->judul_event }}</td>
                    <td class="py-3 px-5 text-sm text-brand-600">
                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td class="py-3 px-5">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $event->status == 'berjalan' ? 'green' : 'blue' }}-100 text-{{ $event->status == 'berjalan' ? 'green' : 'blue' }}-800">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-5 text-sm text-brand-600">
                        {{ $event->kuota_tenant }} Tenant<br>
                        Rp {{ number_format($event->harga_sewa_booth, 0, ',', '.') }}
                    </td>
                    <td class="py-3 px-5 flex gap-2">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-brand-500 hover:text-brand-700" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-5 text-center text-gray-500">Belum ada event yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
    <div class="p-4 border-t border-brand-100">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
