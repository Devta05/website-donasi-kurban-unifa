<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Donasi;
use App\Models\Kurban;
use App\Models\ProfilMasjid;

class HomeController extends Controller
{
    public function index()
    {
        $profil = ProfilMasjid::first();
        $beritaTerbaru = Berita::latest()->take(3)->get();

        $totalDonasi = Donasi::where("status", "terverifikasi")->sum("nominal");
        $totalDonatur = Donasi::where("status", "terverifikasi")->distinct("whatsapp")->count("whatsapp");
        $totalKurban = Kurban::where("status", "terverifikasi")->count();

        return view("home", compact("profil", "beritaTerbaru", "totalDonasi", "totalDonatur", "totalKurban"));
    }
}
