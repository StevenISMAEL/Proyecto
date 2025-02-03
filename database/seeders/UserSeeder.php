<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jostin Quilca',
            'email' => 'jdquilcap1@utn.edu.ec',
            'password' => Hash::make('2004Jd20'),
            'role' => 'admin',
            'phone' => '0992031359',
            'profile_photo' => null, // Puedes agregar una ruta de prueba si lo deseas
        ]);

        User::create([
            'name' => 'Steven Lara',
            'email' => 'silarac@utn.edu.ec',
            'password' => Hash::make('root'),
            'role' => 'user',
            'phone' => '0987654321',
            'profile_photo' => null,
        ]);

        User::create([
            'name' => 'Leonel Arellano',
            'email' => 'ilarellanom@utn.edu.ec',
            'password' => Hash::make('root'),
            'role' => 'support',
            'phone' => '1122334455',
            'profile_photo' => null,
        ]);
    }
}
