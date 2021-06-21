<?php

namespace App\Http\Controllers\Admin\Bodega1\Unidad;

use App\Http\Controllers\Controller;
use App\Models\UnidadMedidaB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnidadMedidaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.lista-unidad-medida');
    }

    public function indexUnidadMedida(){
        return view('backend.bodega1.unidad.index');
    }

    public function tablaIndexUnidadMedida(){
        $listado = UnidadMedidaB1::orderBy('nombre')->get();
        return view('backend.bodega1.unidad.tabla.unidadtabla', compact('listado'));
    }

    public function nuevaUnidad(Request $request){

        $regla = array(
            'nombre' => 'required',
            'magnitud' => 'required',
            'simbolo' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'Nombre es requerido',
            'magnitud.required' => 'Magnitud es requerido',
            'simbolo.required' => 'Simbolo es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje);

        if ($validar->fails()){return ['success' => 0];}

        $s = new UnidadMedidaB1();
        $s->nombre = $request->nombre;
        $s->magnitud = $request->magnitud;
        $s->simbolo = $request->simbolo;
        $s->activo = 1;

        if($s->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoUnidad(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = UnidadMedidaB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarUnidad(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'magnitud' => 'required',
            'simbolo' => 'required',
            'toggle' => 'required'
        );

        $mensaje = array(
            'id.required' => 'ID es requerido',
            'nombre.required' => 'Nombre es requerido',
            'magnitud.required' => 'Magnitud es requerido',
            'simbolo.required' => 'Simbolo es requerido',
            'toggle.required' => 'Toggle es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        UnidadMedidaB1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'magnitud' => $request->magnitud,
                'simbolo' => $request->simbolo,
                'activo' => $request->toggle
            ]);

        return ['success' => 1];

    }
}
