<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/wilayah_kota_bandung.csv');
        $examplePath = database_path('data/wilayah_kota_bandung.csv.example');

        if (! File::exists($csvPath)) {
            $this->command?->warn('PERINGATAN: File database/data/wilayah_kota_bandung.csv belum ditemukan.');
            $this->command?->info('Menggunakan data sampel resmi dari database/data/wilayah_kota_bandung.csv.example.');
            // TODO: Pengguna akan menyediakan file database/data/wilayah_kota_bandung.csv lengkap (30 kecamatan, 151 kelurahan).
            if (File::exists($examplePath)) {
                $this->importFromCsv($examplePath);
            }

            return;
        }

        $this->importFromCsv($csvPath);
    }

    protected function importFromCsv(string $path): void
    {
        $handle = fopen($path, 'r');
        if (! $handle) {
            return;
        }

        $header = null;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            // Abaikan baris komentar atau baris kosong
            if (empty($row) || str_starts_with(trim($row[0] ?? ''), '#')) {
                continue;
            }

            if (! $header) {
                $header = array_map('trim', $row);

                continue;
            }

            if (count($row) < 4) {
                continue;
            }

            $kodeKecamatan = trim($row[0]);
            $namaKecamatan = trim($row[1]);
            $kodeKelurahan = trim($row[2]);
            $namaKelurahan = trim($row[3]);

            if (empty($kodeKecamatan) || empty($kodeKelurahan)) {
                continue;
            }

            $kecamatan = Kecamatan::firstOrCreate(
                ['kode_kecamatan' => $kodeKecamatan],
                ['nama_kecamatan' => $namaKecamatan]
            );

            Kelurahan::firstOrCreate(
                ['kode_kelurahan' => $kodeKelurahan],
                [
                    'kecamatan_id' => $kecamatan->id,
                    'nama_kelurahan' => $namaKelurahan,
                ]
            );
        }

        fclose($handle);
        $this->command?->info('Seeding data wilayah selesai. Total Kecamatan: '.Kecamatan::count().', Kelurahan: '.Kelurahan::count());
    }
}
