<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Bibliotecario Admin',
            'email' => 'admin@biblioteca.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Estudiante Ejemplo',
            'email' => 'estudiante@biblioteca.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}
