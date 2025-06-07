<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed roles
        Role::factory()->admin()->create();
        Role::factory()->pelanggan()->create();

        // Seed admin account
        Akun::factory()->admin()->create([
            'nama' => 'Admin User',
            'username' => 'admin123',
            'password' => Hash::make('admin123'),
        ]);

        // Seed customer account
        Akun::factory()->pelanggan()->create([
            'nama' => 'Pelanggan Satu',
            'username' => 'pelanggan1',
            'password' => Hash::make('cus12345'),
        ]);

        // Call other seeders in the correct order
        $this->call([
            ProdukSeeder::class,
            TransaksiSeeder::class,
            DetailTransaksiSeeder::class,
            ReviewSeeder::class,
            ReviewReplySeeder::class,
        ]);
    }
}
