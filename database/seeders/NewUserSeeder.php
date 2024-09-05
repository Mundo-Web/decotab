<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Decotab',
            'email' => 'admin@decotab.com',
            'password' => Hash::make('#D3c0t4b#'),
        ])->assignRole('Admin');
    }
}
