<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("kurban", function (Blueprint $table) {
            $table->id();
            $table->string("kode_transaksi")->unique();
            $table->foreignId("paket_kurban_id")->constrained("paket_kurban")->cascadeOnDelete();
            $table->foreignId("slot_sapi_id")->nullable()->constrained("slot_sapi")->nullOnDelete();
            $table->string("nama");
            $table->string("whatsapp");
            $table->string("email")->nullable();
            $table->text("alamat");
            $table->decimal("nominal", 15, 2);
            $table->date("tanggal");
            $table->string("bukti_pembayaran")->nullable();
            $table->enum("status", ["menunggu_verifikasi", "terverifikasi", "ditolak"])->default("menunggu_verifikasi");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("kurban");
    }
};
