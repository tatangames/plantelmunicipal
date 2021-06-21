<?php

namespace App\Http\Controllers\Admin\Bodega1\Persona;

use App\Http\Controllers\Controller;
use App\Models\PersonaB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.lista-de-personas');
    }

    public function indexPersona(){
        return view('backend.bodega1.persona.index');
    }

    public function tablaIndexPersona(){
        $listado = PersonaB1::orderBy('nombre')
            ->whereNotIn('id', [1]) // El por defecto sera Sin Nombre
            ->get();
        return view('backend.bodega1.persona.tabla.tablapersona', compact('listado'));
    }

    public function nuevaPersona(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $s = new PersonaB1();
        $s->nombre = $request->nombre;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoPersona(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = PersonaB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarPersona(Request $request){

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

        PersonaB1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
