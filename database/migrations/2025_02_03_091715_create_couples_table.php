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
        Schema::create('couples', function (Blueprint $table) {
            $table->id();
            // template
            $table->string('template');
            // tipe
            $table->string('tipe');
            // tipe acara
            $table->string('tipe_acara');
            // slug
            $table->string('slug');
            // pria
            $table->text('nama_lengkap_pria');
            $table->string('nama_panggilan_pria');
            $table->text('nama_ayah_mempelai_pria');
            $table->text('nama_ibu_mempelai_pria');
            $table->string('nomor_whatsapp_pria')->nullable();
            $table->text('alamat_pria')->nullable();
            // wanita
            $table->text('nama_lengkap_wanita');
            $table->string('nama_panggilan_wanita');
            $table->text('nama_ayah_mempelai_wanita');
            $table->text('nama_ibu_mempelai_wanita');
            $table->string('nomor_whatsapp_wanita')->nullable();
            $table->text('alamat_wanita')->nullable();
            // tanggal akad & resepsi
            $table->string('tanggal_akad');
            $table->string('tempat_akad');
            $table->string('jam_akad');
            $table->string('tanggal_resepsi');
            $table->text('tempat_resepsi');
            $table->string('jam_resepsi');
            // map
            $table->text('link_map');
            // rekening
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening_2')->nullable();
            $table->string('nama_bank_2')->nullable();
            $table->string('nama_rekening_2')->nullable();
            // foto mempelai
            $table->string('foto_mempelai_background')->nullable();
            $table->string('foto_mempelai')->nullable();
            $table->string('foto_mempelai_pria')->nullable();
            $table->string('foto_mempelai_wanita')->nullable();
            // love story
            $table->text('love_story')->nullable();
            // galery
            $table->json('galery')->nullable();
            // tamu
            $table->json('tamu')->nullable();
            $table->text('pesan_chat')->nullable();
            // musik
            $table->text('musik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couples');
    }
};
