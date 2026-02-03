<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Hapus user lama jika ada
        User::truncate();
        
        // Buat user admin baru
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sdlantabur.com',
            'password' => Hash::make('admin123'),
        ]);
        
        echo "Admin user created successfully!\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
    }
}
