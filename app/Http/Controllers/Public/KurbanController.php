<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\KurbanRequest;
use App\Http\Requests\UploadBuktiRequest;
use App\Models\Kurban;
use App\Models\PaketKurban;
use App\Models\SlotSapi;
use App\Models\ProfilMasjid;

class KurbanController extends Controller
{
    public function index()
{
    $paketSapi = PaketKurban::where('jenis_hewan', 'sapi')
        ->where('is_active', true)
        ->whereHas('slotSapi', function ($q) {
            $q->where('status', 'kosong');
        })
        ->get();

    $paketKambing = PaketKurban::where('jenis_hewan', 'kambing')->where('is_active', true)->get();

    return view('kurban.form', compact('paketSapi', 'paketKambing'));
}

    public function slot(PaketKurban $paket)
    {
        $slot = $paket->slotSapi()->orderBy("nomor_slot")->get();

        return response()->json($slot);
    }

    public function store(KurbanRequest $request)
    {
        $data = $request->validated();
        $paket = PaketKurban::findOrFail($data["paket_kurban_id"]);

        if ($paket->jenis_hewan === "sapi") {
            if (empty($data["slot_sapi_id"])) {
                return back()->withErrors(["slot_sapi_id" => "Silakan pilih slot sapi."])->withInput();
            }

            $slot = SlotSapi::where("id", $data["slot_sapi_id"])
                ->where("paket_kurban_id", $paket->id)
                ->first();

            if (! $slot || $slot->status === "terisi") {
                return back()->withErrors(["slot_sapi_id" => "Slot yang dipilih sudah penuh, silakan pilih slot lain."])->withInput();
            }
        } else {
            $data["slot_sapi_id"] = null;
        }

        $data["nominal"] = $paket->harga;
        $data["nama_paket_snapshot"] = $paket->nama_paket;
        $data["tanggal"] = now()->toDateString();

        session(["kurban_pending" => $data]);

        return redirect()->route("kurban.payment");
    }

    public function payment()
{
    $data = session('kurban_pending');

    if (! $data) {
        return redirect()->route('kurban.index')->with('error', 'Silakan isi form pendaftaran kurban terlebih dahulu.');
    }

    $paket = PaketKurban::find($data['paket_kurban_id']);
    $profil = ProfilMasjid::first();

    return view('kurban.payment', compact('data', 'paket', 'profil'));
}

    public function upload(UploadBuktiRequest $request)
    {
        $data = session("kurban_pending");

        if (! $data) {
            return redirect()->route("kurban.index")->with("error", "Sesi pendaftaran kurban tidak ditemukan, silakan ulangi.");
        }

        if (! empty($data["slot_sapi_id"])) {
            $slot = SlotSapi::find($data["slot_sapi_id"]);
            if (! $slot || $slot->status === "terisi") {
                session()->forget("kurban_pending");
                return redirect()->route("kurban.index")->with("error", "Slot sudah terisi, silakan pilih ulang.");
            }
        }

        $path = $request->file("bukti_pembayaran")->store("bukti-kurban", "public");

        $kurban = Kurban::create([
            "kode_transaksi" => $this->generateKodeTransaksi(),
            "paket_kurban_id" => $data["paket_kurban_id"],
            "slot_sapi_id" => $data["slot_sapi_id"] ?? null,
            "nama" => $data["nama"],
            "whatsapp" => $data["whatsapp"],
            "email" => $data["email"] ?? null,
            "alamat" => $data["alamat"],
            "nominal" => $data["nominal"],
            "tanggal" => $data["tanggal"],
            "bukti_pembayaran" => $path,
            "status" => "menunggu_verifikasi",
        ]);

        if ($kurban->slot_sapi_id) {
            SlotSapi::where("id", $kurban->slot_sapi_id)->update(["status" => "terisi"]);
        }

        session()->forget("kurban_pending");

        return redirect()->route("kurban.success", $kurban->kode_transaksi);
    }

    public function success(string $kode)
    {
        $kurban = Kurban::with(["paketKurban", "slotSapi"])->where("kode_transaksi", $kode)->firstOrFail();

        return view("kurban.success", compact("kurban"));
    }

    private function generateKodeTransaksi(): string
    {
        $last = Kurban::orderByDesc("id")->first();
        $next = $last ? $last->id + 1 : 1;

        return "KRB-" . str_pad((string) $next, 6, "0", STR_PAD_LEFT);
    }
}
