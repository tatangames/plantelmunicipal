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

        // SISTEMA 1

        // administrador con todos los permisos
        $role1 = Role::create(['name' => 'Super-Admin']);

        // bodeguero1 con los permisos necesarios
        $role2 = Role::create(['name' => 'Sistema1-Admin1']);

        // auxiliar de bodeguero1, segun permisos necesarios
        $role3 = Role::create(['name' => 'Sistema1-Admin2']);

        // para ver unicamente reportes e informes de bodega1
        $role4 = Role::create(['name' => 'Sistema1-Admin3']);

        // SISTEMA 2

        // bodeguero2 con los permisos necesarios
        $role5 = Role::create(['name' => 'Sistema2-Admin1']);

        // SISTEMA 3

        // ingresa los materiales a bodega
        $role6 = Role::create(['name' => 'Sistema3-Admin1']);

        // verifica la cantidades, y hace los retiros de bodega
        $role7 = Role::create(['name' => 'Sistema3-Admin2']);

        // SISTEMA 4

        // ingreso de registro de llantas
        $role8 = Role::create(['name' => 'Sistema4-Admin1']);


        // --- CREAR PERMISOS ---

        // ADMIN
        Permission::create(['name' => 'url.admin.rolespermiso.permiso-y-roles', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Roles, vista lista roles'])->syncRoles($role1);

        // SISTEMA 1

        Permission::create(['name' => 'url.bodega1.admin1.ingreso.index', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Bodega, vista ingresos'])->syncRoles($role2, $role3);
        Permission::create(['name' => 'url.bodega1.admin2.proveedor.lista.index', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Proveedores, vista lista de proveedores'])->syncRoles($role4);

        // SISTEMA 2
        Permission::create(['name' => 'url.bodega2.admin1.ingreso.nuevo-ingreso', 'description' => 'Cuando inicia el sistema 2, se redirigirá la vista al grupo Registros, vista ingresos'])->syncRoles($role5);

        // SISTEMA 3
        Permission::create(['name' => 'url.bodega3.admin1.ingreso.nuevo-ingreso', 'description' => 'Cuando inicia el sistema 2, se redirigirá la vista al grupo Registros, vista ingresos'])->syncRoles($role6);
        Permission::create(['name' => 'url.bodega3.admin2.proyecto.lista-de-proyectos', 'description' => 'Cuando inicia el sistema 2, se redirigirá la vista al grupo Registros, vista ingresos'])->syncRoles($role7);

        // SISTEMA 4
        Permission::create(['name' => 'url.bodega4.admin1.bodega.ingreso', 'description' => 'Cuando inicia el sistema 4, se redirigirá la vista al grupo Bodega, vista ingresos'])->syncRoles($role8);


        // Lista de permisos
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


        // --- SISTEMA 3 ---
        Permission::create(['name' => 'grupo.bodega3.ingreso', 'description' => 'Contenedor para el grupo llamado: Ingreso'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.ingreso.nuevo-ingreso', 'description' => 'Vista index para grupo Ingreso - vista nuevo ingreso'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.ingreso.lista-de-proyectos', 'description' => 'Vista index para grupo Ingreso - vista lista de proyectos'])->syncRoles($role6);

        Permission::create(['name' => 'grupo.bodega3.extras', 'description' => 'Contenedor para el grupo llamado: Extras'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.extras.encargados', 'description' => 'Vista index para grupo Proyectos - vista encargados'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.extras.servicios', 'description' => 'Vista index para grupo Proyectos - vista servicios'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.extras.cargos', 'description' => 'Vista index para grupo Proyectos - vista cargos'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.extras.tipo-retiro', 'description' => 'Vista index para grupo Proyectos - vista tipos de retiro'])->syncRoles($role6);
        Permission::create(['name' => 'vista.grupo.bodega3.extras.bodega-ubicacion', 'description' => 'Vista index para grupo Proyectos - vista bodega ubicacion'])->syncRoles($role6);

        Permission::create(['name' => 'grupo.bodega3.proyectos', 'description' => 'Contenedor para el grupo llamado: Proyectos'])->syncRoles($role7);
        Permission::create(['name' => 'vista.grupo.bodega3.proyectos.lista-de-proyectos', 'description' => 'Vista index para grupo Proyectos - vista lista de proyectos'])->syncRoles($role7);


        // SISTEMA 4 - CONTROL DE LLANTAS
        Permission::create(['name' => 'grupo.bodega4.bodega', 'description' => 'Contenedor para el grupo llamado: Ingreso'])->syncRoles($role8);

        Permission::create(['name' => 'grupo.bodega4.registros', 'description' => 'Contenedor para el grupo llamado: Registros'])->syncRoles($role8);

        Permission::create(['name' => 'grupo.bodega4.reportes', 'description' => 'Contenedor para el grupo llamado: Reportes'])->syncRoles($role8);

        // - BOTONES -

        // boton para verificar material
        Permission::create(['name' => 'vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.verificar-material', 'description' => 'Vista index para grupo Proyectos - vista lista de proyectos, boton verificar material'])->syncRoles($role7);

        // boton para editar material
        Permission::create(['name' => 'vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.editar-verificar-material', 'description' => 'Vista index para grupo Proyectos - vista lista de proyectos, boton editar verificar material'])->syncRoles($role7);

        // boton para retirar material
        Permission::create(['name' => 'vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.retirar-material', 'description' => 'Vista index para grupo Proyectos - vista lista de proyectos, boton retirar material'])->syncRoles($role7);

        // boton para editar retiro de material
        Permission::create(['name' => 'vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.editar-retirar-material', 'description' => 'Vista index para grupo Proyectos - vista lista de proyectos, boton editar retirar material'])->syncRoles($role7);



        // para agregarselo al permiso creado y asiganarlo a 1 unicamente rol
        // ->assignRole($role1);  solo es para un solo rol

        // crear permiso y asignar a x cantidad de roels
        //Permission::create(['name' => 'estadisticas.index', 'description' => 'Vista para estadisticas'])->syncRoles($role1);

        // querememos asignar al rol, permiso x permiso.
        //$role1->permission()->attach(['admin.denuncias', 'xxx']);
    }
}
