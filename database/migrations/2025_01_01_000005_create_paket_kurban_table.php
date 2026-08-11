<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("paket_kurban", function (Blueprint $table) {
            $table->id();
            $table->enum("jenis_hewan", ["sapi", "kambing"]);
            $table->string("nama_paket");
            $table->decimal("harga", 15, 2);
            $table->text("deskripsi")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("paket_kurban");
    }
};
