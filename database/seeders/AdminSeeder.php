<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::firstOrCreate(
            ['email' => 'calamuseducation@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('@$calamus5241$@'),
                'access' => ['*'],
            ]
        );
    }
}


