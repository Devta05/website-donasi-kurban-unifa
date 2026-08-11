<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilMasjid;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilMasjid::first();

        return view("profil", compact("profil"));
    }
}
