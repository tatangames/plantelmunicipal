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
        if($user->hasPermissionTo('rol.roles.lista.index')){
            $ruta = 'admin.roles.index';
        }

        // Rol: Bodeguero1
        // vista para Bodeguero 1 -> rederigir a vista bodega ingreso
        else if($user->hasPermissionTo('rol.ingreso.bodega1.index')) {
            $ruta = 'ingreso.bodega1.index';
        }

        // Rol: Info-Bodeguero1
        // vista para informacion nomas -> rederigir a vista lista de proveedores
        else if($user->hasPermissionTo('rol.proveedor.lista.index')) {
            $ruta = 'proveedor.index.listado';
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
