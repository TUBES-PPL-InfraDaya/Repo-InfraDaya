<?php

namespace Database\Factories;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelurahanFactory extends Factory
{
    protected $model = Kelurahan::class;

    public function definition(): array
    {
        return [
            'kecamatan_id' => Kecamatan::factory(),
            'kode_kelurahan' => 'KEL-'.strtoupper(fake()->unique()->lexify('???-###')),
            'nama_kelurahan' => 'Kelurahan '.fake()->streetName(),
        ];
    }
}
