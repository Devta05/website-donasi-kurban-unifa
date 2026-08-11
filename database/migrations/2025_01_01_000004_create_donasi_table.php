<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("donasi", function (Blueprint $table) {
            $table->id();
            $table->string("kode_transaksi")->unique();
            $table->foreignId("jenis_donasi_id")->constrained("jenis_donasi")->cascadeOnDelete();
            $table->string("nama");
            $table->string("whatsapp");
            $table->string("email")->nullable();
            $table->decimal("nominal", 15, 2);
            $table->text("pesan")->nullable();
            $table->date("tanggal");
            $table->string("bukti_pembayaran")->nullable();
            $table->enum("status", ["menunggu_verifikasi", "terverifikasi", "ditolak"])->default("menunggu_verifikasi");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("donasi");
    }
};
