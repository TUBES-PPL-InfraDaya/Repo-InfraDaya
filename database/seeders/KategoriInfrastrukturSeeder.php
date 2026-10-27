<?php

namespace Database\Seeders;

use App\Models\KategoriInfrastruktur;
use Illuminate\Database\Seeder;

class KategoriInfrastrukturSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = [
            [
                'nama_kategori' => 'Jalan Raya / Trotoar',
                'deskripsi' => 'Kerusakan aspal jalan berlubang, amblas, retak parah, trotoar pejalan kaki rusak atau hilang penutup.',
                'bobot_prioritas' => 3, // Tinggi
            ],
            [
                'nama_kategori' => 'Saluran Drainase / Gorong-gorong',
                'deskripsi' => 'Gorong-gorong tersumbat, sedimentasi parah, tanggul saluran jebol, atau penutup drainase patah yang berisiko banjir.',
                'bobot_prioritas' => 3, // Tinggi
            ],
            [
                'nama_kategori' => 'Penerangan Jalan Umum (PJU)',
                'deskripsi' => 'Lampu jalan mati, tiang PJU miring/rawan roboh, instalasi kabel putus yang mengganggu keselamatan pengguna jalan.',
                'bobot_prioritas' => 2, // Sedang
            ],
            [
                'nama_kategori' => 'Jembatan / Tanggul Air',
                'deskripsi' => 'Retakan struktur jembatan, railing pelindung rusak, tanggul penahan air sungai longsor atau mengikis jalan.',
                'bobot_prioritas' => 3, // Tinggi
            ],
        ];

        foreach ($kategoriList as $kategori) {
            KategoriInfrastruktur::firstOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }
    }
}
