<?php

namespace App\Http\Controllers\Admin\Bodega1\Retiro;

use App\Http\Controllers\Controller;
use App\Models\EquiposB1;
use App\Models\IngresosDetalleB1;
use App\Models\PersonaB1;
use App\Models\RegistroBodegaB1;
use App\Models\RetiroBodegaB1;
use App\Models\RetiroBodegaDetalleB1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RetiroController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.bodega.retiro');
    }

    public function indexBodegaRetiro(){
        $equipo = EquiposB1::where('activo', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return view('backend.bodega1.retiro.index', compact( 'equipo'));
    }

    public function buscarPersona(Request $request){
        $persona = PersonaB1::where('nombre', 'like', '%' . $request->nombre . '%')
            ->where('id', '!=', 1)
            ->select('nombre AS label')
            ->take(7)
            ->get();

        return $persona;
    }

    // registrar una salida, aqui se registra nombre de la persona a retirar
    // una lista de equipos para el uso
    public function registrarRetiro(Request $request){

        $regla = array(
            'equipo' => 'required',
            'material' => 'required|array',
            'cantidad' => 'required|array',
        );


        $validar = Validator::make($request->all(), $regla );

        if ($validar->fails()){
            return ['success' => 0];
        }

        // iniciar el try catch DB

        DB::beginTransaction();

        try {

            $fecha = Carbon::now('America/El_Salvador');

            $idusuario = Auth::id();

            $idpersona = 1; // defecto "Sin nombre"

            // registrar persona quien solicita el retiro
            if($request->persona != null){
                if($dataPersona = PersonaB1::where('nombre', $request->persona)->first()){
                    $idpersona = $dataPersona->id;
                }else{
                    // guardar un nuevo nombre
                    $idpersona = PersonaB1::insertGetId(
                        ['nombre' => $request->persona]
                    );
                }
            }

            // guardar el retiro_bodega

            $retiro = new RetiroBodegaB1();
            $retiro->id_usuarios = $idusuario;
            $retiro->id_persona = $idpersona;
            $retiro->nota = $request->nota;
            $retiro->id_equipo = $request->equipo;
            $retiro->fecha = $fecha;

            if($retiro->save()){
                // guardar retiro bodega detalles
                for ($i = 0; $i < count($request->material); $i++) {

                    // buscar el id del material a retirar, sino se encuentra,
                    // se devolvera una alerta

                    $idmaterial = 0;
                    $nombre = "";
                    if($data = RegistroBodegaB1::where('nombre', $request->material[$i])->first()){
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
                    $obtenido = IngresosDetalleB1::where('id_registro_bodega', $idmaterial)->get();
                    $suma = collect($obtenido)->sum('cantidad'); // ejemplo 20

                    $obtenidoResta = RetiroBodegaDetalleB1::where('id_registro_bodega', $idmaterial)->get();
                    $resta = (collect($obtenidoResta)->sum('cantidad') + $request->cantidad[$i]);
                    // verificar que haya stock aun para hacer un retiro
                    if($resta > $suma){
                        // no hay unidades suficiente para el retiro
                        return ['success' => 2, 'fila' => $i+1, 'nombre' => $nombre, 'total' => $suma];
                    }

                    // registrar cada detalle del retiro

                    $retiroDetalle = new RetiroBodegaDetalleB1();
                    // id repuesto
                    $retiroDetalle->id_retiro_bodega = $retiro->id;
                    // id del retiro
                    $retiroDetalle->id_registro_bodega = $idmaterial;
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
