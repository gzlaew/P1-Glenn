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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('saldo')->default(0)->after('email');
            $table->date('tanggal_daftar')->nullable()->after('saldo');
            $table->string('status')->default('aktif')->after('tanggal_daftar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['saldo', 'tanggal_daftar', 'status']);
        });
    }
};
