<?php

namespace App\Http\Controllers\Admin\Bodega3\Cargos;

use App\Http\Controllers\Controller;
use App\Models\CargosB3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CargosB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.extras.cargos');
    }

    public function indexCargos(){
        return view('backend.bodega3.cargos.index');
    }

    public function tablaIndexCargos(){
        $listado = CargosB3::orderBy('nombre')->get();
        return view('backend.bodega3.cargos.tabla.tablacargos', compact('listado'));
    }

    public function nuevoCargo(Request $request){

        $regla = array(
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        $s = new CargosB3();
        $s->nombre = $request->nombre;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoCargo(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = CargosB3::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarCargo(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        CargosB3::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
