<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'guard_name' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('permissions')->insert([
            [
                'name' => 'create-user',
                'guard_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete-user',
                'guard_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('role_has_permissions')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
            ],
        ]);

        DB::table('user_has_permissions')->insert([
            [
                'user_id' => 1,
                'permission_id' => 1,
            ],
            [
                'user_id' => 1,
                'permission_id' => 2,
            ],
        ]);

        DB::table('user_has_roles')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ]);
    }
}
