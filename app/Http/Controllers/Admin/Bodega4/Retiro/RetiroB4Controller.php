<?php

namespace App\Http\Controllers\Admin\Bodega4\Retiro;

use App\Http\Controllers\Controller;
use App\Models\IngresosDetalleB4;
use App\Models\RegistroBodegaB4;
use App\Models\RetiroBodegaB4;
use App\Models\RetiroBodegaDetalleB4;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RetiroB4Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexBodegaRetiro(){
        return view('backend.bodega4.retiro.index');
    }

    public function registrarRetiro(Request $request){

        $regla = array(
            'material' => 'required|array',
            'cantidad' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){ return ['success' => 0]; }

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar el retiro_bodega

            $retiro = new RetiroBodegaB4();
            $retiro->id_usuarios = $idusuario;
            $retiro->nota = $request->nota;
            $retiro->fecha = $fecha;

            if($retiro->save()){
                // guardar retiro bodega detalles
                for ($i = 0; $i < count($request->material); $i++) {

                    // buscar el id del material a retirar, sino se encuentra,
                    // se devolvera una alerta

                    $idmaterial = 0;
                    $nombre = "";
                    if($data = RegistroBodegaB4::where('nombre', $request->material[$i])->first()){
                        $idmaterial = $data->id;
                        $nombre = $data->nombre;
                    }else{
                        // el nombre del material a retirar no existe, asi que mostrar error
                        // debe existir el material para efectuar el retiro.
                        return ['success' => 1, 'fila' => $i+1, 'nombre' => $request->material[$i]];
                    }

                    // verificar que haya stock
                    // sumar todos los ingresos de por vida de un idmaterial
                    // y restar todos los retiros de por vida del mismo idmaterial
                    $obtenido = IngresosDetalleB4::where('id_registro_bodega_b4', $idmaterial)->get();
                    $suma = collect($obtenido)->sum('cantidad'); // ejemplo 20

                    $obtenidoResta = RetiroBodegaDetalleB4::where('id_registro_bodega_b4', $idmaterial)->get();
                    $resta = (collect($obtenidoResta)->sum('cantidad') + $request->cantidad[$i]);
                    // verificar que haya stock aun para hacer un retiro
                    if($resta > $suma){
                        // no hay unidades suficiente para el retiro
                        return ['success' => 2, 'fila' => $i+1, 'nombre' => $nombre, 'total' => $suma];
                    }

                    // registrar cada detalle del retiro

                    $retiroDetalle = new RetiroBodegaDetalleB4();
                    // id repuesto
                    $retiroDetalle->id_retiro_bodega_b4 = $retiro->id;
                    // id del retiro
                    $retiroDetalle->id_registro_bodega_b4 = $idmaterial;
                    $retiroDetalle->cantidad = $request->cantidad[$i];
                    $retiroDetalle->descripcion = $request->descripcion[$i];
                    $retiroDetalle->save();
                }
            }

            DB::commit();
            return ['success' => 3];
        }catch(\Throwable $e){
            DB::rollback();
            return ['success' => 4, 'error' => 'e: ' . $e];
        }
    }

}
