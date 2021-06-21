<?php

namespace App\Http\Controllers\Admin\Bodega1\Reportes;

use App\Http\Controllers\Controller;
use App\Models\IngresosB1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class ReporteBodega1Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:vista.grupo.bodega1.reportes.reporte-ingreso', ['only' => ['indexReporteBodegaIngreso',
            'reporteBodegaIngreso']]);
        $this->middleware('can:vista.grupo.bodega1.reportes.reporte-retiro', ['only' => ['indexReporteBodegaRetiro',
            'reporteBodegaRetiro']]);
    }

    public function indexReporteBodegaIngreso(){
        return view('backend.bodega1.reportes.ingreso.index');
    }

    public function indexReporteBodegaRetiro(){
        return view('backend.bodega1.reportes.retiro.index');
    }

    public function reporteBodegaIngreso($fecha1, $fecha2){

        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de ingreso por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = DB::table('ingresos_b1 AS i')
            ->join('proveedores_b1 AS b', 'b.id', '=', 'i.id_proveedor')
            ->join('tipos_b1 AS t', 't.id', '=', 'i.id_tipomaterial')
            ->join('condicion_b1 AS c', 'c.id', '=', 'i.id_tipoingreso')
            ->join('equipos_b1 AS e', 'e.id', '=', 'i.id_equipo')
            ->select('i.id', 'b.empresa', 't.nombre AS tipo', 'c.nombre AS condicion',
                            'e.nombre AS equipo', 'i.fecha')
            ->whereBetween('i.fecha', array($date1, $date2)) // fecha entrego el encargo
                ->orderBy('i.fecha', 'ASC')
            ->get();

        // modificar el formato de fecha
        foreach ($tablas as $fe){
            $info = date("d-m-Y h:i A", strtotime($fe->fecha));
            $fe->fecha = $info;
        }


        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = DB::table('ingresos_detalle_b1 AS id')
                ->join('unidad_medida_b1 AS um', 'um.id', '=', 'id.id_unidadmedida')
                ->join('registro_bodega_b1 AS rb', 'rb.id', '=', 'id.id_registro_bodega')
                ->select('id.id_ingresos', 'um.nombre AS unidadmedida', 'rb.nombre AS nombrematerial',
                        'id.descripcion', 'id.cantidad', 'id.preciounitario')
                ->where('id.id_ingresos', $secciones->id) // segun el ID
                ->get();

            // despues de obtener todos los detalles se sumara el total ingresado
            $total = collect($subSecciones)->sum('preciounitario');
            $secciones->total = number_format((float)$total, 2, '.', '');

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega1.reportes.tablas.registro-materiales', compact(['f1', 'f2', 'tablas']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function reporteBodegaRetiro($fecha1, $fecha2){

        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de retiro por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = DB::table('retiro_bodega_b1 AS rb')
            ->join('persona_b1 AS p', 'p.id', '=', 'rb.id_persona')
            ->join('equipos_b1 AS e', 'e.id', '=', 'rb.id_equipo')
            ->select('rb.id', 'p.nombre AS nombrepersona', 'e.nombre AS equipo',
                            'rb.nota', 'rb.fecha')
            ->whereBetween('rb.fecha', array($date1, $date2)) // fecha entrego el encargo
            ->orderBy('rb.fecha', 'ASC')
            ->get();

        // fecha, equipo, notas, quien solicito

        // modificar el formato de fecha
        foreach ($tablas as $fe){
            $info = date("d-m-Y h:i A", strtotime($fe->fecha));
            $fe->fecha = $info;
        }

        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = DB::table('retiro_bodega_detalle_b1 AS rbd')
                ->join('registro_bodega_b1 AS rb1', 'rb1.id', '=', 'rbd.id_registro_bodega')
                ->select('rbd.id_retiro_bodega', 'rb1.nombre AS nombrematerial', 'rbd.cantidad', 'rbd.descripcion')
                ->where('rbd.id_retiro_bodega', $secciones->id) // segun el ID
                ->get();

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega1.reportes.tablas.retiro-materiales', compact(['f1', 'f2', 'tablas']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }


}
