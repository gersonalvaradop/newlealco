<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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



Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'loginDo'])->name('login.do');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('seguridad', [HomeController::class, 'se'])->name('se');

Route::middleware(['auth'])->group(
    function () {

        Route::get('/', [HomeController::class, 'index'])->name('inicio')->middleware('auth');
        Route::get('tggr', [HomeController::class, 'generador'])->name('tggr')->middleware('auth');
        
        Route::post('subir/cvs', [HomeController::class, 'subirCvs'])->name('subir.cvs')->middleware('auth');
        Route::post('registros/get', [HomeController::class, 'getRegistros'])->name('get.registros')->middleware('auth');
        Route::post('enviar', [HomeController::class, 'enviar'])->name('enviar')->middleware('auth');
        Route::post('correo/save', [HomeController::class, 'guardarCorreo'])->name('correo.save')->middleware('auth');
        Route::get('test', [HomeController::class, 'test'])->name('t')->middleware('auth');
        Route::get('fusion', [HomeController::class, 'fusion'])->name('f')->middleware('auth');
        Route::get('getSupermercados', [HomeController::class, 'getSupermercados'])->name('getSupermercados')->middleware('auth');
        Route::get('getCodigoBarra', [HomeController::class, 'getCodigoBarra'])->name('getCodigoBarra')->middleware('auth');
        Route::get('getMunicipios', [HomeController::class, 'getMunicipios'])->name('getMunicipios')->middleware('auth');
        Route::get('getDepartamentos', [HomeController::class, 'getDepartamentos'])->name('getDepartamentos')->middleware('auth');
        Route::post('getFacturas', [HomeController::class, 'getFacturas'])->name('getFacturas')->middleware('auth');
        Route::post('conversor', [HomeController::class, 'conversor'])->name('conversor')->middleware('auth');
        Route::get('reporte/pos', [HomeController::class, 'reportepos'])->name('reportepos')->middleware('auth');
        Route::post('getRepoGeneral', [HomeController::class, 'getRepoGeneral'])->name('getRepoGeneral')->middleware('auth');
        Route::post('getRepoGeneralDetalle', [HomeController::class, 'getRepoGeneralDetalle'])->name('getRepoGeneralDetalle')->middleware('auth');
        Route::get('reporte/general', [HomeController::class, 'reportegeneral'])->name('reportegeneral')->middleware('auth');
        Route::post('updaterRPT', [HomeController::class, 'updaterRPT'])->name('updaterRPT')->middleware('auth');


        Route::get('resumenDiario', [HomeController::class, 'resumenDiario'])->name('resumenDiario')->middleware('auth');
        Route::post('getresumenDiario', [HomeController::class, 'getresumenDiario'])->name('getresumenDiario')->middleware('auth');


        Route::get('resumenMensual', [HomeController::class, 'resumenMensual'])->name('resumenMensual')->middleware('auth');
        Route::post('getresumenMensual', [HomeController::class, 'getresumenMensual'])->name('getresumenMensual')->middleware('auth');
        
        Route::get('liq', [HomeController::class, 'reporteliq'])->name('reporteliq')->middleware('auth');
        Route::post('getRepoliq', [HomeController::class, 'getRepoliq'])->name('getRepoliq')->middleware('auth');
        Route::post('get/liquidacion', [HomeController::class, 'getRepoLiqudacion'])->name('getRepoLiqudacion')->middleware('auth');
        
        
        Route::get('reporte/jornada', [HomeController::class, 'reporteJornada'])->name('reporteJornada')->middleware('auth');
        Route::post('jornada/get', [HomeController::class, 'getReporteJornada'])->name('getReporteJornada')->middleware('auth');
        
        Route::get('reporte/pareto', [HomeController::class, 'reportePareto'])->name('reportePareto')->middleware('auth');
        Route::post('pareto/get', [HomeController::class, 'getReportePareto'])->name('getReportePareto')->middleware('auth');
        
        Route::get('reporte/subsidio', [HomeController::class, 'reporteSubsidio'])->name('reporteSubsidio')->middleware('auth');
        Route::post('subsidios/get', [HomeController::class, 'getSubsidios'])->name('getSubsidios')->middleware('auth');
        
        Route::get('reporte/subsidioDetalle', [HomeController::class, 'reporteSubsidioDetalle'])->name('reporteSubsidioDetalle')->middleware('auth');
        Route::post('subsidiosDetalle/get', [HomeController::class, 'getSubsidiosDetalle'])->name('getSubsidiosDetalle')->middleware('auth');
        
        Route::post('generarLiquidacion', [HomeController::class, 'generarLiquidacion'])->name('generarLiquidacion')->middleware('auth');
        
        Route::get('materiales', [HomeController::class, 'materiales'])->name('materiales')->middleware('auth');
        Route::post('material/store', [HomeController::class, 'materialCreate'])->name('material.store')->middleware('auth');
        Route::post('materiales/get', [HomeController::class, 'getMateriales'])->name('getMateriales')->middleware('auth');
        Route::post('materiales/edit', [HomeController::class, 'editMateriales'])->name('material.edit')->middleware('auth');
        Route::post('materiales/delete', [HomeController::class, 'deleteMaterial'])->name('deleteMaterial')->middleware('auth');
        
        Route::get('sucursales', [HomeController::class, 'sucursales'])->name('sucursales')->middleware('auth');
        Route::post('sucursales/get', [HomeController::class, 'getSucursales'])->name('getSucursales')->middleware('auth');
        Route::post('sucursales/edit', [HomeController::class, 'editSucursal'])->name('editSucursal')->middleware('auth');
        Route::post('sucursales/store', [HomeController::class, 'sucursalCreate'])->name('crearSucursal')->middleware('auth');


        Route::get('clases', [HomeController::class, 'clases'])->name('clases')->middleware('auth');
        Route::post('clases/get', [HomeController::class, 'getClases'])->name('getClases')->middleware('auth');
        Route::post('clases/edit', [HomeController::class, 'editClase'])->name('editClase')->middleware('auth');
        Route::post('clases/store', [HomeController::class, 'claseCreate'])->name('crearClase')->middleware('auth');

        Route::get('subclases', [HomeController::class, 'subclases'])->name('subclases')->middleware('auth');
        Route::post('subclases/get', [HomeController::class, 'getSubclases'])->name('getSubclases')->middleware('auth');
        Route::post('subclases/edit', [HomeController::class, 'editSubclase'])->name('editSubclase')->middleware('auth');
        Route::post('subclases/store', [HomeController::class, 'subclaseCreate'])->name('crearSubclase')->middleware('auth');

        Route::get('inventario', [HomeController::class, 'inventario'])->name('inventario')->middleware('auth');
        Route::post('inventario/get', [HomeController::class, 'getInventario'])->name('getInventario')->middleware('auth');
        Route::post('inventario/edit', [HomeController::class, 'editInventario'])->name('editInventario')->middleware('auth');
        Route::post('inventario/store', [HomeController::class, 'inventarioCreate'])->name('crearInventario')->middleware('auth');


        Route::get('proveedores', [HomeController::class, 'proveedores'])->name('proveedores')->middleware('auth');
        Route::post('proveedores/get', [HomeController::class, 'getProveedores'])->name('getProveedores')->middleware('auth');
        Route::post('proveedores/edit', [HomeController::class, 'editProveedores'])->name('editProveedores')->middleware('auth');
        Route::post('proveedores/store', [HomeController::class, 'proveedoresCreate'])->name('proveedoresCreate')->middleware('auth');


        Route::get('reporte/kardex', [HomeController::class, 'reporteKardex'])->name('reporteKardex')->middleware('auth');
        
        
        Route::post('kardex/get', [HomeController::class, 'getKardexDate'])->name('getKardexDate')->middleware('auth');
        
        
        Route::get('reporte/venta', [HomeController::class, 'ventadiaria'])->name('ventadiaria')->middleware('auth');
        Route::post('venta/get', [HomeController::class, 'getVentadiaria'])->name('getVentadiaria')->middleware('auth');


        Route::get('teste', function () {
            $factura = "13C7C981-B766-4EBA-88EF-85706A006A0E";
            $json = json_decode(shell_exec('curl -X "GET"  "https://sv.lacnetcorp.com/firmador-proxy/fetch-by-generation/?generation_number='. $factura .'"  -H "accept: application/json"'));
            $json = $json->record[0]->documento;
            
            $j = json_encode(array(
                "status"=> "OK",
                "body"=>array(
                    "codigoGeneracion"=>$json->identificacion->codigoGeneracion,
                    "fechaRegistro"=>"",
                    "fechaEmision"=>$json->identificacion->fecEmi.' '.$json->identificacion->horEmi,
                    "tipoDte"=>$json->identificacion->tipoDte,
                    "tipoDgii"=>"",
                    "nitEmision"=>$json->emisor->nit,
                    "tipoIdenRec"=>1,
                    "numeIdenRec"=>"",
                    "numeroValidacion"=>null,
                    "selloRecibido"=>"",
                    "estado"=>"",
                    "observaciones"=>[],
                    "firma"=>"",
                    "documento"=>$json
                )
            ));

            echo ($j);
        });

    }
);


Route::get('elpdf', [HomeController::class, 'elpdf'])->name('elpdf');
