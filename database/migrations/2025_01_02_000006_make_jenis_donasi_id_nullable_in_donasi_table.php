<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropForeign(['jenis_donasi_id']);
        });

        Schema::table('donasi', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_donasi_id')->nullable()->change();
            $table->string('nama_jenis_donasi_snapshot')->nullable()->after('jenis_donasi_id');
        });

        Schema::table('donasi', function (Blueprint $table) {
            $table->foreign('jenis_donasi_id')->references('id')->on('jenis_donasi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropForeign(['jenis_donasi_id']);
        });

        Schema::table('donasi', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_donasi_id')->nullable(false)->change();
            $table->dropColumn('nama_jenis_donasi_snapshot');
        });

        Schema::table('donasi', function (Blueprint $table) {
            $table->foreign('jenis_donasi_id')->references('id')->on('jenis_donasi')->cascadeOnDelete();
        });
    }
};