<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@peminjaman.app',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Staf',
                'email'    => 'staf@peminjaman.app',
                'password' => Hash::make('staf456'),
                'role'     => 'staf',
            ],
            [
                'name'     => 'Peminjam',
                'email'    => 'pinjam@peminjaman.com',
                'password' => Hash::make('12345678'),
                'role'     => 'peminjam',
            ],
        ];
    }
}
