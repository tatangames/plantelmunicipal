<?php

namespace App\Http\Controllers\Admin\Bodega2\Reportes;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteBodega2Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:grupo.bodega2.registros');
    }

    public function indexReporteBodega2Ingreso(){
        return view('backend.bodega2.reportes.ingreso.index');
    }

    // generar reporte de los ingresos a los equipos de fecha por fecha
    public function reporteBodega2Ingreso($fecha1, $fecha2){

        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de ingreso por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = DB::table('ingresos_b2 AS i')
            ->join('equipos_b2 AS e', 'e.id', '=', 'i.id_equipo2')
            ->select('i.id', 'e.nombre AS equipo', 'i.fecha', 'i.nota')
            ->whereBetween('i.fecha', array($date1, $date2))
            ->orderBy('i.fecha', 'ASC')
            ->get();

        // modificar el formato de fecha
        foreach ($tablas as $fe){
            $info = date("d-m-Y", strtotime($fe->fecha));
            $fe->fecha = $info;
        }

        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;

        $totalSuma = 0;

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = DB::table('ingresos_detalle_b2 AS id')
                ->select('id.id_ingresos_b2', 'id.nombre', 'id.codigo', 'id.cantidad', 'id.preciounitario')
                ->where('id.id_ingresos_b2', $secciones->id) // segun el ID
                ->get();

            // despues de obtener todos los detalles se sumara el total ingresado
            $total = collect($subSecciones)->sum('preciounitario');
            $totalSuma = $totalSuma + $total;
            $secciones->total = number_format((float)$total, 2, '.', '');

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        $totalSuma = number_format((float)$totalSuma, 2, '.', '');

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega2.reportes.tablas.pdf-ingreso', compact(['f1', 'f2', 'tablas', 'totalSuma']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }


}
