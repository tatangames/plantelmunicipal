<?php

namespace App\Http\Controllers\Admin\Bodega4\Proveedor;

use App\Http\Controllers\Controller;
use App\Models\ProveedoresB4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorB4Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // index proveedores
    public function index(){
        return view('backend.bodega4.proveedor.index');
    }

    public function tablaIndex(){
        // obtener todos los servicios
        $listado = ProveedoresB4::orderBy('empresa')->get();

        return view('backend.bodega4.proveedor.tabla.tablaproveedor', compact('listado'));
    }

    // registro de proveedores
    public function registrarProveedor(Request $request){

        $regla = array(
            'empresa' => 'required'
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){return ['success' => 0];}

        $s = new ProveedoresB4();
        $s->empresa = $request->empresa;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoProveedor(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){return ['success' => 0];}

        if($data = ProveedoresB4::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarProveedor(Request $request){

        $regla = array(
            'empresa' => 'required'
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){return ['success' => 0];}

        ProveedoresB4::where('id', $request->id)
            ->update(['empresa' => $request->empresa,
            ]);

        return ['success' => 1];
    }
}
