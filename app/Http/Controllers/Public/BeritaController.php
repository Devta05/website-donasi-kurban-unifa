<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(9);

        return view("berita.index", compact("berita"));
    }

    public function show(string $slug)
    {
        $berita = Berita::where("slug", $slug)->firstOrFail();
        $beritaLain = Berita::where("id", "!=", $berita->id)->latest()->take(3)->get();

        return view("berita.show", compact("berita", "beritaLain"));
    }
}
