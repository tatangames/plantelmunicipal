<?php

namespace App\Http\Controllers\Admin\Bodega3\Servicios;

use App\Http\Controllers\Controller;
use App\Models\ServiciosB3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiciosB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.extras.servicios');
    }

    public function indexServicios(){
        return view('backend.bodega3.servicios.index');
    }

    public function tablaIndexServicios(){
        $listado = ServiciosB3::orderBy('nombre')->get();
        return view('backend.bodega3.servicios.tabla.tablaservicios', compact('listado'));
    }

    public function nuevoServicio(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $s = new ServiciosB3();
        $s->nombre = $request->nombre;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoServicio(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = ServiciosB3::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarServicio(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $mensaje = array(
            'id.required' => 'ID es requerido',
            'nombre.required' => 'Nombre es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        ServiciosB3::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
