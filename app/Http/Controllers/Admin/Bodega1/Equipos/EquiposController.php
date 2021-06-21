<?php

namespace App\Http\Controllers\Admin\Bodega1\Equipos;

use App\Http\Controllers\Controller;
use App\Models\EquiposB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EquiposController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.lista-equipos');
    }

    public function indexEquipos(){
        return view('backend.bodega1.equipo.index');
    }

    public function tablaIndexEquipos(){
        $listado = EquiposB1::orderBy('nombre')->get();
        return view('backend.bodega1.equipo.tabla.tablaequipo', compact('listado'));
    }


    public function nuevoEquipo(Request $request){

        $regla2 = array(
            'nombre' => 'required',
        );

        $validar2 = Validator::make($request->all(), $regla2);

        if($validar2->fails()){return ['success' => 0];}

        $equipo = new EquiposB1();
        $equipo->nombre = $request->nombre;
        $equipo->activo = 1;

        if($equipo->save()){
            return ['success' => 1]; // guardado
        }else{
            return ['success' => 2];
        }
    }


    public function infoEquipo(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = EquiposB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarEquipo(Request $request){

        $regla = array(
            'id' => 'required',
            'toggle' => 'required',
            'nombre' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id equipo es requerido',
            'toggle.required' => 'toggle es requerido',
            'nombre.required' => 'nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){
            return ['success' => 0];
        }

        EquiposB1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'activo' => $request->toggle
            ]);

        return ['success' => 1]; // actualizado
    }
}
