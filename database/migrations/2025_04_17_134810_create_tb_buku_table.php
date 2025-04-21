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
        Schema::create('tb_buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('judul');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_penerbit');
            $table->unsignedBigInteger('id_pengarang');

            // Data buku
            $table->integer('stok');
            $table->integer('harga_pinjam');
            $table->integer('denda'); // per jam
            $table->string('size');   // ukuran buku
            $table->integer('harga'); // harga beli buku

            $table->string('status')->default('tersedia');

            // Foreign key constraints
            $table->foreign('id_kategori')->references('id_kategori')->on('tb_kategori')->onDelete('cascade');
            $table->foreign('id_penerbit')->references('id_penerbit')->on('tb_penerbit')->onDelete('cascade');
            $table->foreign('id_pengarang')->references('id_pengarang')->on('tb_pengarang')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_buku');
    }
};
