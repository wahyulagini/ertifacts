<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Tenant;

class RegisterController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        $events = \App\Models\Event::whereIn('status', ['berjalan', 'akan datang'])->get();
        return view('auth.register', compact('events'));
    }

    public function store(Request $request)
    {
        // Debug: pastikan role yang dikirim benar
        // dd($request->all()); // uncomment jika masih error

        $rules = [
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            // ✅ Hanya terima 'pengunjung' atau 'tenant' — BUKAN 'visitor' atau 'tenant'
            'role'     => ['required', 'in:pengunjung,tenant'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];

        if ($request->role === 'tenant') {
            $rules['event_id']    = ['required', 'exists:events,id'];
            $rules['nama_tenant'] = ['required', 'string', 'max:150'];
            $rules['jenis_usaha'] = ['required', 'string', 'max:100'];
            $rules['deskripsi']   = ['nullable', 'string', 'max:500'];
        }

        $validated = $request->validate($rules, [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'role.required'         => 'Pilih jenis akun.',
            'role.in'               => 'Jenis akun tidak valid. Pilih Pengunjung atau tenant.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.confirmed'    => 'Konfirmasi sandi tidak cocok.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'event_id.required'     => 'Anda harus memilih event untuk mendaftar sebagai tenant.',
            'event_id.exists'       => 'Event yang dipilih tidak valid.',
            'nama_tenant.required'  => 'Nama usaha wajib diisi.',
            'jenis_usaha.required'  => 'Jenis usaha wajib dipilih.',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $request->phone ?? null,
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Kalau tenant → simpan ke tabel tenants
        if ($validated['role'] === 'tenant') {
            Tenant::create([
                'user_id'          => $user->id,
                'event_id'         => $validated['event_id'],
                'nama_tenant'      => $validated['nama_tenant'],
                'jenis_usaha'      => $validated['jenis_usaha'],
                'deskripsi'        => $request->deskripsi ?? null,
                'lokasi_di_museum' => $request->lokasi_di_museum ?? null,
                'persentase_pajak' => 10.00,
                'status'           => 'menunggu',
            ]);
        }

        Auth::login($user);

        return $this->redirectByRole($user->role)
            ->with('success', $user->role === 'tenant'
                ? 'Akun tenant berhasil dibuat! Menunggu persetujuan admin.'
                : 'Selamat datang di E-RTIFACT, ' . $user->name . '!'
            );
    }

    public function adminShowForm()
    {
        return view('admin.users.create');
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:150'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'role'             => ['required', 'in:pengunjung,tenant,admin'],
            'password'         => ['required', Password::min(8)],
            'nama_tenant'      => ['required_if:role,tenant', 'nullable', 'string', 'max:150'],
            'jenis_usaha'      => ['required_if:role,tenant', 'nullable', 'string', 'max:100'],
            'tarif_sewa'       => ['nullable', 'numeric', 'min:0'],
            'persentase_pajak' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $request->phone ?? null,
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($validated['role'] === 'tenant') {
            Tenant::create([
                'user_id'          => $user->id,
                'nama_tenant'      => $validated['nama_tenant'],
                'jenis_usaha'      => $validated['jenis_usaha'],
                'tarif_sewa'       => $validated['tarif_sewa'] ?? 0,
                'persentase_pajak' => $validated['persentase_pajak'] ?? 10.00,
                'status'           => 'aktif',
                'disetujui_pada'   => now(),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$user->name} berhasil ditambahkan.");
    }

    private function redirectByRole(string $role)
    {
        return match($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'tenant'  => redirect()->route('tenant.dashboard'),
            default  => redirect()->route('pengunjung.dashboard'),
        };
    }
}
