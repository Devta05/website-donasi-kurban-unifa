<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonasiRequest;
use App\Http\Requests\UploadBuktiRequest;
use App\Models\Donasi;
use App\Models\JenisDonasi;
use App\Models\ProfilMasjid;

class DonasiController extends Controller
{
    public function index()
    {
        $jenisDonasi = JenisDonasi::where("is_active", true)->get();

        return view("donasi.form", compact("jenisDonasi"));
    }

    public function store(DonasiRequest $request)
    {
        $data = $request->validated();
        $data["tanggal"] = now()->toDateString();

        session(["donasi_pending" => $data]);

        return redirect()->route("donasi.payment");
    }

    public function payment()
{
    $data = session('donasi_pending');

    if (! $data) {
        return redirect()->route('donasi.index')->with('error', 'Silakan isi form donasi terlebih dahulu.');
    }

    $jenis = JenisDonasi::find($data['jenis_donasi_id']);
    $profil = ProfilMasjid::first();

    return view('donasi.payment', compact('data', 'jenis', 'profil'));
}

    public function upload(UploadBuktiRequest $request)
    {
        $data = session("donasi_pending");

        if (! $data) {
            return redirect()->route("donasi.index")->with("error", "Sesi donasi tidak ditemukan, silakan ulangi.");
        }

        $path = $request->file("bukti_pembayaran")->store("bukti-donasi", "public");

        $donasi = Donasi::create([
            "kode_transaksi" => $this->generateKodeTransaksi(),
            "jenis_donasi_id" => $data["jenis_donasi_id"],
            "nama" => $data["nama"],
            "whatsapp" => $data["whatsapp"],
            "email" => $data["email"] ?? null,
            "nominal" => $data["nominal"],
            "pesan" => $data["pesan"] ?? null,
            "tanggal" => $data["tanggal"],
            "bukti_pembayaran" => $path,
            "status" => "menunggu_verifikasi",
        ]);

        session()->forget("donasi_pending");

        return redirect()->route("donasi.success", $donasi->kode_transaksi);
    }

    public function success(string $kode)
    {
        $donasi = Donasi::with("jenisDonasi")->where("kode_transaksi", $kode)->firstOrFail();

        return view("donasi.success", compact("donasi"));
    }

    private function generateKodeTransaksi(): string
    {
        $last = Donasi::orderByDesc("id")->first();
        $next = $last ? $last->id + 1 : 1;

        return "DON-" . str_pad((string) $next, 6, "0", STR_PAD_LEFT);
    }
}
