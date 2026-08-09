@extends('layouts.app')

@section('title', 'Daftar Tenant Event - E-RTIFACT')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Daftar Tenant Event
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Pilih event dan lengkapi data usaha Anda
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form action="{{ route('Tenant.daftar.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Event</label>
                    <div class="mt-1">
                        <select name="event_id" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->judul_event }} (Mulai: {{ \Carbon\Carbon::parse($ev->tanggal_mulai)->format('d M Y') }}) - Rp {{ number_format($ev->harga_sewa_booth, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('event_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Usaha / Tenant</label>
                    <div class="mt-1">
                        <input type="text" name="nama_Tenant" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('nama_Tenant') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Usaha</label>
                    <div class="mt-1">
                        <select name="jenis_usaha" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Jenis Usaha --</option>
                            <option value="Makanan & Minuman">Makanan & Minuman</option>
                            <option value="Cendera Mata">Cendera Mata / Souvenir</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('jenis_usaha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Kontak (WA)</label>
                    <div class="mt-1">
                        <input type="text" name="no_kontak" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                    <div class="mt-1">
                        <textarea name="deskripsi" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Daftar Tenant Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
