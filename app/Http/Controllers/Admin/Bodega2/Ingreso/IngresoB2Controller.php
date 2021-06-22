<?php

namespace App\Http\Controllers\Admin\Bodega2\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\EquiposB2;
use App\Models\IngresosB2;
use App\Models\IngresosDetalleB2;
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

        return view('backend.bodega2.ingreso.index', compact('equipo'));
    }

    // ingreso de de registros para x equipo
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
}
