<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create(
            [
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'change_password_status'=>1,
            'role' => 'admin',
            ]
            );
    }
}
