<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Membuat pengguna admin
        User::create([
            'name' => 'Admin User',
            'email' => 'shepia@gmail.com',
            'password' => bcrypt('123'),
            'level' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas User',
            'email' => 'petugas@example.com',
            'password' => bcrypt('123'),
            'level' => 'petugas',
        ]);

        // Panggil seeder lain jika diperlukan
        // $this->call(OtherSeeder::class);
    }

    
}
