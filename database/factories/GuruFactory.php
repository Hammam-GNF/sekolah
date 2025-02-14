<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    protected $model = Guru::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $usedKelasIds = [];
        $kelas = Kelas::doesntHave('guru')
            ->whereNotIn('id', $usedKelasIds)
            ->inRandomOrder()
            ->first();

        if (!$kelas) {
            $kelas = Kelas::factory()->create();
        }

        $usedKelasIds[] = $kelas->id;

        return [
            'nama_guru' => $this->faker->name(),
            'kelas_id' => $kelas->id,
        ];
    }
}
