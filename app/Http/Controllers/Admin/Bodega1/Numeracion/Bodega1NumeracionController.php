<?php

namespace App\Http\Controllers\Admin\Bodega1\Numeracion;

use App\Http\Controllers\Controller;
use App\Models\BodegaNumeracion1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Bodega1NumeracionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.bodega-numeracion');
    }

    public function indexNumeracion(){
        return view('backend.bodega1.bodega.index');
    }

    public function tablaIndexNumeracion(){
        $listado = BodegaNumeracion1::orderBy('nombre')->get();
        return view('backend.bodega1.bodega.tabla.tablabodega', compact('listado'));
    }

    public function nuevaNumeracion(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if(BodegaNumeracion1::where('nombre', $request->nombre)->first()){
            return ['success' => 1];
        }

        $s = new BodegaNumeracion1();
        $s->nombre = $request->nombre;
        $s->descripcion = $request->descripcion;

        if($s->save()){
            return ['success' => 2];
        }else{
            return ['success' => 3];
        }
    }

    public function infoNumeracion(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = BodegaNumeracion1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarNumeracion(Request $request){

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

        if(BodegaNumeracion1::where('nombre', $request->nombre)
            ->where('id', '!=', $request->id)
            ->first()){
            return ['success' => 1];
        }

        BodegaNumeracion1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

        return ['success' => 2];
    }
}
