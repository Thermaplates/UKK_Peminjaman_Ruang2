<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusPembayaranEnumInPeminjamanTable extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'terverifikasi', 'lunas'])
                  ->default('belum_bayar')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'terverifikasi'])
                  ->default('belum_bayar')
                  ->change();
        });
    }
}