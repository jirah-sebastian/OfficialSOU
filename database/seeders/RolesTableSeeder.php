<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'System Developer',
            ],
            [
                'id'    => 2,
                'title' => 'SO Administrator',
            ],
            [
                'id'    => 3,
                'title' => 'Organization President',
            ],
        ];

        Role::insert($roles);
    }
}