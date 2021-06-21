<?php

namespace App\Http\Controllers\Admin\Bodega1\Tipos;

use App\Http\Controllers\Controller;
use App\Models\TiposB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiposController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.lista-de-tipos');
    }

    public function indexTipos(){
        return view('backend.bodega1.tipos.index');
    }

    public function tablaIndexTipos(){
        $listado = TiposB1::orderBy('nombre')->get();
        return view('backend.bodega1.tipos.tabla.tablatipos', compact('listado'));
    }

    public function nuevaTipos(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $s = new TiposB1();
        $s->nombre = $request->nombre;
        $s->descripcion = $request->descripcion;
        $s->activo = 1;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoTipos(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = TiposB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarTipos(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'toggle' => 'required'
        );

        $mensaje = array(
            'id.required' => 'ID es requerido',
            'nombre.required' => 'Nombre es requerido',
            'toggle.required' => 'Toggle es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        TiposB1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activo' => $request->toggle
            ]);

        return ['success' => 1];
    }
}
