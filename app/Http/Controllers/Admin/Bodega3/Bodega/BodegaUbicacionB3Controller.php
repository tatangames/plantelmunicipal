<?php

namespace App\Http\Controllers\Admin\Bodega3\Bodega;

use App\Http\Controllers\Controller;
use App\Models\BodegaUbicacionB3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BodegaUbicacionB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.extras.bodega-ubicacion');
    }

    public function index(){
        return view('backend.bodega3.bodegaubicacion.index');
    }

    public function tablaIndex(){
        $listado = BodegaUbicacionB3::orderBy('nombre')->get();
        return view('backend.bodega3.bodegaubicacion.tabla.tablabodegaubicacion', compact('listado'));
    }

    public function nuevaBodegaUbicacion(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        $s = new BodegaUbicacionB3();
        $s->nombre = $request->nombre;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoBodegaUbicacion(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = BodegaUbicacionB3::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarBodegaUbicacion(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        BodegaUbicacionB3::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
