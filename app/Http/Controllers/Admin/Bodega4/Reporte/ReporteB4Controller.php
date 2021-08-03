<?php

namespace App\Http\Controllers\Admin\Bodega4\Reporte;

use App\Http\Controllers\Controller;
use App\Models\IngresosDetalleB4;
use App\Models\RetiroBodegaB4;
use App\Models\RetiroBodegaDetalleB4;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteB4Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexReporteBodegaIngreso(){
        return view('backend.bodega4.reportes.ingreso.index');
    }

    public function indexReporteBodegaRetiro(){
        return view('backend.bodega4.reportes.retiro.index');
    }

    public function reporteBodegaIngreso($fecha1, $fecha2){

        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de ingreso por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = DB::table('ingresos_b4 AS i')
            ->join('proveedores_b4 AS b', 'b.id', '=', 'i.id_proveedor_b4')
            ->select('i.id', 'b.empresa', 'i.fecha')
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
            $subSecciones = DB::table('ingresos_detalle_b4 AS id')
                ->join('registro_bodega_b4 AS rb', 'rb.id', '=', 'id.id_registro_bodega_b4')
                ->select('id.id_ingresos_b4', 'rb.nombre AS nombrematerial', 'id.descripcion', 'id.cantidad', 'id.preciounitario')
                ->where('id.id_ingresos_b4', $secciones->id) // segun el ID
                ->get();

            // despues de obtener todos los detalles se sumara el total ingresado
            $total = collect($subSecciones)->sum('preciounitario');
            $secciones->total = number_format((float)$total, 2, '.', '');

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega4.reportes.tablas.registro-materiales', compact(['f1', 'f2', 'tablas']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function reporteBodegaIngresoFila($fecha1, $fecha2){

        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de ingreso por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = DB::table('ingresos_b4 AS i')
            ->join('proveedores_b4 AS b', 'b.id', '=', 'i.id_proveedor_b4')
            ->select('i.id', 'b.empresa', 'i.fecha')
            ->whereBetween('i.fecha', array($date1, $date2))
            ->orderBy('i.fecha', 'ASC')
            ->get();

        $fecha = "";

        // modificar el formato de fecha
        foreach ($tablas as $fe){
            $fecha = date("d-m-Y", strtotime($fe->fecha));
        }

        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;

        $dataArray = [];

        $sumatoria = 0;

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = DB::table('ingresos_detalle_b4 AS id')
                ->join('registro_bodega_b4 AS rb', 'rb.id', '=', 'id.id_registro_bodega_b4')
                ->select('id.id_ingresos_b4', 'rb.nombre AS nombrematerial', 'rb.codigo', 'id.cantidad', 'id.preciounitario')
                ->where('id.id_ingresos_b4', $secciones->id) // segun el ID
                ->get();

            // llenar un array
            foreach ($subSecciones as $ss){
                $multiplicado = number_format((float)$ss->cantidad * $ss->preciounitario, 2, '.', '');

                $sumatoria = $sumatoria + $multiplicado;

                // meter registros

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre'=> $ss->nombrematerial,
                    'descripcion' => $ss->codigo,
                    'cantidad' => $ss->cantidad,
                    'preciounitario' => $ss->preciounitario,
                    'totalmultiplicado' => $multiplicado,
                ];
            }

            $sumatoria = number_format((float)$sumatoria, 2, '.', '');

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega4.reportes.tablas.reporte-ingreso-fila', compact(['f1', 'f2', 'dataArray', 'sumatoria']))->render();
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

        $tablas = RetiroBodegaB4::whereBetween('fecha', array($date1, $date2)) // fecha entrego el encargo
        ->orderBy('fecha', 'ASC')
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
            $subSecciones = DB::table('retiro_bodega_detalle_b4 AS rbd')
                ->join('registro_bodega_b4 AS rb1', 'rb1.id', '=', 'rbd.id_registro_bodega_b4')
                ->select('rbd.id_retiro_bodega_b4', 'rb1.nombre AS nombrematerial', 'rbd.cantidad', 'rbd.descripcion')
                ->where('rbd.id_retiro_bodega_b4', $secciones->id) // segun el ID
                ->get();

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega4.reportes.tablas.retiro-materiales', compact(['f1', 'f2', 'tablas']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function reporteBodegaRetiroFila($fecha1, $fecha2){
        $date1 = Carbon::parse($fecha1)->format('Y-m-d');
        $date2 = Carbon::parse($fecha2)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fecha1)->format('d-m-Y');
        $f2 = Carbon::parse($fecha2)->format('d-m-Y');

        // obtener todos los resultados de retiro por fecha desde y hasta
        // ordenar por fecha ascedente

        $tablas = RetiroBodegaB4::whereBetween('fecha', array($date1, $date2)) // fecha entrego el encargo
        ->orderBy('fecha', 'ASC')
            ->get();

        $fecha = "";

        // modificar el formato de fecha
        foreach ($tablas as $fe){
            $fecha = date("d-m-Y", strtotime($fe->fecha));
        }

        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;

        $dataArray = [];

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = DB::table('retiro_bodega_detalle_b4 AS rbd')
                ->join('registro_bodega_b4 AS rb1', 'rb1.id', '=', 'rbd.id_registro_bodega_b4')
                ->select('rbd.id_retiro_bodega_b4', 'rb1.nombre AS nombrematerial', 'rbd.cantidad', 'rb1.codigo')
                ->where('rbd.id_retiro_bodega_b4', $secciones->id) // segun el ID
                ->get();

            // llenar un array
            foreach ($subSecciones as $ss){

                $dataArray[] = [
                    'fecha' => $fecha,
                    'nombre'=> $ss->nombrematerial,
                    'descripcion' => $ss->codigo,
                    'cantidad' => $ss->cantidad,
                ];
            }

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        // generar vista y enviar datos
        $view =  \View::make('backend.bodega4.reportes.tablas.reporte-salida-fila', compact(['f1', 'f2', 'dataArray']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }


    public function informesBodega4(){

        // cantidad de los ingresos detalle
        $ingresoSuma = IngresosDetalleB4::get();
        $sumaIngreso = collect($ingresoSuma)->sum('cantidad');
        $sumaPrecio = collect($ingresoSuma)->sum('preciounitario');

        $sumaPrecio = number_format((float)$sumaPrecio, 2, '.', '');

        // cantidad de los retiros detalle

        $retiro = RetiroBodegaDetalleB4::get();
        $sumaRetiro = collect($retiro)->sum('cantidad');

        $totalActual = $sumaIngreso - $sumaRetiro;

        return view('backend.bodega4.reportes.informe.index', compact('sumaPrecio', 'totalActual'));
    }

}
