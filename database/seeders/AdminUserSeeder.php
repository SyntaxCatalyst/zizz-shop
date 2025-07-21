<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin-zizz',
            'nomor_hp' => '085785313072',
            'email' => 'topyws@gmail.com',
            'password' => Hash::make('P@$$w0rdZ!zz!2025!'), // Password yang sangat kuat
            'role' => 'admin',
            'email_verified_at' => now(), // Opsional: langsung set sebagai terverifikasi
        ]);
    }
}