<?php

namespace App\Http\Controllers\Admin\Controles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexRedireccionamiento(){

        $user = Auth::user();

        //$permiso = $user->getAllPermissions()->pluck('name');

        // Rol: Super-Admin
        // vista administrador -> rederigir a vista Roles
        if($user->hasPermissionTo('url.admin.rolespermiso.permiso-y-roles')){
            $ruta = 'admin.roles.index';
        }

        // Rol: Bodeguero1 Admin 1
        // vista para Bodeguero 1 -> rederigir a vista bodega ingreso
        else if($user->hasPermissionTo('url.bodega1.admin1.ingreso.index')) {
            $ruta = 'ingreso.bodega1.index';
        }

        // Rol: Bodeguero1 Admin 2
        // vista para informacion nomas -> rederigir a vista lista de proveedores
        else if($user->hasPermissionTo('url.bodega1.admin2.proveedor.lista.index')) {
            $ruta = 'proveedor.index.listado';
        }

        // Rol: Bodeguero2 Admin 1
        // Sistema de marlene -> registrar cada compra a un equipo
        // vista para Bodeguero 2 -> rederigir a vista bodega 2 ingreso
        else if($user->hasPermissionTo('url.bodega2.admin1.ingreso.nuevo-ingreso')) {
            $ruta = 'registro.bodega2.index';
        }


        // Rol: Bodeguero3 Admin 1
        // Sistema de bienes municipales -> registrar nuevo proyecto (carpeta)
        // vista para Bodeguero 3 -> rederigir a grupo Ingreso -> nuevo ingreso
        else if($user->hasPermissionTo('url.bodega3.admin1.ingreso.nuevo-ingreso')) {
            $ruta = 'registro.bodega3.index';
        }

        // Rol: Bodeguero3 Admin 2
        // Sistema de bienes municipales -> lista de proyectos
        // vista para Bodeguero 3 -> rederigir a grupo Proyectos -> lista de proyectos
        else if($user->hasPermissionTo('url.bodega3.admin2.proyecto.lista-de-proyectos')) {
            $ruta = 'verificacion.bodega3.index';
        }

        else{
            // no tiene ningun permiso de vista, redirigir a pantalla sin permisos
            $ruta = 'no.permisos.index';
        }

        return view('backend.index', compact('user', 'ruta'));
    }

    public function indexSinPermiso(){
        return view('errors.403');
    }
}
