<?php

namespace App\Http\Controllers\Admin\Bodega2\Equipos;

use App\Http\Controllers\Controller;
use App\Models\EquiposB2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Equipos2Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:grupo.bodega2.registros');
    }

    public function indexEquipos(){
        return view('backend.bodega2.equipo.index');
    }

    public function tablaIndexEquipos(){
        $listado = EquiposB2::orderBy('nombre')->get();
        return view('backend.bodega2.equipo.tabla.tablaequipo', compact('listado'));
    }


    public function nuevoEquipo(Request $request){

        $regla2 = array(
            'nombre' => 'required',
        );

        $validar2 = Validator::make($request->all(), $regla2);

        if($validar2->fails()){return ['success' => 0];}

        $equipo = new EquiposB2();
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

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = EquiposB2::where('id', $request->id)->first()){

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

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){
            return ['success' => 0];
        }

        EquiposB2::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'activo' => $request->toggle
            ]);

        return ['success' => 1]; // actualizado
    }
}
