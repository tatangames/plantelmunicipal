<?php

namespace App\Http\Controllers\Admin\Bodega3\Ingresos;

use App\Http\Controllers\Controller;
use App\Models\BodegaUbicacionB3;
use App\Models\CargosB3;
use App\Models\DocumentoIngresoB3;
use App\Models\EncargadosB3;
use App\Models\EstadoProyectoB3;
use App\Models\IngresosB3;
use App\Models\IngresosDetalleB3;
use App\Models\IngresosEncargadoB3;
use App\Models\RegistroExtraMaterialB3;
use App\Models\RegistroExtraMaterialDetalleB3;
use App\Models\RetiroBodegaB3;
use App\Models\RetiroBodegaDetalleB3;
use App\Models\ServiciosB3;
use App\Models\TipoRetiroB3;
use App\Models\Usuario;
use App\Models\VerificadoIngresoB3;
use App\Models\VerificadoIngresoDetalleB3;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IngresosB3Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexBodega3Ingreso(){

        // nombre de las personas
        $persona = EncargadosB3::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        // tipo de servicio
        $servicio = ServiciosB3::orderBy('nombre')->get();

        // tipos de cargo
        $cargo = CargosB3::orderBy('nombre')->get();

        return view('backend.bodega3.ingreso.index', compact('persona', 'servicio', 'cargo'));
    }

    // ingreso de registros para x equipo
    public function registrarIngreso(Request $request){
        $regla = array(
            'cargo' => 'required|array',
            'persona' => 'required|array',
            'material' => 'required|array',
            'preciounitario' => 'required|array',
            'cantidad' => 'required|array',
            'servicio' => 'required',
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            if($request->file('documento')){

                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena.$tiempo;
                $nombre = str_replace(' ', '_', $union);

                // guardar imagen en disco
                $extension = '.'.$request->documento->getClientOriginalExtension();
                $nombreDocumento = $nombre.$extension;
                $avatar = $request->file('documento');

                $upload = Storage::disk('documentos')->put($nombreDocumento, \File::get($avatar));

                if($upload){
                    // guardar info

                    // guardar el primer registro tabla "ingresos"
                    $ingreso = new IngresosB3();
                    $ingreso->id_usuarios = $idusuario;
                    $ingreso->id_servicios = $request->servicio;
                    $ingreso->id_estado_proyecto_b3 = 1; // proyecto en ejecucion
                    $ingreso->nombre = $request->nombre;
                    $ingreso->nota = $request->nota;
                    $ingreso->codigo = $request->codigo;
                    $ingreso->fecha = $fecha;
                    $ingreso->destino = $request->destino;

                    // servicio en ejecucion
                    $ingreso->id_estado_proyecto_b3 = 1;

                    $ingreso->save();

                    // ingresar detalles de materiales
                    for ($i = 0; $i < count($request->material); $i++) {

                        $ingresoDetalle = new IngresosDetalleB3();
                        $ingresoDetalle->id_ingresos_b3 = $ingreso->id;
                        $ingresoDetalle->nombre = $request->material[$i];
                        $ingresoDetalle->cantidad = $request->cantidad[$i];
                        $ingresoDetalle->preciounitario = $request->preciounitario[$i];
                        $ingresoDetalle->save();
                    }

                    // ingresar encargados del servicio
                    for ($j = 0; $j < count($request->cargo); $j++) {

                        $cargo = new IngresosEncargadoB3();
                        $cargo->id_ingresos_b3 = $ingreso->id;
                        $cargo->id_cargos_b3 = $request->cargo[$j];
                        $cargo->id_encargados_b3 = $request->persona[$j];
                        $cargo->save();
                    }

                    // guardar registro del documento

                    $docu = new DocumentoIngresoB3();
                    $docu->id_ingresos_b3 = $ingreso->id;
                    $docu->nombre = $request->nombredoc;
                    $docu->urldoc = $nombreDocumento;
                    $docu->id_usuarios = $idusuario;
                    $docu->save();

                    DB::commit();
                    return ['success' => 1];

                }else{
                    return ['success' => 2];
                }
            }else{
                // solo guardar info

                // guardar el primer registro tabla "ingresos"
                $ingreso = new IngresosB3();
                $ingreso->id_usuarios = $idusuario;
                $ingreso->id_servicios = $request->servicio;
                $ingreso->id_estado_proyecto_b3 = 1; // proyecto en ejecucion
                $ingreso->nombre = $request->nombre;
                $ingreso->nota = $request->nota;
                $ingreso->codigo = $request->codigo;
                $ingreso->fecha = $fecha;
                $ingreso->destino = $request->destino;

                // servicio en ejecucion
                $ingreso->id_estado_proyecto_b3 = 1;

                $ingreso->save();

                // ingresar detalles de materiales
                for ($i = 0; $i < count($request->material); $i++) {

                    $ingresoDetalle = new IngresosDetalleB3();
                    $ingresoDetalle->id_ingresos_b3 = $ingreso->id;
                    $ingresoDetalle->nombre = $request->material[$i];
                    $ingresoDetalle->cantidad = $request->cantidad[$i];
                    $ingresoDetalle->preciounitario = $request->preciounitario[$i];
                    $ingresoDetalle->save();
                }

                // ingresar encargados del servicio
                for ($j = 0; $j < count($request->cargo); $j++) {

                    $cargo = new IngresosEncargadoB3();
                    $cargo->id_ingresos_b3 = $ingreso->id;
                    $cargo->id_cargos_b3 = $request->cargo[$j];
                    $cargo->id_encargados_b3 = $request->persona[$j];
                    $cargo->save();
                }

                DB::commit();
                return ['success' => 1];
            }

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 2];
        }
    }

    // --- REGISTROS EDITAR ---

    public function indexBodega3IngresoEditar(){
        return view('backend.bodega3.ingreso.editar.index');
    }

    // tabla de todos los proyectos
    public function tablaIndexIngresoEditar(){

        $listado = IngresosB3::orderBy('fecha', 'ASC')->get();

        $idusuario = Auth::id();

        foreach ($listado as $l){
            $l->fecha = date("d-m-Y", strtotime($l->fecha));
            $servicio = ServiciosB3::where('id', $l->id_servicios)->pluck('nombre')->first();
            $l->servicio = $servicio;

            $estado = EstadoProyectoB3::where('id', $l->id_estado_proyecto_b3)->pluck('nombre')->first();
            $fechater = "";

            if($l->id_estado_proyecto_b3 == 2) {
                if ($l->fecha_terminado != null) {
                    $fechater = date("d-m-Y h:i A", strtotime($l->fecha_terminado));
                }
            }

            if($l->id_usuarios == $idusuario){
                $l->esmio = 1;
            }else{
                $l->esmio = 0;
            }

            $usuario = Usuario::where('id', $l->id_usuarios)->pluck('nombre')->first();
            $l->usuario = $usuario;

            $l->estado = $estado . " " . $fechater;
        }

        return view('backend.bodega3.ingreso.editar.tabla.tablaeditar', compact('listado'));
    }

    // pdf del proyecto
    public function pdfProyecto($id){

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

            $total = $l->cantidad * $l->preciounitario;
            $total = number_format((float)$total, 2, '.', '');

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
                    'total' =>  $total
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
                    'total' =>  $total
                ];
            }
        }


        usort($dataArray, array( $this, 'sortDate' ));

        $lista = IngresosEncargadoB3::where('id_ingresos_b3', $id)->get();

        foreach ($lista as $l){

            $cargo = CargosB3::where('id', $l->id_cargos_b3)->first();
            $l->nombrecargo = $cargo->nombre;

            $persona = EncargadosB3::where('id', $l->id_encargados_b3)->first();
            $l->persona = $persona->nombre;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega3.ingreso.editar.reporte.pdf-proyecto', compact(['info', 'dataArray',
            'servicio', 'fecha', 'codigo', 'nota', 'nombre', 'tipo', 'destino', 'lista']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    // lista de materiales de un proyecto para editar cantidad si se equivoco
    public function indexMaterialesEditar($id){

        $info = IngresosB3::where('id', $id)->first();
        $nombre = $info->nombre;
        $destino = $info->destino;
        $codigo = $info->codigo;
        $nota = $info->nota;
        $idservicio = $info->id_servicios;

        $lista = ServiciosB3::orderBy('nombre')->get();

        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        $dataArray = array();

        foreach ($listado as $l){
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
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                ];

            }else{
                // es un material agregado al crear el proyecto
                $daa = IngresosB3::where('id', $l->id_ingresos_b3)->first();

                $fecha = date("d-m-Y", strtotime($daa->fecha));

                $dataArray[] = [
                    'fecha' => $fecha,
                    'id' => $l->id,
                    'nombre' => $l->nombre,
                    'preciounitario' => $l->preciounitario,
                    'cantidad' => $l->cantidad,
                ];
            }
        }

        // metodos para ordenar el array
        usort($dataArray, array( $this, 'sortDate' ));

        $fila = 1;

        return view('backend.bodega3.ingreso.editar.modificar.index', compact('id',
            'dataArray', 'nombre', 'destino', 'codigo', 'nota', 'idservicio', 'lista', 'fila'));
    }

    // metodo para ordenar un array con fechas
    public function sortDate($a, $b){
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) < strtotime($b['fecha'])) ?-1:1;
    }


    // editar materiales por un admin calificado
    public function editarMaterialesProyecto(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'destino' => 'required',
            'identificador' => 'required|array',
            'material' => 'required|array',
            'precio' => 'required|array',
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            // editar ingreso_b3

            IngresosB3::where('id', $request->id)
                ->update(['nombre' => $request->nombre,
                    'destino' => $request->destino,
                    'codigo' => $request->codigo,
                    'nota' => $request->nota,
                    'id_servicios' => $request->selectservicio
                ]);

            // recorrer cada material para actualizarlo
            for ($i = 0; $i < count($request->material); $i++) {

                IngresosDetalleB3::where('id', $request->identificador[$i])
                    ->update(['nombre' => $request->material[$i],
                        'cantidad' => $request->cantidad[$i],
                        'preciounitario' => $request->precio[$i],
                    ]);
            }

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 2];
        }
    }

    // index para agregar extra material
    public function indexBodega3IngresoExtraMaterial($id){

        return view('backend.bodega3.ingreso.extramaterial.index', compact('id'));
    }

    // registrar extra material
    public function registrarIngresoExtraMaterial(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // registrar la nota al ingreso extra
            $deta = new RegistroExtraMaterialB3();
            $deta->fecha = $fecha;
            $deta->id_ingresos_b3 = $request->id;
            $deta->nota = $request->nota;
            $deta->id_usuarios = $idusuario;
            $deta->save();

            // ingresar detalles de materiales
            for ($i = 0; $i < count($request->material); $i++) {

                $ingresoDetalle = new IngresosDetalleB3();
                $ingresoDetalle->id_ingresos_b3 = $request->id;
                $ingresoDetalle->nombre = $request->material[$i];
                $ingresoDetalle->cantidad = $request->cantidad[$i];
                $ingresoDetalle->preciounitario = $request->preciounitario[$i];
                $ingresoDetalle->save();

                // hoy guardar la lista de materiales extra en detalle
                $reg = new RegistroExtraMaterialDetalleB3();
                $reg->id_reg_ex_mate_b3 = $deta->id;
                $reg->id_ingresos_detalle_b3 = $ingresoDetalle->id;
                $reg->save();
            }

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 2];
        }
    }

    public function indexListaDocumentos($id){
        // viene el id de ingresos_b3

        return view('backend.bodega3.ingreso.editar.documento.index', compact('id'));
    }

    public function tablaIndexListaDocumentos($id){
        $listado = DocumentoIngresoB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();

        $idusuario = Auth::id();

        foreach ($listado as $l){
            $infousuario = Usuario::where('id', $l->id_usuarios)->first();
            $l->usuario = $infousuario->nombre;

            if($l->id_usuarios == $idusuario){
                $l->esmio = 1;
            }else{
                $l->esmio = 0;
            }
        }

        return view('backend.bodega3.ingreso.editar.documento.tabla.tabladocumento', compact('listado'));
    }

    public function descargarDocumento($url){

        $pathToFile = "storage/documentos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    public function nuevoDocumento(Request $request){

        // validacion si manda el documento pdf

        $cadena = Str::random(15);
        $tiempo = microtime();
        $union = $cadena.$tiempo;
        $nombre = str_replace(' ', '_', $union);

        // guardar imagen en disco
        $extension = '.'.$request->documento->getClientOriginalExtension();
        $nombreDocumento = $nombre.$extension;
        $avatar = $request->file('documento');

        $upload = Storage::disk('documentos')->put($nombreDocumento, \File::get($avatar));

        if($upload){

            $idusuario = Auth::id();

            $docu = new DocumentoIngresoB3();
            $docu->id_ingresos_b3 = $request->id;
            $docu->nombre = $request->nombredoc;
            $docu->urldoc = $nombreDocumento;
            $docu->id_usuarios = $idusuario;

            if($docu->save()){
                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }else{
            return ['success' => 2];
        }
    }

    public function indexListaRetiros($id){
        return view('backend.bodega3.ingreso.verretiros.index', compact('id'));
    }

    public function tablaIndexListaRetiros($id){
        // viene el id de ingreso_b3

        $listado = RetiroBodegaB3::where('id_ingresos_b3', $id)
            ->orderBy('fecha', 'DESC')
            ->get();

        foreach ($listado as $l){
            $fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $l->fecha = $fecha;

            $tipo = TipoRetiroB3::where('id', $l->id_tipo_retiro_b3)->pluck('nombre')->first();
            $l->tipo = $tipo;

            $persona = Usuario::where('id', $l->id_usuarios)->pluck('nombre')->first();
            $l->persona = $persona;

            $bodega = BodegaUbicacionB3::where('id', $l->id_bodega_b3)->pluck('nombre')->first();
            $l->bodega = $bodega;
        }

        return view('backend.bodega3.ingreso.verretiros.tabla.tablaverretiros', compact('listado'));
    }

    // mostrar la lista segun id
    public function indexListaRetirosMateriales($id){

        $listado = RetiroBodegaDetalleB3::where('id_retiro_bodega_b3', $id)->get();

        foreach ($listado as $l){
            $material = IngresosDetalleB3::where('id', $l->id_ingresos_detalle_b3)->pluck('nombre')->first();
            $l->material = $material;
        }

        return view('backend.bodega3.ingreso.verretiros.lista.index', compact('listado'));
    }

    // ver lista de sobrantes
    public function indexListaSobrantes($id){
        // viene id de ingreso_b3

        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();
        $dataArray = array();

        foreach ($listado as $l){

            // obtener cantidad verificada
            $listave = VerificadoIngresoDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();
            $totalve = collect($listave)->sum('cantidad');

            // obtener cantidad retirada
            $listare = RetiroBodegaDetalleB3::where('id_ingresos_detalle_b3', $l->id)->get();
            $totalre = collect($listare)->sum('cantidad');

            $resta = $totalve - $totalre;

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
                    'cantidad' => $l->cantidad,
                    'cantiverificada' => $totalve,
                    'cantiretirada' => $totalre,
                    'sobrante' => $resta
                ];
            }
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.bodega3.ingreso.sobrante.index', compact('dataArray'));
    }

    public function verEncargadosProyecto($id){

        $nombre = IngresosB3::where('id', $id)->pluck('nombre')->first();

        return view('backend.bodega3.ingreso.encargados.index', compact('id', 'nombre'));
    }

    // vista tabla de encargados
    public function verEncargadosProyectoTabla($id){

        $lista = IngresosEncargadoB3::where('id_ingresos_b3', $id)->get();

        foreach ($lista as $l){
            $cargo = CargosB3::where('id', $l->id_cargos_b3)->pluck('nombre')->first();
            $persona = EncargadosB3::where('id', $l->id_encargados_b3)->pluck('nombre')->first();

            $l->cargo = $cargo;
            $l->persona = $persona;
        }

        return view('backend.bodega3.ingreso.encargados.tabla.tablaencargados', compact('lista'));
    }

    // index lista de materiales
    public function indexTablaMateriales($id){
        return view('backend.bodega3.ingreso.listamaterial.index', compact('id'));
    }

    // tabla *
    public function tablaMateriales($id){
        $listado = IngresosDetalleB3::where('id_ingresos_b3', $id)->orderBy('nombre')->get();
        $dataArray = array();

        foreach ($listado as $l){

            $total = $l->cantidad * $l->preciounitario;
            $total = number_format((float)$total, 2, '.', '');

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

        return view('backend.bodega3.ingreso.listamaterial.tabla.tablalistamaterial', compact('dataArray'));
    }

    // lista de materiales extra + fecha y nota
    public function indexMaterialExtra($id){
        return view('backend.bodega3.ingreso.listamaterial.extra.index', compact('id'));
    }

    // tabla
    public function indexTablaMaterialExtra($id){
        $listado = RegistroExtraMaterialB3::where('id_ingresos_b3', $id)->orderBy('fecha')->get();

        foreach ($listado as $l){
            $fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $l->fecha = $fecha;

            $usuario = Usuario::where('id', $l->id_usuarios)->first();
            $l->usuario = $usuario->nombre;
        }

        return view('backend.bodega3.ingreso.listamaterial.extra.tabla.tablaextra', compact('listado'));
    }

    // lista detalle de materiales extra
    public function indexMaterialExtraDetalle($id){

        $listado = RegistroExtraMaterialDetalleB3::where('id_reg_ex_mate_b3', $id)->orderBy('id', 'DESC')->get();

        foreach ($listado as $l){

            $info = IngresosDetalleB3::where('id', $l->id_ingresos_detalle_b3)->first();

            $l->material = $info->nombre;
            $l->cantidad = $info->cantidad;
            $l->preciounitario = $info->preciounitario;

            $total = $l->cantidad * $l->preciounitario;
            $l->total = number_format((float)$total, 2, '.', '');
        }

        return view('backend.bodega3.ingreso.listamaterial.extra.lista.index', compact('listado'));
    }


    public function indexListaVerificados($id){
        return view('backend.bodega3.ingreso.listaverificados.index', compact('id'));
    }

    public function tablaIndexListaVerificados($id){
        // viene el id de ingreso_b3

        $listado = VerificadoIngresoB3::where('id_ingresos_b3', $id)
            ->orderBy('fecha', 'DESC')
            ->get();

        foreach ($listado as $l){
            $fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $l->fecha = $fecha;

            $bodega = BodegaUbicacionB3::where('id', $l->id_bodega_ubicacion_b3)->pluck('nombre')->first();
            $l->bodega = $bodega;

            $persona = Usuario::where('id', $l->id_usuarios)->pluck('nombre')->first();
            $l->persona = $persona;
        }

        return view('backend.bodega3.ingreso.listaverificados.tabla.tablalistaverificados', compact('listado'));
    }

    public function detalleListaVerificados($id){
        // viene id del verificado

        $listado = VerificadoIngresoDetalleB3::where('id_verificado_ingreso_b3', $id)->orderBy('id', 'DESC')->get();

        foreach ($listado as $l){
           $material = IngresosDetalleB3::where('id', $l->id_ingresos_detalle_b3)->pluck('nombre')->first();
           $l->material = $material;
        }

        return view('backend.bodega3.ingreso.listaverificados.lista.index', compact('listado'));
    }

    // public informacion de proyectos
    public function informacionProyecto(Request $request){

        $idusuario = Auth::id();

        // primero saver si el proyecto fue creado por idusuario
        $data = IngresosB3::where('id', $request->id)->first();

        $esmio = 0;

        if($data->id_usuarios == $idusuario){
            $esmio = 1;
        }

        return ['success' => 1, 'esmio' => $esmio];
    }

    // borrar documento
    public function borrarDocumento(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) { return ['success' => 0]; }

        $idusuario = Auth::id();

        if($data = DocumentoIngresoB3::where('id', $request->id)->first()){
            // solo puedo borrar si es mi archivo subido
            if($data->id_usuarios == $idusuario){

                $imagenOld = $data->urldoc;

                DocumentoIngresoB3::where('id', $request->id)->delete();

                // borrar foto anterior
                if(Storage::disk('documentos')->exists($imagenOld)){
                    Storage::disk('documentos')->delete($imagenOld);
                }
            }

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }




}
