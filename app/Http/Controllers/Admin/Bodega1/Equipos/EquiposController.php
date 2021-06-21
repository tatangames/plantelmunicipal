<?php

namespace App\Http\Controllers\Admin\Bodega1\Equipos;

use App\Http\Controllers\Controller;
use App\Models\EquiposB1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EquiposController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        // aplica a todos los metodos
        $this->middleware('can:vista.grupo.bodega1.equipos.lista-equipos');
    }

    public function indexEquipos(){
        return view('backend.bodega1.equipo.index');
    }

    public function tablaIndexEquipos(){
        $listado = EquiposB1::orderBy('nombre')->get();
        return view('backend.bodega1.equipo.tabla.tablaequipo', compact('listado'));
    }


    public function nuevoEquipo(Request $request){

        // validar imagen
        if($request->hasFile('imagen')){

            $regla2 = array(
                'imagen' => 'required|image',
            );

            $mensaje2 = array(
                'imagen.required' => 'La imagen es requerida',
                'imagen.image' => 'El archivo debe ser una imagen',
            );

            $validar2 = Validator::make($request->all(), $regla2, $mensaje2 );

            if($validar2->fails()){return ['success' => 0];}

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena.$tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.'.$request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre.strtolower($extension);
            $avatar = $request->file('imagen');

            // guardar imagen
            $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

            if($upload){

                $equipo = new EquiposB1();
                $equipo->nombre = $request->nombre;
                $equipo->imagen = $nombreFoto;
                $equipo->activo = 1;

                if($equipo->save()){
                    return ['success' => 1]; // guardado
                }else{
                    return ['success' => 2]; // error al guardar
                }
            }else{
                return ['success' => 2]; // error al guardar imagen
            }

        }else{
            $equipo = new EquiposB1();
            $equipo->nombre = $request->nombre;
            $equipo->imagen = "";
            $equipo->activo = 1;

            if($equipo->save()){
                return ['success' => 1]; // guardado
            }else{
                return ['success' => 2]; // error al guardar
            }
        }
    }


    public function infoEquipo(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id unidad es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){return ['success' => 0];}

        if($data = EquiposB1::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarEquipo(Request $request){

        $regla = array(
            'id' => 'required',
            'toggle' => 'required',
            'nombre' => 'required'
        );

        $mensaje = array(
            'id.required' => 'id equipo es requerido',
            'toggle.required' => 'toggle es requerido',
            'nombre.required' => 'nombre es requerido'
        );

        $validar = Validator::make($request->all(), $regla, $mensaje );

        if ($validar->fails()){
            return ['success' => 0];
        }

        // validar imagen
        if($request->hasFile('imagen')){

            $regla2 = array(
                'imagen' => 'required|image',
            );

            $mensaje2 = array(
                'imagen.required' => 'La imagen es requerida',
                'imagen.image' => 'El archivo debe ser una imagen',
            );

            $validar2 = Validator::make($request->all(), $regla2, $mensaje2 );

            if ( $validar2->fails()){
                return ['success' => 0];
            }

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena.$tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.'.$request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre.strtolower($extension);
            $avatar = $request->file('imagen');

            // guardar imagen
            $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

            if($upload){

                $imagenOld = EquiposB1::where('id', $request->id)->pluck('imagen')->first();

                EquiposB1::where('id', $request->id)
                    ->update(['nombre' => $request->nombre,
                        'activo' => $request->toggle,
                        'imagen' => $nombreFoto
                    ]);

                // borrar foto anterior
                if(Storage::disk('imagenes')->exists($imagenOld)){
                    Storage::disk('imagenes')->delete($imagenOld);
                }

                return ['success' => 1]; // actualizado
            }else{
                return ['success' => 2]; // error al guardar imagen
            }

        }else{

            // solo actualizar datos
            EquiposB1::where('id', $request->id)
                ->update(['nombre' => $request->nombre,
                    'activo' => $request->toggle
                ]);

            return ['success' => 1]; // actualizado
        }
    }
}
