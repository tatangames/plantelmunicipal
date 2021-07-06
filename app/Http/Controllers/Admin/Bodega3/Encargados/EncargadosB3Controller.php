<?php

namespace App\Http\Controllers\Admin\Bodega3\Encargados;

use App\Http\Controllers\Controller;
use App\Models\EncargadosB3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EncargadosB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.extras.encargados');
    }

    public function indexEncargados(){
        return view('backend.bodega3.encargados.index');
    }

    public function tablaIndexEncargados(){
        $listado = EncargadosB3::orderBy('nombre')->get();
        return view('backend.bodega3.encargados.tabla.tablaencargados', compact('listado'));
    }


    public function nuevoEncargado(Request $request){

        $regla2 = array(
            'nombre' => 'required',
        );

        $validar2 = Validator::make($request->all(), $regla2);

        if($validar2->fails()){return ['success' => 0];}

        $equipo = new EncargadosB3();
        $equipo->nombre = $request->nombre;
        $equipo->activo = 1;

        if($equipo->save()){
            return ['success' => 1]; // guardado
        }else{
            return ['success' => 2];
        }
    }


    public function infoEncargado(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = EncargadosB3::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarEncargado(Request $request){

        $regla = array(
            'id' => 'required',
            'toggle' => 'required',
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){
            return ['success' => 0];
        }

        EncargadosB3::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'activo' => $request->toggle
            ]);

        return ['success' => 1]; // actualizado
    }
}
