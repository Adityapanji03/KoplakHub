<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produk')->insert([
            [
                'id' => 1,
                'nama_produk' => 'Rustic Arabica 100g',
                'harga_produk' => 25000,
                'stok_produk' => 100,
                'deskripsi_produk' => 'Nikmati setiap tegukan Rustic Arabica, biji kopi pilihan yang menghadirkan aroma tanah yang kaya dan sentuhan manis karamel. Diproses dengan cinta, kopi ini menjanjikan pengalaman autentik yang menenangkan jiwa, cocok untuk memulai hari atau menemani momen santai Anda.',
                'gambar_produk' => 'products/ieTOpwEQU1cX3rHGTPro25pHe6aS3mEgPNa8Hgax.jpg',
                'created_at' => '2025-05-17 19:07:36',
                'updated_at' => '2025-05-20 00:04:16',
            ],
            [
                'id' => 2,
                'nama_produk' => 'Rustic Robusta 100g',
                'harga_produk' => 20000,
                'stok_produk' => 100,
                'deskripsi_produk' => 'Selami kekayaan rasa Rustic Robusta, biji kopi dengan karakter bold dan sentuhan earthy yang unik. Kopi ini menawarkan tingkat kafein yang lebih tinggi dan crema yang melimpah, menjadikannya fondasi sempurna untuk minuman kopi berbasis susu atau diseduh hitam untuk pengalaman yang kuat.',
                'gambar_produk' => 'products/bkP5WK2mLWfWoNI7lvGh7fDJSCNaLgkW9efJdaCl.jpg',
                'created_at' => '2025-05-18 21:22:26',
                'updated_at' => '2025-05-21 14:37:24',
            ],
            [
                'id' => 3,
                'nama_produk' => 'Kopi Biji Salak 100g',
                'harga_produk' => 20000,
                'stok_produk' => 100,
                'deskripsi_produk' => 'Raskan keunikan varian kopi biji salak, biji kopi dengan karakter bold dan sentuhan manis dari harumnya biji salak yang masih diolah secara tradisional ini akan memanjakan selera dan menggugah iman anda terhadap kopi.',
                'gambar_produk' => 'products/ZkbuIB4vsWeIJismch4BctbGlE7LCpf7lM6dYyTR.jpg',
                'created_at' => '2025-05-18 21:22:26',
                'updated_at' => '2025-05-21 14:37:24',
            ],
            [
                'id' => 4,
                'nama_produk' => 'Kripik Tape 125g',
                'harga_produk' => 15000,
                'stok_produk' => 100,
                'deskripsi_produk' => 'Nikmati kerenyahan Keripik Tape kami, perpaduan sempurna antara manisnya tape singkong pilihan dengan gurihnya setiap gigitan. Dibuat dari tape fermentasi berkualitas tinggi dan diolah hingga renyah sempurna, camilan ini menawarkan pengalaman rasa yang unik dan memanjakan lidah. Cocok untuk teman ngopi, teman santai, atau suguhan istimewa.',
                'gambar_produk' => 'products/FXVu670SAUMQVfUUzn5KHQeTtKVUesDSRvemTuUi.jpg',
                'created_at' => '2025-05-18 21:22:26',
                'updated_at' => '2025-05-21 14:37:24',
            ],
        ]);
    }
}
