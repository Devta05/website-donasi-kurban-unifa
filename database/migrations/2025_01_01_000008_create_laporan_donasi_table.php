<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("laporan_donasi", function (Blueprint $table) {
            $table->id();
            $table->foreignId("donasi_id")->nullable()->constrained("donasi")->nullOnDelete();
            $table->date("tanggal");
            $table->string("jenis_donasi");
            $table->decimal("nominal", 15, 2);
            $table->string("status_penyaluran")->default("Belum Disalurkan");
            $table->text("keterangan")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("laporan_donasi");
    }
};
