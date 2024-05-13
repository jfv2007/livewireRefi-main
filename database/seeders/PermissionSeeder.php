<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'permission_index',
            'permission_create',
            'permission_show',
            'permission_edit',
            'permission_destroy',

            'role_index',
            'role_create',
            'role_show',
            'role_edit',
            'role_destroy',

            'user_index',
            'user_create',
            'user_show',
            'user_edit',
            'user_destroy',

            'tags18_index',
            'tags18_create',
            'tags18_show',
            'tags18_edit',
            'tags18_destroy',

            'tag18_index',
            'tag18_create',
            'tag18_show',
            'tag18_edit',
            'tag18_destroy',

            'falla_index',
            'falla_create',
            'falla_show',
            'falla_edit',
            'falla_destroy',

            'trabajo_index',
            'trabajo_create',
            'trabajo_show',
            'trabajo_edit',
            'trabajo_destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
