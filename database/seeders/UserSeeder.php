<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'Library Administrator',
            'email' => 'admin@library.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'status' => 'pending', 
            'university_id' => 'ADMIN-001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'student@library.com',
            'password' => Hash::make('123'),
            'role' => 'user',
            'status' => 'pending',
            'university_id' => 'NIM-12345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
