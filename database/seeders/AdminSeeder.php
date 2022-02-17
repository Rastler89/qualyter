<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder {

    public function run() {
        DB::table('permissions')->insert([
            [
                'slug' => 'view-roles',
                'name' => 'Ver roles'
            ], [
                'slug' => 'create-roles',
                'name' => 'Crear roles'
            ], [
                'slug' => 'edit-roles',
                'name' => 'Modificar roles'
            ], [
                'slug' => 'assign-roles',
                'name' => 'Assignar rol'
            ], [
                'slug' => 'edit-users',
                'name' => 'Modificar Usuarios'
            ]
        ]);

        DB::table('roles')->insert([
            'slug' => 'admin',
            'name' => 'Administrador'
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Dani Molina',
                'email' => 'daniel.molina@optimaretail.es',
                'password' => Hash::make('123456'),
                'status' => 1
            ], [
                'name' => 'Banejat',
                'email' => 'banned@test.es',
                'password' => Hash::make('123456'),
                'status' => 0
            ]
        ]);

        DB::table('roles_permissions')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1
            ], [
                'role_id' => 1,
                'permission_id' => 2
            ], [
                'role_id' => 1,
                'permission_id' => 3
            ], [
                'role_id' => 1,
                'permission_id' => 4
            ], [
                'role_id' => 1,
                'permission_id' => 5
            ]
        ]);

        DB::table('users_roles')->insert([
            [
                'role_id' => 1,
                'user_id' => 1
            ]
        ]);
    }
}