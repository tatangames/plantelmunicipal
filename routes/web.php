<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\Login\LoginController;
use App\Http\Controllers\Admin\Controles\ControlController;
use App\Http\Controllers\Admin\Bodega1\Ingreso\IngresoController;
use App\Http\Controllers\Admin\Bodega1\Perfil\PerfilController;
use App\Http\Controllers\Admin\Bodega1\Retiro\RetiroController;
use App\Http\Controllers\Admin\Bodega1\Proveedor\ProveedorController;
use App\Http\Controllers\Admin\Bodega1\Unidad\UnidadMedidaController;
use App\Http\Controllers\Admin\Bodega1\Persona\PersonaController;
use App\Http\Controllers\Admin\Bodega1\Equipos\EquiposController;
use App\Http\Controllers\Admin\Bodega1\Tipos\TiposController;
use App\Http\Controllers\Admin\Bodega1\Registro\RegistroBodega1Controller;
use App\Http\Controllers\Admin\Bodega1\Reportes\ReporteBodega1Controller;
use App\Http\Controllers\Admin\Bodega1\Numeracion\Bodega1NumeracionController;
use App\Http\Controllers\Admin\Administrador\Roles\RolesController;
use App\Http\Controllers\Admin\Administrador\Permisos\PermisosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');


    // --- CONTROL WEB ---
    Route::get('/panel', [ControlController::class,'indexRedireccionamiento'])->name('admin.panel');


    // --- INGRESO BODEGA 1 ---
    Route::get('/bodega/ingreso', [IngresoController::class,'indexBodegaIngreso'])->name('ingreso.bodega1.index');
    Route::post('/bodega/buscar/material', [IngresoController::class,'busquedaMaterial']);
    Route::post('/bodega/registrar/material', [IngresoController::class,'registrarMateriales']);


    // --- RETIRO BODEGA 1 ---
    Route::get('/retiro/index', [RetiroController::class,'indexBodegaRetiro'])->name('retiro.bodega1.index');
    Route::post('/retiro/bodega/buscar', [RetiroController::class,'buscarPersona']);
    Route::post('/retiro/bodega/material', [RetiroController::class,'registrarRetiro']);

    // --- PERFIL ---
    Route::get('/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
    Route::post('/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);
    Route::post('/addimagen', [PerfilController::class, 'agregar']);

    // --- PROVEEDORES ---
    // ingreso de proveedor
    Route::get('/proveedor/ingreso', [ProveedorController::class,'indexProveedorIngreso'])->name('proveedor.index');
    Route::post('/proveedor/ingreso/nuevo', [ProveedorController::class,'registrarProveedor']);

    // listado de proveedores
    Route::get('/proveedor/listado', [ProveedorController::class,'indexProveedorListado'])->name('proveedor.index.listado');
    Route::get('/proveedor/listado-tabla', [ProveedorController::class,'tablaIndexProveedorListado']);
    Route::post('/proveedor/listado-info', [ProveedorController::class,'infoProveedor']);
    Route::post('/proveedor/listado-editar', [ProveedorController::class,'editarProveedor']);

    // --- UNIDAD DE MEDIDA ---
    Route::get('/unidad/listado', [UnidadMedidaController::class,'indexUnidadMedida'])->name('unidad.index');
    Route::get('/unidad/listado-tabla', [UnidadMedidaController::class,'tablaIndexUnidadMedida']);
    Route::post('/unidad/listado-nuevo', [UnidadMedidaController::class,'nuevaUnidad']);
    Route::post('/unidad/listado-info', [UnidadMedidaController::class,'infoUnidad']);
    Route::post('/unidad/listado-editar', [UnidadMedidaController::class,'editarUnidad']);

    // --- PERSONA ---
    Route::get('/persona/listado', [PersonaController::class,'indexPersona'])->name('persona.index');
    Route::get('/persona/listado-tabla', [PersonaController::class,'tablaIndexPersona']);
    Route::post('/persona/listado-nuevo', [PersonaController::class,'nuevaPersona']);
    Route::post('/persona/listado-info', [PersonaController::class,'infoPersona']);
    Route::post('/persona/listado-editar', [PersonaController::class,'editarPersona']);

    // --- EQUIPOS ---
    Route::get('/equipos/listado', [EquiposController::class,'indexEquipos'])->name('equipo.index');
    Route::get('/equipos/listado-tabla', [EquiposController::class,'tablaIndexEquipos']);
    Route::post('/equipos/listado-nuevo', [EquiposController::class,'nuevoEquipo']);
    Route::post('/equipos/listado-info', [EquiposController::class,'infoEquipo']);
    Route::post('/equipos/listado-editar', [EquiposController::class,'editarEquipo']);

    // --- TIPOS ---
    Route::get('/tipos/listado', [TiposController::class,'indexTipos'])->name('tipo.index');
    Route::get('/tipos/listado-tabla', [TiposController::class,'tablaIndexTipos']);
    Route::post('/tipos/listado-nuevo', [TiposController::class,'nuevaTipos']);
    Route::post('/tipos/listado-info', [TiposController::class,'infoTipos']);
    Route::post('/tipos/listado-editar', [TiposController::class,'editarTipos']);

    // --- REGISTRO MATERIALES BODEGA 1 ---
    Route::get('/materiales/listado', [RegistroBodega1Controller::class,'indexMateriales'])->name('registro.bodega1.index');
    Route::get('/materiales/listado-tabla', [RegistroBodega1Controller::class,'tablaIndexMateriales']);
    Route::post('/materiales/listado-nuevo', [RegistroBodega1Controller::class,'nuevoMaterial']);
    Route::post('/materiales/listado-info', [RegistroBodega1Controller::class,'infoMateriales']);
    Route::post('/materiales/listado-editar', [RegistroBodega1Controller::class,'editarMateriales']);

    // --- HISTORIAL MATERIALES BODEGA 1 ---
    Route::get('/materiales/histo/ingreso/{id}', [RegistroBodega1Controller::class,'indexHistorialIngresoB1']);
    Route::get('/materiales/histo/ingreso/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialIngresoB1']);

    Route::get('/materiales/histo/retiro/{id}', [RegistroBodega1Controller::class,'indexHistorialRetiroB1']);
    Route::get('/materiales/histo/retiro/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialRetiroB1']);

    // --- NUMERACION DE BODEGA 1 ---
    Route::get('/bodega1/numeracion/listado', [Bodega1NumeracionController::class,'indexNumeracion'])->name('numeracion.bodega1.index');
    Route::get('/bodega1/numeracion/listado-tabla', [Bodega1NumeracionController::class,'tablaIndexNumeracion']);
    Route::post('/bodega1/numeracion/listado-nuevo', [Bodega1NumeracionController::class,'nuevaNumeracion']);
    Route::post('/bodega1/numeracion/listado-info', [Bodega1NumeracionController::class,'infoNumeracion']);
    Route::post('/bodega1/numeracion/listado-editar', [Bodega1NumeracionController::class,'editarNumeracion']);

    // --- REPORTES BODEGA 1---
    // vistas
    Route::get('/reportes/ingreso/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaIngreso'])->name('reporte.ingreso.bodega1');
    Route::get('/reportes/retiro/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaRetiro'])->name('reporte.retiro.bodega1');

    // reportes pdf
    Route::get('/reportes/bodega1/ingreso/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaIngreso']);
    Route::get('/reportes/bodega1/retiro/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaRetiro']);

    // --- INFORME DE BODEGA ---
    Route::get('/informes/bodega1', [RegistroBodega1Controller::class,'informesBodega1'])->name('informe.bodega1');
    Route::post('/informes/bodega1/ingresos-fechas', [RegistroBodega1Controller::class,'infoIngresosFechas']);



    // *--- ADMINISTRADOR ---*

    // --- ROLES ---
    Route::get('/admin/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
    Route::get('/admin/roles/tabla', [RolesController::class,'tablaRoles']);
    Route::get('/admin/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
    Route::get('/admin/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
    Route::post('/admin/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
    Route::post('/admin/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
    Route::get('/admin/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
    Route::get('/admin/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
    Route::post('/admin/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

    // --- PERMISOS ---
    Route::get('/admin/permisos/index', [PermisosController::class,'index'])->name('admin.permisos.index');
    Route::get('/admin/permisos/tabla', [PermisosController::class,'tablaUsuarios']);
    Route::post('/admin/permisos/nuevo-usuario', [PermisosController::class, 'nuevoUsuario']);
    Route::post('/admin/permisos/info-usuario', [PermisosController::class, 'infoUsuario']);
    Route::post('/admin/permisos/editar-usuario', [PermisosController::class, 'editarUsuario']);
    Route::post('/admin/permisos/nuevo-rol', [PermisosController::class, 'nuevoRol']);
    Route::post('/admin/permisos/extra-nuevo', [PermisosController::class, 'nuevoPermisoExtra']);
    Route::post('/admin/permisos/extra-borrar', [PermisosController::class, 'borrarPermisoGlobal']);

    // --- SIN PERMISOS VISTA 403 ---
    Route::get('/sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');

