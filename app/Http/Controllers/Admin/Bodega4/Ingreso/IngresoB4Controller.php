<?php

namespace App\Http\Controllers\Admin\Bodega4\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\IngresosB4;
use App\Models\IngresosDetalleB4;
use App\Models\ProveedoresB4;
use App\Models\RegistroBodegaB4;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IngresoB4Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexBodegaIngreso(){

        $proveedores = ProveedoresB4::orderBy('empresa')
            ->get();

        return view('backend.bodega4.ingreso.index', compact( 'proveedores'));
    }

    // se realiza una busqueda por nombre o por codigo
    public function busquedaMaterial(Request $request){

        $material = RegistroBodegaB4::where('nombre', 'like', '%' . $request->nombre . '%')
            ->orWhere('codigo', 'like', '%' . $request->nombre . '%')
            ->select('nombre AS label')
            ->take(8)
            ->get();

        return $material;
    }

    // ingreso de material
    public function registrarMateriales(Request $request){
        $regla = array(
            'proveedor' => 'required',
            'material' => 'required|array',
            'preciounitario' => 'required|array',
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){
            return ['success' => 0];
        }

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');

            $idusuario = Auth::id();

            // guardar el primer registro tabla "ingresos"
            $ingreso = new IngresosB4();
            $ingreso->id_proveedor_b4 = $request->proveedor;
            $ingreso->id_usuarios = $idusuario;
            $ingreso->fecha = $fecha;
            $ingreso->nota = $request->nota;

            if($ingreso->save()){

                // verificar si existe el nombre del repuesto sino guardar
                // un registro nuevo y obtener su id
                for ($i = 0; $i < count($request->material); $i++) {

                    // si existe el nombre, solo ingresar el registro nuevo
                    if($data = RegistroBodegaB4::where('nombre', $request->material[$i])->first()){
                        $ingresoDetalle = new IngresosDetalleB4();
                        $ingresoDetalle->id_ingresos_b4 = $ingreso->id;
                        $ingresoDetalle->id_registro_bodega_b4 = $data->id;
                        $ingresoDetalle->descripcion = $request->descripcion[$i];
                        $ingresoDetalle->cantidad = $request->cantidad[$i];
                        $ingresoDetalle->preciounitario = $request->preciounitario[$i];
                        $ingresoDetalle->save();
                    }else{
                        return ['success' => 1, 'fila' => $i+1, 'nombre' => $request->material[$i]];
                    }
                }

                DB::commit();
                return ['success' => 2];
            }

        }catch(\Throwable $e){
            DB::rollback();

            return ['success' => 3];
        }
    }

}
