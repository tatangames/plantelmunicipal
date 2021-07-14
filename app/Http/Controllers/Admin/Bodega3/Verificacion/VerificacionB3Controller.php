<?php

namespace App\Http\Controllers\Admin\Bodega3\Verificacion;

use App\Http\Controllers\Controller;
use App\Models\BodegaUbicacionB3;
use App\Models\CargosB3;
use App\Models\DocumentoIngresoB3;
use App\Models\EncargadosB3;
use App\Models\IngresosB3;
use App\Models\IngresosDetalleB3;
use App\Models\IngresosEncargadoB3;
use App\Models\RegistroExtraMaterialB3;
use App\Models\RegistroExtraMaterialDetalleB3;
use App\Models\RetiroBodegaDetalleB3;
use App\Models\ServiciosB3;
use App\Models\Usuario;
use App\Models\VerificadoIngresoB3;
use App\Models\VerificadoIngresoDetalleB3;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VerificacionB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // vista para verificadores, aqui tiene todas las opciones para
    // verificar y retirar material *
    public function index(){
        return view('backend.bodega3.verificacion.index');
    }

    public function tablaIndex(){
        // obtener todos los servicios
        $listado = IngresosB3::orderBy('fecha', 'ASC')->get();

        foreach ($listado as $l){
            $l->fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $servicio = ServiciosB3::where('id', $l->id_servicios)->pluck('nombre')->first();
            $l->servicio = $servicio;
        }

        return view('backend.bodega3.verificacion.tabla.tablaverificacion', compact('listado'));
    }

    // ---  LISTA DE MATERIALES ---
    // index *
    public function indexTablaMateriales($id){
        return view('backend.bodega3.verificacion.materiales.index', compact('id'));
    }

    // tabla *
    public function tablaMateriales($id){
        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        $dataArray = array();

        foreach ($listado as $l){

            $total = $l->cantidad * $l->preciounitario;
            $l->total = number_format((float)$total, 2, '.', '');


            if($rem = RegistroExtraMaterialDetalleB3::where('id_ingresos_detalle_b3', $l->id)->first()){
                // si lo encuentra es un material extra agregado
                // obtener fecha cuando se agrego

                $infodeta = RegistroExtraMaterialB3::where('id', $rem->id_reg_ex_mate_b3)->first();

                // meter la fecha
                $fecha = date("d-m-Y", strtotime($infodeta->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                    'total' => $total
                ];

            }else{
                // es un material agregado al crear el proyecto
                $daa = IngresosB3::where('id', $l->id_ingresos_b3)->first();

                $fecha = date("d-m-Y", strtotime($daa->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                    'total' => $total
                ];
            }
        }

        // metodos para ordenar el array
        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.bodega3.verificacion.materiales.tabla.tablamateriales', compact('dataArray'));
    }

    // pdf lista materiales *
    public function pdfMateriales($id){

        $info = IngresosB3::where('id', $id)->first();

        $tablas = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        $servicio = ServiciosB3::where('id', $info->id_servicios)->pluck('nombre')->first();
        $fecha = date("d-m-Y", strtotime($info->fecha));
        $codigo = $info->codigo;
        $nota = $info->nota;
        $nombre = $info->nombre;
        $tipo = ServiciosB3::where('id', $info->id_servicios)->pluck('nombre')->first();
        $destino = $info->destino;

        $dataArray = array();

        foreach ($tablas as $l){

            if($rem = RegistroExtraMaterialDetalleB3::where('id_ingresos_detalle_b3', $l->id)->first()){
                // si lo encuentra es un material extra agregado
                // obtener fecha cuando se agrego

                $infodeta = RegistroExtraMaterialB3::where('id', $rem->id_reg_ex_mate_b3)->first();

                // meter la fecha
                $fecha = date("d-m-Y", strtotime($infodeta->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'cantidad' => $l->cantidad,
                    'preciounitario' => $l->preciounitario,
                ];

            }else{
                // es un material agregado al crear el proyecto
                $daa = IngresosB3::where('id', $l->id_ingresos_b3)->first();

                $fecha = date("d-m-Y", strtotime($daa->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'cantidad' => $l->cantidad,
                    'preciounitario' => $l->preciounitario,
                ];
            }
        }

        usort($dataArray, array( $this, 'sortDate' ));

        // obtener cargos y persona

        $lista = IngresosEncargadoB3::where('id_ingresos_b3', $id)->get();

        foreach ($lista as $l){

            $cargo = CargosB3::where('id', $l->id_cargos_b3)->first();
            $l->nombrecargo = $cargo->nombre;

            $persona = EncargadosB3::where('id', $l->id_encargados_b3)->first();
            $l->persona = $persona->nombre;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega3.verificacion.reporte.pdf-material', compact(['info', 'dataArray',
            'servicio', 'fecha', 'codigo', 'nota', 'nombre', 'tipo', 'destino', 'lista']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }


    // vista de encargados *
    public function verEncargadosProyecto($id){

        $nombre = IngresosB3::where('id', $id)->pluck('nombre')->first();

        return view('backend.bodega3.verificacion.encargados.index', compact('id', 'nombre'));
    }

    // vista tabla de encargados *
    public function verEncargadosProyectoTabla($id){

        $lista = IngresosEncargadoB3::where('id_ingresos_b3', $id)->get();

        foreach ($lista as $l){
            $cargo = CargosB3::where('id', $l->id_cargos_b3)->pluck('nombre')->first();
            $persona = EncargadosB3::where('id', $l->id_encargados_b3)->pluck('nombre')->first();

            $l->cargo = $cargo;
            $l->persona = $persona;
        }

        return view('backend.bodega3.verificacion.encargados.tabla.tablaencargados', compact('lista'));
    }



    // vista donde se registra los materiales para verificar *
    public function indexRegistroMaterialVerificacion($id){

        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();
        $bodega = BodegaUbicacionB3::orderBy('nombre')->get();

        $dataArray = array();

        // contar todos los registros del mismo
        foreach ($listado as $l){

            // todos los registros del mismo
            $info = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();

            // suma de toda la cantidad registrada del material.
            // nunca sera mayor al registro
            $total = collect($info)->sum('cantidad');

            if($rem = RegistroExtraMaterialDetalleB3::where('id_ingresos_detalle_b3', $l->id)->first()){
                // si lo encuentra es un material extra agregado
                // obtener fecha cuando se agrego

                $infodeta = RegistroExtraMaterialB3::where('id', $rem->id_reg_ex_mate_b3)->first();

                // meter la fecha
                $fecha = date("d-m-Y", strtotime($infodeta->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'id' => $l->id,
                    'nombre' => $l->nombre,
                    'cantidad' => $l->cantidad,
                    'registrado' => $total,
                ];

            }else{
                // es un material agregado al crear el proyecto
                $daa = IngresosB3::where('id', $l->id_ingresos_b3)->first();

                $fecha = date("d-m-Y", strtotime($daa->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'id' => $l->id,
                    'nombre' => $l->nombre,
                    'cantidad' => $l->cantidad,
                    'registrado' => $total,
                ];
            }
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.bodega3.verificacion.materialverificado.index', compact('id', 'dataArray', 'bodega'));
    }


    // ingresar cantidad verificada
    // ingresar nota + ubicacion de bodega *
    public function ingresarCantidadVerificada(Request $request){

        $regla = array(
            'id' => 'required',
            'bodega' => 'required',
            'identificador' => 'required|array',
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){ return ['success' => 0]; }

        // verificar que al menos 1 material se vaya a registrar como verificacion
        $suma = 0;
        for ($i = 0; $i < count($request->cantidad); $i++) {
            $suma = $suma + $request->cantidad[$i];
        }

        if($suma == 0){
            // no hay cantidad a registrar
            return ['success' => 1];
        }

        // crear registro y colocar su ubicacion de bodega

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');

            $idusuario = Auth::id();

            $veri = new VerificadoIngresoB3();
            $veri->id_ingresos_b3 = $request->id;
            $veri->id_bodega_ubicacion_b3 = $request->bodega;
            $veri->fecha = $fecha;
            $veri->id_usuarios = $idusuario;
            $veri->nota = $request->nota;

            if($veri->save()){

                for ($j = 0; $j < count($request->cantidad); $j++) {

                    // necesitamos revisar que la cantidad a verificar no sea mayor
                    // a la cantidad que fue ingresada

                    // obtener cantidad total que ya habia registrada
                    $info = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $request->identificador[$j])->get();
                    $total = collect($info)->sum('cantidad');

                    // sumar
                    $sumaTotal = $total + $request->cantidad[$j];

                    $infoDetalle = IngresosDetalleB3::where('id', $request->identificador[$j])->first();

                    // suma de toda la cantidad registrada del material.
                    // nunca sera mayor al registro
                    if($sumaTotal > $infoDetalle->cantidad){
                        return ['success' => 2, 'fila' => $j+1, 'nombre' => $infoDetalle->nombre, 'total' => $infoDetalle->cantidad];
                    }

                    // ingresar registro
                    $deta = new VerificadoIngresoDetalleB3();
                    $deta->id_verificado_ingreso_b3 = $veri->id;
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



    // lista de verificaciones para poder editar *
    public function indexListaMaterialVerificado($id){

        $nombre = IngresosB3::where('id', $id)->pluck('nombre')->first();
        return view('backend.bodega3.verificacion.editar.index', compact('id', 'nombre'));
    }

    // tabla *
    public function tablaListaMaterialVerificado($id){

        $idusuario = Auth::id();

        // viene el id del proyecto
        $listado = VerificadoIngresoB3::where('id_ingresos_b3', $id)->orderBy('fecha', 'DESC')->get();

        foreach ($listado as $l){
            $l->fecha = date("d-m-Y h:i A", strtotime($l->fecha));

            $bodega = BodegaUbicacionB3::where('id', $l->id_bodega_ubicacion_b3)->pluck('nombre')->first();
            $l->bodega = $bodega;

            $infouser = Usuario::where('id', $l->id_usuarios)->first();
            $l->usuario = $infouser->nombre;

            if($l->id_usuarios == $idusuario){
                $l->esmio = 1;
            }else{
                $l->esmio = 0;
            }
        }

        return view('backend.bodega3.verificacion.editar.tabla.tablaeditar', compact('listado'));
    }


    // tabla de lista de materiales verificados,
    public function indexMaterialVerificadoEditar($id){

        // viene el id de verificado_ingreso_b3

        $info = VerificadoIngresoB3::where('id', $id)->first();
        $nota = $info->nota;

        // para poder situar el select en la ubicacion de bodega
        $idbodega = $info->id_bodega_ubicacion_b3;

        $bodega = BodegaUbicacionB3::orderBy('nombre')->get();

        // lista de materiales verificados
        $listado = VerificadoIngresoDetalleB3::where('id_verificado_ingreso_b3', $id)->orderBy('id', 'ASC')->get();

        // contar todos los registros del mismo
        foreach ($listado as $l){

            // se obtiene la fila de verificado_ingreso_detalle_b3
            $data = IngresosDetalleB3::where('id', $l->id_ingresos_detalle_b3)->first();
            $l->nombre = $data->nombre;

            // cantidad maxima ingresada al crear el proyecto
            $l->cantidadmax = $data->cantidad;

            // todos los registros del mismo
            $deta = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $data->id)
                ->where('id', '!=', $l->id)
                ->get();

            // suma de toda la cantidad registrada del material.
            // nunca sera mayor al registro
            $total = collect($deta)->sum('cantidad');
            $l->cantidadverificada = $total;
        }

        return view('backend.bodega3.verificacion.editar.materiales.index', compact( 'listado',
            'bodega', 'nota', 'idbodega', 'id'));
    }

    // editar
    public function editarMaterialesVerificadoProyecto(Request $request){

        $regla = array(
            'id' => 'required', // id de verificado_ingreso_b3
            'bodega' => 'required',
            'identificador' => 'required|array', // id VerificadoIngresoDetalleB3
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){ return ['success' => 0]; }

        // editar el registro

        DB::beginTransaction();

        try {

            // actualizar ubicacion bodega y nota
            VerificadoIngresoB3::where('id', $request->id)
                ->update(['id_bodega_ubicacion_b3' => $request->bodega,
                    'nota' => $request->nota
                ]);

            for ($j = 0; $j < count($request->cantidad); $j++) {

                // necesitamos revisar que la cantidad a verificar no sea mayor
                // a la cantidad que fue ingresada

                // obtener fila por su id
                $data = VerificadoIngresoDetalleB3::where('id', $request->identificador[$j])->first();

                // obtener cantidad total que ya habia retirada, menos la que viene ahorita
                $info = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $data->id_ingresos_detalle_b3)
                    ->where('id', '!=', $request->identificador[$j]) // no quiero del mismo
                    ->get();

                $total = collect($info)->sum('cantidad');

                // sumar
                $sumaTotal = $total + $request->cantidad[$j];

                // obtener maximo ingresado por admin del proyecto
                $info2 = VerificadoIngresoDetalleB3::where('id', $request->identificador[$j])->first();
                $infoDetalle = IngresosDetalleB3::where('id', $info2->id_ingresos_detalle_b3)->first();

                // suma de toda la cantidad registrada del material.
                // nunca sera mayor al registro
                if($sumaTotal > $infoDetalle->cantidad){
                    return ['success' => 1, 'fila' => $j+1, 'nombre' => $infoDetalle->nombre, 'total' => $infoDetalle->cantidad];
                }

                // sino supera, se puede actualizar cantidad

                VerificadoIngresoDetalleB3::where('id', $request->identificador[$j])
                    ->update(['cantidad' => $request->cantidad[$j]
                    ]);
            }

            DB::commit();
            return ['success' => 2];

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 3];
        }
    }

    public function indexListaDocumentos($id){
        // viene el id de ingresos_b3

        return view('backend.bodega3.verificacion.documento.index', compact('id'));
    }

    public function tablaIndexListaDocumentos($id){
        $listado = DocumentoIngresoB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        $idusuario = Auth::id();

        foreach ($listado as $l){

            if($l->id_usuarios == $idusuario){
                $l->esmio = 1;
            }else{
                $l->esmio = 0;
            }

            $usuario = Usuario::where('id', $l->id_usuarios)->first();
            $l->usuario = $usuario->nombre;
        }

        return view('backend.bodega3.verificacion.documento.tabla.tabladocumento', compact('listado'));
    }

    public function descargarDocumento($url){

        $pathToFile = "storage/documentos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    // ver lista de sobrantes
    public function indexListaSobrantes($id){
        // viene id de ingreso_b3

        $dataArray = array();

        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        foreach ($listado as $l){

            // obtener cantidad verificada
            $listave = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();
            $totalve = collect($listave)->sum('cantidad');
            $l->cantiverificada = $totalve;

            // obtener cantidad retirada
            $listare = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();
            $totalre = collect($listare)->sum('cantidad');
            $l->cantiretirada = $totalre;

            $resta = $totalve - $totalre;
           // $l->sobrante = $resta;

            if($rem = RegistroExtraMaterialDetalleB3::where('id_ingresos_detalle_b3', $l->id)->first()){
                // si lo encuentra es un material extra agregado
                // obtener fecha cuando se agrego

                $infodeta = RegistroExtraMaterialB3::where('id', $rem->id_reg_ex_mate_b3)->first();

                // meter la fecha
                $fecha = date("d-m-Y", strtotime($infodeta->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                    'cantiverificada' => $totalve,
                    'cantiretirada' => $totalre,
                    'sobrante' => $resta
                ];

            }else{
                // es un material agregado al crear el proyecto
                $daa = IngresosB3::where('id', $l->id_ingresos_b3)->first();

                $fecha = date("d-m-Y", strtotime($daa->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre' => $l->nombre,
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                    'cantiverificada' => $totalve,
                    'cantiretirada' => $totalre,
                    'sobrante' => $resta
                ];
            }
        }

        // metodos para ordenar el array
        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.bodega3.verificacion.sobrante.index', compact('dataArray'));
    }

    // metodo para ordenar un array con fechas
    public function sortDate($a, $b){
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) < strtotime($b['fecha'])) ?-1:1;
    }

}
