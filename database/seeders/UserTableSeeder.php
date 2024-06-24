<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hamid Raza',
            'username' => 'hamidraza',
            'email' => 'hamidraza04321@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
