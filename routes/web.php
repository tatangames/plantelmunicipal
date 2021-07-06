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
use App\Http\Controllers\Admin\Bodega3\Encargados\EncargadosB3Controller;
use App\Http\Controllers\Admin\Bodega3\Servicios\ServiciosB3Controller;
use App\Http\Controllers\Admin\Bodega3\Ingresos\IngresosB3Controller;
use App\Http\Controllers\Admin\Bodega3\Cargos\CargosB3Controller;
use App\Http\Controllers\Admin\Bodega3\Verificacion\VerificacionB3Controller;
use App\Http\Controllers\Admin\Bodega3\RetiroMaterial\RetiroMaterialB3Controller;
use App\Http\Controllers\Admin\Bodega3\Bodega\BodegaUbicacionB3Controller;
use App\Http\Controllers\Admin\Bodega3\TipoRetiro\TipoRetiroB3Controller;


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
    Route::get('admin/sistema1/bodega/ingreso', [IngresoController::class,'indexBodegaIngreso'])->name('ingreso.bodega1.index');
    Route::post('admin/sistema1/bodega/buscar/material', [IngresoController::class,'busquedaMaterial']);
    Route::post('admin/sistema1/bodega/registrar/material', [IngresoController::class,'registrarMateriales']);


    // --- RETIRO BODEGA 1 ---
    Route::get('admin/sistema1/retiro/index', [RetiroController::class,'indexBodegaRetiro'])->name('retiro.bodega1.index');
    Route::post('admin/sistema1/retiro/bodega/buscar', [RetiroController::class,'buscarPersona']);
    Route::post('admin/sistema1/retiro/bodega/material', [RetiroController::class,'registrarRetiro']);

    // --- PERFIL ---
    Route::get('admin/sistema1/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
    Route::post('admin/sistema1/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);


    // --- PROVEEDORES ---
    // ingreso de proveedor
    Route::get('admin/sistema1/proveedor/ingreso', [ProveedorController::class,'indexProveedorIngreso'])->name('proveedor.index');
    Route::post('admin/sistema1/proveedor/ingreso/nuevo', [ProveedorController::class,'registrarProveedor']);

    // listado de proveedores
    Route::get('sistema1/proveedor/listado', [ProveedorController::class,'indexProveedorListado'])->name('proveedor.index.listado');
    Route::get('sistema1/proveedor/listado-tabla', [ProveedorController::class,'tablaIndexProveedorListado']);
    Route::post('admin/sistema1/proveedor/listado-info', [ProveedorController::class,'infoProveedor']);
    Route::post('admin/sistema1/proveedor/listado-editar', [ProveedorController::class,'editarProveedor']);

    // --- UNIDAD DE MEDIDA ---
    Route::get('sistema1/unidad/listado', [UnidadMedidaController::class,'indexUnidadMedida'])->name('unidad.index');
    Route::get('sistema1/unidad/listado-tabla', [UnidadMedidaController::class,'tablaIndexUnidadMedida']);
    Route::post('admin/sistema1/unidad/listado-nuevo', [UnidadMedidaController::class,'nuevaUnidad']);
    Route::post('admin/sistema1/unidad/listado-info', [UnidadMedidaController::class,'infoUnidad']);
    Route::post('admin/sistema1/unidad/listado-editar', [UnidadMedidaController::class,'editarUnidad']);

    // --- PERSONA ---
    Route::get('sistema1/persona/listado', [PersonaController::class,'indexPersona'])->name('persona.index');
    Route::get('sistema1/persona/listado-tabla', [PersonaController::class,'tablaIndexPersona']);
    Route::post('admin/sistema1/persona/listado-nuevo', [PersonaController::class,'nuevaPersona']);
    Route::post('admin/sistema1/persona/listado-info', [PersonaController::class,'infoPersona']);
    Route::post('admin/sistema1/persona/listado-editar', [PersonaController::class,'editarPersona']);

    // --- EQUIPOS ---
    Route::get('sistema1/equipos/listado', [EquiposController::class,'indexEquipos'])->name('equipo.index');
    Route::get('sistema1/equipos/listado-tabla', [EquiposController::class,'tablaIndexEquipos']);
    Route::post('admin/sistema1/equipos/listado-nuevo', [EquiposController::class,'nuevoEquipo']);
    Route::post('admin/sistema1/equipos/listado-info', [EquiposController::class,'infoEquipo']);
    Route::post('admin/sistema1/equipos/listado-editar', [EquiposController::class,'editarEquipo']);

    // --- TIPOS ---
    Route::get('sistema1/tipos/listado', [TiposController::class,'indexTipos'])->name('tipo.index');
    Route::get('sistema1/tipos/listado-tabla', [TiposController::class,'tablaIndexTipos']);
    Route::post('admin/sistema1/tipos/listado-nuevo', [TiposController::class,'nuevaTipos']);
    Route::post('admin/sistema1/tipos/listado-info', [TiposController::class,'infoTipos']);
    Route::post('admin/sistema1/tipos/listado-editar', [TiposController::class,'editarTipos']);

    // --- REGISTRO MATERIALES BODEGA 1 ---
    Route::get('sistema1/materiales/listado', [RegistroBodega1Controller::class,'indexMateriales'])->name('registro.bodega1.index');
    Route::get('sistema1/materiales/listado-tabla', [RegistroBodega1Controller::class,'tablaIndexMateriales']);
    Route::post('admin/sistema1/materiales/listado-nuevo', [RegistroBodega1Controller::class,'nuevoMaterial']);
    Route::post('admin/sistema1/materiales/listado-info', [RegistroBodega1Controller::class,'infoMateriales']);
    Route::post('admin/sistema1/materiales/listado-editar', [RegistroBodega1Controller::class,'editarMateriales']);

    // --- HISTORIAL MATERIALES BODEGA 1 ---
    Route::get('sistema1/materiales/histo/ingreso/{id}', [RegistroBodega1Controller::class,'indexHistorialIngresoB1']);
    Route::get('sistema1/materiales/histo/ingreso/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialIngresoB1']);

    Route::get('sistema1/materiales/histo/retiro/{id}', [RegistroBodega1Controller::class,'indexHistorialRetiroB1']);
    Route::get('sistema1/materiales/histo/retiro/tabla/{id}', [RegistroBodega1Controller::class,'tablaHistorialRetiroB1']);

    // --- NUMERACION DE BODEGA 1 ---
    Route::get('sistema1/bodega1/numeracion/listado', [Bodega1NumeracionController::class,'indexNumeracion'])->name('numeracion.bodega1.index');
    Route::get('sistema1/bodega1/numeracion/listado-tabla', [Bodega1NumeracionController::class,'tablaIndexNumeracion']);
    Route::post('admin/sistema1/bodega1/numeracion/listado-nuevo', [Bodega1NumeracionController::class,'nuevaNumeracion']);
    Route::post('admin/sistema1/bodega1/numeracion/listado-info', [Bodega1NumeracionController::class,'infoNumeracion']);
    Route::post('admin/sistema1/bodega1/numeracion/listado-editar', [Bodega1NumeracionController::class,'editarNumeracion']);

    // --- REPORTES BODEGA 1---
    // vistas
    Route::get('sistema1/reportes/ingreso/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaIngreso'])->name('reporte.ingreso.bodega1');
    Route::get('sistema1/reportes/retiro/bodega1/index', [ReporteBodega1Controller::class,'indexReporteBodegaRetiro'])->name('reporte.retiro.bodega1');

    // reportes pdf
    Route::get('sistema1/reportes/bodega1/ingreso/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaIngreso']);
    Route::get('sistema1/reportes/bodega1/retiro/{id}/{id2}', [ReporteBodega1Controller::class,'reporteBodegaRetiro']);

    // --- INFORME DE BODEGA ---
    Route::get('sistema1/informes/bodega1', [RegistroBodega1Controller::class,'informesBodega1'])->name('informe.bodega1');
    Route::post('admin/sistema1/informes/bodega1/ingresos-fechas', [RegistroBodega1Controller::class,'infoIngresosFechas']);


    // ------------------------------------------------------------------------------------------------------------ //


    // *--- ADMINISTRADOR ---*

    // --- ROLES ---
    Route::get('principal/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
    Route::get('principal/roles/tabla', [RolesController::class,'tablaRoles']);
    Route::get('principal/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
    Route::get('principal/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
    Route::post('admin/principal/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
    Route::post('admin/principal/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
    Route::get('principal/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
    Route::get('principal/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
    Route::post('admin/principal/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

    // --- PERMISOS ---
    Route::get('principal/permisos/index', [PermisosController::class,'index'])->name('admin.permisos.index');
    Route::get('principal/permisos/tabla', [PermisosController::class,'tablaUsuarios']);
    Route::post('admin/principal/permisos/nuevo-usuario', [PermisosController::class, 'nuevoUsuario']);
    Route::post('admin/principal/permisos/info-usuario', [PermisosController::class, 'infoUsuario']);
    Route::post('admin/principal/permisos/editar-usuario', [PermisosController::class, 'editarUsuario']);
    Route::post('admin/principal/permisos/nuevo-rol', [PermisosController::class, 'nuevoRol']);
    Route::post('admin/principal/permisos/extra-nuevo', [PermisosController::class, 'nuevoPermisoExtra']);
    Route::post('admin/principal/permisos/extra-borrar', [PermisosController::class, 'borrarPermisoGlobal']);


    // --- SIN PERMISOS VISTA 403 ---
    Route::get('sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');


    // ------------------------------------------------------------------------------------------------------------ //

    // *--- SISTEMA DE MARLENE - REGISTRAR ORDENES DE COMPRA A CADA EQUIPO ---*

    // --- EQUIPOS ---
    Route::get('sistema2/equipos/listado', [Equipos2Controller::class,'indexEquipos'])->name('admin2.equipo.index');
    Route::get('sistema2/equipos/listado-tabla', [Equipos2Controller::class,'tablaIndexEquipos']);
    Route::post('admin/sistema2/equipos/listado-nuevo', [Equipos2Controller::class,'nuevoEquipo']);
    Route::post('admin/sistema2/equipos/listado-info', [Equipos2Controller::class,'infoEquipo']);
    Route::post('admin/sistema2/equipos/listado-editar', [Equipos2Controller::class,'editarEquipo']);

    // --- REGISTRO PARA EQUIPOS ---
    Route::get('sistema2/bodega2/ingreso', [IngresoB2Controller::class,'indexBodega2Ingreso'])->name('registro.bodega2.index');
    Route::post('admin/sistema2/bodega2/registrar/material', [IngresoB2Controller::class,'registrarDetalleEquipo']);

    // --- REPORTES BODEGA 2---
    // vistas
    Route::get('sistema2/reportes/ingreso/bodega2/index', [ReporteBodega2Controller::class,'indexReporteBodega2Ingreso'])->name('reporte.ingreso.bodega2');

    // reportes pdf
    Route::get('sistema2/reportes/bodega2/ingreso/{id}/{id2}', [ReporteBodega2Controller::class,'reporteBodega2Ingreso']);
    Route::get('sistema2/reportes2/bodega2/ingreso/{id}/{id2}/{id3}', [ReporteBodega2Controller::class,'reporteBodega2IngresoEquipo']);



    // ------------------------------------------------------------------------------------------------------------ //

    // *--- SISTEMA DE DON LUIS - BODEGA BIENES MUNICIPALES ---*

    // --- ENCARGADOS ---
    Route::get('sistema3/encargados/listado', [EncargadosB3Controller::class,'indexEncargados'])->name('admin3.encargados.index');
    Route::get('sistema3/encargados/listado-tabla', [EncargadosB3Controller::class,'tablaIndexEncargados']);
    Route::post('admin/sistema3/encargados/listado-nuevo', [EncargadosB3Controller::class,'nuevoEncargado']);
    Route::post('admin/sistema3/encargados/listado-info', [EncargadosB3Controller::class,'infoEncargado']);
    Route::post('admin/sistema3/encargados/listado-editar', [EncargadosB3Controller::class,'editarEncargado']);

    // --- SERVICIOS ---
    Route::get('sistema3/servicios/listado', [ServiciosB3Controller::class,'indexServicios'])->name('admin3.servicios.index');
    Route::get('sistema3/servicios/listado-tabla', [ServiciosB3Controller::class,'tablaIndexServicios']);
    Route::post('admin/sistema3/servicios/listado-nuevo', [ServiciosB3Controller::class,'nuevoServicio']);
    Route::post('admin/sistema3/servicios/listado-info', [ServiciosB3Controller::class,'infoServicio']);
    Route::post('admin/sistema3/servicios/listado-editar', [ServiciosB3Controller::class,'editarServicio']);

    // --- CARGOS ---
    Route::get('sistema3/cargos/listado', [CargosB3Controller::class,'indexCargos'])->name('admin3.cargos.index');
    Route::get('sistema3/cargos/listado-tabla', [CargosB3Controller::class,'tablaIndexCargos']);
    Route::post('admin/sistema3/cargos/listado-nuevo', [CargosB3Controller::class,'nuevoCargo']);
    Route::post('admin/sistema3/cargos/listado-info', [CargosB3Controller::class,'infoCargo']);
    Route::post('admin/sistema3/cargos/listado-editar', [CargosB3Controller::class,'editarCargo']);


    // --- TIPO RETIROS ---
    Route::get('sistema3/tiporetiro/listado', [TipoRetiroB3Controller::class,'index'])->name('admin3.tipo.retiro.index');
    Route::get('sistema3/tiporetiro/listado-tabla', [TipoRetiroB3Controller::class,'tablaIndex']);
    Route::post('admin/sistema3/tiporetiro/listado-nuevo', [TipoRetiroB3Controller::class,'nuevoRetiro']);
    Route::post('admin/sistema3/tiporetiro/listado-info', [TipoRetiroB3Controller::class,'infoRetiro']);
    Route::post('admin/sistema3/tiporetiro/listado-editar', [TipoRetiroB3Controller::class,'editarRetiro']);

    // --- BODEGA UBICACION ---
    Route::get('sistema3/bodegaubicacion/listado', [BodegaUbicacionB3Controller::class,'index'])->name('admin3.bodega.ubicacion.index');
    Route::get('sistema3/bodegaubicacion/listado-tabla', [BodegaUbicacionB3Controller::class,'tablaIndex']);
    Route::post('admin/sistema3/bodegaubicacion/listado-nuevo', [BodegaUbicacionB3Controller::class,'nuevaBodegaUbicacion']);
    Route::post('admin/sistema3/bodegaubicacion/listado-info', [BodegaUbicacionB3Controller::class,'infoBodegaUbicacion']);
    Route::post('admin/sistema3/bodegaubicacion/listado-editar', [BodegaUbicacionB3Controller::class,'editarBodegaUbicacion']);



    // --- REGISTROS INGRESO ---
    Route::get('sistema3/bodega3/ingreso', [IngresosB3Controller::class,'indexBodega3Ingreso'])->name('registro.bodega3.index');
    Route::post('admin/sistema3/bodega3/registro', [IngresosB3Controller::class,'registrarIngreso']);

    // agregar extra material a un proyecto ya creado
    Route::get('sistema3/bodega3/registro-extra-material/{id}', [IngresosB3Controller::class,'indexBodega3IngresoExtraMaterial']);
    Route::post('admin/sistema3/bodega3/registro/extra-material', [IngresosB3Controller::class,'registrarIngresoExtraMaterial']);


    // --- EDITAR REGISTROS INGRESO ---
    Route::get('sistema3/bodega3/ingresoeditar-index', [IngresosB3Controller::class,'indexBodega3IngresoEditar'])->name('registro.ingreso.editar.bodega3.index');
    Route::get('sistema3/bodega3/ingresoeditar/listado-tabla', [IngresosB3Controller::class,'tablaIndexIngresoEditar']);

    // pdf
    Route::get('sistema3/ingresoeditar/material/pdf/{id}', [IngresosB3Controller::class,'pdfProyecto']);

    // lista de materiales para modificar cantidad
    Route::get('sistema3/ingresoeditar/editar-material/{id}', [IngresosB3Controller::class,'indexMaterialesEditar']);
    Route::post('admin/sistema3/ingresoeditar/modificar-materiales', [IngresosB3Controller::class,'editarMaterialesProyecto']);

    // lista de documentos
    Route::get('sistema3/ingreso/lista-documentos/{id}', [IngresosB3Controller::class,'indexListaDocumentos']);
    Route::get('sistema3/ingreso/lista-documentos/tabla/{id}', [IngresosB3Controller::class,'tablaIndexListaDocumentos']);
    Route::get('sistema3/ingreso/descargar-documento/{id}', [IngresosB3Controller::class,'descargarDocumento']);
    Route::post('admin/sistema3/ingreso/nuevo-documento', [IngresosB3Controller::class,'nuevoDocumento']);

    // ver lista de verificados unicamente
    Route::get('sistema3/ingreso/ver/lista-de-verificados/{id}', [IngresosB3Controller::class,'indexListaVerificados']);
    Route::get('sistema3/ingreso/ver/lista-de-verificados/tabla/{id}', [IngresosB3Controller::class,'tablaIndexListaVerificados']);
    Route::get('sistema3/ingreso/ver/lista-de-verificados-detalles/{id}', [IngresosB3Controller::class,'detalleListaVerificados']);




    // ver lista de retiros unicamente
    Route::get('sistema3/ingreso/ver/lista-de-retiros/{id}', [IngresosB3Controller::class,'indexListaRetiros']);
    Route::get('sistema3/ingreso/ver/lista-de-retiros/tabla/{id}', [IngresosB3Controller::class,'tablaIndexListaRetiros']);

    // lista de ingresos de materiales extra
    Route::get('sistema3/ingreso/material-extra-lista/{id}', [IngresosB3Controller::class,'indexMaterialExtra']);
    Route::get('sistema3/ingreso/material-extra-lista/tabla/{id}', [IngresosB3Controller::class,'indexTablaMaterialExtra']);

    // descripcion de la lista de material - detalle
    Route::get('sistema3/ingreso/material-extra-lista/detalle/{id}', [IngresosB3Controller::class,'indexMaterialExtraDetalle']);



    // lista
    Route::get('/sistema3/ingreso/ver/lista-de-material/{id}', [IngresosB3Controller::class,'indexListaRetirosMateriales']);

    // ver sobrantes
    Route::get('sistema3/ingreso/ver/lista-sobrantes/{id}', [IngresosB3Controller::class,'indexListaSobrantes']);

    // ver lista de encargados
    Route::get('sistema3/ingreso/ver/encargados/{id}', [IngresosB3Controller::class,'verEncargadosProyecto']);
    Route::get('sistema3/ingreso/ver/tabla-encargados/{id}', [IngresosB3Controller::class,'verEncargadosProyectoTabla']);

    // ver lista de materiales
    Route::get('sistema3/ingreso/material/index/{id}', [IngresosB3Controller::class,'indexTablaMateriales']);
    Route::get('sistema3/ingreso/material/listado-tabla/{id}', [IngresosB3Controller::class,'tablaMateriales']);




    // --- LISTA DE PROYECTOS PARA REVISADORES ---
    Route::get('sistema3/verificacion/listado', [VerificacionB3Controller::class,'index'])->name('verificacion.bodega3.index');
    Route::get('sistema3/verificacion/listado-tabla', [VerificacionB3Controller::class,'tablaIndex']);


    // ver lista de materiales
    Route::get('sistema3/verificacion/material/index/{id}', [VerificacionB3Controller::class,'indexTablaMateriales']);
    Route::get('sistema3/verificacion/material/listado-tabla/{id}', [VerificacionB3Controller::class,'tablaMateriales']);

    // pdf
    Route::get('sistema3/verificacion/material/pdf/{id}', [VerificacionB3Controller::class,'pdfMateriales']);

    // index registro de materiales en verificacion
    Route::get('sistema3/verificacion/registro-material/{id}', [VerificacionB3Controller::class,'indexRegistroMaterialVerificacion']);
    Route::post('admin/sistema3/verificacion/cantidad-material', [VerificacionB3Controller::class,'ingresarCantidadVerificada']);

    // ver lista de verificaciones
    Route::get('sistema3/verificacion/editar/material-index/{id}', [VerificacionB3Controller::class,'indexListaMaterialVerificado']);
    Route::get('sistema3/verificacion/editar/material-index-tabla/{id}', [VerificacionB3Controller::class,'tablaListaMaterialVerificado']);

    // ver listado de materiales verificados, no podra superar a lo ingresado cuando se creo el proyecto
    Route::get('sistema3/verificacion/proyecto/lista-materiales/{id}', [VerificacionB3Controller::class,'indexMaterialVerificadoEditar']);
    Route::post('admin/sistema3/verificacion/proyecto/editar-mate-verificados', [VerificacionB3Controller::class,'editarMaterialesVerificadoProyecto']);

    // lista de encargados
    Route::get('sistema3/verificacion/ver/encargados/{id}', [VerificacionB3Controller::class,'verEncargadosProyecto']);
    Route::get('sistema3/verificacion/ver/tabla-encargados/{id}', [VerificacionB3Controller::class,'verEncargadosProyectoTabla']);

    // lista de documentos para ver
    Route::get('sistema3/verificacion/lista-documentos/{id}', [VerificacionB3Controller::class,'indexListaDocumentos']);
    Route::get('sistema3/verificacion/lista-documentos/tabla/{id}', [VerificacionB3Controller::class,'tablaIndexListaDocumentos']);
    Route::get('sistema3/verificacion/descargar-documento/{id}', [VerificacionB3Controller::class,'descargarDocumento']);




    // --- RETIRO DE MATERIAL ---

    // retiro de material index
    Route::get('sistema3/retiromaterial/retiro-index/{id}', [RetiroMaterialB3Controller::class,'verRetiroMaterialIndex']);

    // registrar retiro
    Route::post('admin/sistema3/retiromaterial/registrar/retiro', [RetiroMaterialB3Controller::class,'registrarRetiro']);

    // completar proyecto
    Route::post('admin/sistema3/retiromaterial/completar-proyecto', [RetiroMaterialB3Controller::class,'completarProyecto']);


    // lista de retiros para poder editar uno
    Route::get('sistema3/retiromaterial/ver/lista-retiros/{id}', [RetiroMaterialB3Controller::class,'indexListaRetirosEditar']);
    Route::get('sistema3/retiromaterial/ver/tabla-lista-retiros/{id}', [RetiroMaterialB3Controller::class,'tablaIndexListaRetirosEditar']);

    // vista donde se edita los materiales de un retiro
    Route::get('sistema3/retiromaterial/vistaeditarmaterial/{id}', [RetiroMaterialB3Controller::class,'indexVistaEditarRetiroMaterial']);
    Route::post('admin/sistema3/retiromaterial/vistaeditarmaterial/modificarretiro', [RetiroMaterialB3Controller::class,'modificarCantidadRetirda']);

