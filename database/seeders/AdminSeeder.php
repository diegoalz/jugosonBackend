<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'nombre' => 'administrador',
            'email' => 'admin@gmail.com',
            'telefono' => '0123456789',
            'rol' => 'admin',
            'password' => Hash::make("admin123")
        ];
        DB::table('users')->insert($data);
    }
}
