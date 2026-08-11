<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("slot_sapi", function (Blueprint $table) {
            $table->id();
            $table->foreignId("paket_kurban_id")->constrained("paket_kurban")->cascadeOnDelete();
            $table->unsignedTinyInteger("nomor_slot");
            $table->enum("status", ["kosong", "terisi"])->default("kosong");
            $table->timestamps();

            $table->unique(["paket_kurban_id", "nomor_slot"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("slot_sapi");
    }
};
