<?php

namespace App\Http\Controllers\Admin\Bodega1\Proveedor;

use App\Http\Controllers\Controller;
use App\Models\ProveedoresB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:vista.grupo.bodega1.proveedores.ingresar', ['only' => ['indexProveedorIngreso', 'registrarProveedor']]);
        $this->middleware('can:vista.grupo.bodega1.proveedores.listado', ['only' => ['indexProveedorListado', 'tablaIndexProveedorListado']]);
        $this->middleware('can:boton.grupo.bodega1.proveedores.listado.btn-editar', ['only' => ['infoProveedor', 'editarProveedor']]);
    }

    public function indexProveedorIngreso(){
        return view('backend.bodega1.proveedor.ingreso.index');
    }

    // registro de proveedores
    public function registrarProveedor(Request $request){

        $regla = array(
            'empresa' => 'required'
        );

        $mensaje = array(
            'empresa.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $s = new ProveedoresB1();
        $s->empresa = $request->empresa;
        $s->nombrecontacto = $request->nombrecontacto;
        $s->direccion = $request->direccion;
        $s->correo = $request->correo;
        $s->observaciones = $request->observaciones;
        $s->telfijo = $request->telfijo;
        $s->telmovil = $request->telmovil;
        $s->activo = 1;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    // mostrar listado de proveedores
    public function indexProveedorListado(){
        return view('backend.bodega1.proveedor.listado.index');
    }

    public function tablaIndexProveedorListado(){
        $listado = ProveedoresB1::orderBy('empresa')->get();
        return view('backend.bodega1.proveedor.listado.tabla.tablaproveedor', compact('listado'));
    }

    public function infoProveedor(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id proveedor es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = ProveedoresB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarProveedor(Request $request){

        $regla = array(
            'empresa' => 'required'
        );

        $mensaje = array(
            'empresa.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        ProveedoresB1::where('id', $request->id)
            ->update(['empresa' => $request->empresa,
                'nombrecontacto' => $request->nombrecontacto,
                'direccion' => $request->direccion,
                'correo' => $request->correo,
                'observaciones' => $request->observaciones,
                'telfijo' => $request->telfijo,
                'telmovil' => $request->telmovil,
                'activo' => $request->activo
            ]);

        return ['success' => 1];
    }

}
