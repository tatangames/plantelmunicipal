<?php

namespace App\Http\Controllers\Admin\Bodega1\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerfilController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function indexEditarPerfil(){
        $usuario = auth()->user();
        return view('backend.bodega1.perfil.index', compact('usuario'));
    }

    public function editarUsuario(Request $request){

        if (!Auth::check()) {return ['success' => 2];}

        $usuario = auth()->user();

        if (Hash::check($request->passactual, $usuario->password)) {

            Usuario::where('id', $usuario->id)
                ->update(['password' => bcrypt($request->passnueva)]);

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

}
