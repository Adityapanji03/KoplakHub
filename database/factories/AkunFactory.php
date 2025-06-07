<?php

namespace Database\Factories;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Akun>
 */
class AkunFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Akun::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'username' => fake()->userName(),
            'nomor_hp' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'provinsi' => fake()->state(),
            'kabupaten_kota' => fake()->city(),
            'kecamatan' => fake()->word(),
            'kelurahan' => fake()->word(),
            'detail_alamat' => fake()->address(),
            'id_role' => \App\Models\Role::factory(),
        ];
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'id_role' => \App\Models\Role::where('nama_role', 'admin')->first()->id ?? \App\Models\Role::factory(['nama_role' => 'admin']),
            ];
        });
    }

    /**
     * Indicate that the user is a pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pelanggan(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'id_role' => \App\Models\Role::where('nama_role', 'pelanggan')->first()->id ?? \App\Models\Role::factory(['nama_role' => 'pelanggan']),
            ];
        });
    }
}
