<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("profil_masjid", function (Blueprint $table) {
            $table->id();
            $table->string("nama_masjid");
            $table->longText("sejarah")->nullable();
            $table->longText("visi")->nullable();
            $table->longText("misi")->nullable();
            $table->longText("fasilitas")->nullable();
            $table->string("foto")->nullable();
            $table->text("alamat")->nullable();
            $table->string("email")->nullable();
            $table->string("whatsapp")->nullable();
            $table->text("google_maps_embed")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("profil_masjid");
    }
};
