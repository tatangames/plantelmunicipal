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
use App\Http\Controllers\Admin\Bodega2\Equipos\Equipos2Controller;
use App\Http\Controllers\Admin\Bodega2\Ingreso\IngresoB2Controller;
use App\Http\Controllers\Admin\Bodega2\Reportes\ReporteBodega2Controller;

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
    Route::get('/admin1/bodega/ingreso', [IngresoController::class,'indexBodegaIngreso'])->name('ingreso.bodega1.index');
    Route::post('/admin1/bodega/buscar/material', [IngresoController::class,'busquedaMaterial']);
    Route::post('/admin1/bodega/registrar/material', [IngresoController::class,'registrarMateriales']);


    // --- RETIRO BODEGA 1 ---
    Route::get('/admin1/retiro/index', [RetiroController::class,'indexBodegaRetiro'])->name('retiro.bodega1.index');
    Route::post('/admin1/retiro/bodega/buscar', [RetiroController::class,'buscarPersona']);
    Route::post('/admin1/retiro/bodega/material', [RetiroController::class,'registrarRetiro']);

    // --- PERFIL ---
    Route::get('/admin1/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
    Route::post('/admin1/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);
    Route::post('/admin1/addimagen', [PerfilController::class, 'agregar']);

    // --- PROVEEDORES ---
    // ingreso de proveedor
    Route::get('/admin1/proveedor/ingreso', [ProveedorController::class,'indexProveedorIngreso'])->name('proveedor.index');
    Route::post('/admin1/proveedor/ingreso/nuevo', [ProveedorController::class,'registrarProveedor']);

    // listado de proveedores
    Route::get('/admin1/proveedor/listado', [ProveedorController::class,'indexProveedorListado'])->name('proveedor.index.listado');
    Route::get('/admin1/proveedor/listado-tabla', [ProveedorController::class,'tablaIndexProveedorListado']);
    Route::post('/admin1/proveedor/listado-info', [ProveedorController::class,'infoProveedor']);
    Route::post('/admin1/proveedor/listado-editar', [ProveedorController::class,'editarProveedor']);

    // --- UNIDAD DE MEDIDA ---
    Route::get('/admin1/unidad/listado', [UnidadMedidaController::class,'indexUnidadMedida'])->name('unidad.index');
    Route::get('/admin1/unidad/listado-tabla', [UnidadMedidaController::class,'tablaIndexUnidadMedida']);
    Route::post('/admin1/unidad/listado-nuevo', [UnidadMedidaController::class,'nuevaUnidad']);
    Route::post('/admin1/unidad/listado-info', [UnidadMedidaController::class,'infoUnidad']);
    Route::post('/admin1/unidad/listado-editar', [UnidadMedidaController::class,'editarUnidad']);

    // --- PERSONA ---
    Route::get('/admin1/persona/listado', [PersonaController::class,'indexPersona'])->name('persona.index');
    Route::get('/admin1/persona/listado-tabla', [PersonaController::class,'tablaIndexPersona']);
    Route::post('/admin1/persona/listado-nuevo', [PersonaController::class,'nuevaPersona']);
    Route::post('/admin1/persona/listado-info', [PersonaController::class,'infoPersona']);
    Route::post('/admin1/persona/listado-editar', [PersonaController::class,'editarPersona']);

    // --- EQUIPOS ---
    Route::get('/admin1/equipos/listado', [EquiposController::class,'indexEquipos'])->name('equipo.index');
    Route::get('/admin1/equipos/listado-tabla', [EquiposController::class,'tablaIndexEquipos']);
    Route::post('/admin1/equipos/listado-nuevo', [EquiposController::class,'nuevoEquipo']);
    Route::post('/admin1/equipos/listado-info', [EquiposController::class,'infoEquipo']);
    Route::post('/admin1/equipos/listado-editar', [EquiposController::class,'editarEquipo']);

    // --- TIPOS ---
    Route::get('/admin1/tipos/listado', [TiposController::class,'indexTipos'])->name('tipo.index');
    Route::get('/admin1/tipos/listado-tabla', [TiposController::class,'tablaIndexTipos']);
    Route::post('/admin1/tipos/listado-nuevo', [TiposController::class,'nuevaTipos']);
    Route::post('/admin1/tipos/listado-info', [TiposController::class,'infoTipos']);
    Route::post('/admin1/tipos/listado-editar', [TiposController::class,'editarTipos']);

    // --- REGISTRO MATERIALES BODEGA 1 ---
    Route::get('/admin1/materiales/listado', [RegistroBodega1Controller::class,'indexMateriales'])->name('registro.bodega1.index');
    Route::get('/admin1/materiales/listado-tabla', [RegistroBodega1Controller::class,'tablaIndexMateriales']);
    Route::post('/admin1/materiales/listado-nuevo', [RegistroBodega1Controller::class,'nuevoMaterial']);
    Route::post('/admin1/materiales/listado-info', [RegistroBodega1Controller::class,'infoMateriales']);
    Route::post('/admin1/materiales/listado-editar', [RegistroBodega1Controller::class,'editarMateriales']);

    // --- HISTORIAL MATERIALES BODEGA 1 ---
    Route::get('/admin1/materiales/histo/ingreso/{id}', [RegistroBodega1Controller::class,'indexHistorialIngresoB1']);
    Route::get('/admin1/materiales/histo/ingreso/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialIngresoB1']);

    Route::get('/admin1/materiales/histo/retiro/{id}', [RegistroBodega1Controller::class,'indexHistorialRetiroB1']);
    Route::get('/admin1/materiales/histo/retiro/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialRetiroB1']);

    // --- NUMERACION DE BODEGA 1 ---
    Route::get('/admin1/bodega1/numeracion/listado', [Bodega1NumeracionController::class,'indexNumeracion'])->name('numeracion.bodega1.index');
    Route::get('/admin1/bodega1/numeracion/listado-tabla', [Bodega1NumeracionController::class,'tablaIndexNumeracion']);
    Route::post('/admin1/bodega1/numeracion/listado-nuevo', [Bodega1NumeracionController::class,'nuevaNumeracion']);
    Route::post('/admin1/bodega1/numeracion/listado-info', [Bodega1NumeracionController::class,'infoNumeracion']);
    Route::post('/admin1/bodega1/numeracion/listado-editar', [Bodega1NumeracionController::class,'editarNumeracion']);

    // --- REPORTES BODEGA 1---
    // vistas
    Route::get('/admin1/reportes/ingreso/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaIngreso'])->name('reporte.ingreso.bodega1');
    Route::get('/admin1/reportes/retiro/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaRetiro'])->name('reporte.retiro.bodega1');

    // reportes pdf
    Route::get('/admin1/reportes/bodega1/ingreso/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaIngreso']);
    Route::get('/admin1/reportes/bodega1/retiro/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaRetiro']);

    // --- INFORME DE BODEGA ---
    Route::get('/admin1/informes/bodega1', [RegistroBodega1Controller::class,'informesBodega1'])->name('informe.bodega1');
    Route::post('/admin1/informes/bodega1/ingresos-fechas', [RegistroBodega1Controller::class,'infoIngresosFechas']);


    // ------------------------------------------------------------------------------------------------------------ //


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


    // ------------------------------------------------------------------------------------------------------------ //

    // *--- SISTEMA DE MARLENE - REGISTRAR ORDENES DE COMPRA A CADA EQUIPO ---*

    // --- EQUIPOS ---
    Route::get('/admin2/equipos/listado', [Equipos2Controller::class,'indexEquipos'])->name('admin2.equipo.index');
    Route::get('/admin2/equipos/listado-tabla', [Equipos2Controller::class,'tablaIndexEquipos']);
    Route::post('/admin2/equipos/listado-nuevo', [Equipos2Controller::class,'nuevoEquipo']);
    Route::post('/admin2/equipos/listado-info', [Equipos2Controller::class,'infoEquipo']);
    Route::post('/admin2/equipos/listado-editar', [Equipos2Controller::class,'editarEquipo']);

    // --- REGISTRO PARA EQUIPOS ---
    Route::get('/admin2/bodega2/ingreso', [IngresoB2Controller::class,'indexBodega2Ingreso'])->name('registro.bodega2.index');
    Route::post('/admin2/bodega2/registrar/material', [IngresoB2Controller::class,'registrarDetalleEquipo']);

    // --- REPORTES BODEGA 2---
    // vistas
    Route::get('/admin2/reportes/ingreso/bodega2/index', [ReporteBodega2Controller::class,'indexReporteBodega2Ingreso'])->name('reporte.ingreso.bodega2');

    // reportes pdf
    Route::get('/admin2/reportes/bodega2/ingreso/{id}/{id2}', [ReporteBodega2Controller::class,'reporteBodega2Ingreso']);




    // --- SIN PERMISOS VISTA 403 ---
    Route::get('/sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');

