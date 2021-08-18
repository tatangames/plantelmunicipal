<?php

namespace App\Http\Controllers\Admin\Bodega2\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\EquiposB2;
use App\Models\IngresosB2;
use App\Models\IngresosDetalleB2;
use App\Models\ProveedoresB2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IngresoB2Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:grupo.bodega2.registros');
    }

    public function indexBodega2Ingreso(){

        $equipo = EquiposB2::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        $proveedor = ProveedoresB2::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return view('backend.bodega2.ingreso.index', compact('equipo', 'proveedor'));
    }

    // ingreso de registros para x equipo
    public function registrarDetalleEquipo(Request $request){
        $regla = array(
            'material' => 'required|array',
            'preciounitario' => 'required|array',
            'cantidad' => 'required|array',
            'equipo' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');

            $idusuario = Auth::id();

            // guardar el primer registro tabla "ingresos"
            $ingreso = new IngresosB2();
            $ingreso->id_usuarios = $idusuario;
            $ingreso->id_equipo2 = $request->equipo;
            $ingreso->fecha = $fecha;
            $ingreso->nota = $request->nota;


            if($ingreso->save()){

                // verificar si existe el nombre del repuesto sino guardar
                // un registro nuevo y obtener su id
                for ($i = 0; $i < count($request->material); $i++) {

                    $ingresoDetalle = new IngresosDetalleB2();
                    $ingresoDetalle->id_ingresos_b2 = $ingreso->id;
                    $ingresoDetalle->nombre = $request->material[$i];
                    $ingresoDetalle->codigo = $request->codigo[$i];
                    $ingresoDetalle->cantidad = $request->cantidad[$i];
                    $ingresoDetalle->preciounitario = $request->preciounitario[$i];
                    $ingresoDetalle->save();
                }

                DB::commit();
                return ['success' => 1];
            }

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 2];
        }
    }


    public function indexEditarRegistros(){
        return view('backend.bodega2.editar.index');
    }

    public function tablaEditarRegistros(){

        $listado = IngresosB2::orderBy('fecha', 'ASC')->get();

        foreach ($listado as $l){

            $fecha = date("d-m-Y h:i A", strtotime($l->fecha));
            $l->fecha = $fecha;

            $equi = EquiposB2::where('id', $l->id_equipo2)->first();
            $l->equiponombre = $equi->nombre;

            $prove = ProveedoresB2::where('id', $l->proveedorb2_id)->first();
            $l->proveedor = $prove->nombre;
        }

        return view('backend.bodega2.editar.tabla.tablaeditar', compact('listado'));
    }

    public function listadoEditarRegistro($id){
        $listado = IngresosDetalleB2::where('id_ingresos_b2', $id)->get();

        $info = IngresosB2::where('id', $id)->first();

        $nota = $info->nota;

        $equipos = EquiposB2::orderBy('nombre')->get();
        $proveedor = ProveedoresB2::orderBy('nombre')->get();

        $idequipo = $info->id_equipo2;
        $idproveedor = $info->proveedorb2_id;

        $fila = 0;

        foreach ($listado as $l){
            $fila++;

            $l->fila = $fila;
        }

        return view('backend.bodega2.editar.lista.index', compact('listado', 'equipos', 'nota', 'idequipo', 'id', 'idproveedor', 'proveedor'));
    }

    // editar materiales por un admin calificado
    public function editarMaterialesProyecto(Request $request){

        $regla = array(
            'id' => 'required',
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

            IngresosB2::where('id', $request->id)
                ->update(['id_equipo2' => $request->selectequipo,
                    'nota' => $request->nota,
                    'proveedorb2_id' => $request->proveedor
                ]);

            // recorrer cada material para actualizarlo
            for ($i = 0; $i < count($request->material); $i++) {

                IngresosDetalleB2::where('id', $request->identificador[$i])
                    ->update(['nombre' => $request->material[$i],
                        'cantidad' => $request->cantidad[$i],
                        'preciounitario' => $request->precio[$i],
                        'codigo' => $request->codigo[$i]
                    ]);
            }

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 2];
        }
    }


}
