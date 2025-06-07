<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_role' => $this->faker->unique()->word(), 
        ];
    }

    /**
     * Indicate that the role is admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'nama_role' => 'admin',
        ]);
    }

    /**
     * Indicate that the role is pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pelanggan(): static
    {
        return $this->state(fn (array $attributes) => [
            'nama_role' => 'pelanggan',
        ]);
    }
}
