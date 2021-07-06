<?php

namespace App\Http\Controllers\Admin\Bodega1\Registro;

use App\Http\Controllers\Controller;
use App\Models\BodegaNumeracion1;
use App\Models\EquiposB1;
use App\Models\IngresosB1;
use App\Models\IngresosDetalleB1;
use App\Models\PersonaB1;
use App\Models\ProveedoresB1;
use App\Models\RegistroBodegaB1;
use App\Models\RetiroBodegaB1;
use App\Models\RetiroBodegaDetalleB1;
use App\Models\UnidadMedidaB1;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistroBodega1Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:vista.grupo.bodega1.equipos.registrar-material', ['only' => ['indexMateriales', 'tablaIndexMateriales']]);
        $this->middleware('can:boton.grupo.bodega1.equipos.registrar-material.btn-agregar', ['only' => ['nuevoMaterial']]);
        $this->middleware('can:boton.grupo.bodega1.equipos.registrar-material.btn-editar', ['only' => ['infoMateriales', 'editarMateriales']]);
        $this->middleware('can:vista.grupo.bodega1.reportes.informe-de-bodega', ['only' => ['informesBodega1', 'infoIngresosFechas']]);
    }

    // vista para registrar materiales
    public function indexMateriales(){
        $bodega = BodegaNumeracion1::orderBy('nombre')->get();
        return view('backend.bodega1.registro.index', compact('bodega'));
    }

    // vista tabla de materiales
    public function tablaIndexMateriales(){
        $listado = DB::table('bodega_numeracion_b1 AS b')
            ->join('registro_bodega_b1 AS r', 'r.id_bodega_num', '=', 'b.id')
            ->select('r.id', 'r.nombre', 'r.codigo', 'b.nombre AS ubicacion', 'r.id_bodega_num')
            ->orderBy('r.nombre')
            ->get();

        foreach ($listado as $l){

            // verificar que haya stock
            // sumar todos los ingresos de por vida de un idmaterial
            // y restar todos los retiros de por vida del mismo idmaterial

            // primero verificar que haya al menos un ingreso
            if(IngresosDetalleB1::where('id_registro_bodega', $l->id)->first()){
                $obtenido = IngresosDetalleB1::where('id_registro_bodega', $l->id)->get();
                $suma = collect($obtenido)->sum('cantidad');

                $obtenidoResta = RetiroBodegaDetalleB1::where('id_registro_bodega', $l->id)->get();
                $total = $suma - collect($obtenidoResta)->sum('cantidad');

                $l->cantidad = $total;
            }else{
                $l->cantidad = 0;
            }
        }

        return view('backend.bodega1.registro.tabla.tablaregistro', compact('listado'));
    }

    public function nuevoMaterial(Request $request){

        $regla = array(
            'nombre' => 'required',
            'bodega' => 'required'
        );

        $mensaje = array(
            'nombre.required' => 'nombre es requerido',
            'bodega.required' => 'bodega es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if(RegistroBodegaB1::where('nombre', $request->nombre)->first()){
            return ['success' => 1];
        }

        if($request->codigo != null){
            if(RegistroBodegaB1::where('codigo', $request->codigo)->first()){
                return ['success' => 2];
            }
        }

        $s = new RegistroBodegaB1();
        $s->nombre = $request->nombre;
        $s->codigo = $request->codigo;
        $s->id_bodega_num  = $request->bodega;

        if($s->save()){
            return ['success' => 3];
        }else{
            return ['success' => 4];
        }
    }

    public function infoMateriales(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = RegistroBodegaB1::where('id', $request->id)->first()){

            $ubicaciones = BodegaNumeracion1::orderBy('nombre')->get();

            return ['success' => 1, 'info' => $data, 'ubicaciones' => $ubicaciones];
        }else{
            return ['success' => 2];
        }
    }

    public function editarMateriales(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'bodega' => 'required'
        );

        $mensaje = array(
            'id.required' => 'ID es requerido',
            'nombre.required' => 'Nombre es requerido',
            'bodega.required' => 'ID Bodega es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if(RegistroBodegaB1::where('nombre', $request->nombre)
            ->where('id', '!=', $request->id)
            ->first()){
            return ['success' => 1];
        }

        if($request->codigo != null) {
            if (RegistroBodegaB1::where('codigo', $request->codigo)
                ->where('id', '!=', $request->id)
                ->first()) {
                return ['success' => 2];
            }
        }

        RegistroBodegaB1::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'id_bodega_num' => $request->bodega
            ]);

        return ['success' => 3];
    }

    // Permiso: acceso libre
    public function indexHistorialIngresoB1($idmaterial){
        $nombre = RegistroBodegaB1::where('id', $idmaterial)->pluck('nombre')->first();
        return view('backend.bodega1.registro.histo-ingreso.index', compact('nombre', 'idmaterial'));
    }
    // Permiso: acceso libre
    public function tablaHistorialIngresoB1($id){

        // obtener todos los materiales por el id
        $lista = IngresosDetalleB1::where('id_registro_bodega', $id)->get();

        // agregar los datos segun se requiera
        foreach ($lista as $l){

            // obtener la fecha cuando fue ingresado
            $ingresos = IngresosB1::where('id', $l->id_ingresos)->first();
            $l->fecha = date("d-m-Y", strtotime($ingresos->fecha));

            // nombre del proveedor
            $proveedor = ProveedoresB1::where('id', $ingresos->id_proveedor)->pluck('empresa')->first();
            $l->proveedor = $proveedor;

            // obtener unidad de medida
            $unidad = UnidadMedidaB1::where('id', $l->id_unidadmedida)->pluck('nombre')->first();
            $l->unidad = $unidad;

            // obtener equipo a cual fue asignado
            $equipo = EquiposB1::where('id', $ingresos->id_equipo)->pluck('nombre')->first();
            $l->equipo = $equipo;

            $usuario = Usuario::where('id', $ingresos->id_usuarios)->pluck('usuario')->first();
            $l->usuario = $usuario;
        }

        return view('backend.bodega1.registro.histo-ingreso.tabla.tablahisto-ingreso', compact('lista'));
    }

    // Permiso: acceso libre
    public function indexHistorialRetiroB1($idmaterial){
        $nombre = RegistroBodegaB1::where('id', $idmaterial)->pluck('nombre')->first();
        return view('backend.bodega1.registro.histo-retiro.index', compact('nombre', 'idmaterial'));
    }

    // Permiso: acceso libre
    public function tablaHistorialRetiroB1($id){

        // obtener todos los materiales por el id
        $lista = RetiroBodegaDetalleB1::where('id_registro_bodega', $id)->get();

        // agregar los datos segun se requiera
        foreach ($lista as $l){

            // obtener la fecha cuando fue retirado
            $retiro = RetiroBodegaB1::where('id', $l->id_retiro_bodega)->first();
            $l->fecha = date("d-m-Y", strtotime($retiro->fecha));

            // obtener equipo a cual fue destinado
            $equipo = EquiposB1::where('id', $retiro->id_equipo)->pluck('nombre')->first();
            $l->equipo = $equipo;

            $usuario = Usuario::where('id', $retiro->id_usuarios)->pluck('usuario')->first();
            $l->usuario = $usuario;

            $persona = PersonaB1::where('id', $retiro->id_persona)->pluck('nombre')->first();
            $l->persona = $persona;
        }

        return view('backend.bodega1.registro.histo-retiro.tabla.tablahisto-retiro', compact('lista'));
    }


    public function informesBodega1(){

        // cantidad de los ingresos detalle
        $ingresoSuma = IngresosDetalleB1::get();
        $sumaIngreso = collect($ingresoSuma)->sum('cantidad');
        $sumaPrecio = collect($ingresoSuma)->sum('preciounitario');

        // cantidad de los retiros detalle

        $retiro = RetiroBodegaDetalleB1::get();
        $sumaRetiro = collect($retiro)->sum('cantidad');

        $totalActual = $sumaIngreso - $sumaRetiro;

        $sumaIngreso = 15;


        return view('backend.bodega1.informes.index', compact('sumaPrecio', 'totalActual'));
    }


    // se obtiene el dinero total de ingresado de fecha desde y hasta
    public function infoIngresosFechas(Request $request){

        $regla = array(
            'desde' => 'required',
            'hasta' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        $date1 = Carbon::parse($request->desde)->format('Y-m-d');
        $date2 = Carbon::parse($request->hasta)->addDays(1)->format('Y-m-d');


        // obtener datos
        $tablas = IngresosB1::whereBetween('fecha', array($date1, $date2)) // fecha entrego el encargo
            ->orderBy('fecha', 'ASC')
            ->get();

        // iniciar bloque para colocar el array dentro de otro
        // llamado detalles
        $resultsBloque = array();
        $index = 0;
        $total = 0;

        foreach($tablas  as $secciones){
            array_push($resultsBloque,$secciones);

            // obtener todos los detalles que coinciden con el ID
            $subSecciones = IngresosDetalleB1::where('id_ingresos', $secciones->id) // segun el ID
                ->get();

            // despues de obtener todos los detalles se sumara el total ingresado
            $resultadoFila = collect($subSecciones)->sum('preciounitario');
            $total = $total + $resultadoFila;

            // ingresar a fila detalles
            $resultsBloque[$index]->detalles = $subSecciones;
            $index++;
        }

        $total = number_format((float)$total, 2, '.', '');

        return ['success' => 1, 'total' => $total];
    }

}
