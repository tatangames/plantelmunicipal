<?php

namespace App\Http\Controllers\Admin\Bodega4\RegistroBodega;

use App\Http\Controllers\Controller;
use App\Models\IngresosB4;
use App\Models\IngresosDetalleB4;
use App\Models\ProveedoresB4;
use App\Models\RegistroBodegaB4;
use App\Models\RetiroBodegaB4;
use App\Models\RetiroBodegaDetalleB4;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistroBodegaB4Controller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.bodega4.registro.index');
    }

    public function tablaIndex(){
        $listado = RegistroBodegaB4::orderBy('nombre')->get();

        foreach ($listado as $l){

            // verificar que haya stock
            // sumar todos los ingresos de por vida de un idmaterial
            // y restar todos los retiros de por vida del mismo idmaterial

            // primero verificar que haya al menos un ingreso
            if(IngresosDetalleB4::where('id_registro_bodega_b4', $l->id)->first()){
                $obtenido = IngresosDetalleB4::where('id_registro_bodega_b4', $l->id)->get();
                $suma = collect($obtenido)->sum('cantidad');

                $obtenidoResta = RetiroBodegaDetalleB4::where('id_registro_bodega_b4', $l->id)->get();
                $total = $suma - collect($obtenidoResta)->sum('cantidad');

                $l->cantidad = $total;
            }else{
                $l->cantidad = 0;
            }
        }

        return view('backend.bodega4.registro.tabla.tablaregistro', compact('listado'));
    }

    public function nuevoMaterial(Request $request){

        $regla = array(
            'nombre' => 'required',
        );

        $mensaje = array(
            'nombre.required' => 'nombre es requerido',
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if(RegistroBodegaB4::where('nombre', $request->nombre)->first()){
            return ['success' => 1];
        }

        if($request->codigo != null){
            if(RegistroBodegaB4::where('codigo', $request->codigo)->first()){
                return ['success' => 2];
            }
        }

        $s = new RegistroBodegaB4();
        $s->nombre = $request->nombre;
        $s->codigo = $request->codigo;

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

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = RegistroBodegaB4::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }


    public function editarMateriales(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if(RegistroBodegaB4::where('nombre', $request->nombre)
            ->where('id', '!=', $request->id)
            ->first()){
            return ['success' => 1];
        }

        if($request->codigo != null) {
            if (RegistroBodegaB4::where('codigo', $request->codigo)
                ->where('id', '!=', $request->id)
                ->first()) {
                return ['success' => 2];
            }
        }

        RegistroBodegaB4::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'codigo' => $request->codigo,
            ]);

        return ['success' => 3];
    }



    // Permiso: acceso libre
    public function indexHistorialIngresoB4($idmaterial){
        $nombre = RegistroBodegaB4::where('id', $idmaterial)->pluck('nombre')->first();
        return view('backend.bodega4.registro.histo-ingreso.index', compact('nombre', 'idmaterial'));
    }
    // Permiso: acceso libre
    public function tablaHistorialIngresoB4($id){

        // obtener todos los materiales por el id
        $lista = IngresosDetalleB4::where('id_registro_bodega_b4', $id)->get();

        // agregar los datos segun se requiera
        foreach ($lista as $l){

            // obtener la fecha cuando fue ingresado
            $ingresos = IngresosB4::where('id', $l->id_ingresos_b4)->first();
            $l->fecha = date("d-m-Y", strtotime($ingresos->fecha));

            $l->nota = $ingresos->nota;

            // nombre del proveedor
            $proveedor = ProveedoresB4::where('id', $ingresos->id_proveedor_b4)->pluck('empresa')->first();
            $l->proveedor = $proveedor;

            $usuario = Usuario::where('id', $ingresos->id_usuarios)->pluck('usuario')->first();
            $l->usuario = $usuario;

            $total = $l->cantidad * $l->preciounitario;
            $total = number_format((float)$total, 2, '.', '');
            $l->total = $total;
        }

        return view('backend.bodega4.registro.histo-ingreso.tabla.tablahisto-ingreso', compact('lista'));
    }

    // Permiso: acceso libre
    public function indexHistorialRetiroB4($idmaterial){
        $nombre = RegistroBodegaB4::where('id', $idmaterial)->pluck('nombre')->first();
        return view('backend.bodega4.registro.histo-retiro.index', compact('nombre', 'idmaterial'));
    }

    // Permiso: acceso libre
    public function tablaHistorialRetiroB4($id){

        // obtener todos los materiales por el id
        $lista = RetiroBodegaDetalleB4::where('id_registro_bodega_b4', $id)->get();

        // agregar los datos segun se requiera
        foreach ($lista as $l){

            // obtener la fecha cuando fue retirado
            $retiro = RetiroBodegaB4::where('id', $l->id_retiro_bodega_b4)->first();
            $l->fecha = date("d-m-Y", strtotime($retiro->fecha));

            $l->nota = $retiro->nota;

            $usuario = Usuario::where('id', $retiro->id_usuarios)->pluck('usuario')->first();
            $l->usuario = $usuario;
        }

        return view('backend.bodega4.registro.histo-retiro.tabla.tablahisto-retiro', compact('lista'));
    }

}
