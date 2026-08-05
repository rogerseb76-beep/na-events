<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'roger.seb76@gmail.com'],
            [
                'name' => 'Sébastien Roger',
                'password' => Hash::make('EEro4JiZ2b5NsXfYJtDz!'),
            ]
        );
    }
}