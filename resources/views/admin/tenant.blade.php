@extends('layouts.admin')
@section('title', 'Kelola Permohonan Tenant')
@section('page-title', 'Kelola Permohonan Tenant')
@section('page-subtitle', 'Approve permohonan dan kelola tenant museum')

 

@section('content')

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-3 gap-3 mb-6">
    @foreach([
        ['Menunggu',  $stats['menunggu'] ?? 0, 'bg-yellow-50 border-yellow-200 text-yellow-700'],
        ['Aktif',     $stats['aktif']    ?? 0, 'bg-emerald-50 border-emerald-200 text-emerald-700'],
        ['Ditolak',   $stats['ditolak']  ?? 0, 'bg-red-50 border-red-200 text-red-700'],
    ] as [$label, $val, $cls])
    <div class="border rounded-xl px-4 py-3 {{ $cls }}">
        <p class="text-xs font-bold">{{ $label }}</p>
        <p class="font-serif text-2xl font-bold mt-0.5">{{ $val }}</p>
    </div>
    @endforeach
</div>

{{-- Filter --}}
<div class="flex gap-2 mb-4 flex-wrap">
    @foreach(['semua','menunggu','aktif','ditolak'] as $f)
    <a href="{{ request()->fullUrlWithQuery(['status' => $f === 'semua' ? '' : $f]) }}"
       class="text-xs font-semibold px-4 py-2 rounded-xl border transition-all
       {{ (request('status', '') === ($f === 'semua' ? '' : $f)) ? 'bg-brand-700 text-white border-brand-700' : 'bg-white text-brand-600 border-brand-200 hover:bg-brand-50' }}">
        {{ ucfirst($f) }}
    </a>
    @endforeach
</div>

{{-- Daftar tenant --}}
<div class="space-y-4">
    @forelse($tenants as $t)
    <div class="bg-white rounded-2xl border border-brand-200 p-5 hover:shadow-md transition-all">
        <div class="flex flex-col sm:flex-row sm:items-start gap-4">

            <div class="flex items-start gap-4 flex-1 min-w-0">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-lg shrink-0">
                    {{ strtoupper(substr($t->nama_tenant, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-bold text-brand-900">{{ $t->nama_tenant }}</h3>
                        @php
                            $sc = match($t->status) {
                                'aktif'    => 'badge-green',
                                'menunggu' => 'badge-yellow',
                                'ditolak'  => 'badge-red',
                                default    => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $sc }}">{{ ucfirst($t->status) }}</span>
                    </div>
                    <p class="text-xs text-brand-500 mt-0.5">{{ $t->jenis_usaha }} · {{ $t->lokasi_di_museum ?? 'Lokasi belum ditentukan' }}</p>
                    <p class="text-xs text-brand-400 mt-0.5">
                        <i class="fa-solid fa-user text-[10px] mr-1"></i>{{ $t->user->name ?? '-' }} — {{ $t->user->email ?? '' }}
                    </p>
                    @if($t->deskripsi)
                    <p class="text-xs text-brand-600 mt-2 leading-relaxed">{{ $t->deskripsi }}</p>
                    @endif
                    @if($t->status === 'aktif')
                    <div class="flex gap-4 mt-2 text-xs text-brand-500">
                        <span><i class="fa-solid fa-money-bill text-brand-gold mr-1"></i>Sewa: Rp {{ number_format($t->tarif_sewa, 0, ',', '.') }}/bln</span>
                        <span><i class="fa-solid fa-percent text-brand-gold mr-1"></i>Pajak: {{ $t->persentase_pajak }}%</span>
                    </div>
                    @endif
                    @if($t->catatan_admin)
                    <p class="text-[11px] text-brand-400 mt-1 italic">Catatan: {{ $t->catatan_admin }}</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @if($t->status === 'menunggu')
                <button onclick="openTenantModal('setuju', {{ $t->id }}, '{{ $t->nama_tenant }}')"
                    class="flex items-center gap-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-xs font-semibold px-3 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-check"></i> Setujui
                </button>
                <button onclick="openTenantModal('tolak', {{ $t->id }}, '{{ $t->nama_tenant }}')"
                    class="flex items-center gap-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-xmark"></i> Tolak
                </button>
                @elseif($t->status === 'aktif')
                <form method="POST" action="{{ route('admin.tenant.tolak', $t->id) }}"
                      onsubmit="return confirm('Nonaktifkan tenant ini?')">
                    @csrf
                    <input type="hidden" name="catatan" value="Dinonaktifkan oleh admin">
                    <button class="flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-2 rounded-xl transition-colors">
                        <i class="fa-solid fa-ban"></i> Nonaktifkan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-brand-200 py-20 flex flex-col items-center text-center">
        <i class="fa-solid fa-store text-4xl text-brand-200 mb-4"></i>
        <p class="font-bold text-brand-600">Tidak ada tenant ditemukan</p>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $tenants->links() }}</div>

{{-- Modal Setujui/Tolak tenant --}}
<div id="tenant-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-brand-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-brand-100">
            <h3 id="tenant-modal-title" class="font-bold text-brand-900"></h3>
            <p id="tenant-modal-subtitle" class="text-xs text-brand-400 mt-0.5"></p>
        </div>
        <form id="tenant-modal-form" method="POST" class="p-6 space-y-4">
            @csrf

            <div id="tenant-setuju-fields" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                            Tarif Sewa/Bulan (Rp) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="tarif_sewa" min="0" step="50000"
                            class="w-full border-2 border-brand-200 rounded-xl px-3 py-2 text-sm focus:border-brand-gold focus:outline-none"
                            placeholder="1500000">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                            Pajak (%) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="persentase_pajak" min="0" max="100" step="0.5" value="10"
                            class="w-full border-2 border-brand-200 rounded-xl px-3 py-2 text-sm focus:border-brand-gold focus:outline-none">
                    </div>
                </div>
                <div class="bg-brand-50 border border-brand-200 rounded-xl px-3 py-2 text-xs text-brand-600 flex gap-2">
                    <i class="fa-solid fa-circle-info text-brand-gold shrink-0 mt-0.5"></i>
                    Pajak dihitung otomatis dari setiap pendapatan tenant yang tercatat.
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-brand-700 uppercase tracking-wider block mb-1.5">
                    Catatan <span class="text-brand-400 font-normal">(opsional)</span>
                </label>
                <textarea name="catatan" rows="2" id="tenant-catatan"
                    class="w-full border-2 border-brand-200 rounded-xl px-4 py-2.5 text-sm focus:border-brand-gold focus:outline-none resize-none"
                    placeholder="Catatan untuk tenant..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeTenantModal()"
                    class="btn-outline flex-1 justify-center py-2.5">Batal</button>
                <button type="submit" id="tenant-modal-submit"
                    class="btn-primary flex-1 justify-center py-2.5"></button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openTenantModal(action, id, nama) {
    const modal   = document.getElementById('tenant-modal');
    const form    = document.getElementById('tenant-modal-form');
    const title   = document.getElementById('tenant-modal-title');
    const sub     = document.getElementById('tenant-modal-subtitle');
    const submit  = document.getElementById('tenant-modal-submit');
    const fields  = document.getElementById('tenant-setuju-fields');
    const catatan = document.getElementById('tenant-catatan');
    catatan.value = '';

    if (action === 'setuju') {
        form.action = `/admin/tenant/${id}/setuju`;
        title.textContent = 'Setujui Permohonan Tenant';
        sub.textContent = nama;
        submit.textContent = '✓ Setujui & Aktifkan';
        submit.className = 'btn-primary flex-1 justify-center py-2.5';
        fields.style.display = 'block';
        fields.querySelectorAll('input').forEach(i => i.required = true);
    } else {
        form.action = `/admin/tenant/${id}/tolak`;
        title.textContent = 'Tolak Permohonan Tenant';
        sub.textContent = nama;
        submit.textContent = '✕ Tolak Permohonan';
        submit.className = 'btn-primary flex-1 justify-center py-2.5 !bg-red-600';
        fields.style.display = 'none';
        fields.querySelectorAll('input').forEach(i => i.required = false);
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTenantModal() {
    const modal = document.getElementById('tenant-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('tenant-modal').addEventListener('click', function(e) {
    if (e.target === this) closeTenantModal();
});
</script>
@endpush
@endsection