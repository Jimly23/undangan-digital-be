<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{

    use HasFactory;

    protected $fillable = [
        'template',
        'tipe',
        'slug',
        // pria
        'nama_lengkap_pria',
        'nama_panggilan_pria',
        'nama_ayah_mempelai_pria',
        'nama_ibu_mempelai_pria',
        'nomor_whatsapp_pria',
        'alamat_pria',
        // wanita
        'nama_lengkap_wanita',
        'nama_panggilan_wanita',
        'nama_ayah_mempelai_wanita',
        'nama_ibu_mempelai_wanita',
        'nomor_whatsapp_wanita',
        'alamat_wanita',
        // tanggal akad & resepsi
        'tanggal_akad',
        'tempat_akad',
        'jam_akad',
        'tanggal_resepsi',
        'tempat_resepsi',
        'jam_resepsi',
        // map
        'link_map',
        // rekening
        'nomor_rekening',
        'nama_bank',
        'nama_rekening',
        'nomor_rekening_2',
        'nama_bank_2',
        'nama_rekening_2',
        // foto mempelai
        'foto_mempelai_background',
        'foto_mempelai',
        'foto_mempelai_pria',
        'foto_mempelai_wanita',
        // love story
        'love_story',
        // galery
        'galery',
        // musik
        'musik',
        // tamu
        'tamu',
        'pesan_chat',
    ];


    protected function fotoMempelai(): Attribute
    {
        return Attribute::make(
            get: fn ($foto_mempelai) => $foto_mempelai,
        );
    }
 
    protected function fotoMempelaiPria(): Attribute
    {
        return Attribute::make(
            get: fn ($foto_mempelai_pria) => $foto_mempelai_pria,
        );
    }

    protected function fotoMempelaiWanita(): Attribute
    {
        return Attribute::make(
            get: fn ($foto_mempelai_wanita) => $foto_mempelai_wanita,
        );
    }

    protected function fotoMempelaiBakcground(): Attribute
    {
        return Attribute::make(
            get: fn ($foto_mempelai_background) => $foto_mempelai_background,
        );
    }

    protected function galery(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    protected function musik(): Attribute
    {
        return Attribute::make(
            get: fn ($musik) => $musik,
        );
    }

}
