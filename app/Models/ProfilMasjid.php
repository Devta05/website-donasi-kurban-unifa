<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMasjid extends Model
{
    use HasFactory;

    protected $table = "profil_masjid";

    protected $fillable = [
    'nama_masjid', 'sejarah', 'visi', 'misi', 'fasilitas',
    'foto', 'qris', 'alamat', 'email', 'whatsapp', 'google_maps_embed',
];
}
