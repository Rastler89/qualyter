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
                'name' => 'Asignar rol'
            ], [
                'slug' => 'edit-users',
                'name' => 'Modificar Usuarios'
            ], [
                'slug' => 'create-users',
                'name' => 'Crear Usuarios'
            ], [
                'slug' => 'view-users',
                'name' => 'Ver Usuarios'
            ], [
                'slug' => 'view-bulks',
                'name' => 'Ver uploads'
            ], [
                'slug' => 'bulk-talks',
                'name' => 'Uploads: tasks'
            ], [
                'slug' => 'bulk-agents',
                'name' => 'Uploads: agents'
            ], [
                'slug' => 'bulk-stores',
                'name' => 'Uploads: stores'
            ], [
                'slug' => 'bulk-clients',
                'name' => 'Uploads: clients'
            ], [
                'slug' => 'view-clients',
                'name' => 'Ver clientes'
            ], [
                'slug' => 'add-clients',
                'name' => 'Agregar clientes'
            ], [
                'slug' => 'edit-clients',
                'name' => 'Editar Clientes'
            ], [
                'slug' => 'view-stores',
                'name' => 'Ver tiendas'
            ], [
                'slug' => 'add-stores',
                'name' => 'Agregar tiendas'
            ], [
                'slug' => 'edit-stores',
                'name' => 'Editar tiendas'
            ], [
                'slug' => 'view-agents',
                'name' => 'Ver agentes'
            ], [
                'slug' => 'add-agents',
                'name' => 'Agregar agentes'
            ], [
                'slug' => 'edit-agents',
                'name' => 'Editar agentes'
            ], [
                'slug' => 'view-tasks',
                'name' => 'Ver tareas'
            ], [
                'slug' => 'response-tasks',
                'name' => 'Gestionar tareas'
            ], [
                'slug' => 'view-incidences',
                'name' => 'Ver incidencias'
            ], [
                'slug' => 'change-incidences',
                'name' => 'Cambiar agente/incidencia'
            ], [
                'slug' => 'response-incidences',
                'name' => 'Gestionar incidencia'
            ], [
                'slug' => 'translates',
                'name' => 'Traducciones'
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
            ], [
                'role_id' => 1,
                'permission_id' => 6
            ], [
                'role_id' => 1,
                'permission_id' => 7
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