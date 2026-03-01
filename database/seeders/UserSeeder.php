<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class UserSeeder extends Seeder
{
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
        foreach ($users as $key => $val) {
            User::create($val);
        }
    }
}