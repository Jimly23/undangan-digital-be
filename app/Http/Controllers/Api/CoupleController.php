<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CoupleController extends Controller
{

    function simpan(Request $request) {
        $couple = new Couple();

        $request->validate([
            'musik' => 'required|file|mimes:mp3,wav,ogg|max:10240',
        ]);
    
        // Upload image jika ada file yang diunggah, jika tidak tetap null
        $foto_mempelai = $request->hasFile('foto_mempelai') 
            ? url('/storage/' . $request->file('foto_mempelai')->store('images_couple', 'public'))
            : null;
    
        $foto_mempelai_pria = $request->hasFile('foto_mempelai_pria') 
            ? url('/storage/' . $request->file('foto_mempelai_pria')->store('images_couple', 'public'))
            : null;
    
        $foto_mempelai_wanita = $request->hasFile('foto_mempelai_wanita') 
            ? url('/storage/' . $request->file('foto_mempelai_wanita')->store('images_couple', 'public'))
            : null;
    
        $foto_mempelai_background = $request->hasFile('foto_mempelai_background') 
            ? url('/storage/' . $request->file('foto_mempelai_background')->store('images_couple', 'public'))
            : null;
    
        $musik = null;

        if ($request->hasFile('musik')) {
            $path = $request->file('musik')->store('audio', 'public');
            $musik = url('/storage/' . $path);
        }
    
        // Upload multiple images untuk galery, jika tidak ada maka tetap null
        $galery = [];
    
        if ($request->hasFile('galery')) {
            foreach ($request->file('galery') as $image) {
                $path = $image->store('images_couple/' , 'public');
                $galery[] = url('/storage/' . $path);
            }
        }

        // Ubah string hobi menjadi array
        $tamu = explode(',', $request->tamu); // Pecah berdasarkan koma
        $tamu = array_map('trim', $tamu); // Hilangkan spasi di awal & akhir
    
        // Simpan ke database
        $couple = Couple::create([
            'template' => $request->template,
            'slug' => $request->slug,
            'tipe' => $request->tipe,
            'tipe_acara' => $request->tipe_acara,
            // pria
            'nama_lengkap_pria' => $request->nama_lengkap_pria,
            'nama_panggilan_pria' => $request->nama_panggilan_pria,
            'nama_ayah_mempelai_pria' => $request->nama_ayah_mempelai_pria,
            'nama_ibu_mempelai_pria' => $request->nama_ibu_mempelai_pria,
            'nomor_whatsapp_pria' => $request->filled('nomor_whatsapp_pria') ? $request->nomor_whatsapp_pria : null,
            'alamat_pria' => $request->alamat_pria,
            // wanita
            'nama_lengkap_wanita' => $request->nama_lengkap_wanita,
            'nama_panggilan_wanita' => $request->nama_panggilan_wanita,
            'nama_ayah_mempelai_wanita' => $request->nama_ayah_mempelai_wanita,
            'nama_ibu_mempelai_wanita' => $request->nama_ibu_mempelai_wanita,
            'nomor_whatsapp_wanita' => $request->filled('nomor_whatsapp_wanita') ? $request->nomor_whatsapp_wanita : null,
            'alamat_wanita' => $request->alamat_wanita,
            // tanggal akad & resepsi
            'tanggal_akad' => $request->tanggal_akad,
            'tempat_akad' => $request->tempat_akad,
            'jam_akad' => $request->jam_akad,
            'tanggal_resepsi' => $request->tanggal_resepsi,
            'tempat_resepsi' => $request->tempat_resepsi,
            'jam_resepsi' => $request->jam_resepsi,
            // map
            'link_map' => $request->link_map,
            // rekening
            'nomor_rekening' => $request->nomor_rekening,
            'nama_bank' => $request->nama_bank,
            'nama_rekening' => $request->nama_rekening,
            'nomor_rekening_2' => $request->nomor_rekening_2,
            'nama_bank_2' => $request->nama_bank_2,
            'nama_rekening_2' => $request->nama_rekening_2,
            // foto mempelai
            'foto_mempelai' => $foto_mempelai, 
            'foto_mempelai_pria' => $foto_mempelai_pria, 
            'foto_mempelai_wanita' => $foto_mempelai_wanita, 
            'foto_mempelai_background' => $foto_mempelai_background, 
            // love story tetap null jika tidak ada input
            'love_story' => $request->filled('love_story') ? $request->love_story : null,
            'musik' => $musik, 
            // Jika galery kosong, tetap null
            'galery' => !empty($galery) ? json_encode($galery) : null, 
            // Tamu
            'tamu' => !empty($tamu) ? json_encode($tamu) : null, 
            'pesan_chat' => $request->pesan_chat, 
        ]);
    
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $couple
        ]);
    }

    public function updateTamu(Request $request, $slug)
    {
        // Validasi input
        $request->validate([
            'tamu' => 'required|string', // tamu dikirim dalam bentuk string
        ]);

        // Ambil couple berdasarkan slug
        $couple = Couple::where('slug', $slug)->firstOrFail();

        // Ubah string tamu menjadi array
        $tamu = explode(',', $request->tamu);
        $tamu = array_map('trim', $tamu);

        // Update tamu
        $couple->update([
            'tamu' => $tamu, // Laravel akan otomatis menyimpan sebagai JSON
            'pesan_chat' => $request->pesan_chat, // Laravel akan otomatis menyimpan sebagai JSON
        ]);

        return response()->json([
            'message' => 'Nama tamu berhasil di tambahkan',
            'data' => $couple
        ]);
    }
    

    function index() {
        $tampil = ['items'=>Couple::get()];
        return $tampil;
    }

    function getCouple($slug) {
        $couple = Couple::where('slug', $slug)      // Filter berdasarkan slug
                        ->firstOrFail();               // Ambil data atau gagal
        $couple->galery = json_decode($couple->galery, true);
        $couple->tamu = json_decode($couple->tamu, true);
        $data = ['couple' => $couple];
        return $data;
    }

    public function hapusCouple($slug) {
        // Cari semua couple berdasarkan slug
        $couples = Couple::where('slug', $slug)->get();
    
        // Jika tidak ada data yang ditemukan, kembalikan response
        if ($couples->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        foreach ($couples as $couple) {
            // Hapus semua file gambar jika ada
            if ($couple->foto_mempelai) {
                Storage::disk('public')->delete(str_replace(url('/storage/'), '', $couple->foto_mempelai));
            }
            if ($couple->foto_mempelai_pria) {
                Storage::disk('public')->delete(str_replace(url('/storage/'), '', $couple->foto_mempelai_pria));
            }
            if ($couple->foto_mempelai_wanita) {
                Storage::disk('public')->delete(str_replace(url('/storage/'), '', $couple->foto_mempelai_wanita));
            }
            if ($couple->foto_mempelai_background) {
                Storage::disk('public')->delete(str_replace(url('/storage/'), '', $couple->foto_mempelai_background));
            }
            if ($couple->musik) {
                Storage::disk('public')->delete(str_replace(url('/storage/'), '', $couple->musik));
            }
    
            // Hapus semua file di galery jika ada
            if ($couple->galery) {
                $galeryImages = json_decode($couple->galery, true);
                if (is_array($galeryImages)) {
                    foreach ($galeryImages as $image) {
                        Storage::disk('public')->delete(str_replace(url('/storage/'), '', $image));
                    }
                }
            }
    
            // Hapus data couple dari database
            $couple->delete();
        }
    
        return response()->json(['message' => 'Data couple dan file gambar berhasil dihapus']);
    }
}
