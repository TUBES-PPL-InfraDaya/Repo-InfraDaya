<?php

namespace Database\Factories;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KecamatanFactory extends Factory
{
    protected $model = Kecamatan::class;

    public function definition(): array
    {
        return [
            'kode_kecamatan' => 'KEC-'.strtoupper(fake()->unique()->lexify('???-###')),
            'nama_kecamatan' => 'Kecamatan '.fake()->city(),
        ];
    }
}
