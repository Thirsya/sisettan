<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'username' => "admin97",
            'name' => "Admin 97",
            'email' => null,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'username' => "kota",
            'name' => "Kota",
            'email' => null,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'username' => "pesantren",
            'name' => "Pesantren",
            'email' => null,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'username' => "mojoroto",
            'name' => "Mojoroto",
            'email' => null,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'username' => "peserta",
            'name' => "Peserta",
            'email' => null,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
