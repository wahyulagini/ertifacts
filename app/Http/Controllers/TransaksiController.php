<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\PajakTenant;

class TransaksiController extends Controller
{
    public function pengunjung()
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('reservasi')->latest()->paginate(15);
        return view('pengunjung.transaksi', compact('transaksi'));
    }

    public function Tenant()
    {
        $Tenant    = Auth::user()->Tenant;
        $transaksi = Transaksi::where('Tenant_id', $Tenant?->id)
            ->with('pajakTenant')->latest()->paginate(15);
        return view('Tenant.transaksi', compact('transaksi'));
    }
}