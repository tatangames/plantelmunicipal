<?php

namespace App\Http\Controllers\Admin\Bodega1\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\CondicionB1;
use App\Models\EquiposB1;
use App\Models\IngresosB1;
use App\Models\IngresosDetalleB1;
use App\Models\ProveedoresB1;
use App\Models\RegistroBodegaB1;
use App\Models\TiposB1;
use App\Models\UnidadMedidaB1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PDF;

class IngresoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.bodega.ingreso');
    }

    public function indexBodegaIngreso(){
        $condicion = CondicionB1::orderBy('id', 'ASC')->get();

        $tipomaterial = TiposB1::where('activo', 1)
            ->orderBy('id', 'ASC')
            ->get();

        $proveedores = ProveedoresB1::where('activo', 1)
            ->select('id', 'empresa')
            ->orderBy('empresa')
            ->get();

        $unidad = UnidadMedidaB1::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('id')
            ->get();

        $equipo = EquiposB1::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return view('backend.bodega1.ingreso.index', compact('condicion',
            'tipomaterial', 'proveedores', 'unidad', 'equipo'));
    }

    // se realiza una busqueda por nombre o por codigo
    public function busquedaMaterial(Request $request){

        $material = RegistroBodegaB1::where('nombre', 'like', '%' . $request->nombre . '%')
            ->orWhere('codigo', 'like', '%' . $request->nombre . '%')
            ->select('nombre AS label')
            ->take(8)
            ->get();

        return $material;
    }

    // ingreso de material
    public function registrarMateriales(Request $request){
        $regla = array(
            'condicion' => 'required',
            'tipomaterial' => 'required',
            'proveedor' => 'required',
            'material' => 'required|array',
            'preciounitario' => 'required|array',
            'unidadmedida' => 'required|array',
            'cantidad' => 'required|array',
            'equipo' => 'required'
        );

        $mensaje = array(
            'condicion.required' => 'ID Condición es requerido',
            'tipomaterial.required' => 'ID Tipo Material es requerida',
            'proveedor.required' => 'ID Proveedor es requerido',
            'material.required' => 'Nombre Material es requerido',
            'material.array' => 'Nombre Material Array es requerido',
            'preciounitario.required' => 'Precio unitario es requerido',
            'preciounitario.array' => 'Precio unitario Array es requerido',
            'unidadmedida.required' => 'Unidad medida es requerido',
            'unidadmedida.array' => 'Unidad medida Array es requerido',
            'cantidad.required' => 'Cantidad es requerido',
            'cantidad.array' => 'Cantidad Array es requerido',
            'equipo.required' => 'Equipo ID es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){
            return ['success' => 0];
        }

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');

            $idusuario = Auth::id();

            // guardar el primer registro tabla "ingresos"
            $ingreso = new IngresosB1();
            $ingreso->id_proveedor = $request->proveedor;
            $ingreso->id_tipomaterial = $request->tipomaterial;
            $ingreso->id_tipoingreso = $request->condicion;
            $ingreso->id_usuarios = $idusuario;
            $ingreso->id_equipo = $request->equipo;
            $ingreso->fecha = $fecha;

            if($ingreso->save()){

                // verificar si existe el nombre del repuesto sino guardar
                // un registro nuevo y obtener su id
                for ($i = 0; $i < count($request->material); $i++) {

                    // si existe el nombre, solo ingresar el registro nuevo
                    if($data = RegistroBodegaB1::where('nombre', $request->material[$i])->first()){
                        $ingresoDetalle = new IngresosDetalleB1();
                        $ingresoDetalle->id_ingresos = $ingreso->id;
                        $ingresoDetalle->id_unidadmedida = $request->unidadmedida[$i];
                        $ingresoDetalle->id_registro_bodega = $data->id;
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
