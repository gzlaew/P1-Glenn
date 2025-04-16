<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('nama_aplikasi')->nullable();
            $table->string('nama_perpustakaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->integer('biaya_pendaftaran')->nullable();
            $table->integer('biaya_peminjaman')->nullable();
            $table->integer('biaya_keterlambatan')->nullable();
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'nama_aplikasi',
                'nama_perpustakaan',
                'alamat',
                'kontak',
                'biaya_pendaftaran',
                'biaya_peminjaman',
                'biaya_keterlambatan',
                'logo',
            ]);
        });
    }
};
