<?php

namespace Database\Factories;

use App\Models\KategoriInfrastruktur;
use App\Models\Kelurahan;
use App\Models\LaporanKerusakan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanKerusakanFactory extends Factory
{
    protected $model = LaporanKerusakan::class;

    public function definition(): array
    {
        return [
            'nomor_tiket' => 'INFRA-'.now()->format('Ymd').'-'.fake()->unique()->numerify('####'),
            'warga_id' => User::factory(),
            'kelurahan_id' => Kelurahan::factory(),
            'kategori_id' => KategoriInfrastruktur::factory(),
            'judul' => fake()->sentence(4),
            'deskripsi_kondisi' => fake()->paragraph(),
            'latitude' => fake()->latitude(-6.95, -6.88),
            'longitude' => fake()->longitude(107.58, 107.68),
            'foto_bukti_sebelum' => 'laporan/sebelum/sample.jpg',
            'status' => 'menunggu_verifikasi',
            'prioritas' => fake()->randomElement(['rendah', 'sedang', 'tinggi']),
        ];
    }
}
