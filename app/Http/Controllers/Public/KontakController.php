<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilMasjid;

class KontakController extends Controller
{
    public function index()
    {
        $profil = ProfilMasjid::first();

        return view("kontak.index", compact("profil"));
    }
}
