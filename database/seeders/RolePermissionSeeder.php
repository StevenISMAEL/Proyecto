<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $bodeguero = Role::firstOrCreate(['name' => 'bodeguero']); 

         // ✅ Crear permisos
         $permissions = [
            // Permisos generales
            'ver dashboard',

            // Permisos de productos
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',

            // Permisos de proveedores
            'ver proveedores',

            // Permisos de compras
            'ver compras',

            // Permisos de ventas (NO ASIGNADOS A BODEGUERO)
            'gestionar ventas'
        ];

        foreach ($permissions as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all()); // El admin tiene todos los permisos
        $user->givePermissionTo(['ver dashboard', 'ver compras']);
        $bodeguero->givePermissionTo([
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',
            'ver proveedores' // Solo puede ver proveedores, no editarlos ni eliminarlos.
        ]);
    }
}
