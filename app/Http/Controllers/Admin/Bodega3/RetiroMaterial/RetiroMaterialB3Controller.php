<?php

namespace App\Http\Controllers\Admin\Bodega3\RetiroMaterial;

use App\Http\Controllers\Controller;
use App\Models\BodegaUbicacionB3;
use App\Models\CargosB3;
use App\Models\EncargadosB3;
use App\Models\EstadoProyectoB3;
use App\Models\IngresosB3;
use App\Models\IngresosDetalleB3;
use App\Models\IngresosEncargadoB3;
use App\Models\RetiroBodegaB3;
use App\Models\RetiroBodegaDetalleB3;
use App\Models\ServiciosB3;
use App\Models\TipoRetiroB3;
use App\Models\Usuario;
use App\Models\VerificadoIngresoDetalleB3;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RetiroMaterialB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.retirar-material', ['only' => ['verRetiroMaterialIndex',
            'registrarRetiro']]);

        $this->middleware('can:vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.editar-verificar-material', ['only' => ['indexListaRetirosEditar',
            'tablaIndexListaRetirosEditar', 'indexVistaEditarRetiroMaterial', 'modificarCantidadRetirda']]);
    }

    // index para retiro de material
    public function verRetiroMaterialIndex($id){
        $nombre = IngresosB3::where('id', $id)->pluck('nombre')->first();

        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();
        $tiporetiro = TipoRetiroB3::orderBy('nombre')->get();
        $bodega = BodegaUbicacionB3::orderBy('nombre')->get();

        // contar todos los registros del mismo
        foreach ($listado as $l){

            // obtener total verificado
            $tt = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();
            $ttve = collect($tt)->sum('cantidad');
            $l->sumaverificado = $ttve;

            // aqui se obtiene la cantidad total retirada del mismo

            // todos los registros del mismo
            $info = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();

            // suma de toda la cantidad registrada del material.
            // nunca sera mayor al registro
            $total = collect($info)->sum('cantidad');
            $l->registrado = $total;
        }

        return view('backend.bodega3.retiro.vistaretiro.index', compact('id', 'nombre',
            'listado', 'tiporetiro', 'bodega'));
    }

    // registrar retiros de material a un proyecto
    public function registrarRetiro(Request $request){

        $regla = array(
            'id' => 'required', // viene id del proyecto
            'identificador' => 'required|array',
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){ return ['success' => 0]; }

        // verificar que al menos 1 material se vaya a registrar como retiro
        $suma = 0;
        for ($i = 0; $i < count($request->cantidad); $i++) {
            $suma = $suma + $request->cantidad[$i];
        }

        if($suma == 0){
            // no hay cantidad a registrar para retiro
            return ['success' => 1];
        }

        // crear registro y colocar su ubicacion de bodega

        DB::beginTransaction();

        try {

            $idusuario = Auth::id();

            $fecha = Carbon::now('America/El_Salvador');

            $veri = new RetiroBodegaB3();
            $veri->id_ingresos_b3 = $request->id;
            $veri->id_usuarios = $idusuario;
            $veri->nota = $request->nota;
            $veri->fecha = $fecha;
            $veri->id_tipo_retiro_b3 = $request->tiporetiro;
            $veri->id_bodega_b3 = $request->bodega;

            if($veri->save()){

                for ($j = 0; $j < count($request->cantidad); $j++) {

                    // necesitamos revisar que la cantidad a retirar no sea mayor
                    // a la cantidad que fue ingresada en factura

                    // obtener cantidad total que ya habia registrada de retiros anteriores
                    $info = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $request->identificador[$j])->get();
                    $total = collect($info)->sum('cantidad');

                    // sumar
                    $sumaTotal = $total + $request->cantidad[$j];

                    $infoDetalle = IngresosDetalleB3::where('id', $request->identificador[$j])->first();

                    $tt = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $request->identificador[$j])->get();
                    $ttve = collect($tt)->sum('cantidad');

                    // suma de toda la cantidad registrada del material.
                    // nunca sera mayor al total verificado
                    if($sumaTotal > $ttve){
                        return ['success' => 2, 'fila' => $j+1, 'nombre' => $infoDetalle->nombre, 'total' => $ttve];
                    }

                    // cantidad a retirar
                    $deta = new RetiroBodegaDetalleB3();
                    $deta->id_retiro_bodega_b3 = $veri->id;
                    $deta->id_ingresos_detalle_b3 = $request->identificador[$j];
                    $deta->cantidad = $request->cantidad[$j];
                    $deta->save();
                }

                DB::commit();
                return ['success' => 3];
            }else{
                return ['success' => 4];
            }

        }catch(\Throwable $e){
            DB::rollback();
            return ['success' => 4];
        }
    }


    // completar un proyecto (Libre sin Permiso 04/07/2021)
    public function completarProyecto(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $mensaje = array(
            'id.required' => 'ID es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        $fecha = Carbon::now('America/El_Salvador');

        IngresosB3::where('id', $request->id)
            ->update(['id_estado_proyecto_b3' => 2, // pasara a terminado
                'fecha_terminado' => $fecha
            ]);

        return ['success' => 1];
    }


    // index lista de retiros para editar
    public function indexListaRetirosEditar($id){
        // viene el id de proyecto
        $nombre = IngresosB3::where('id', $id)->pluck('nombre')->first();

        return view('backend.bodega3.retiro.listaretiro.index', compact('id', 'nombre'));
    }

    // tabla
    public function tablaIndexListaRetirosEditar($id){
        $listado = RetiroBodegaB3::where('id_ingresos_b3', $id)->get();

        foreach ($listado as $l){

            $l->fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $usuario = Usuario::where('id', $l->id_usuarios)->pluck('nombre')->first();
            $tipo = TipoRetiroB3::where('id', $l->id_tipo_retiro_b3)->pluck('nombre')->first();

            $l->usuario = $usuario;
            $l->tipo = $tipo;
        }

        return view('backend.bodega3.retiro.listaretiro.tabla.tablalistaretiro', compact('listado'));
    }


    // vista index para ver lista de materiales para editar
    public function indexVistaEditarRetiroMaterial($id){

        // viene el id de retiro_bodega_b3

        $tiporetiro = TipoRetiroB3::orderBy('nombre')->get();
        $bodega = BodegaUbicacionB3::orderBy('nombre')->get();

        $info = RetiroBodegaB3::where('id', $id)->first();
        $nota = $info->nota;

        // para poder situar el select en la ubicacion de tipo retiro
        $idtiporetiro = $info->id_tipo_retiro_b3;

        // id bodega
        $idbodega = $info->id_bodega_b3;

        // lista de materiales retirados
        $listado = RetiroBodegaDetalleB3::where('id_retiro_bodega_b3', $id)->orderBy('id', 'ASC')->get();

        // contar todos los registros del mismo
        foreach ($listado as $l){

            // se obtiene la fila de verificado_ingreso_detalle_b3
            $data = IngresosDetalleB3::where('id', $l->id_ingresos_detalle_b3)->first();
            $l->nombre = $data->nombre;

            $dataVerificado = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $l->id_ingresos_detalle_b3)
                ->get();

            $dataTotal = collect($dataVerificado)->sum('cantidad');


            // cantidad maxima verificada por el admin que recibe material
            $l->cantidadmax = $dataTotal;

            // todos los registros del mismo retiro
            $deta = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $data->id)
                ->where('id', '!=', $l->id)
                ->get();

            // suma de toda la cantidad retirada del material.
            // nunca sera mayor a la cantidad verificada
            $total = collect($deta)->sum('cantidad');
            $l->cantidadretirada = $total;
        }

        return view('backend.bodega3.retiro.listaretiro.editar.index', compact('tiporetiro',
            'listado', 'idtiporetiro', 'nota', 'id', 'bodega', 'idbodega'));
    }

    // editar la cantidad que se retiro
    public function modificarCantidadRetirda(Request $request){

        $regla = array(
            'id' => 'required', // id de retiro_bodega_b3
            'tiporetiro' => 'required',
            'identificador' => 'required|array', // id retiro_bodega_detalle_b3
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){ return ['success' => 0]; }

        // editar el registro

        DB::beginTransaction();

        try {

            $idusuario = Auth::id();

            // actualizar retiro de bodega
            RetiroBodegaB3::where('id', $request->id)
                ->update(['id_tipo_retiro_b3' => $request->tiporetiro,
                    'id_bodega_b3' => $request->bodega,
                    'id_usuarios' => $idusuario,
                    'nota' => $request->nota
                ]);

            for ($j = 0; $j < count($request->cantidad); $j++) {


                // obtener fila para saver que material id es
                $info = RetiroBodegaDetalleB3::where('id', $request->identificador[$j])->first();

                // obtener total retirado
                $totalretirado = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $info->id_ingresos_detalle_b3)
                    ->where('id', '!=', $info->id)
                    ->get();
                $total = collect($totalretirado)->sum('cantidad');

                // sumar
                $sumaTotal = $total + $request->cantidad[$j];

                // obtener maximo verificado
                $tveri = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $info->id_ingresos_detalle_b3)->get();
                $tverificada = collect($tveri)->sum('cantidad');

                // suma de toda la cantidad registrada del material.
                // nunca sera mayor al registro
                if($sumaTotal > $tverificada){

                    $nn = IngresosDetalleB3::where('id', $info->id_ingresos_detalle_b3)->pluck('nombre')->first();

                    return ['success' => 1, 'fila' => $j+1, 'nombre' => $nn, 'total' => $total];
                }

                // sino supera, se puede actualizar cantidad

                RetiroBodegaDetalleB3::where('id', $request->identificador[$j])
                    ->update(['cantidad' => $request->cantidad[$j]
                    ]);
            }

            DB::commit();
            return ['success' => 2];

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 3, 'ee' => 'oo ' . $e];
        }
    }

}
