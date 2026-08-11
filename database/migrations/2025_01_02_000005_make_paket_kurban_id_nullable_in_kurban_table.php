<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kurban', function (Blueprint $table) {
            $table->dropForeign(['paket_kurban_id']);
        });

        Schema::table('kurban', function (Blueprint $table) {
            $table->unsignedBigInteger('paket_kurban_id')->nullable()->change();
            $table->string('nama_paket_snapshot')->nullable()->after('paket_kurban_id');
        });

        Schema::table('kurban', function (Blueprint $table) {
            $table->foreign('paket_kurban_id')->references('id')->on('paket_kurban')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kurban', function (Blueprint $table) {
            $table->dropForeign(['paket_kurban_id']);
        });

        Schema::table('kurban', function (Blueprint $table) {
            $table->unsignedBigInteger('paket_kurban_id')->nullable(false)->change();
            $table->dropColumn('nama_paket_snapshot');
        });

        Schema::table('kurban', function (Blueprint $table) {
            $table->foreign('paket_kurban_id')->references('id')->on('paket_kurban')->cascadeOnDelete();
        });
    }
};