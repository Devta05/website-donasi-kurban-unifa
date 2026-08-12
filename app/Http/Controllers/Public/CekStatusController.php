<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Kurban;
use Illuminate\Http\Request;

class CekStatusController extends Controller
{
    public function index()
    {
        return view("cek-status.index");
    }

    public function cek(Request $request)
    {
        $request->validate([
            "kode_transaksi" => ["required", "string"],
        ], [
            "kode_transaksi.required" => "Kode transaksi wajib diisi.",
        ]);

        $kode = $request->kode_transaksi;
        $data = null;
        $tipe = null;

        if (str_starts_with(strtoupper($kode), "DON-")) {
            $data = Donasi::with("jenisDonasi")->where("kode_transaksi", $kode)->first();
            $tipe = "donasi";
        } elseif (str_starts_with(strtoupper($kode), "KRB-")) {
            $data = Kurban::with("paketKurban")->where("kode_transaksi", $kode)->first();
            $tipe = "kurban";
        }

        $sudahDicari = true;

        return view("cek-status.index", compact("data", "tipe", "kode", "sudahDicari"));
    }
}