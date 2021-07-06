<?php

namespace App\Http\Controllers\Admin\Bodega3\TipoRetiro;

use App\Http\Controllers\Controller;
use App\Models\TipoRetiroB3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoRetiroB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.extras.tipo-retiro');
    }

    public function index(){
        return view('backend.bodega3.tiporetiro.index');
    }

    public function tablaIndex(){
        $listado = TipoRetiroB3::orderBy('nombre')->get();
        return view('backend.bodega3.tiporetiro.tabla.tablatiporetiro', compact('listado'));
    }

    public function nuevoRetiro(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $s = new TipoRetiroB3();
        $s->nombre = $request->nombre;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoRetiro(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = TipoRetiroB3::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarRetiro(Request $request){

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

        TipoRetiroB3::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
