<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Pajaktenant;

class TransaksiController extends Controller
{
    public function pengunjung()
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('reservasi')->latest()->paginate(15);
        return view('pengunjung.transaksi', compact('transaksi'));
    }

    public function tenant()
    {
        $tenant    = Auth::user()->tenant;
        $transaksi = Transaksi::where('tenant_id', $tenant?->id)
            ->with('pajaktenant')->latest()->paginate(15);
        return view('tenant.transaksi', compact('transaksi'));
    }
}