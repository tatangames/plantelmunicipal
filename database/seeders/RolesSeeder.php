<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        // --- CREAR ROLES ---

        // administrador con todos los permisos
        $role1 = Role::create(['name' => 'Super-Admin']);

        // bodeguero1 con los permisos necesarios
        $role2 = Role::create(['name' => 'Bodeguero1-Admin']);

        // auxiliar de bodeguero1, segun permisos necesarios
        $role3 = Role::create(['name' => 'Bodeguero1-Auxiliar']);

        // para ver unicamente reportes e informes de bodega1
        $role4 = Role::create(['name' => 'Info-Bodeguero1']);

        // bodeguero2 con los permisos necesarios
        $role5 = Role::create(['name' => 'Bodeguero2-Admin']);


        // --- CREAR PERMISOS ---

        Permission::create(['name' => 'rol.ingreso.bodega1.index', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Bodega, vista ingresos'])->syncRoles($role2, $role3);
        Permission::create(['name' => 'rol.proveedor.lista.index', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Proveedores, vista lista de proveedores'])->syncRoles($role4);
        Permission::create(['name' => 'rol.roles.lista.index', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Roles, vista lista roles'])->syncRoles($role1);
        Permission::create(['name' => 'grupo.bodega1.bodega', 'description' => 'Contenedor para el grupo llamado: Bodega'])->syncRoles($role2, $role3);
        Permission::create(['name' => 'vista.grupo.bodega1.bodega.ingreso', 'description' => 'Vista index para grupo Bodega - vista ingresos'])->syncRoles($role2, $role3);
        Permission::create(['name' => 'vista.grupo.bodega1.bodega.retiro', 'description' => 'Vista index para grupo Bodega - vista retiro'])->syncRoles($role2, $role3);
        Permission::create(['name' => 'grupo.bodega1.proveedores', 'description' => 'Contenedor para el grupo llamado: Proveedores'])->syncRoles($role2, $role4);
        Permission::create(['name' => 'vista.grupo.bodega1.proveedores.ingresar', 'description' => 'Vista index para grupo Proveedores - vista ingresar'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.bodega1.proveedores.listado', 'description' => 'Vista index para grupo Proveedores - vista listado'])->syncRoles($role2, $role4);
        Permission::create(['name' => 'grupo.bodega1.equipos', 'description' => 'Contenedor para el grupo llamado: Equipos'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.registrar-material', 'description' => 'Vista index para grupo Equipos - vista registrar material'])->syncRoles($role2, $role4);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.bodega-numeracion', 'description' => 'Vista index para grupo Equipos - vista bodega numeración'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.lista-unidad-medida', 'description' => 'Vista index para grupo Equipos - vista lista unidad de medida'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.lista-de-tipos', 'description' => 'Vista index para grupo Equipos - vista lista de tipos'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.lista-de-personas', 'description' => 'Vista index para grupo Equipos - vista lista de personas'])->syncRoles($role2);
        Permission::create(['name' => 'grupo.bodega1.reportes', 'description' => 'Contenedor para el grupo llamado: Reportes'])->syncRoles($role2, $role3, $role4);
        Permission::create(['name' => 'vista.grupo.bodega1.reportes.reporte-ingreso', 'description' => 'Vista index para grupo Reportes - vista generar reporte ingresos'])->syncRoles($role2 ,$role3, $role4);
        Permission::create(['name' => 'vista.grupo.bodega1.reportes.reporte-retiro', 'description' => 'Vista index para grupo Reportes - vista generar reporte retiro'])->syncRoles($role2, $role3, $role4);
        Permission::create(['name' => 'vista.grupo.bodega1.reportes.informe-de-bodega', 'description' => 'Vista index para grupo Reportes - vista informes de bodega'])->syncRoles($role2, $role3, $role4);
        Permission::create(['name' => 'boton.grupo.bodega1.proveedores.listado.btn-editar', 'description' => 'Mostrar botón, para editar proveedores para bodega1'])->syncRoles($role2);
        Permission::create(['name' => 'boton.grupo.bodega1.equipos.registrar-material.btn-editar', 'description' => 'Mostrar botón para editar material bodega 1'])->syncRoles($role2);
        Permission::create(['name' => 'grupo.admin.roles-y-permisos', 'description' => 'Contenedor para el grupo llamado: Roles y Permisos'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.bodega1.equipos.lista-equipos', 'description' => 'Vista index para grupo Equipos - vista lista de equipos'])->syncRoles($role2);
        Permission::create(['name' => 'boton.grupo.bodega1.equipos.registrar-material.btn-agregar', 'description' => 'Mostrar botón para agregar nuevo registro de material'])->syncRoles($role2);

        // --- SISTEMA 2 ---
        // Sistema para Marlene - Ingresar registros de compras para cada equipo
        Permission::create(['name' => 'grupo.bodega2.registros', 'description' => 'Bodega 2 - Contenedor para el grupo llamado Registros'])->syncRoles($role5);




        // para agregarselo al permiso creado y asiganarlo a 1 unicamente rol
        // ->assignRole($role1);  solo es para un solo rol

        // crear permiso y asignar a x cantidad de roels
        //Permission::create(['name' => 'estadisticas.index', 'description' => 'Vista para estadisticas'])->syncRoles($role1);

        // querememos asignar al rol, permiso x permiso.
        //$role1->permission()->attach(['admin.denuncias', 'xxx']);
    }
}
