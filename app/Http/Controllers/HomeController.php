<?php

namespace App\Http\Controllers;

use App\Mail\EnvioDTE;
use App\Models\Clase;
use App\Models\Companies;
use App\Models\General;
use App\Models\Kardex;
use App\Models\Liquidaciones;
use App\Models\Material;
use App\Models\MaterialDetalle;
use App\Models\Proveedores;
use App\Models\Registro;
use App\Models\ReporteJornada;
use App\Models\RptFacturas;
use App\Models\RptFacturasDETS;
use App\Models\RptFacturasDTE;
use App\Models\RptFacturasUpdate;
use App\Models\RptResumVtaDia;
use App\Models\RptResumVtaMes;
use App\Models\Subclase;
use App\Models\Sucursales;
use DateInterval;
use DateTime;
use Exception;
use FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PDF;
use setasign\Fpdi\Fpdi;
use Symfony\Component\Console\Output\ConsoleOutput;
use TCPDF;

class HomeController extends Controller
{
    public function __construct() {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function generador()
    {
        return view('principal.generador');
    }

    function clases()
    {
        return view('principal.clases');
    }

    function materiales()
    {
        $info = [];
        $info['clases'] = Clase::with(['subclases'])->get()->toJson();
        $info['subclases'] = Subclase::get()->toJson();
        return view('principal.materiales', $info);
    }

    function getMateriales()
    {
        echo Material::with(['detalles.padre', 'detalles.hijo'])->get()->toJson();
    }

    public function index()
    {
        if ($this->esTienda()) {
            return redirect()->route('principal.materiales');
        }

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        $info = [];
        $user = Auth::user();
        $info['clases'] = Clase::with(['subclases'])->get()->toJson();
        $info['subclases'] = Subclase::get()->toJson();
        $info['impresor'] = $user->impresor;
        //echo $user->company->fecha_vencimiento;
        $user->company->fecha_vencimiento;
        $fecha_vencimiento = new DateTime($user->company->fecha_vencimiento);
        $fecha_actual = new DateTime();
        $fecha_actual->add(new DateInterval('PT3H'));
        //$fecha_actual->format('Y-m-d H:i:s');

        if (false) {
            //if ($fecha_vencimiento < $fecha_actual) {
            //echo "La fecha_vencimiento es menor que la fecha 2";
            $company = Companies::find($user->company->id);
            //echo "curl --location --request POST 'https://admin.factura.gob.sv/test/seguridad/auth/portal?user=" . $company->nit . "&pwd=" . $company->password . "&grant_type=password'";
            //die();
            //$token = shell_exec("curl --location --request POST 'https://admin.factura.gob.sv/test/seguridad/auth/portal?user=" . $company->nit . "&pwd=" . $company->password . "&grant_type=password'");
            $token = shell_exec('curl --location --request POST "https://admin.factura.gob.sv/prod/seguridad/auth/portal?user=' . $company->nit . '&pwd=' . $company->password . '&grant_type=password" --max-time 15');
            //$token = '{"status":"OK","body":{"user":"06140902840024","token":"Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIwNjE0MDkwMjg0MDAyNCIsImF1dGhvcml0aWVzIjpbIlVTRVIiLCJVU0VSX0FQSSIsIlVzdWFyaW8iXSwiaWF0IjoxNjg5MTExNjE0LCJleHAiOjE2ODkxOTgwMTR9.ATqXDQ94XXatUnGRryYZkDdChrhphv5OtPx0JHSVME-joeqTn6sncktUOHwsQW9V9ods1Br4qsKCbODydvYxpQ","rol":{"nombre":null,"codigo":"ROLE_USER","descripcion":null,"rolSuperior":null,"nivel":null,"activo":null,"permisos":null},"roles":["USER","USER_API","Usuario"],"tokenType":"Bearer"}}';

            $token = json_decode($token);
            if (is_null($token)) {
                return view('principal.materiales', $info);
            }


            $token = $token->body->token;
            $fecha_actual = new DateTime();
            //$fecha_actual->add(new DateInterval('PT46H'));
            $fecha_actual->add(new DateInterval('PT24H'));
            $company->fecha_vencimiento = $fecha_actual->format('Y-m-d H:i:s');
            $company->token = $token;
            $company->save();
        } elseif ($fecha_vencimiento > $fecha_actual) {
            //echo "La fecha vencimiento es mayor que la fecha 2";
        }
        //{"status":"OK","body":{"user":"06140902840024","token":"Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIwNjE0MDkwMjg0MDAyNCIsImF1dGhvcml0aWVzIjpbIlVTRVIiLCJVU0VSX0FQSSIsIlVzdWFyaW8iXSwiaWF0IjoxNjg5MTExNjE0LCJleHAiOjE2ODkxOTgwMTR9.ATqXDQ94XXatUnGRryYZkDdChrhphv5OtPx0JHSVME-joeqTn6sncktUOHwsQW9V9ods1Br4qsKCbODydvYxpQ","rol":{"nombre":null,"codigo":"ROLE_USER","descripcion":null,"rolSuperior":null,"nivel":null,"activo":null,"permisos":null},"roles":["USER","USER_API","Usuario"],"tokenType":"Bearer"}}

        return view('principal.materiales', $info);
    }

    function esTienda()
    {
        $roleId = 2;
        $esTienda = false;
        foreach (auth()->user()->roles as $value) {
            if ($value['id'] == $roleId) {
                $esTienda = true;
            }
        }
        return $esTienda;
    }

    function reportegeneral()
    {
        $inf = [];
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reportegen', $inf);
    }

    function getRepoGeneralDetalle(Request $request)
    {
        $data = $request->all();

        $documento = $data['documento'];

        // Usa parámetros en la consulta para evitar inyecciones SQL
        $query = "
        SELECT documento, linea, sku, descripcion, cantidad, precio, cantidad * precio AS subtotal
        FROM rpt_venta_jornada
        WHERE documento LIKE ?
        ORDER BY linea
    ";

        // Ejecuta la consulta con parámetros
        $results = DB::select(DB::raw($query), ["%$documento%"]);
         if (empty($results)) {
            $query2 = "
             SELECT documento, linea, sku, descripcion, cantidad, precio, cantidad * precio AS subtotal
        FROM rpt_venta_jornada_nulos
        WHERE documento LIKE ?
        ORDER BY linea
            ";
            $results = DB::select(DB::raw($query2), ["%$documento%"]);
        }


        // Devuelve la respuesta en formato JSON
        return response()->json($results);

        //$general = RptFacturasDETS::where('documento', $data['documento'])->get()->toJson();
        //echo $general;



    }


    function getRepoGeneral(Request $request)
    {
        $data = $request->all();

        $general = General::whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
        echo $general;
        die();

        $v = RptFacturas::with(['detalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->orderBy('sucursal')->orderBy('id')->get();
        foreach ($v as $value) {
            $tmp = array();
            //$value['detalle'] =DB::select('select * from rpt_facturas_det where documento = ? and id = ?', [$value->documento,$value->id]);  
            foreach ($value['detalle'] as $x) {
                if ($x->documento === $value->documento) {
                    array_push($tmp, $x);
                }
                $value['detalle'] = $tmp;
            }
        }
        echo json_encode($v);
    }

    function getRepoLiqudacion(Request $request)
    {
        $data = $request->all();

        $v = Liquidaciones::whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
        echo ($v);
    }


    function reporteJornada()
    {
        $inf = [];
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reporteJornada', $inf);
    }

    function getReporteJornada(Request $request)
    {
        $data = $request->all();
        echo  ReporteJornada::with(['claseDetalle', 'subclaseDetalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }


    function reportePareto()
    {
        $inf = [];
        $inf['clases'] = Clase::with(['subclases'])->get()->toJson();
        $inf['subclases'] = Subclase::get()->toJson();
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reportePareto', $inf);
    }

    function getReportePareto(Request $request)
    {
        $data = $request->all();

        echo json_encode(DB::select(DB::raw(" SELECT material_id, 
 (case when (f.facturasap <> '') then f.facturasap else (case when (f.destino = 1) then 'Consum' when (f.destino = 2) then 'Retiro' when (f.destino = 3) then 'Domici' else f.destino end) end) as consumo, 
 f.sucursal, m.clase, m.subclase, r.sku,  m.descripcion,  round(SUM((r.cantidad*r.precio)+r.impuesto),2) total, SUM(r.cantidad) cantidad        
        FROM rpt_facturas_det r 
        LEFT JOIN materiales m on r.material_id = m.id
        INNER JOIN  rpt_facturas f on r.id=f.id
          WHERE coalesce(f.estatus,'-')<>'X' and f.fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' 
          GROUP BY f.sucursal,(case when (f.facturasap <> '') then f.facturasap else (case when (f.destino = 1) then 'Consum' when (f.destino = 2) then 'Retiro' when (f.destino = 3) then 'Domici' else f.destino end) end), r.sku,m.clase,m.subclase,m.descripcion, material_id ORDER BY SUM((r.cantidad*r.precio)+r.impuesto) DESC")));

       // echo json_encode(DB::select(DB::raw("SELECT material_id, f.destino, f.sucursal, m.clase, m.subclase, r.sku,  m.descripcion,  round(SUM((r.cantidad*r.precio)+r.impuesto),2) total, SUM(r.cantidad) cantidad, 
       //  (case when (f.facturasap <> '') then f.facturasap else (case when (f.destino = 1) then 'Consum' when (f.destino = 2) then 'Retiro' when (f.destino = 3) then 'Domici' else f.destino end) end) as destino
       // FROM rpt_facturas_det r 
       // LEFT JOIN materiales m on r.material_id = m.id
       // INNER JOIN  rpt_facturas f on r.id=f.id
       //   WHERE coalesce(f.estatus,'-')<>'X' and f.fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' 
       //   GROUP BY f.sucursal,(case when (f.facturasap <> '') then f.facturasap else (case when (f.destino = 1) then 'Consum' when (f.destino = 2) then 'Retiro' when (f.destino = 3) then 'Domici' else f.destino end) end), r.sku,m.clase,m.subclase,m.descripcion, material_id ORDER BY SUM((r.cantidad*r.precio)+r.impuesto) desc")));
//
        //"SELECT material_id, clase, subclase, r.sku,  m.descripcion,  round(SUM((cantidad*precio)+impuesto),2) total, SUM(cantidad) cantidad FROM rpt_facturas_det r INNER JOIN materiales m on r.material_id = m.id  WHERE fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' GROUP BY material_id, r.sku,clase,subclase,descripcion ORDER BY SUM((cantidad*precio)+impuesto) desc"      
        //SELECT material_id,  m.descripcion, SUM(total) total, SUM(cantidad) cantidad FROM rpt_facturas_det r INNER JOIN materiales m on r.material_id = m.id  WHERE fecha_docum BETWEEN '2024-03-01' AND '2024-03-04' GROUP BY material_id ORDER BY SUM(total) desc
        //echo  ReporteJornada::with(['claseDetalle', 'subclaseDetalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }



    function reporteSubsidio()
    {
        $inf = [];
        $inf['clases'] = Clase::with(['subclases'])->get()->toJson();
        $inf['subclases'] = Subclase::get()->toJson();
        return view('principal.reporteSubsidios', $inf);
    }

    function getSubsidios(Request $request)
    {
        $data = $request->all();
        echo json_encode(DB::select(DB::raw("select * from docum_credito_por_fecha WHERE fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' ")));
        //SELECT material_id,  m.descripcion, SUM(total) total, SUM(cantidad) cantidad FROM rpt_facturas_det r INNER JOIN materiales m on r.material_id = m.id  WHERE fecha_docum BETWEEN '2024-03-01' AND '2024-03-04' GROUP BY material_id ORDER BY SUM(total) desc
        //echo  ReporteJornada::with(['claseDetalle', 'subclaseDetalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }

    function reporteSubsidioDetalle()
    {
        $inf = [];
        $inf['clases'] = Clase::with(['subclases'])->get()->toJson();
        $inf['subclases'] = Subclase::get()->toJson();
        $inf['empresaNombre'] = Companies::first()->nombre;
        return view('principal.reporteSubsidiosDetalle', $inf);
    }

    function getSubsidiosDetalle(Request $request)
    {
        $data = $request->all();
        echo json_encode(DB::select(DB::raw("select * from subsidios_excedentes WHERE fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' order by fecha_docum ")));
        //SELECT material_id,  m.descripcion, SUM(total) total, SUM(cantidad) cantidad FROM rpt_facturas_det r INNER JOIN materiales m on r.material_id = m.id  WHERE fecha_docum BETWEEN '2024-03-01' AND '2024-03-04' GROUP BY material_id ORDER BY SUM(total) desc
        //echo  ReporteJornada::with(['claseDetalle', 'subclaseDetalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }





    function reporteliq()
    {
        $inf = [];
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reporteliq', $inf);
    }

    function reporteKardex()
    {
        $inf = [];
        $inf['clases'] = Clase::with(['subclases'])->get()->toJson();
        $inf['subclases'] = Subclase::get()->toJson();
        $inf['materiales'] = Material::get()->toJson();
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reporteKardex', $inf);
    }
    function ventadiaria()
    {
        $inf = [];
        $inf['clases'] = Clase::with(['subclases'])->get()->toJson();
        $inf['subclases'] = Subclase::get()->toJson();
        $inf['materiales'] = Material::get()->toJson();
        $inf['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reporteVentaDiaria', $inf);
    }


    function getRepoliq(Request $request)
    {
        $data = $request->all();
        echo  RptFacturas::with(['detalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->orderBy('sucursal')->get()->toJson();
    }


    function generarLiquidacion(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            // Actualiza los registros en la tabla RPTfacturas sin actualizar updated_at
            RptFacturasUpdate::whereIn('idunico', $data['datos'])
                ->update(['liquidado' => 1, 'saldo' => 0, 'updated_at' => DB::raw('updated_at')]);
            // Confirma la transacción
            DB::commit();
            // Puedes agregar un mensaje de éxito si es necesario
            echo json_encode(array('exito' => 1, 'mensaje' => "Registros actualizados con éxito."));
        } catch (\Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollBack();
            // Maneja el error de alguna manera (puede ser un registro en el archivo de registro)
            echo json_encode(array('exito' => 0, 'mensaje' => "Error al actualizar los registros: " . $e->getMessage()));
        } finally {
            // Vuelve a activar las marcas de tiempo
        }
    }



    function reportepos()
    {
        $data = [];



        $data['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.reportepos', $data);
    }


    function resumenDiario()
    {
        $data = [];
        $data['clases'] = Clase::with(['subclases'])->get()->toJson();
        $data['subclases'] = Subclase::get()->toJson();
        $data['materiales'] = Material::get()->toJson();
        $data['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.resumendiario', $data);
    }

    function getresumenDiario(Request $request)
    {
        $data = $request->all();
        echo RptResumVtaDia::whereBetween('fecha', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }



    function resumenMensual()
    {
        $data = [];
        $data['clases'] = Clase::with(['subclases'])->get()->toJson();
        $data['subclases'] = Subclase::get()->toJson();
        $data['materiales'] = Material::get()->toJson();
        $data['sucursales'] = Sucursales::orderBy('codigo')->get()->toJson();
        return view('principal.resumenMensual', $data);
    }

    function getresumenMensual(Request $request)
    {
        $data = $request->all();
        echo RptResumVtaMes::where('anio',$data['año'])->get()->toJson();
    }









    public function getJson()
    {
        $info = $this->getJsonFactura("93F9AA8E-6F14-4A42-B48B-3F4B549EB77E");

        echo json_encode($info);
    }

    function getJsonFactura($factura)
    {
        $ambiente = 'prod';
        $user = Auth::user();
        $company = Companies::find($user->company->id);

        $d = [];

        $json = json_decode(shell_exec('curl --location --request POST "https://admin.factura.gob.sv/' . $ambiente . '/consulta/query/listaByFilter/" --header "Authorization: ' . $company->token . '" --header "Content-Type: application/json" --data-raw " { \"codigoGeneracion\": \"' . $factura . '\", \"tipoRpt\": \"R\" }" --max-time 15'));
        if ((isset($json->status) ? $json->status : 'ERROR') == 'ERROR' || is_null($json) || (isset($json->body) ? count($json->body) : 0) == 0) {
            $json = json_decode(shell_exec('curl --location --request POST "https://admin.factura.gob.sv/' . $ambiente . '/consulta/query/listaByFilter/" --header "Authorization: ' . $company->token . '" --header "Content-Type: application/json" --data-raw " { \"codigoGeneracion\": \"' . $factura . '\", \"tipoRpt\": \"E\" }" --max-time 15'));
        }
        $d = $json;
        if (isset($json->body[0])) {
            $d->body = $json->body[0];
        }

        return $d;
    }

    function getJsonLocal($factura)
    {
        $ambiente = 'prod';
        $user = Auth::user();
        $company = Companies::find($user->company->id);

        $d = [];

        $json = json_decode(shell_exec('curl -X "GET"  "https://sv.lacnetcorp.com/firmador-proxy/fetch-by-generation/?generation_number=' . $factura . '"  -H "accept: application/json" --max-time 15'));

        if (isset($json->message)) {
            return $json;
        }

        try {
            if (false) {
                return $this->getJsonFactura($factura);
            } else {
                $json = $json->record[0]->documento;
                $j = json_encode(array(
                    "status" => "OK",
                    "body" => array(
                        "codigoGeneracion" => $json->identificacion->codigoGeneracion,
                        "fechaRegistro" => "",
                        "fechaEmision" => $json->identificacion->fecEmi . ' ' . $json->identificacion->horEmi,
                        "tipoDte" => $json->identificacion->tipoDte,
                        "tipoDgii" => "",
                        "nitEmision" => $json->emisor->nit,
                        "tipoIdenRec" => 1,
                        "numeIdenRec" => "",
                        "numeroValidacion" => null,
                        "selloRecibido" => "",
                        "estado" => "",
                        "observaciones" => [],
                        "firma" => "",
                        "documento" => $json
                    )
                ));
                return  json_decode($j);
            }
        } catch (\Throwable $th) {
        }
        // if(!isset($json->record)){

    }

    public function getRegistros(Request $request)
    {
        $data = $request->all();
        echo Registro::whereDate('fecha', $data['fecha'])->get()->toJson();
        //echo Registro::where('cod_gen_dte','217CAA96-60D9-4561-BF6B-E09B675C5CC1')->get()->toJson();
    }

    public function getFacturas(Request $request)
    {
        $data = $request->all();

        echo RptFacturas::with(['detalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }

    public function enviar(Request $request)
    {
        $v = $request->all();
        $rutaArchivoAdjunto = storage_path('app/public/' . $v['id']);
        $envio = Mail::to($v['para'])->cc($v['cc'])->bcc($v['bcc'])->send(new EnvioDTE($rutaArchivoAdjunto));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    function traerPDF($id, $token)
    {
        $ambiente = 'prod';
        $v = ($ambiente == 'test') ? 1 : 2;
        return shell_exec('curl --request POST \ --url https://admin.factura.gob.sv/' . $ambiente . '/generardte/generar-pdf/descargar/base64/codigo-generacion/' . $v . '/' . $id . ' \ --header "Authorization: ' . $token . '" --max-time 15');
    }

    public function subirCvs(Request $request)
    {
        $o = new ConsoleOutput();
        $rechazados = [];
        $data = $request->all();
        $user = Auth::user();
        $company = Companies::find($user->company->id);

        //utilizado para eliminar lo del dia
        //Registro::where('fecha', $data['fecha'])->delete();
        foreach ($data['datos'] as $v) {
            $registro = Registro::where('cod_gen_dte', $v['codigo_dte'])->first();
            if (!$registro) {
                $nuevoRegistro = new Registro;
                $nuevoRegistro->cod_gen_dte = $v["codigo_dte"];


                if ($data['modelo'] == 'contingencia') {
                    $o->writeln("***************** Ejecucion local ***********************");
                    $j = $this->getJsonLocal($v["codigo_dte"]);
                    $o->writeln("***************** Fin Ejecucion local ***********************");
                } else {
                    $o->writeln("-------------------------------- ejecucion remota -----------------------------");
                    $j = $this->getJsonFactura($v["codigo_dte"]);
                }

                if (isset($j->message)) {
                    if ($j->message == "No se encontró un registro con ese número de generación") {
                        $j = $this->getJsonFactura($v["codigo_dte"]);
                    }
                }

                if (!isset($j->status)) {
                    array_push($rechazados, $v['codigo_dte']);
                    continue;
                }

                if ($j->status == 'ERROR') {
                    array_push($rechazados, $v['codigo_dte']);
                    continue;
                }




                $datetime = new DateTime($j->body->fechaEmision);

                $nuevoRegistro->fecha = $datetime;
                $nuevoRegistro->tipo_dte = $j->body->tipoDte;

                //trae de hacienda el pdf generado por ellos
                //***$pdf = $this->traerPDF($v["codigo_dte"], $company->token);

                //lo decodifica
                //***$pdfData = base64_decode($pdf);

                try {
                    // Guarda el archivo PDF en el servidor
                    //***$filePath = $v["codigo_dte"] . '.pdf';

                    //***if (Storage::put('public/' . $v["codigo_dte"] . '.pdf', $pdfData)) {//inicio iff
                    $nuevoRegistro->pdf = $v["codigo_dte"] . '.pdf';

                    //********insercion de logo al PDF

                    //********fin insercion de logo al PDF



                    $nuevoRegistro->json_data =  json_encode($j);
                    $nuevoRegistro->nombre =  $j->body->documento->receptor->nombre;
                    $nuevoRegistro->comercial =  (isset($j->body->documento->receptor->nombreComercial) ? $j->body->documento->receptor->nombreComercial : '');
                    $nuevoRegistro->correo =  $j->body->documento->receptor->correo;
                    $nuevoRegistro->valor =  $j->body->documento->resumen->montoTotalOperacion;
                    //***}//fin if
                    //file_put_contents($filePath, $pdfData);
                    if (error_get_last()) {
                        //print_r(error_get_last());
                    }

                    // Verificar si el archivo se guardó correctamente
                    /*if (file_exists($filePath)) {
                    $nuevoRegistro->pdf = $filePath;
                } else {
                    //echo 'Error al guardar el archivo PDF.';
                }*/
                } catch (\Throwable $th) {
                    throw $th;
                }


                $nuevoRegistro->save();
            }
        }
        echo json_encode($rechazados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function guardarCorreo(Request $request)
    {
        $data = $request->all();
        $registro = Registro::find($data['id']);
        $registro->correo = $data['correo'];
        //$registro->correo_enviado = 1;

        if ($registro->save()) {
            echo json_encode(array('exito' => 1, "mensaje" => "Guardado con exito"));
        } else {
            echo json_encode(array('exito' => 0, "mensaje" => "No se pudo realizar la edición"));
        }
    }

    function fusion()
    {
        $pdf = new Fpdi();
        $archivosPDF = array(
            storage_path('app/public/4BF7D4FD-A27D-41C1-9A7E-3613A9FB0933.pdf'),
            storage_path('app/public/8316CE20-05DF-4B8B-931E-1F537831CF2D.pdf'),
            storage_path('app/public/7093955F-1D59-42E2-9E95-E2988CD4E635.pdf')
        );

        foreach ($archivosPDF as $archivo) {
            $pdf->setSourceFile($archivo);
            $pdf->AddPage();
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0); // Importar la primera página del archivo PDF
        }

        $pdfName = "pdf_fusionado.pdf";
        $nombrePDFSalida = storage_path('app/public/' . $pdfName);
        header('Content-Type: application/pdf');
        $pdf->output($nombrePDFSalida, 'I');
        //header("Content-Disposition: attachment; filename=\"$pdfName\"");
        //readfile($nombrePDFSalida);


    }

    public function test()
    {
        // Ruta al archivo PDF existente y al logotipo
        $pdfFilePath = storage_path('app/public/4BF7D4FD-A27D-41C1-9A7E-3613A9FB0933.pdf');
        $logoFilePath = 'logo.pdf';

        $pdf = new Fpdi();
        $pdf->AddPage();

        // Importa el PDF existente
        $pdf->setSourceFile($pdfFilePath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);  // Ajusta el tamaño según tus necesidades

        // Importa el logotipo
        $pdf->setSourceFile($logoFilePath);
        $tplIdx = $pdf->importPage(1);

        //$pdf->addPage();
        $pdf->useTemplate($tplIdx, 150, 9, 40, 15);
        // Agrega el logotipo a cada página del PDF existente
        /*for ($pageNo = 1; $pageNo <= $pdf->PageNo(); $pageNo++) {
    $pdf->addPage();
    $pdf->useTemplate($tplIdx, 50, 50);  // Ajusta las coordenadas según tus necesidades
}*/

        // Nombre del archivo de salida
        $outputFilePath = storage_path('app/public/pdf_con_logo.pdf');

        // Guarda el PDF resultante en un archivo
        $pdf->Output($outputFilePath, 'F');
    }

    function elpdf()
    {


        return view('pp');

        die();
        $pdf = new TCPDF();

        // Set document information
        //$pdf->SetCreator('Your Name');
        //$pdf->SetAuthor('Your Name');
        //$pdf->SetTitle('Sample PDF');

        $cornerRadius = 10;
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();

        // Add a page
        $pdf->AddPage();


        $pdf->RoundedRect(10, 13, $pageWidth - 15, $pageHeight - 25, $cornerRadius, '1111', 'C', array(0, 0, 0));

        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Add some content
        $pdf->Ln(7);
        $pdf->Cell(0, 0, 'Ver.3', 0, 1, 'R');
        $pdf->Cell(0, 0, 'DOCUMENTO TRIBUTARIO ELECTRÓNICO', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 0, 'COMPROBANTE DE CRÉDITO FISCAL', 0, 1, 'C', false, '');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 8);
        //Código de Generación: 969BC88C-DEB0-4552-A705-3F33D1B08718
        $pdf->Cell(0, 0, 'Código de Generación: 969BC88C-DEB0-4552-A705-3F33D1B08718', 0, 0, 'L', false, '');
        $pdf->Cell(0, 0, 'Modelo de Facturación: Previo', 0, 1, 'R', false, '');


        $pdf->Cell(0, 0, 'Número de Control:DTE-03-S003P001-000000000001054', 0, 0, 'L', false, '');
        $pdf->Cell(0, 0, 'Tipo de Transmisión: Normal', 0, 1, 'R', false, '');



        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 6,
            'stretchtext' => 0
        );
        $txt = "test";

        //$pdf->write1DBarcode('123456789', 'C39', 25, 25, 50, 10, 0.4, $style, 'N');
        // Output the PDF as a file
        $pdf->Output('sample.pdf', 'I');
    }

    function getSupermercados(Request $request)
    {

        $data = $request->all();

        $fecha = $data['fecha'];

        /*$v = json_decode(shell_exec('curl --location --request GET "https://sv.lacnetcorp.com/sapapi/functiontest?path=ZRFC_DATOS_DTE_F&where=PFKDAT1=' . $fecha . ',PFKDAT2=' . $fecha . '"'));

        if(!isset($v->TT_DATOS_ENVIO_DTE)){
            $v = json_decode(shell_exec('curl --location --request GET "https://sv.lacnetcorp.com/sapapi/functionfs?path=ZRFC_DATOS_DTE_F&where=PFKDAT1=' . $fecha . ',PFKDAT2=' . $fecha . '"'));
        }*/
        //$v = json_decode(shell_exec('curl --location --request GET "https://sv.lacnetcorp.com/sapapi/functionfs?path=ZRFC_DATOS_DTE_F&where=PFKDAT1=' . $fecha . ',PFKDAT2=' . $fecha . '",PGESTOR=EX'));
        //**$v = json_decode(shell_exec('curl --location --request GET "https://sv.lacnetcorp.com/sapapi/functionfs?path=ZRFC_DATOS_DTE_F&where=PFKDAT1=' . $fecha . ',PFKDAT2=' . $fecha . '"'));

        //echo (shell_exec('curl --location --request GET "https://sv.lacnetcorp.com/prolac/ssapi/?ff1=' . $fecha . '"'));

        //**echo json_encode($v->TT_DATOS_ENVIO_DTE);

        //implementando version fer
        $fecha_array = explode(".", $fecha);
        echo (shell_exec('curl --location --request GET "https://dte-data.yes.com.sv/consuta-dte/api/v1/json-extra-fields-date/' . $fecha_array[2] . '-' . $fecha_array[1] . '-' . $fecha_array[0] . '"'));
    }

    function getCodigoBarra()
    {
        echo '[ { "EAN11": "10400000005635", "MATNR": "000000000000150001" }, { "EAN11": "10400000005642", "MATNR": "000000000000150003" }, { "EAN11": "10400000005659", "MATNR": "000000000000150005" }, { "EAN11": "10400000005673", "MATNR": "000000000000160005" }, { "EAN11": "10400000002498", "MATNR": "000000000000120004" }, { "EAN11": "10400000004447", "MATNR": "000000000000110003" }, { "EAN11": "10400000005598", "MATNR": "000000000000110005" }, { "EAN11": "2000000000039", "MATNR": "000000000000110006" }, { "EAN11": "10400000004157", "MATNR": "000000000000110007" }, { "EAN11": "10400000004454", "MATNR": "000000000000110009" }, { "EAN11": "10400000005345", "MATNR": "000000000000240002" }, { "EAN11": "10400000005352", "MATNR": "000000000000240003" }, { "EAN11": "10400000005369", "MATNR": "000000000000240004" }, { "EAN11": "10400000005376", "MATNR": "000000000000240005" }, { "EAN11": "10400000005383", "MATNR": "000000000000240007" }, { "EAN11": "10400000005390", "MATNR": "000000000000240008" }, { "EAN11": "10400000005406", "MATNR": "000000000000240009" }, { "EAN11": "10400000005529", "MATNR": "000000000000250004" }, { "EAN11": "10400000001347", "MATNR": "000000000000110036" }, { "EAN11": "10400000004164", "MATNR": "000000000000110037" }, { "EAN11": "10400000001804", "MATNR": "000000000000110039" }, { "EAN11": "10400000001484", "MATNR": "000000000000110056" }, { "EAN11": "10400000001491", "MATNR": "000000000000110057" }, { "EAN11": "10400000001507", "MATNR": "000000000000110058" }, { "EAN11": "10400000001514", "MATNR": "000000000000110060" }, { "EAN11": "10400000001521", "MATNR": "000000000000110061" }, { "EAN11": "10400000001309", "MATNR": "000000000000110062" }, { "EAN11": "10400000001538", "MATNR": "000000000000110063" }, { "EAN11": "10400000001170", "MATNR": "000000000000110065" }, { "EAN11": "10400000003945", "MATNR": "000000000000110066" }, { "EAN11": "10400000003952", "MATNR": "000000000000110067" }, { "EAN11": "2000000000053", "MATNR": "000000000000140005" }, { "EAN11": "787003000861", "MATNR": "000000000000140220" }, { "EAN11": "787003000892", "MATNR": "000000000000140221" }, { "EAN11": "787003000878", "MATNR": "000000000000140222" }, { "EAN11": "787003001028", "MATNR": "000000000000140223" }, { "EAN11": "787003001523", "MATNR": "000000000000140224" }, { "EAN11": "787003250518", "MATNR": "000000000000140225" }, { "EAN11": "787003600184", "MATNR": "000000000000140226" }, { "EAN11": "787003600191", "MATNR": "000000000000140227" }, { "EAN11": "787003250549", "MATNR": "000000000000140228" }, { "EAN11": "10400000004461", "MATNR": "000000000000110013" }, { "EAN11": "2000000000190", "MATNR": "000000000000110014" }, { "EAN11": "10400000004478", "MATNR": "000000000000110015" }, { "EAN11": "10400000001422", "MATNR": "000000000000110016" }, { "EAN11": "10400000001460", "MATNR": "000000000000110018" }, { "EAN11": "10400000001316", "MATNR": "000000000000110019" }, { "EAN11": "10400000001323", "MATNR": "000000000000110020" }, { "EAN11": "10400000001330", "MATNR": "000000000000110021" }, { "EAN11": "10400000001767", "MATNR": "000000000000110023" }, { "EAN11": "10400000001569", "MATNR": "000000000000110024" }, { "EAN11": "10400000001774", "MATNR": "000000000000110025" }, { "EAN11": "10400000001576", "MATNR": "000000000000110028" }, { "EAN11": "10400000005871", "MATNR": "000000000000110029" }, { "EAN11": "10400000001477", "MATNR": "000000000000110030" }, { "EAN11": "10400000001095", "MATNR": "000000000000110031" }, { "EAN11": "10400000001781", "MATNR": "000000000000110033" }, { "EAN11": "10400000001798", "MATNR": "000000000000110034" }, { "EAN11": "10400000006304", "MATNR": "000000000000200030" }, { "EAN11": "10400000006298", "MATNR": "000000000000200033" }, { "EAN11": "10400000005338", "MATNR": "000000000000240001" }, { "EAN11": "10400000004362", "MATNR": "000000000000110116" }, { "EAN11": "10400000004379", "MATNR": "000000000000110117" }, { "EAN11": "10400000001200", "MATNR": "000000000000110118" }, { "EAN11": "10400000001217", "MATNR": "000000000000110119" }, { "EAN11": "10400000004386", "MATNR": "000000000000110121" }, { "EAN11": "10400000001446", "MATNR": "000000000000110122" }, { "EAN11": "10400000002504", "MATNR": "000000000000120010" }, { "EAN11": "10400000002511", "MATNR": "000000000000120029" }, { "EAN11": "10400000003969", "MATNR": "000000000000110068" }, { "EAN11": "10400000003976", "MATNR": "000000000000110069" }, { "EAN11": "10400000003983", "MATNR": "000000000000110070" }, { "EAN11": "10400000003990", "MATNR": "000000000000110071" }, { "EAN11": "10400000004003", "MATNR": "000000000000110072" }, { "EAN11": "10400000005888", "MATNR": "000000000000110073" }, { "EAN11": "10400000005895", "MATNR": "000000000000110074" }, { "EAN11": "10400000001415", "MATNR": "000000000000110075" }, { "EAN11": "10400000001187", "MATNR": "000000000000110076" }, { "EAN11": "10400000001354", "MATNR": "000000000000110078" }, { "EAN11": "10400000001361", "MATNR": "000000000000110079" }, { "EAN11": "10400000001378", "MATNR": "000000000000110080" }, { "EAN11": "10400000001385", "MATNR": "000000000000110081" }, { "EAN11": "10400000001392", "MATNR": "000000000000110082" }, { "EAN11": "10400000001408", "MATNR": "000000000000110083" }, { "EAN11": "10400000001194", "MATNR": "000000000000110086" }, { "EAN11": "10400000004133", "MATNR": "000000000000110087" }, { "EAN11": "10400000001439", "MATNR": "000000000000110088" }, { "EAN11": "10400000002177", "MATNR": "000000000000110089" }, { "EAN11": "10400000002184", "MATNR": "000000000000110090" }, { "EAN11": "10400000002191", "MATNR": "000000000000110091" }, { "EAN11": "10400000002207", "MATNR": "000000000000110092" }, { "EAN11": "10400000002214", "MATNR": "000000000000110094" }, { "EAN11": "10400000002221", "MATNR": "000000000000110095" }, { "EAN11": "10400000002238", "MATNR": "000000000000110100" }, { "EAN11": "10400000002245", "MATNR": "000000000000110104" }, { "EAN11": "10400000002139", "MATNR": "000000000000110111" }, { "EAN11": "10400000002146", "MATNR": "000000000000110112" }, { "EAN11": "10400000004348", "MATNR": "000000000000110113" }, { "EAN11": "10400000004355", "MATNR": "000000000000110114" }, { "EAN11": "10400000000005", "MATNR": "000000000000120051" }, { "EAN11": "10400000000333", "MATNR": "000000000000120052" }, { "EAN11": "10400000001750", "MATNR": "000000000000120053" }, { "EAN11": "10400000000340", "MATNR": "000000000000120059" }, { "EAN11": "10400000000425", "MATNR": "000000000000120061" }, { "EAN11": "10400000000357", "MATNR": "000000000000120062" }, { "EAN11": "10400000000494", "MATNR": "000000000000120109" }, { "EAN11": "10400000005956", "MATNR": "000000000000120129" }, { "EAN11": "10400000000364", "MATNR": "000000000000120063" }, { "EAN11": "10400000000432", "MATNR": "000000000000120071" }, { "EAN11": "10400000000449", "MATNR": "000000000000120073" }, { "EAN11": "10400000001910", "MATNR": "000000000000120075" }, { "EAN11": "10400000006038", "MATNR": "000000000000120194" }, { "EAN11": "10400000001972", "MATNR": "000000000000120207" }, { "EAN11": "10400000001989", "MATNR": "000000000000120208" }, { "EAN11": "10400000000951", "MATNR": "000000000000120209" }, { "EAN11": "10400000000968", "MATNR": "000000000000120210" }, { "EAN11": "10400000000975", "MATNR": "000000000000120213" }, { "EAN11": "10400000000982", "MATNR": "000000000000120214" }, { "EAN11": "10400000000999", "MATNR": "000000000000120215" }, { "EAN11": "10400000001996", "MATNR": "000000000000120217" }, { "EAN11": "10400000001002", "MATNR": "000000000000120218" }, { "EAN11": "10400000005994", "MATNR": "000000000000120141" }, { "EAN11": "10400000006007", "MATNR": "000000000000120143" }, { "EAN11": "10400000006014", "MATNR": "000000000000120145" }, { "EAN11": "10400000006021", "MATNR": "000000000000120146" }, { "EAN11": "10400000000500", "MATNR": "000000000000120163" }, { "EAN11": "10400000000050", "MATNR": "000000000000120231" }, { "EAN11": "10400000005970", "MATNR": "000000000000120232" }, { "EAN11": "10400000000067", "MATNR": "000000000000120234" }, { "EAN11": "10400000002016", "MATNR": "000000000000120236" }, { "EAN11": "10400000001071", "MATNR": "000000000000120237" }, { "EAN11": "10400000000159", "MATNR": "000000000000120251" }, { "EAN11": "10400000000166", "MATNR": "000000000000120252" }, { "EAN11": "10400000000173", "MATNR": "000000000000120254" }, { "EAN11": "10400000002528", "MATNR": "000000000000120255" }, { "EAN11": "10400000003402", "MATNR": "000000000000120256" }, { "EAN11": "10400000003310", "MATNR": "000000000000120262" }, { "EAN11": "10400000002535", "MATNR": "000000000000120268" }, { "EAN11": "10400000004126", "MATNR": "000000000000120273" }, { "EAN11": "10400000000456", "MATNR": "000000000000120300" }, { "EAN11": "10400000001019", "MATNR": "000000000000120219" }, { "EAN11": "10400000005963", "MATNR": "000000000000120221" }, { "EAN11": "10400000001026", "MATNR": "000000000000120222" }, { "EAN11": "10400000002009", "MATNR": "000000000000120224" }, { "EAN11": "10400000001033", "MATNR": "000000000000120225" }, { "EAN11": "10400000001040", "MATNR": "000000000000120230" }, { "EAN11": "787003000830", "MATNR": "000000000000140232" }, { "EAN11": "787003600221", "MATNR": "000000000000140233" }, { "EAN11": "787003000632", "MATNR": "000000000000140234" }, { "EAN11": "787003600214", "MATNR": "000000000000140235" }, { "EAN11": "787003600252", "MATNR": "000000000000140236" }, { "EAN11": "787003600375", "MATNR": "000000000000140237" }, { "EAN11": "787003600436", "MATNR": "000000000000140238" }, { "EAN11": "787003600368", "MATNR": "000000000000140239" }, { "EAN11": "787003600382", "MATNR": "000000000000140240" }, { "EAN11": "787003001356", "MATNR": "000000000000140241" }, { "EAN11": "787003001455", "MATNR": "000000000000140211" }, { "EAN11": "787003250532", "MATNR": "000000000000140229" }, { "EAN11": "787003250556", "MATNR": "000000000000140230" }, { "EAN11": "787003000847", "MATNR": "000000000000140231" }, { "EAN11": "2000000000060", "MATNR": "000000000000140013" }, { "EAN11": "787003001646", "MATNR": "000000000000140015" }, { "EAN11": "2000000000077", "MATNR": "000000000000140023" }, { "EAN11": "2000000000084", "MATNR": "000000000000140034" }, { "EAN11": "2000000000152", "MATNR": "000000000000140040" }, { "EAN11": "2000000000091", "MATNR": "000000000000140041" }, { "EAN11": "2000000000107", "MATNR": "000000000000140055" }, { "EAN11": "787003002346", "MATNR": "000000000000140071" }, { "EAN11": "2000000000114", "MATNR": "000000000000140072" }, { "EAN11": "2000000000121", "MATNR": "000000000000140077" }, { "EAN11": "2000000000138", "MATNR": "000000000000140078" }, { "EAN11": "2000000000145", "MATNR": "000000000000140079" }, { "EAN11": "787003000526", "MATNR": "000000000000140184" }, { "EAN11": "787003001622", "MATNR": "000000000000140254" }, { "EAN11": "787003600610", "MATNR": "000000000000140255" }, { "EAN11": "787003600627", "MATNR": "000000000000140256" }, { "EAN11": "787003600580", "MATNR": "000000000000140257" }, { "EAN11": "787003600597", "MATNR": "000000000000140258" }, { "EAN11": "787003001387", "MATNR": "000000000000140259" }, { "EAN11": "787003000793", "MATNR": "000000000000140260" }, { "EAN11": "787003600511", "MATNR": "000000000000140261" }, { "EAN11": "787003600535", "MATNR": "000000000000140262" }, { "EAN11": "787003000908", "MATNR": "000000000000140263" }, { "EAN11": "787003250341", "MATNR": "000000000000140264" }, { "EAN11": "787003000557", "MATNR": "000000000000140265" }, { "EAN11": "787003000526", "MATNR": "000000000000140266" }, { "EAN11": "787003000618", "MATNR": "000000000000140267" }, { "EAN11": "787003000601", "MATNR": "000000000000140268" }, { "EAN11": "787003001561", "MATNR": "000000000000140269" }, { "EAN11": "787003000977", "MATNR": "000000000000140270" }, { "EAN11": "787003000564", "MATNR": "000000000000140271" }, { "EAN11": "787003000915", "MATNR": "000000000000140272" }, { "EAN11": "787003250310", "MATNR": "000000000000140273" }, { "EAN11": "787003250365", "MATNR": "000000000000140274" }, { "EAN11": "787003250334", "MATNR": "000000000000140275" }, { "EAN11": "787003001592", "MATNR": "000000000000140309" }, { "EAN11": "787003120040", "MATNR": "000000000000140310" }, { "EAN11": "787003600498", "MATNR": "000000000000140311" }, { "EAN11": "787003002056", "MATNR": "000000000000140312" }, { "EAN11": "787003000038", "MATNR": "000000000000140313" }, { "EAN11": "787003002063", "MATNR": "000000000000140314" }, { "EAN11": "787003016084", "MATNR": "000000000000140315" }, { "EAN11": "787003115022", "MATNR": "000000000000140316" }, { "EAN11": "787003016077", "MATNR": "000000000000140317" }, { "EAN11": "787003016060", "MATNR": "000000000000140318" }, { "EAN11": "7419901501166", "MATNR": "000000000000140319" }, { "EAN11": "787003002070", "MATNR": "000000000000140320" }, { "EAN11": "2319373529154", "MATNR": "000000000000140321" }, { "EAN11": "787003002087", "MATNR": "000000000000140322" }, { "EAN11": "787003001691", "MATNR": "000000000000140323" }, { "EAN11": "787003001684", "MATNR": "000000000000140324" }, { "EAN11": "787003002292", "MATNR": "000000000000140325" }, { "EAN11": "787003116012", "MATNR": "000000000000140326" }, { "EAN11": "787003016107", "MATNR": "000000000000140327" }, { "EAN11": "787003000069", "MATNR": "000000000000140328" }, { "EAN11": "787003016091", "MATNR": "000000000000140329" }, { "EAN11": "787003116050", "MATNR": "000000000000140330" }, { "EAN11": "787003250372", "MATNR": "000000000000140276" }, { "EAN11": "787003001547", "MATNR": "000000000000140277" }, { "EAN11": "787003000649", "MATNR": "000000000000140278" }, { "EAN11": "787003600634", "MATNR": "000000000000140279" }, { "EAN11": "787003000663", "MATNR": "000000000000140280" }, { "EAN11": "787003001349", "MATNR": "000000000000140281" }, { "EAN11": "787003000656", "MATNR": "000000000000140282" }, { "EAN11": "787003001363", "MATNR": "000000000000140283" }, { "EAN11": "787003000670", "MATNR": "000000000000140284" }, { "EAN11": "787003001639", "MATNR": "000000000000140285" }, { "EAN11": "787003001882", "MATNR": "000000000000140286" }, { "EAN11": "787003001899", "MATNR": "000000000000140287" }, { "EAN11": "787003001905", "MATNR": "000000000000140288" }, { "EAN11": "787003001912", "MATNR": "000000000000140289" }, { "EAN11": "787003001929", "MATNR": "000000000000140290" }, { "EAN11": "787003001936", "MATNR": "000000000000140291" }, { "EAN11": "787003001943", "MATNR": "000000000000140292" }, { "EAN11": "787003001950", "MATNR": "000000000000140293" }, { "EAN11": "787003001967", "MATNR": "000000000000140294" }, { "EAN11": "787003001974", "MATNR": "000000000000140295" }, { "EAN11": "787003001189", "MATNR": "000000000000140296" }, { "EAN11": "787003001981", "MATNR": "000000000000140297" }, { "EAN11": "787003001998", "MATNR": "000000000000140298" }, { "EAN11": "787003002001", "MATNR": "000000000000140299" }, { "EAN11": "787003002018", "MATNR": "000000000000140300" }, { "EAN11": "787003000021", "MATNR": "000000000000140301" }, { "EAN11": "787003111055", "MATNR": "000000000000140302" }, { "EAN11": "787003000014", "MATNR": "000000000000140303" }, { "EAN11": "787003000106", "MATNR": "000000000000140304" }, { "EAN11": "787003001165", "MATNR": "000000000000140305" }, { "EAN11": "787003002025", "MATNR": "000000000000140306" }, { "EAN11": "787003002032", "MATNR": "000000000000140307" }, { "EAN11": "787003002049", "MATNR": "000000000000140308" }, { "EAN11": "787003001486", "MATNR": "000000000000140250" }, { "EAN11": "787003001493", "MATNR": "000000000000140251" }, { "EAN11": "787003001509", "MATNR": "000000000000140252" }, { "EAN11": "787003001615", "MATNR": "000000000000140253" }, { "EAN11": "787003002230", "MATNR": "000000000000140375" }, { "EAN11": "787003001202", "MATNR": "000000000000140376" }, { "EAN11": "787003001721", "MATNR": "000000000000140377" }, { "EAN11": "787003001738", "MATNR": "000000000000140378" }, { "EAN11": "2000000000169", "MATNR": "000000000000140379" }, { "EAN11": "787003001783", "MATNR": "000000000000140380" }, { "EAN11": "787003002872", "MATNR": "000000000000140387" }, { "EAN11": "2000000000015", "MATNR": "000000000000140390" }, { "EAN11": "787003001653", "MATNR": "000000000000140401" }, { "EAN11": "10400000006335", "MATNR": "000000000000200037" }, { "EAN11": "787003002100", "MATNR": "000000000000140331" }, { "EAN11": "787003002117", "MATNR": "000000000000140332" }, { "EAN11": "787003002124", "MATNR": "000000000000140333" }, { "EAN11": "787003002131", "MATNR": "000000000000140334" }, { "EAN11": "787003002148", "MATNR": "000000000000140335" }, { "EAN11": "787003002155", "MATNR": "000000000000140336" }, { "EAN11": "787003002162", "MATNR": "000000000000140337" }, { "EAN11": "787003002179", "MATNR": "000000000000140338" }, { "EAN11": "787003120026", "MATNR": "000000000000140339" }, { "EAN11": "787003002308", "MATNR": "000000000000140340" }, { "EAN11": "787003001080", "MATNR": "000000000000140341" }, { "EAN11": "787003001431", "MATNR": "000000000000140342" }, { "EAN11": "2319373529161", "MATNR": "000000000000140343" }, { "EAN11": "787003180013", "MATNR": "000000000000140344" }, { "EAN11": "787003180020", "MATNR": "000000000000140345" }, { "EAN11": "2319373529185", "MATNR": "000000000000140346" }, { "EAN11": "787003002186", "MATNR": "000000000000140347" }, { "EAN11": "787003001288", "MATNR": "000000000000140348" }, { "EAN11": "787003000700", "MATNR": "000000000000140349" }, { "EAN11": "787003002193", "MATNR": "000000000000140350" }, { "EAN11": "787003001752", "MATNR": "000000000000140351" }, { "EAN11": "787003002209", "MATNR": "000000000000140352" }, { "EAN11": "787003002315", "MATNR": "000000000000140353" }, { "EAN11": "787003002322", "MATNR": "000000000000140354" }, { "EAN11": "787003200100", "MATNR": "000000000000140355" }, { "EAN11": "787003002261", "MATNR": "000000000000140356" }, { "EAN11": "787003180068", "MATNR": "000000000000140357" }, { "EAN11": "787003180105", "MATNR": "000000000000140358" }, { "EAN11": "787003002278", "MATNR": "000000000000140359" }, { "EAN11": "787003001271", "MATNR": "000000000000140360" }, { "EAN11": "2319373529178", "MATNR": "000000000000140361" }, { "EAN11": "787003600672", "MATNR": "000000000000140362" }, { "EAN11": "787003600665", "MATNR": "000000000000140363" }, { "EAN11": "787003600658", "MATNR": "000000000000140364" }, { "EAN11": "787003600641", "MATNR": "000000000000140365" }, { "EAN11": "787003001448", "MATNR": "000000000000140366" }, { "EAN11": "787003001462", "MATNR": "000000000000140367" }, { "EAN11": "787003001479", "MATNR": "000000000000140368" }, { "EAN11": "787003002285", "MATNR": "000000000000140369" }, { "EAN11": "787003002339", "MATNR": "000000000000140370" }, { "EAN11": "787003002353", "MATNR": "000000000000140371" }, { "EAN11": "2000000000046", "MATNR": "000000000000140372" }, { "EAN11": "787003001196", "MATNR": "000000000000140373" }, { "EAN11": "787003002223", "MATNR": "000000000000140374" }, { "EAN11": "10400000005413", "MATNR": "000000000000240010" }, { "EAN11": "10400000005420", "MATNR": "000000000000240011" }, { "EAN11": "8012063000158", "MATNR": "000000000000180021" }, { "EAN11": "8012063001025", "MATNR": "000000000000180022" }, { "EAN11": "8012063000974", "MATNR": "000000000000180023" }, { "EAN11": "10400000005451", "MATNR": "000000000000240014" }, { "EAN11": "10400000005468", "MATNR": "000000000000240016" }, { "EAN11": "10400000005475", "MATNR": "000000000000240017" }, { "EAN11": "10400000005536", "MATNR": "000000000000240018" }, { "EAN11": "10400000005543", "MATNR": "000000000000240019" }, { "EAN11": "10400000005482", "MATNR": "000000000000240020" }, { "EAN11": "10400000005499", "MATNR": "000000000000240021" }, { "EAN11": "10400000005512", "MATNR": "000000000000240023" }, { "EAN11": "8012063000073", "MATNR": "000000000000180000" }, { "EAN11": "8012063000141", "MATNR": "000000000000180001" }, { "EAN11": "8012063000752", "MATNR": "000000000000180002" }, { "EAN11": "8012063000684", "MATNR": "000000000000180003" }, { "EAN11": "8012063000615", "MATNR": "000000000000180004" }, { "EAN11": "8012063000998", "MATNR": "000000000000180005" }, { "EAN11": "8012063000790", "MATNR": "000000000000180006" }, { "EAN11": "8012063001544", "MATNR": "000000000000180007" }, { "EAN11": "8012063000080", "MATNR": "000000000000180008" }, { "EAN11": "8005021013703", "MATNR": "000000000000180009" }, { "EAN11": "8012063001551", "MATNR": "000000000000180010" }, { "EAN11": "8012063000592", "MATNR": "000000000000180011" }, { "EAN11": "8012063000936", "MATNR": "000000000000180012" }, { "EAN11": "8012063000905", "MATNR": "000000000000180013" }, { "EAN11": "8005021013727", "MATNR": "000000000000180014" }, { "EAN11": "8012063001667", "MATNR": "000000000000180015" }, { "EAN11": "8012063001049", "MATNR": "000000000000180016" }, { "EAN11": "8012063000738", "MATNR": "000000000000180017" }, { "EAN11": "8012063001643", "MATNR": "000000000000180018" }, { "EAN11": "8012063001018", "MATNR": "000000000000180019" }, { "EAN11": "8012063000745", "MATNR": "000000000000180020" }, { "EAN11": "10400000005796", "MATNR": "000000000000200040" }, { "EAN11": "10400000005802", "MATNR": "000000000000200043" }, { "EAN11": "10400000006892", "MATNR": "000000000000200046" }, { "EAN11": "10400000000074", "MATNR": "000000000000120492" }, { "EAN11": "10400000001927", "MATNR": "000000000000120493" }, { "EAN11": "10400000001934", "MATNR": "000000000000120494" }, { "EAN11": "10400000001941", "MATNR": "000000000000120495" }, { "EAN11": "10400000001958", "MATNR": "000000000000120496" }, { "EAN11": "10400000002252", "MATNR": "000000000000110173" }, { "EAN11": "10400000002269", "MATNR": "000000000000110174" }, { "EAN11": "10400000002276", "MATNR": "000000000000110175" }, { "EAN11": "10400000002283", "MATNR": "000000000000110177" }, { "EAN11": "10400000002290", "MATNR": "000000000000110178" }, { "EAN11": "10400000005901", "MATNR": "000000000000120497" }, { "EAN11": "10400000002153", "MATNR": "000000000000110179" }, { "EAN11": "10400000002160", "MATNR": "000000000000110180" }, { "EAN11": "10400000004010", "MATNR": "000000000000110183" }, { "EAN11": "787003001578", "MATNR": "000000000000150030" }, { "EAN11": "10400000002559", "MATNR": "000000000000120502" }, { "EAN11": "10400000002566", "MATNR": "000000000000120503" }, { "EAN11": "10400000004409", "MATNR": "000000000000110184" }, { "EAN11": "10400000002306", "MATNR": "000000000000110185" }, { "EAN11": "787003001554", "MATNR": "000000000000150031" }, { "EAN11": "787003002391", "MATNR": "000000000000140423" }, { "EAN11": "787003002384", "MATNR": "000000000000140424" }, { "EAN11": "787003002421", "MATNR": "000000000000140425" }, { "EAN11": "787003002407", "MATNR": "000000000000140426" }, { "EAN11": "787003002414", "MATNR": "000000000000140427" }, { "EAN11": "787003002483", "MATNR": "000000000000140428" }, { "EAN11": "787003002452", "MATNR": "000000000000140429" }, { "EAN11": "787003002445", "MATNR": "000000000000140430" }, { "EAN11": "787003002438", "MATNR": "000000000000140431" }, { "EAN11": "787003002469", "MATNR": "000000000000140432" }, { "EAN11": "10400000001088", "MATNR": "000000000000120316" }, { "EAN11": "10400000000463", "MATNR": "000000000000120304" }, { "EAN11": "10400000005987", "MATNR": "000000000000120305" }, { "EAN11": "10400000005437", "MATNR": "000000000000240031" }, { "EAN11": "787003002377", "MATNR": "000000000000140413" }, { "EAN11": "10400000006045", "MATNR": "000000000000120372" }, { "EAN11": "787003002360", "MATNR": "000000000000140417" }, { "EAN11": "787003002247", "MATNR": "000000000000140418" }, { "EAN11": "787003002254", "MATNR": "000000000000140419" }, { "EAN11": "10400000002542", "MATNR": "000000000000120336" }, { "EAN11": "10400000005819", "MATNR": "000000000000120472" }, { "EAN11": "10400000005826", "MATNR": "000000000000120473" }, { "EAN11": "10400000005833", "MATNR": "000000000000120474" }, { "EAN11": "10400000003440", "MATNR": "000000000000120475" }, { "EAN11": "10400000000579", "MATNR": "000000000000120714" }, { "EAN11": "10400000002825", "MATNR": "000000000000120743" }, { "EAN11": "787003002926", "MATNR": "000000000000140572" }, { "EAN11": "787003002933", "MATNR": "000000000000140574" }, { "EAN11": "787003002940", "MATNR": "000000000000140575" }, { "EAN11": "10400000000616", "MATNR": "000000000000120744" }, { "EAN11": "10400000000623", "MATNR": "000000000000120746" }, { "EAN11": "787003002599", "MATNR": "000000000000140434" }, { "EAN11": "10400000000586", "MATNR": "000000000000120722" }, { "EAN11": "10400000004492", "MATNR": "000000000000110283" }, { "EAN11": "10400000001224", "MATNR": "000000000000110254" }, { "EAN11": "10400000006106", "MATNR": "000000000000120724" }, { "EAN11": "10400000001637", "MATNR": "000000000000120754" }, { "EAN11": "10400000006120", "MATNR": "000000000000120755" }, { "EAN11": "787003002957", "MATNR": "000000000000140584" }, { "EAN11": "787003002964", "MATNR": "000000000000140585" }, { "EAN11": "787003002704", "MATNR": "000000000000140586" }, { "EAN11": "10400000002580", "MATNR": "000000000000120632" }, { "EAN11": "10400000002719", "MATNR": "000000000000120646" }, { "EAN11": "10400000002726", "MATNR": "000000000000120647" }, { "EAN11": "10400000002733", "MATNR": "000000000000120648" }, { "EAN11": "10400000002740", "MATNR": "000000000000120649" }, { "EAN11": "10400000006137", "MATNR": "000000000000120757" }, { "EAN11": "10400000002351", "MATNR": "000000000000110284" }, { "EAN11": "787003002971", "MATNR": "000000000000140587" }, { "EAN11": "10400000002757", "MATNR": "000000000000120702" }, { "EAN11": "10400000002764", "MATNR": "000000000000120705" }, { "EAN11": "10400000001644", "MATNR": "000000000000120758" }, { "EAN11": "10400000003525", "MATNR": "000000000000120766" }, { "EAN11": "10400000003532", "MATNR": "000000000000120767" }, { "EAN11": "10400000003549", "MATNR": "000000000000120768" }, { "EAN11": "10400000003556", "MATNR": "000000000000120769" }, { "EAN11": "10400000003563", "MATNR": "000000000000120770" }, { "EAN11": "10400000003570", "MATNR": "000000000000120771" }, { "EAN11": "10400000003587", "MATNR": "000000000000120772" }, { "EAN11": "10400000003594", "MATNR": "000000000000120777" }, { "EAN11": "10400000003600", "MATNR": "000000000000120778" }, { "EAN11": "10400000003617", "MATNR": "000000000000120779" }, { "EAN11": "10400000003624", "MATNR": "000000000000120780" }, { "EAN11": "787003002742", "MATNR": "000000000000140512" }, { "EAN11": "787003002834", "MATNR": "000000000000140553" }, { "EAN11": "10400000006113", "MATNR": "000000000000120725" }, { "EAN11": "10400000001057", "MATNR": "000000000000120726" }, { "EAN11": "10400000000944", "MATNR": "000000000000120729" }, { "EAN11": "10400000000593", "MATNR": "000000000000120730" }, { "EAN11": "10400000000609", "MATNR": "000000000000120731" }, { "EAN11": "10400000000906", "MATNR": "000000000000120708" }, { "EAN11": "10400000000913", "MATNR": "000000000000120709" }, { "EAN11": "10400000000920", "MATNR": "000000000000120711" }, { "EAN11": "10400000003457", "MATNR": "000000000000120759" }, { "EAN11": "10400000003464", "MATNR": "000000000000120760" }, { "EAN11": "10400000003471", "MATNR": "000000000000120761" }, { "EAN11": "10400000003488", "MATNR": "000000000000120762" }, { "EAN11": "10400000005918", "MATNR": "000000000000110193" }, { "EAN11": "787003002575", "MATNR": "000000000000140457" }, { "EAN11": "787003003183", "MATNR": "000000000000140458" }, { "EAN11": "10400000002313", "MATNR": "000000000000110197" }, { "EAN11": "10400000002320", "MATNR": "000000000000110198" }, { "EAN11": "10400000002337", "MATNR": "000000000000110203" }, { "EAN11": "10400000000937", "MATNR": "000000000000120712" }, { "EAN11": "787003002520", "MATNR": "000000000000140462" }, { "EAN11": "787003002667", "MATNR": "000000000000140463" }, { "EAN11": "10400000006052", "MATNR": "000000000000120557" }, { "EAN11": "10400000006069", "MATNR": "000000000000120558" }, { "EAN11": "10400000006076", "MATNR": "000000000000120559" }, { "EAN11": "10400000006083", "MATNR": "000000000000120560" }, { "EAN11": "10400000001590", "MATNR": "000000000000110273" }, { "EAN11": "10400000003495", "MATNR": "000000000000120763" }, { "EAN11": "10400000003501", "MATNR": "000000000000120764" }, { "EAN11": "10400000003518", "MATNR": "000000000000120765" }, { "EAN11": "787003001295", "MATNR": "000000000000140444" }, { "EAN11": "787003001318", "MATNR": "000000000000140445" }, { "EAN11": "787003001301", "MATNR": "000000000000140446" }, { "EAN11": "787003001530", "MATNR": "000000000000140447" }, { "EAN11": "787003001394", "MATNR": "000000000000140448" }, { "EAN11": "787003001417", "MATNR": "000000000000140449" }, { "EAN11": "787003001400", "MATNR": "000000000000140450" }, { "EAN11": "787003001820", "MATNR": "000000000000140451" }, { "EAN11": "20787003001282", "MATNR": "000000000000140452" }, { "EAN11": "10400000001583", "MATNR": "000000000000110213" }, { "EAN11": "10400000000562", "MATNR": "000000000000120713" }, { "EAN11": "10400000003631", "MATNR": "000000000000120781" }, { "EAN11": "10400000003648", "MATNR": "000000000000120782" }, { "EAN11": "10400000003655", "MATNR": "000000000000120783" }, { "EAN11": "787003002568", "MATNR": "000000000000140588" }, { "EAN11": "787003002674", "MATNR": "000000000000140589" }, { "EAN11": "787003002889", "MATNR": "000000000000140562" }, { "EAN11": "10400000006090", "MATNR": "000000000000120693" }, { "EAN11": "10400000000548", "MATNR": "000000000000120694" }, { "EAN11": "10400000006311", "MATNR": "000000000000200080" }, { "EAN11": "10400000000371", "MATNR": "000000000000120617" }, { "EAN11": "10400000002597", "MATNR": "000000000000120633" }, { "EAN11": "10400000002603", "MATNR": "000000000000120634" }, { "EAN11": "10400000002610", "MATNR": "000000000000120635" }, { "EAN11": "10400000002627", "MATNR": "000000000000120636" }, { "EAN11": "10400000002634", "MATNR": "000000000000120637" }, { "EAN11": "10400000002641", "MATNR": "000000000000120638" }, { "EAN11": "10400000002658", "MATNR": "000000000000120639" }, { "EAN11": "10400000002665", "MATNR": "000000000000120640" }, { "EAN11": "10400000002672", "MATNR": "000000000000120642" }, { "EAN11": "10400000002689", "MATNR": "000000000000120643" }, { "EAN11": "10400000002696", "MATNR": "000000000000120644" }, { "EAN11": "10400000002702", "MATNR": "000000000000120645" }, { "EAN11": "10400000001118", "MATNR": "000000000000110224" }, { "EAN11": "10400000004485", "MATNR": "000000000000110263" }, { "EAN11": "2319373982102", "MATNR": "000000000000140502" }, { "EAN11": "2319373982089", "MATNR": "000000000000140503" }, { "EAN11": "2319373982096", "MATNR": "000000000000140504" }, { "EAN11": "2319373982119", "MATNR": "000000000000140505" }, { "EAN11": "2319373976521", "MATNR": "000000000000140506" }, { "EAN11": "2319373976538", "MATNR": "000000000000140507" }, { "EAN11": "10400000005680", "MATNR": "000000000000120535" }, { "EAN11": "10400000002788", "MATNR": "000000000000120733" }, { "EAN11": "10400000002795", "MATNR": "000000000000120734" }, { "EAN11": "10400000002801", "MATNR": "000000000000120735" }, { "EAN11": "10400000002818", "MATNR": "000000000000120742" }, { "EAN11": "10400000002573", "MATNR": "000000000000120582" }, { "EAN11": "20787003001442", "MATNR": "000000000000140475" }, { "EAN11": "20787003001466", "MATNR": "000000000000140476" }, { "EAN11": "20787003001473", "MATNR": "000000000000140477" }, { "EAN11": "10787003600648", "MATNR": "000000000000140478" }, { "EAN11": "10787003000790", "MATNR": "000000000000140479" }, { "EAN11": "10787003001025", "MATNR": "000000000000140480" }, { "EAN11": "10787003001087", "MATNR": "000000000000140481" }, { "EAN11": "10787003001162", "MATNR": "000000000000140482" }, { "EAN11": "10787003600495", "MATNR": "000000000000140483" }, { "EAN11": "20787003016071", "MATNR": "000000000000140484" }, { "EAN11": "787003002698", "MATNR": "000000000000140485" }, { "EAN11": "2319373976644", "MATNR": "000000000000140508" }, { "EAN11": "787003002681", "MATNR": "000000000000140522" }, { "EAN11": "10400000001101", "MATNR": "000000000000110187" }, { "EAN11": "10400000000555", "MATNR": "000000000000120700" }, { "EAN11": "10400000006328", "MATNR": "000000000000200083" }, { "EAN11": "10400000002023", "MATNR": "000000000000120701" }, { "EAN11": "10400000000388", "MATNR": "000000000000120706" }, { "EAN11": "10400000002771", "MATNR": "000000000000120707" }, { "EAN11": "787003002636", "MATNR": "000000000000140472" }, { "EAN11": "787003002643", "MATNR": "000000000000140473" }, { "EAN11": "787003002612", "MATNR": "000000000000140474" }, { "EAN11": "10400000002344", "MATNR": "000000000000110214" }, { "EAN11": "10400000004089", "MATNR": "000000000000120608" }, { "EAN11": "10400000004140", "MATNR": "000000000000120695" }, { "EAN11": "787003002841", "MATNR": "000000000000140536" }, { "EAN11": "10400000004072", "MATNR": "000000000000120526" }, { "EAN11": "787003002506", "MATNR": "000000000000140532" }, { "EAN11": "10400000004027", "MATNR": "000000000000110199" }, { "EAN11": "10400000004393", "MATNR": "000000000000110200" }, { "EAN11": "787003002544", "MATNR": "000000000000140465" }, { "EAN11": "10400000000517", "MATNR": "000000000000120686" }, { "EAN11": "10400000000524", "MATNR": "000000000000120687" }, { "EAN11": "10400000003327", "MATNR": "000000000000120672" }, { "EAN11": "10400000003334", "MATNR": "000000000000120673" }, { "EAN11": "10400000001736", "MATNR": "000000000000110234" }, { "EAN11": "10400000005697", "MATNR": "000000000000120676" }, { "EAN11": "10400000000531", "MATNR": "000000000000120689" }, { "EAN11": "787003002827", "MATNR": "000000000000140533" }, { "EAN11": "10400000002863", "MATNR": "000000000000120824" }, { "EAN11": "10400000002870", "MATNR": "000000000000120825" }, { "EAN11": "10400000002887", "MATNR": "000000000000120826" }, { "EAN11": "787003002919", "MATNR": "000000000000140612" }, { "EAN11": "10400000001132", "MATNR": "000000000000110333" }, { "EAN11": "10400000000111", "MATNR": "000000000000120922" }, { "EAN11": "10400000005734", "MATNR": "000000000000120923" }, { "EAN11": "10400000001453", "MATNR": "000000000000110363" }, { "EAN11": "10400000000661", "MATNR": "000000000000120952" }, { "EAN11": "10400000000678", "MATNR": "000000000000120953" }, { "EAN11": "10400000000395", "MATNR": "000000000000120954" }, { "EAN11": "10400000000128", "MATNR": "000000000000120955" }, { "EAN11": "2319374226076", "MATNR": "000000000000140632" }, { "EAN11": "10400000003426", "MATNR": "000000000000120872" }, { "EAN11": "10400000004171", "MATNR": "000000000000120873" }, { "EAN11": "10400000001149", "MATNR": "000000000000110369" }, { "EAN11": "10400000000685", "MATNR": "000000000000120958" }, { "EAN11": "10400000000692", "MATNR": "000000000000120959" }, { "EAN11": "10400000000708", "MATNR": "000000000000120960" }, { "EAN11": "10400000000715", "MATNR": "000000000000120961" }, { "EAN11": "10400000001248", "MATNR": "000000000000110366" }, { "EAN11": "10400000001255", "MATNR": "000000000000110367" }, { "EAN11": "10400000002368", "MATNR": "000000000000110375" }, { "EAN11": "10400000002375", "MATNR": "000000000000110376" }, { "EAN11": "10400000002382", "MATNR": "000000000000110377" }, { "EAN11": "787003003305", "MATNR": "000000000000140692" }, { "EAN11": "10400000004317", "MATNR": "000000000000110393" }, { "EAN11": "10400000004249", "MATNR": "000000000000120992" }, { "EAN11": "10400000000234", "MATNR": "000000000000120887" }, { "EAN11": "10400000004119", "MATNR": "000000000000121003" }, { "EAN11": "10400000003839", "MATNR": "000000000000121004" }, { "EAN11": "10400000000630", "MATNR": "000000000000120893" }, { "EAN11": "10400000003785", "MATNR": "000000000000120982" }, { "EAN11": "10400000003792", "MATNR": "000000000000120983" }, { "EAN11": "10400000003808", "MATNR": "000000000000120984" }, { "EAN11": "10400000003815", "MATNR": "000000000000120985" }, { "EAN11": "10400000003822", "MATNR": "000000000000120986" }, { "EAN11": "10400000002924", "MATNR": "000000000000120996" }, { "EAN11": "10400000002931", "MATNR": "000000000000120997" }, { "EAN11": "10400000002894", "MATNR": "000000000000120993" }, { "EAN11": "10400000002900", "MATNR": "000000000000120994" }, { "EAN11": "10400000002917", "MATNR": "000000000000120995" }, { "EAN11": "10400000002399", "MATNR": "000000000000110394" }, { "EAN11": "10400000002405", "MATNR": "000000000000110395" }, { "EAN11": "10400000002412", "MATNR": "000000000000110396" }, { "EAN11": "10400000002429", "MATNR": "000000000000110397" }, { "EAN11": "10400000000258", "MATNR": "000000000000121001" }, { "EAN11": "10400000002948", "MATNR": "000000000000120998" }, { "EAN11": "10400000000746", "MATNR": "000000000000120999" }, { "EAN11": "10400000000753", "MATNR": "000000000000121002" }, { "EAN11": "787003003343", "MATNR": "000000000000140712" }, { "EAN11": "10400000002832", "MATNR": "000000000000120792" }, { "EAN11": "10400000002849", "MATNR": "000000000000120794" }, { "EAN11": "10400000002030", "MATNR": "000000000000120842" }, { "EAN11": "10400000001231", "MATNR": "000000000000110303" }, { "EAN11": "10400000005444", "MATNR": "000000000000240071" }, { "EAN11": "10400000003419", "MATNR": "000000000000120863" }, { "EAN11": "10400000000647", "MATNR": "000000000000120912" }, { "EAN11": "10400000000654", "MATNR": "000000000000120913" }, { "EAN11": "10400000001125", "MATNR": "000000000000110305" }, { "EAN11": "10400000001859", "MATNR": "000000000000110306" }, { "EAN11": "787003003008", "MATNR": "000000000000140603" }, { "EAN11": "787003003152", "MATNR": "000000000000140663" }, { "EAN11": "787003003299", "MATNR": "000000000000140675" }, { "EAN11": "10400000006144", "MATNR": "000000000000120915" }, { "EAN11": "10400000002078", "MATNR": "000000000000120916" }, { "EAN11": "10400000002085", "MATNR": "000000000000120917" }, { "EAN11": "10400000000180", "MATNR": "000000000000120806" }, { "EAN11": "10400000000081", "MATNR": "000000000000120814" }, { "EAN11": "10400000000098", "MATNR": "000000000000120816" }, { "EAN11": "10400000000197", "MATNR": "000000000000120818" }, { "EAN11": "10400000005703", "MATNR": "000000000000120819" }, { "EAN11": "10400000005710", "MATNR": "000000000000120821" }, { "EAN11": "10400000005727", "MATNR": "000000000000120822" }, { "EAN11": "10400000002856", "MATNR": "000000000000120823" }, { "EAN11": "10400000001613", "MATNR": "000000000000110364" }, { "EAN11": "10400000001620", "MATNR": "000000000000110365" }, { "EAN11": "10400000000135", "MATNR": "000000000000120962" }, { "EAN11": "10400000004034", "MATNR": "000000000000110357" }, { "EAN11": "10400000003747", "MATNR": "000000000000120934" }, { "EAN11": "10400000003754", "MATNR": "000000000000120935" }, { "EAN11": "10400000003761", "MATNR": "000000000000120936" }, { "EAN11": "10400000003778", "MATNR": "000000000000120937" }, { "EAN11": "10400000000401", "MATNR": "000000000000121076" }, { "EAN11": "10400000003211", "MATNR": "000000000000121077" }, { "EAN11": "10400000003235", "MATNR": "000000000000121079" }, { "EAN11": "10400000003242", "MATNR": "000000000000121080" }, { "EAN11": "10400000003259", "MATNR": "000000000000121081" }, { "EAN11": "10400000003020", "MATNR": "000000000000121044" }, { "EAN11": "10400000000265", "MATNR": "000000000000121029" }, { "EAN11": "10400000003037", "MATNR": "000000000000121045" }, { "EAN11": "10400000003044", "MATNR": "000000000000121046" }, { "EAN11": "10400000003051", "MATNR": "000000000000121047" }, { "EAN11": "10400000003068", "MATNR": "000000000000121048" }, { "EAN11": "10400000003075", "MATNR": "000000000000121049" }, { "EAN11": "10400000003082", "MATNR": "000000000000121050" }, { "EAN11": "10400000003099", "MATNR": "000000000000121051" }, { "EAN11": "10400000003105", "MATNR": "000000000000121052" }, { "EAN11": "10400000003112", "MATNR": "000000000000121054" }, { "EAN11": "10400000003129", "MATNR": "000000000000121055" }, { "EAN11": "10400000004508", "MATNR": "000000000000110416" }, { "EAN11": "10400000000296", "MATNR": "000000000000121095" }, { "EAN11": "10400000000302", "MATNR": "000000000000121096" }, { "EAN11": "10400000005604", "MATNR": "000000000000130168" }, { "EAN11": "10400000005611", "MATNR": "000000000000130171" }, { "EAN11": "10400000006649", "MATNR": "000000000000110419" }, { "EAN11": "10400000000272", "MATNR": "000000000000121064" }, { "EAN11": "10400000000289", "MATNR": "000000000000121065" }, { "EAN11": "10400000003198", "MATNR": "000000000000121074" }, { "EAN11": "10400000003204", "MATNR": "000000000000121075" }, { "EAN11": "10400000003228", "MATNR": "000000000000121078" }, { "EAN11": "10400000004195", "MATNR": "000000000000110353" }, { "EAN11": "10400000004201", "MATNR": "000000000000110354" }, { "EAN11": "10400000004218", "MATNR": "000000000000110355" }, { "EAN11": "10400000004225", "MATNR": "000000000000110356" }, { "EAN11": "10400000001965", "MATNR": "000000000000120932" }, { "EAN11": "10400000000241", "MATNR": "000000000000120933" }, { "EAN11": "10400000001163", "MATNR": "000000000000110443" }, { "EAN11": "10400000001606", "MATNR": "000000000000121092" }, { "EAN11": "10400000005932", "MATNR": "000000000000110453" }, { "EAN11": "787003003916", "MATNR": "000000000000140752" }, { "EAN11": "10400000005628", "MATNR": "000000000000130176" }, { "EAN11": "10400000005666", "MATNR": "000000000000150110" }, { "EAN11": "10400000003266", "MATNR": "000000000000121082" }, { "EAN11": "10400000003273", "MATNR": "000000000000121083" }, { "EAN11": "10400000003358", "MATNR": "000000000000121084" }, { "EAN11": "10400000003365", "MATNR": "000000000000121085" }, { "EAN11": "10400000003372", "MATNR": "000000000000121086" }, { "EAN11": "10400000003389", "MATNR": "000000000000121087" }, { "EAN11": "10400000003396", "MATNR": "000000000000121088" }, { "EAN11": "10400000000470", "MATNR": "000000000000121089" }, { "EAN11": "10400000004263", "MATNR": "000000000000121093" }, { "EAN11": "10400000004270", "MATNR": "000000000000121094" }, { "EAN11": "10400000000876", "MATNR": "000000000000121098" }, { "EAN11": "10400000000883", "MATNR": "000000000000121099" }, { "EAN11": "787003003107", "MATNR": "000000000000140652" }, { "EAN11": "10400000002054", "MATNR": "000000000000120903" }, { "EAN11": "10400000001873", "MATNR": "000000000000120904" }, { "EAN11": "10400000001880", "MATNR": "000000000000120905" }, { "EAN11": "10400000002061", "MATNR": "000000000000120906" }, { "EAN11": "10400000001811", "MATNR": "000000000000110383" }, { "EAN11": "787003003244", "MATNR": "000000000000140702" }, { "EAN11": "787003003251", "MATNR": "000000000000140704" }, { "EAN11": "10400000000807", "MATNR": "000000000000121018" }, { "EAN11": "10400000000814", "MATNR": "000000000000121019" }, { "EAN11": "10400000000821", "MATNR": "000000000000121020" }, { "EAN11": "10400000000838", "MATNR": "000000000000121021" }, { "EAN11": "787003003367", "MATNR": "000000000000140715" }, { "EAN11": "10400000003341", "MATNR": "000000000000120832" }, { "EAN11": "10400000001064", "MATNR": "000000000000120892" }, { "EAN11": "787003003374", "MATNR": "000000000000140716" }, { "EAN11": "787003003381", "MATNR": "000000000000140717" }, { "EAN11": "787003003398", "MATNR": "000000000000140718" }, { "EAN11": "787003003404", "MATNR": "000000000000140719" }, { "EAN11": "787003003411", "MATNR": "000000000000140720" }, { "EAN11": "787003003459", "MATNR": "000000000000140722" }, { "EAN11": "787003003428", "MATNR": "000000000000140723" }, { "EAN11": "10400000002986", "MATNR": "000000000000121022" }, { "EAN11": "10400000002993", "MATNR": "000000000000121023" }, { "EAN11": "10400000001545", "MATNR": "000000000000110313" }, { "EAN11": "10400000004102", "MATNR": "000000000000120957" }, { "EAN11": "787003003190", "MATNR": "000000000000140672" }, { "EAN11": "787003003213", "MATNR": "000000000000140673" }, { "EAN11": "787003003220", "MATNR": "000000000000140674" }, { "EAN11": "787003002988", "MATNR": "000000000000140592" }, { "EAN11": "10400000003006", "MATNR": "000000000000121024" }, { "EAN11": "10400000003013", "MATNR": "000000000000121025" }, { "EAN11": "10400000000142", "MATNR": "000000000000121032" }, { "EAN11": "10400000002436", "MATNR": "000000000000110403" }, { "EAN11": "10400000001897", "MATNR": "000000000000121033" }, { "EAN11": "10400000001903", "MATNR": "000000000000121034" }, { "EAN11": "787003003312", "MATNR": "000000000000140732" }, { "EAN11": "787003003466", "MATNR": "000000000000140733" }, { "EAN11": "787003003015", "MATNR": "000000000000140622" }, { "EAN11": "787003003022", "MATNR": "000000000000140623" }, { "EAN11": "10400000001156", "MATNR": "000000000000110370" }, { "EAN11": "10400000001743", "MATNR": "000000000000110413" }, { "EAN11": "787003003336", "MATNR": "000000000000140742" }, { "EAN11": "787003003350", "MATNR": "000000000000140743" }, { "EAN11": "10400000003136", "MATNR": "000000000000121056" }, { "EAN11": "10400000003143", "MATNR": "000000000000121057" }, { "EAN11": "10400000003150", "MATNR": "000000000000121058" }, { "EAN11": "10400000003167", "MATNR": "000000000000121059" }, { "EAN11": "10400000003174", "MATNR": "000000000000121060" }, { "EAN11": "10400000003181", "MATNR": "000000000000121061" }, { "EAN11": "10400000005925", "MATNR": "000000000000110293" }, { "EAN11": "10400000005550", "MATNR": "000000000000240060" }, { "EAN11": "10400000003693", "MATNR": "000000000000120833" }, { "EAN11": "10400000003709", "MATNR": "000000000000120834" }, { "EAN11": "10400000003716", "MATNR": "000000000000120835" }, { "EAN11": "10400000003723", "MATNR": "000000000000120836" }, { "EAN11": "10400000003730", "MATNR": "000000000000120837" }, { "EAN11": "10400000005840", "MATNR": "000000000000120838" }, { "EAN11": "10400000000104", "MATNR": "000000000000120840" }, { "EAN11": "10400000001552", "MATNR": "000000000000110373" }, { "EAN11": "10400000001262", "MATNR": "000000000000110374" }, { "EAN11": "10400000001279", "MATNR": "000000000000110378" }, { "EAN11": "10400000004188", "MATNR": "000000000000110343" }, { "EAN11": "10400000005857", "MATNR": "000000000000110344" }, { "EAN11": "10400000005864", "MATNR": "000000000000110345" }, { "EAN11": "787003003053", "MATNR": "000000000000140642" }, { "EAN11": "10400000004232", "MATNR": "000000000000110358" }, { "EAN11": "787003003060", "MATNR": "000000000000140662" }, { "EAN11": "10400000002092", "MATNR": "000000000000120942" }, { "EAN11": "10400000002108", "MATNR": "000000000000120943" }, { "EAN11": "787003003121", "MATNR": "000000000000140664" }, { "EAN11": "787003003114", "MATNR": "000000000000140665" }, { "EAN11": "10400000001866", "MATNR": "000000000000120883" }, { "EAN11": "787003003145", "MATNR": "000000000000140666" }, { "EAN11": "787003003176", "MATNR": "000000000000140667" }, { "EAN11": "787003003169", "MATNR": "000000000000140668" }, { "EAN11": "10400000000869", "MATNR": "000000000000121072" }, { "EAN11": "10400000004096", "MATNR": "000000000000120940" }, { "EAN11": "10400000000722", "MATNR": "000000000000120972" }, { "EAN11": "10400000000739", "MATNR": "000000000000120973" }, { "EAN11": "787003003435", "MATNR": "000000000000140714" }, { "EAN11": "10400000002955", "MATNR": "000000000000121005" }, { "EAN11": "10400000002962", "MATNR": "000000000000121007" }, { "EAN11": "10400000002979", "MATNR": "000000000000121012" }, { "EAN11": "10400000000760", "MATNR": "000000000000121014" }, { "EAN11": "10400000000777", "MATNR": "000000000000121015" }, { "EAN11": "787003002995", "MATNR": "000000000000140602" }, { "EAN11": "10400000003662", "MATNR": "000000000000120807" }, { "EAN11": "10400000003679", "MATNR": "000000000000120808" }, { "EAN11": "10400000003686", "MATNR": "000000000000120809" }, { "EAN11": "10400000000012", "MATNR": "000000000000120810" }, { "EAN11": "10400000000029", "MATNR": "000000000000120811" }, { "EAN11": "10400000000036", "MATNR": "000000000000120812" }, { "EAN11": "10400000000043", "MATNR": "000000000000120813" }, { "EAN11": "10400000003860", "MATNR": "000000000000121035" }, { "EAN11": "10400000003877", "MATNR": "000000000000121036" }, { "EAN11": "10400000003884", "MATNR": "000000000000121037" }, { "EAN11": "10400000003891", "MATNR": "000000000000121038" }, { "EAN11": "10400000002443", "MATNR": "000000000000110404" }, { "EAN11": "10400000002450", "MATNR": "000000000000110405" }, { "EAN11": "10400000000784", "MATNR": "000000000000121016" }, { "EAN11": "10400000000791", "MATNR": "000000000000121017" }, { "EAN11": "10400000003846", "MATNR": "000000000000121026" }, { "EAN11": "10400000003853", "MATNR": "000000000000121027" }, { "EAN11": "10400000003907", "MATNR": "000000000000121073" }, { "EAN11": "10400000000845", "MATNR": "000000000000121042" }, { "EAN11": "10400000000852", "MATNR": "000000000000121043" }, { "EAN11": "10400000000203", "MATNR": "000000000000120884" }, { "EAN11": "10400000000210", "MATNR": "000000000000120885" }, { "EAN11": "10400000000227", "MATNR": "000000000000120886" }, { "EAN11": "10400000004928", "MATNR": "000000000000121195" }, { "EAN11": "10400000004935", "MATNR": "000000000000121196" }, { "EAN11": "10400000004942", "MATNR": "000000000000121198" }, { "EAN11": "10400000004959", "MATNR": "000000000000121200" }, { "EAN11": "10400000004522", "MATNR": "000000000000110483" }, { "EAN11": "10400000004966", "MATNR": "000000000000121202" }, { "EAN11": "10400000004539", "MATNR": "000000000000110484" }, { "EAN11": "10400000004973", "MATNR": "000000000000121203" }, { "EAN11": "10400000004546", "MATNR": "000000000000110485" }, { "EAN11": "10400000004980", "MATNR": "000000000000121204" }, { "EAN11": "10400000004553", "MATNR": "000000000000110486" }, { "EAN11": "10400000004560", "MATNR": "000000000000110487" }, { "EAN11": "787003003800", "MATNR": "000000000000140772" }, { "EAN11": "10400000006731", "MATNR": "000000000000121305" }, { "EAN11": "787003004142", "MATNR": "000000000000140834" }, { "EAN11": "10400000004997", "MATNR": "000000000000121207" }, { "EAN11": "10400000005000", "MATNR": "000000000000121208" }, { "EAN11": "10400000005567", "MATNR": "000000000000240100" }, { "EAN11": "10400000005574", "MATNR": "000000000000240101" }, { "EAN11": "10400000005581", "MATNR": "000000000000240102" }, { "EAN11": "10400000004591", "MATNR": "000000000000110493" }, { "EAN11": "10400000004607", "MATNR": "000000000000110495" }, { "EAN11": "787003003961", "MATNR": "000000000000140822" }, { "EAN11": "10400000004577", "MATNR": "000000000000110490" }, { "EAN11": "10400000005147", "MATNR": "000000000000121223" }, { "EAN11": "10400000005253", "MATNR": "000000000000121247" }, { "EAN11": "10400000004621", "MATNR": "000000000000110497" }, { "EAN11": "10400000005260", "MATNR": "000000000000121248" }, { "EAN11": "10400000005277", "MATNR": "000000000000121249" }, { "EAN11": "10400000005284", "MATNR": "000000000000121250" }, { "EAN11": "10400000006700", "MATNR": "000000000000121257" }, { "EAN11": "10400000006717", "MATNR": "000000000000121261" }, { "EAN11": "10400000006656", "MATNR": "000000000000240106" }, { "EAN11": "10400000006724", "MATNR": "000000000000121262" }, { "EAN11": "10400000005154", "MATNR": "000000000000121232" }, { "EAN11": "10400000005789", "MATNR": "000000000000121236" }, { "EAN11": "10400000006663", "MATNR": "000000000000240107" }, { "EAN11": "10400000006670", "MATNR": "000000000000240109" }, { "EAN11": "10400000006694", "MATNR": "000000000000240111" }, { "EAN11": "10400000006281", "MATNR": "000000000000121267" }, { "EAN11": "10400000001293", "MATNR": "000000000000110473" }, { "EAN11": "10400000004515", "MATNR": "000000000000110474" }, { "EAN11": "10400000004065", "MATNR": "000000000000110476" }, { "EAN11": "10400000006168", "MATNR": "000000000000121146" }, { "EAN11": "10400000006175", "MATNR": "000000000000121147" }, { "EAN11": "10400000006380", "MATNR": "000000000000121281" }, { "EAN11": "10400000006700", "MATNR": "000000000000240120" }, { "EAN11": "787003003787", "MATNR": "000000000000140823" }, { "EAN11": "10400000006496", "MATNR": "000000000000121296" }, { "EAN11": "10400000007677", "MATNR": "000000000000240121" }, { "EAN11": "10400000004614", "MATNR": "000000000000110496" }, { "EAN11": "10400000005222", "MATNR": "000000000000121244" }, { "EAN11": "10400000005239", "MATNR": "000000000000121245" }, { "EAN11": "10400000005246", "MATNR": "000000000000121246" }, { "EAN11": "10400000006717", "MATNR": "000000000000240127" }, { "EAN11": "10400000006748", "MATNR": "000000000000121309" }, { "EAN11": "10400000002115", "MATNR": "000000000000121104" }, { "EAN11": "10400000004287", "MATNR": "000000000000121108" }, { "EAN11": "10400000003433", "MATNR": "000000000000121109" }, { "EAN11": "10400000001705", "MATNR": "000000000000121110" }, { "EAN11": "10400000001712", "MATNR": "000000000000121129" }, { "EAN11": "787003004029", "MATNR": "000000000000140836" }, { "EAN11": "10400000001729", "MATNR": "000000000000121130" }, { "EAN11": "10400000004423", "MATNR": "000000000000110465" }, { "EAN11": "10400000000487", "MATNR": "000000000000121153" }, { "EAN11": "10400000004638", "MATNR": "000000000000121154" }, { "EAN11": "10400000004645", "MATNR": "000000000000121155" }, { "EAN11": "10400000004652", "MATNR": "000000000000121156" }, { "EAN11": "10400000004669", "MATNR": "000000000000121157" }, { "EAN11": "787003003664", "MATNR": "000000000000140784" }, { "EAN11": "10400000004911", "MATNR": "000000000000121193" }, { "EAN11": "787003003749", "MATNR": "000000000000140785" }, { "EAN11": "787003003923", "MATNR": "000000000000140794" }, { "EAN11": "10400000005741", "MATNR": "000000000000121148" }, { "EAN11": "10400000005758", "MATNR": "000000000000121149" }, { "EAN11": "10400000001651", "MATNR": "000000000000121100" }, { "EAN11": "10400000001668", "MATNR": "000000000000121101" }, { "EAN11": "10400000004676", "MATNR": "000000000000121158" }, { "EAN11": "10400000004683", "MATNR": "000000000000121159" }, { "EAN11": "10400000004690", "MATNR": "000000000000121160" }, { "EAN11": "10400000004706", "MATNR": "000000000000121161" }, { "EAN11": "10400000004713", "MATNR": "000000000000121162" }, { "EAN11": "10400000004720", "MATNR": "000000000000121163" }, { "EAN11": "10400000004737", "MATNR": "000000000000121164" }, { "EAN11": "10400000004744", "MATNR": "000000000000121165" }, { "EAN11": "10400000004751", "MATNR": "000000000000121166" }, { "EAN11": "10400000004768", "MATNR": "000000000000121167" }, { "EAN11": "10400000004775", "MATNR": "000000000000121168" }, { "EAN11": "10400000004782", "MATNR": "000000000000121169" }, { "EAN11": "10400000005017", "MATNR": "000000000000121210" }, { "EAN11": "10400000005024", "MATNR": "000000000000121211" }, { "EAN11": "10400000004799", "MATNR": "000000000000121170" }, { "EAN11": "10400000004805", "MATNR": "000000000000121171" }, { "EAN11": "10400000004812", "MATNR": "000000000000121172" }, { "EAN11": "10400000004829", "MATNR": "000000000000121173" }, { "EAN11": "10400000004836", "MATNR": "000000000000121174" }, { "EAN11": "10400000004843", "MATNR": "000000000000121176" }, { "EAN11": "10400000004850", "MATNR": "000000000000121177" }, { "EAN11": "10400000004867", "MATNR": "000000000000121178" }, { "EAN11": "10400000004874", "MATNR": "000000000000121179" }, { "EAN11": "10400000004881", "MATNR": "000000000000121180" }, { "EAN11": "10400000004898", "MATNR": "000000000000121181" }, { "EAN11": "10400000004904", "MATNR": "000000000000121182" }, { "EAN11": "10400000005031", "MATNR": "000000000000121212" }, { "EAN11": "10400000005048", "MATNR": "000000000000121213" }, { "EAN11": "10400000005055", "MATNR": "000000000000121214" }, { "EAN11": "10400000005062", "MATNR": "000000000000121215" }, { "EAN11": "10400000005079", "MATNR": "000000000000121216" }, { "EAN11": "10400000005086", "MATNR": "000000000000121217" }, { "EAN11": "10400000005093", "MATNR": "000000000000121218" }, { "EAN11": "10400000005109", "MATNR": "000000000000121219" }, { "EAN11": "10400000005116", "MATNR": "000000000000121220" }, { "EAN11": "10400000005123", "MATNR": "000000000000121221" }, { "EAN11": "787003003862", "MATNR": "000000000000140804" }, { "EAN11": "10400000004584", "MATNR": "000000000000110492" }, { "EAN11": "10400000005130", "MATNR": "000000000000121222" }, { "EAN11": "10400000005765", "MATNR": "000000000000121234" }, { "EAN11": "10400000005772", "MATNR": "000000000000121235" }, { "EAN11": "10400000006755", "MATNR": "000000000000121310" }, { "EAN11": "10400000006724", "MATNR": "000000000000240134" }, { "EAN11": "787003003985", "MATNR": "000000000000140835" }, { "EAN11": "787003004098", "MATNR": "000000000000140837" }, { "EAN11": "787003003992", "MATNR": "000000000000140838" }, { "EAN11": "787003004081", "MATNR": "000000000000140839" }, { "EAN11": "10400000006502", "MATNR": "000000000000121302" }, { "EAN11": "787003003763", "MATNR": "000000000000140803" }, { "EAN11": "10400000005161", "MATNR": "000000000000121237" }, { "EAN11": "10400000005178", "MATNR": "000000000000121239" }, { "EAN11": "10400000005185", "MATNR": "000000000000121240" }, { "EAN11": "10400000005192", "MATNR": "000000000000121241" }, { "EAN11": "10400000005208", "MATNR": "000000000000121242" }, { "EAN11": "10400000005215", "MATNR": "000000000000121243" }, { "EAN11": "10400000001675", "MATNR": "000000000000121102" }, { "EAN11": "10400000006151", "MATNR": "000000000000121103" }, { "EAN11": "10400000006519", "MATNR": "000000000000121112" }, { "EAN11": "10400000006526", "MATNR": "000000000000121113" }, { "EAN11": "10400000003280", "MATNR": "000000000000121115" }, { "EAN11": "10400000003297", "MATNR": "000000000000121116" }, { "EAN11": "10400000003303", "MATNR": "000000000000121117" }, { "EAN11": "10400000003914", "MATNR": "000000000000121118" }, { "EAN11": "10400000003921", "MATNR": "000000000000121119" }, { "EAN11": "10400000003938", "MATNR": "000000000000121120" }, { "EAN11": "10400000002467", "MATNR": "000000000000110456" }, { "EAN11": "10400000005291", "MATNR": "000000000000121251" }, { "EAN11": "10400000005307", "MATNR": "000000000000121252" }, { "EAN11": "10400000005314", "MATNR": "000000000000121253" }, { "EAN11": "10400000005321", "MATNR": "000000000000121254" }, { "EAN11": "10400000001682", "MATNR": "000000000000121105" }, { "EAN11": "10400000001699", "MATNR": "000000000000121106" }, { "EAN11": "10400000002122", "MATNR": "000000000000121107" }, { "EAN11": "10400000002474", "MATNR": "000000000000110457" }, { "EAN11": "10400000002481", "MATNR": "000000000000110458" }, { "EAN11": "10400000005949", "MATNR": "000000000000110459" }, { "EAN11": "10400000004324", "MATNR": "000000000000110460" }, { "EAN11": "10400000004331", "MATNR": "000000000000110461" }, { "EAN11": "10400000004041", "MATNR": "000000000000110462" }, { "EAN11": "10400000004430", "MATNR": "000000000000110463" }, { "EAN11": "10400000004058", "MATNR": "000000000000110464" }, { "EAN11": "10400000000319", "MATNR": "000000000000121122" }, { "EAN11": "10400000000326", "MATNR": "000000000000121123" }, { "EAN11": "10400000004300", "MATNR": "000000000000121125" }, { "EAN11": "10400000006533", "MATNR": "000000000000121127" }, { "EAN11": "10400000006632", "MATNR": "000000000000240104" }, { "EAN11": "787003003657", "MATNR": "000000000000140782" }, { "EAN11": "787003003671", "MATNR": "000000000000140783" }, { "EAN11": "787003003565", "MATNR": "000000000000140786" }, { "EAN11": "787003003626", "MATNR": "000000000000140787" }, { "EAN11": "787003003541", "MATNR": "000000000000140788" }, { "EAN11": "787003003701", "MATNR": "000000000000140789" }, { "EAN11": "787003003695", "MATNR": "000000000000140790" }, { "EAN11": "787003003756", "MATNR": "000000000000140791" }, { "EAN11": "787003003930", "MATNR": "000000000000140792" }, { "EAN11": "787003003947", "MATNR": "000000000000140793" }, { "EAN11": "10400000001286", "MATNR": "000000000000110454" }, { "EAN11": "787003002858", "MATNR": "000000000000140762" }, { "EAN11": "787003002865", "MATNR": "000000000000140763" }, { "EAN11": "787003003534", "MATNR": "000000000000140764" }, { "EAN11": "787003003558", "MATNR": "000000000000140765" }, { "EAN11": "787003003824", "MATNR": "000000000000140766" }, { "EAN11": "787003003831", "MATNR": "000000000000140767" }, { "EAN11": "787003003855", "MATNR": "000000000000140768" }, { "EAN11": "10400000006649", "MATNR": "000000000000240105" }, { "EAN11": "10400000006687", "MATNR": "000000000000240110" }, { "EAN11": "10400000004294", "MATNR": "000000000000121124" }, { "EAN11": "10400000000418", "MATNR": "000000000000121128" }, { "EAN11": "787003003848", "MATNR": "000000000000140769" }, { "EAN11": "10400000006359", "MATNR": "000000000000121273" }, { "EAN11": "10400000006397", "MATNR": "000000000000121279" }, { "EAN11": "10400000006823", "MATNR": "000000000000121284" }, { "EAN11": "10400000004416", "MATNR": "000000000000121132" }, { "EAN11": "10400000006595", "MATNR": "000000000000121333" }, { "EAN11": "10400000006809", "MATNR": "000000000000121346" }, { "EAN11": "10400000006786", "MATNR": "000000000000121347" }, { "EAN11": "10400000006793", "MATNR": "000000000000121348" }, { "EAN11": "10400000006199", "MATNR": "000000000000121349" }, { "EAN11": "10400000006182", "MATNR": "000000000000121350" }, { "EAN11": "787003004241", "MATNR": "000000000000140852" }, { "EAN11": "787003004258", "MATNR": "000000000000140853" }, { "EAN11": "787003004265", "MATNR": "000000000000140854" }, { "EAN11": "787003004203", "MATNR": "000000000000140857" }, { "EAN11": "787003004227", "MATNR": "000000000000140858" }, { "EAN11": "787003004234", "MATNR": "000000000000140859" }, { "EAN11": "787003004326", "MATNR": "000000000000140860" }, { "EAN11": "10400000006601", "MATNR": "000000000000121334" }, { "EAN11": "10400000006250", "MATNR": "000000000000121335" }, { "EAN11": "10400000006243", "MATNR": "000000000000121336" }, { "EAN11": "10400000006229", "MATNR": "000000000000121340" }, { "EAN11": "10400000006588", "MATNR": "000000000000110553" }, { "EAN11": "10400000006847", "MATNR": "000000000000121408" }, { "EAN11": "10400000006915", "MATNR": "000000000000121409" }, { "EAN11": "10400000006922", "MATNR": "000000000000121411" }, { "EAN11": "10400000006939", "MATNR": "000000000000121412" }, { "EAN11": "10400000006236", "MATNR": "000000000000121413" }, { "EAN11": "10400000006205", "MATNR": "000000000000121422" }, { "EAN11": "10400000006212", "MATNR": "000000000000121423" }, { "EAN11": "10400000006366", "MATNR": "000000000000121425" }, { "EAN11": "10400000006373", "MATNR": "000000000000121426" }, { "EAN11": "10400000006816", "MATNR": "000000000000121427" }, { "EAN11": "10400000006762", "MATNR": "000000000000121428" }, { "EAN11": "10400000006632", "MATNR": "000000000000121417" }, { "EAN11": "787003004319", "MATNR": "000000000000140862" }, { "EAN11": "10400000006687", "MATNR": "000000000000121382" }, { "EAN11": "10400000006540", "MATNR": "000000000000121431" }, { "EAN11": "10400000006663", "MATNR": "000000000000121434" }, { "EAN11": "787003004333", "MATNR": "000000000000140863" }, { "EAN11": "10400000006342", "MATNR": "000000000000121402" }, { "EAN11": "10400000006571", "MATNR": "000000000000110560" }, { "EAN11": "10400000006625", "MATNR": "000000000000121436" }, { "EAN11": "10400000006618", "MATNR": "000000000000121437" }, { "EAN11": "10400000006779", "MATNR": "000000000000121441" }, { "EAN11": "10400000006564", "MATNR": "000000000000121443" }, { "EAN11": "787003004128", "MATNR": "000000000000140864" }, { "EAN11": "10400000006670", "MATNR": "000000000000121397" }, { "EAN11": "10400000006656", "MATNR": "000000000000121388" }, { "EAN11": "10400000006694", "MATNR": "000000000000121393" }, { "EAN11": "10400000006557", "MATNR": "000000000000121321" }, { "EAN11": "10400000006267", "MATNR": "000000000000121394" }, { "EAN11": "10400000006274", "MATNR": "000000000000121395" }, { "EAN11": "787003004401", "MATNR": "000000000000140892" }, { "EAN11": "787003004104", "MATNR": "000000000000140908" }, { "EAN11": "787003004791", "MATNR": "000000000000140910" }, { "EAN11": "787003004807", "MATNR": "000000000000140911" }, { "EAN11": "787003004418", "MATNR": "000000000000140916" }, { "EAN11": "787003004432", "MATNR": "000000000000140919" }, { "EAN11": "787003004449", "MATNR": "000000000000140920" }, { "EAN11": "787003004630", "MATNR": "000000000000140921" }, { "EAN11": "787003004869", "MATNR": "000000000000140923" }, { "EAN11": "10400000005505", "MATNR": "000000000000240150" }, { "EAN11": "10400000006908", "MATNR": "000000000000121457" }, { "EAN11": "10400000007196", "MATNR": "000000000000240151" }, { "EAN11": "10400000006946", "MATNR": "000000000000121462" }, { "EAN11": "787003004395", "MATNR": "000000000000140884" }, { "EAN11": "787003004371", "MATNR": "000000000000140885" }, { "EAN11": "787003004357", "MATNR": "000000000000140872" }, { "EAN11": "787003004364", "MATNR": "000000000000140873" }, { "EAN11": "787003004852", "MATNR": "000000000000140922" }, { "EAN11": "787003004586", "MATNR": "000000000000140893" }, { "EAN11": "787003004593", "MATNR": "000000000000140894" }, { "EAN11": "20787003016088", "MATNR": "000000000000140896" }, { "EAN11": "787003004517", "MATNR": "000000000000140897" }, { "EAN11": "787003004524", "MATNR": "000000000000140898" }, { "EAN11": "787003004531", "MATNR": "000000000000140899" }, { "EAN11": "787003004548", "MATNR": "000000000000140900" }, { "EAN11": "787003004555", "MATNR": "000000000000140901" }, { "EAN11": "787003004562", "MATNR": "000000000000140902" }, { "EAN11": "10400000007691", "MATNR": "000000000000121566" }, { "EAN11": "787003004470", "MATNR": "000000000000140903" }, { "EAN11": "787003004487", "MATNR": "000000000000140904" }, { "EAN11": "787003004494", "MATNR": "000000000000140905" }, { "EAN11": "787003004609", "MATNR": "000000000000140906" }, { "EAN11": "787003004616", "MATNR": "000000000000140907" }, { "EAN11": "10400000007707", "MATNR": "000000000000110612" }, { "EAN11": "10400000007684", "MATNR": "000000000000121575" }, { "EAN11": "10787003180010", "MATNR": "000000000000140912" }, { "EAN11": "10787003180027", "MATNR": "000000000000140913" }, { "EAN11": "10787003000707", "MATNR": "000000000000140915" }, { "EAN11": "787003004425", "MATNR": "000000000000140917" }, { "EAN11": "787003004623", "MATNR": "000000000000140918" }, { "EAN11": "10787003016081", "MATNR": "000000000000140886" }, { "EAN11": "10400000007073", "MATNR": "000000000000240163" }, { "EAN11": "10400000007097", "MATNR": "000000000000240165" }, { "EAN11": "10787003115029", "MATNR": "000000000000140887" }, { "EAN11": "10787003016074", "MATNR": "000000000000140888" }, { "EAN11": "10787003016067", "MATNR": "000000000000140889" }, { "EAN11": "10787003000066", "MATNR": "000000000000140890" }, { "EAN11": "10787003016098", "MATNR": "000000000000140891" }, { "EAN11": "10400000006885", "MATNR": "000000000000110569" }, { "EAN11": "787003004388", "MATNR": "000000000000140882" } ]';
        //
    }

    function getMunicipios()
    {
        echo '[{
            "id": "2",
            "codigo": "01",
            "valor": "AHUACHAPÁN ",
            "cod_departamento": "01"
        },
        {
            "id": "3",
            "codigo": "02",
            "valor": "APANECA ",
            "cod_departamento": "01"
        },
        {
            "id": "4",
            "codigo": "03",
            "valor": "ATIQUIZAYA ",
            "cod_departamento": "01"
        },
        {
            "id": "5",
            "codigo": "04",
            "valor": "CONCEPCIÓN DE ATACO ",
            "cod_departamento": "01"
        },
        {
            "id": "6",
            "codigo": "05",
            "valor": "EL REFUGIO ",
            "cod_departamento": "01"
        },
        {
            "id": "7",
            "codigo": "06",
            "valor": "GUAYMANGO ",
            "cod_departamento": "01"
        },
        {
            "id": "8",
            "codigo": "07",
            "valor": "JUJUTLA ",
            "cod_departamento": "01"
        },
        {
            "id": "9",
            "codigo": "08",
            "valor": "SAN FRANCISCO MENÉNDEZ ",
            "cod_departamento": "01"
        },
        {
            "id": "10",
            "codigo": "09",
            "valor": "SAN LORENZO ",
            "cod_departamento": "01"
        },
        {
            "id": "11",
            "codigo": "10",
            "valor": "SAN PEDRO PUXTLA ",
            "cod_departamento": "01"
        },
        {
            "id": "12",
            "codigo": "11",
            "valor": "TACUBA ",
            "cod_departamento": "01"
        },
        {
            "id": "13",
            "codigo": "12",
            "valor": "TURÍN ",
            "cod_departamento": "01"
        },
        {
            "id": "14",
            "codigo": "01",
            "valor": "CANDELARIA DE LA FRONTERA ",
            "cod_departamento": "02"
        },
        {
            "id": "15",
            "codigo": "02",
            "valor": "COATEPEQUE ",
            "cod_departamento": "02"
        },
        {
            "id": "16",
            "codigo": "03",
            "valor": "CHALCHUAPA ",
            "cod_departamento": "02"
        },
        {
            "id": "17",
            "codigo": "04",
            "valor": "EL CONGO ",
            "cod_departamento": "02"
        },
        {
            "id": "18",
            "codigo": "05",
            "valor": "EL PORVENIR ",
            "cod_departamento": "02"
        },
        {
            "id": "19",
            "codigo": "06",
            "valor": "MASAHUAT ",
            "cod_departamento": "02"
        },
        {
            "id": "20",
            "codigo": "07",
            "valor": "METAPÁN ",
            "cod_departamento": "02"
        },
        {
            "id": "21",
            "codigo": "08",
            "valor": "SAN ANTONIO PAJONAL ",
            "cod_departamento": "02"
        },
        {
            "id": "22",
            "codigo": "09",
            "valor": "SAN SEBASTIÁN SALITRILLO ",
            "cod_departamento": "02"
        },
        {
            "id": "23",
            "codigo": "10",
            "valor": "SANTA ANA ",
            "cod_departamento": "02"
        },
        {
            "id": "24",
            "codigo": "11",
            "valor": "STA ROSA GUACHI ",
            "cod_departamento": "02"
        },
        {
            "id": "25",
            "codigo": "12",
            "valor": "STGO D LA FRONT ",
            "cod_departamento": "02"
        },
        {
            "id": "26",
            "codigo": "13",
            "valor": "TEXISTEPEQUE ",
            "cod_departamento": "02"
        },
        {
            "id": "27",
            "codigo": "01",
            "valor": "ACAJUTLA ",
            "cod_departamento": "03"
        },
        {
            "id": "28",
            "codigo": "02",
            "valor": "ARMENIA ",
            "cod_departamento": "03"
        },
        {
            "id": "29",
            "codigo": "03",
            "valor": "CALUCO ",
            "cod_departamento": "03"
        },
        {
            "id": "30",
            "codigo": "04",
            "valor": "CUISNAHUAT ",
            "cod_departamento": "03"
        },
        {
            "id": "31",
            "codigo": "05",
            "valor": "STA I ISHUATAN ",
            "cod_departamento": "03"
        },
        {
            "id": "32",
            "codigo": "06",
            "valor": "IZALCO ",
            "cod_departamento": "03"
        },
        {
            "id": "33",
            "codigo": "07",
            "valor": "JUAYÚA ",
            "cod_departamento": "03"
        },
        {
            "id": "34",
            "codigo": "08",
            "valor": "NAHUIZALCO ",
            "cod_departamento": "03"
        },
        {
            "id": "35",
            "codigo": "09",
            "valor": "NAHULINGO ",
            "cod_departamento": "03"
        },
        {
            "id": "36",
            "codigo": "10",
            "valor": "SALCOATITÁN ",
            "cod_departamento": "03"
        },
        {
            "id": "37",
            "codigo": "11",
            "valor": "SAN ANTONIO DEL MONTE ",
            "cod_departamento": "03"
        },
        {
            "id": "38",
            "codigo": "12",
            "valor": "SAN JULIÁN ",
            "cod_departamento": "03"
        },
        {
            "id": "39",
            "codigo": "13",
            "valor": "STA C MASAHUAT ",
            "cod_departamento": "03"
        },
        {
            "id": "40",
            "codigo": "14",
            "valor": "SANTO DOMINGO GUZMÁN ",
            "cod_departamento": "03"
        },
        {
            "id": "41",
            "codigo": "15",
            "valor": "SONSONATE ",
            "cod_departamento": "03"
        },
        {
            "id": "42",
            "codigo": "16",
            "valor": "SONZACATE ",
            "cod_departamento": "03"
        },
        {
            "id": "43",
            "codigo": "01",
            "valor": "AGUA CALIENTE ",
            "cod_departamento": "04"
        },
        {
            "id": "44",
            "codigo": "02",
            "valor": "ARCATAO ",
            "cod_departamento": "04"
        },
        {
            "id": "45",
            "codigo": "03",
            "valor": "AZACUALPA ",
            "cod_departamento": "04"
        },
        {
            "id": "46",
            "codigo": "04",
            "valor": "CITALÁ ",
            "cod_departamento": "04"
        },
        {
            "id": "47",
            "codigo": "05",
            "valor": "COMALAPA ",
            "cod_departamento": "04"
        },
        {
            "id": "48",
            "codigo": "06",
            "valor": "CONCEPCIÓN QUEZALTEPEQUE ",
            "cod_departamento": "04"
        },
        {
            "id": "49",
            "codigo": "07",
            "valor": "CHALATENANGO ",
            "cod_departamento": "04"
        },
        {
            "id": "50",
            "codigo": "08",
            "valor": "DULCE NOM MARÍA ",
            "cod_departamento": "04"
        },
        {
            "id": "51",
            "codigo": "09",
            "valor": "EL CARRIZAL ",
            "cod_departamento": "04"
        },
        {
            "id": "52",
            "codigo": "10",
            "valor": "EL PARAÍSO ",
            "cod_departamento": "04"
        },
        {
            "id": "53",
            "codigo": "11",
            "valor": "LA LAGUNA ",
            "cod_departamento": "04"
        },
        {
            "id": "54",
            "codigo": "12",
            "valor": "LA PALMA ",
            "cod_departamento": "04"
        },
        {
            "id": "55",
            "codigo": "13",
            "valor": "LA REINA ",
            "cod_departamento": "04"
        },
        {
            "id": "56",
            "codigo": "14",
            "valor": "LAS VUELTAS ",
            "cod_departamento": "04"
        },
        {
            "id": "57",
            "codigo": "15",
            "valor": "NOMBRE DE JESUS ",
            "cod_departamento": "04"
        },
        {
            "id": "58",
            "codigo": "16",
            "valor": "NVA CONCEPCIÓN ",
            "cod_departamento": "04"
        },
        {
            "id": "59",
            "codigo": "17",
            "valor": "NUEVA TRINIDAD ",
            "cod_departamento": "04"
        },
        {
            "id": "60",
            "codigo": "18",
            "valor": "OJOS DE AGUA ",
            "cod_departamento": "04"
        },
        {
            "id": "61",
            "codigo": "19",
            "valor": "POTONICO ",
            "cod_departamento": "04"
        },
        {
            "id": "62",
            "codigo": "20",
            "valor": "SAN ANT LA CRUZ ",
            "cod_departamento": "04"
        },
        {
            "id": "63",
            "codigo": "21",
            "valor": "SAN ANT RANCHOS ",
            "cod_departamento": "04"
        },
        {
            "id": "64",
            "codigo": "22",
            "valor": "SAN FERNANDO ",
            "cod_departamento": "04"
        },
        {
            "id": "65",
            "codigo": "23",
            "valor": "SAN FRANCISCO LEMPA ",
            "cod_departamento": "04"
        },
        {
            "id": "66",
            "codigo": "24",
            "valor": "SAN FRANCISCO MORAZÁN ",
            "cod_departamento": "04"
        },
        {
            "id": "67",
            "codigo": "25",
            "valor": "SAN IGNACIO ",
            "cod_departamento": "04"
        },
        {
            "id": "68",
            "codigo": "26",
            "valor": "SAN I LABRADOR ",
            "cod_departamento": "04"
        },
        {
            "id": "69",
            "codigo": "27",
            "valor": "SAN J CANCASQUE ",
            "cod_departamento": "04"
        },
        {
            "id": "70",
            "codigo": "28",
            "valor": "SAN JOSE FLORES ",
            "cod_departamento": "04"
        },
        {
            "id": "71",
            "codigo": "29",
            "valor": "SAN LUIS CARMEN ",
            "cod_departamento": "04"
        },
        {
            "id": "72",
            "codigo": "30",
            "valor": "SN MIG MERCEDES ",
            "cod_departamento": "04"
        },
        {
            "id": "73",
            "codigo": "31",
            "valor": "SAN RAFAEL ",
            "cod_departamento": "04"
        },
        {
            "id": "74",
            "codigo": "32",
            "valor": "SANTA RITA ",
            "cod_departamento": "04"
        },
        {
            "id": "75",
            "codigo": "33",
            "valor": "TEJUTLA ",
            "cod_departamento": "04"
        },
        {
            "id": "76",
            "codigo": "01",
            "valor": "ANTGO CUSCATLÁN ",
            "cod_departamento": "05"
        },
        {
            "id": "77",
            "codigo": "02",
            "valor": "CIUDAD ARCE ",
            "cod_departamento": "05"
        },
        {
            "id": "78",
            "codigo": "03",
            "valor": "COLON ",
            "cod_departamento": "05"
        },
        {
            "id": "79",
            "codigo": "04",
            "valor": "COMASAGUA ",
            "cod_departamento": "05"
        },
        {
            "id": "80",
            "codigo": "05",
            "valor": "CHILTIUPAN ",
            "cod_departamento": "05"
        },
        {
            "id": "81",
            "codigo": "06",
            "valor": "HUIZÚCAR ",
            "cod_departamento": "05"
        },
        {
            "id": "82",
            "codigo": "07",
            "valor": "JAYAQUE ",
            "cod_departamento": "05"
        },
        {
            "id": "83",
            "codigo": "08",
            "valor": "JICALAPA ",
            "cod_departamento": "05"
        },
        {
            "id": "84",
            "codigo": "09",
            "valor": "LA LIBERTAD ",
            "cod_departamento": "05"
        },
        {
            "id": "85",
            "codigo": "10",
            "valor": "NUEVO CUSCATLÁN ",
            "cod_departamento": "05"
        },
        {
            "id": "86",
            "codigo": "11",
            "valor": "SANTA TECLA ",
            "cod_departamento": "05"
        },
        {
            "id": "87",
            "codigo": "12",
            "valor": "QUEZALTEPEQUE ",
            "cod_departamento": "05"
        },
        {
            "id": "88",
            "codigo": "13",
            "valor": "SACACOYO ",
            "cod_departamento": "05"
        },
        {
            "id": "89",
            "codigo": "14",
            "valor": "SN J VILLANUEVA ",
            "cod_departamento": "05"
        },
        {
            "id": "90",
            "codigo": "15",
            "valor": "SAN JUAN OPICO ",
            "cod_departamento": "05"
        },
        {
            "id": "91",
            "codigo": "16",
            "valor": "SAN MATÍAS ",
            "cod_departamento": "05"
        },
        {
            "id": "92",
            "codigo": "17",
            "valor": "SAN P TACACHICO ",
            "cod_departamento": "05"
        },
        {
            "id": "93",
            "codigo": "18",
            "valor": "TAMANIQUE ",
            "cod_departamento": "05"
        },
        {
            "id": "94",
            "codigo": "19",
            "valor": "TALNIQUE ",
            "cod_departamento": "05"
        },
        {
            "id": "95",
            "codigo": "20",
            "valor": "TEOTEPEQUE ",
            "cod_departamento": "05"
        },
        {
            "id": "96",
            "codigo": "21",
            "valor": "TEPECOYO ",
            "cod_departamento": "05"
        },
        {
            "id": "97",
            "codigo": "22",
            "valor": "ZARAGOZA ",
            "cod_departamento": "05"
        },
        {
            "id": "98",
            "codigo": "01",
            "valor": "AGUILARES ",
            "cod_departamento": "06"
        },
        {
            "id": "99",
            "codigo": "02",
            "valor": "APOPA ",
            "cod_departamento": "06"
        },
        {
            "id": "100",
            "codigo": "03",
            "valor": "AYUTUXTEPEQUE ",
            "cod_departamento": "06"
        },
        {
            "id": "101",
            "codigo": "04",
            "valor": "CUSCATANCINGO ",
            "cod_departamento": "06"
        },
        {
            "id": "102",
            "codigo": "05",
            "valor": "EL PAISNAL ",
            "cod_departamento": "06"
        },
        {
            "id": "103",
            "codigo": "06",
            "valor": "GUAZAPA ",
            "cod_departamento": "06"
        },
        {
            "id": "104",
            "codigo": "07",
            "valor": "ILOPANGO ",
            "cod_departamento": "06"
        },
        {
            "id": "105",
            "codigo": "08",
            "valor": "MEJICANOS ",
            "cod_departamento": "06"
        },
        {
            "id": "106",
            "codigo": "09",
            "valor": "NEJAPA ",
            "cod_departamento": "06"
        },
        {
            "id": "107",
            "codigo": "10",
            "valor": "PANCHIMALCO ",
            "cod_departamento": "06"
        },
        {
            "id": "108",
            "codigo": "11",
            "valor": "ROSARIO DE MORA ",
            "cod_departamento": "06"
        },
        {
            "id": "109",
            "codigo": "12",
            "valor": "SAN MARCOS ",
            "cod_departamento": "06"
        },
        {
            "id": "110",
            "codigo": "13",
            "valor": "SAN MARTIN ",
            "cod_departamento": "06"
        },
        {
            "id": "111",
            "codigo": "14",
            "valor": "SAN SALVADOR ",
            "cod_departamento": "06"
        },
        {
            "id": "112",
            "codigo": "15",
            "valor": "STG TEXACUANGOS ",
            "cod_departamento": "06"
        },
        {
            "id": "113",
            "codigo": "16",
            "valor": "SANTO TOMAS ",
            "cod_departamento": "06"
        },
        {
            "id": "114",
            "codigo": "17",
            "valor": "SOYAPANGO ",
            "cod_departamento": "06"
        },
        {
            "id": "115",
            "codigo": "18",
            "valor": "TONACATEPEQUE ",
            "cod_departamento": "06"
        },
        {
            "id": "116",
            "codigo": "19",
            "valor": "CIUDAD DELGADO ",
            "cod_departamento": "06"
        },
        {
            "id": "117",
            "codigo": "01",
            "valor": "CANDELARIA ",
            "cod_departamento": "07"
        },
        {
            "id": "118",
            "codigo": "02",
            "valor": "COJUTEPEQUE ",
            "cod_departamento": "07"
        },
        {
            "id": "119",
            "codigo": "03",
            "valor": "EL CARMEN ",
            "cod_departamento": "07"
        },
        {
            "id": "120",
            "codigo": "04",
            "valor": "EL ROSARIO ",
            "cod_departamento": "07"
        },
        {
            "id": "121",
            "codigo": "05",
            "valor": "MONTE SAN JUAN ",
            "cod_departamento": "07"
        },
        {
            "id": "122",
            "codigo": "06",
            "valor": "ORAT CONCEPCIÓN ",
            "cod_departamento": "07"
        },
        {
            "id": "123",
            "codigo": "07",
            "valor": "SAN B PERULAPIA ",
            "cod_departamento": "07"
        },
        {
            "id": "124",
            "codigo": "08",
            "valor": "SAN CRISTÓBAL ",
            "cod_departamento": "07"
        },
        {
            "id": "125",
            "codigo": "09",
            "valor": "SAN J GUAYABAL ",
            "cod_departamento": "07"
        },
        {
            "id": "126",
            "codigo": "10",
            "valor": "SAN P PERULAPÁN ",
            "cod_departamento": "07"
        },
        {
            "id": "127",
            "codigo": "11",
            "valor": "SAN RAF CEDROS ",
            "cod_departamento": "07"
        },
        {
            "id": "128",
            "codigo": "12",
            "valor": "SAN RAMON ",
            "cod_departamento": "07"
        },
        {
            "id": "129",
            "codigo": "13",
            "valor": "STA C ANALQUITO ",
            "cod_departamento": "07"
        },
        {
            "id": "130",
            "codigo": "14",
            "valor": "STA C MICHAPA ",
            "cod_departamento": "07"
        },
        {
            "id": "131",
            "codigo": "15",
            "valor": "SUCHITOTO ",
            "cod_departamento": "07"
        },
        {
            "id": "132",
            "codigo": "16",
            "valor": "TENANCINGO ",
            "cod_departamento": "07"
        },
        {
            "id": "133",
            "codigo": "01",
            "valor": "CUYULTITÁN ",
            "cod_departamento": "08"
        },
        {
            "id": "134",
            "codigo": "02",
            "valor": "EL ROSARIO ",
            "cod_departamento": "08"
        },
        {
            "id": "135",
            "codigo": "03",
            "valor": "JERUSALÉN ",
            "cod_departamento": "08"
        },
        {
            "id": "136",
            "codigo": "04",
            "valor": "MERCED LA CEIBA ",
            "cod_departamento": "08"
        },
        {
            "id": "137",
            "codigo": "05",
            "valor": "OLOCUILTA ",
            "cod_departamento": "08"
        },
        {
            "id": "138",
            "codigo": "06",
            "valor": "PARAÍSO OSORIO ",
            "cod_departamento": "08"
        },
        {
            "id": "139",
            "codigo": "07",
            "valor": "SN ANT MASAHUAT ",
            "cod_departamento": "08"
        },
        {
            "id": "140",
            "codigo": "08",
            "valor": "SAN EMIGDIO ",
            "cod_departamento": "08"
        },
        {
            "id": "141",
            "codigo": "09",
            "valor": "SN FCO CHINAMEC ",
            "cod_departamento": "08"
        },
        {
            "id": "142",
            "codigo": "10",
            "valor": "SAN J NONUALCO ",
            "cod_departamento": "08"
        },
        {
            "id": "143",
            "codigo": "11",
            "valor": "SAN JUAN TALPA ",
            "cod_departamento": "08"
        },
        {
            "id": "144",
            "codigo": "12",
            "valor": "SAN JUAN TEPEZONTES ",
            "cod_departamento": "08"
        },
        {
            "id": "145",
            "codigo": "13",
            "valor": "SAN LUIS TALPA ",
            "cod_departamento": "08"
        },
        {
            "id": "146",
            "codigo": "14",
            "valor": "SAN MIGUEL TEPEZONTES ",
            "cod_departamento": "08"
        },
        {
            "id": "147",
            "codigo": "15",
            "valor": "SAN PEDRO MASAHUAT ",
            "cod_departamento": "08"
        },
        {
            "id": "148",
            "codigo": "16",
            "valor": "SAN PEDRO NONUALCO ",
            "cod_departamento": "08"
        },
        {
            "id": "149",
            "codigo": "17",
            "valor": "SAN R OBRAJUELO ",
            "cod_departamento": "08"
        },
        {
            "id": "150",
            "codigo": "18",
            "valor": "STA MA OSTUMA ",
            "cod_departamento": "08"
        },
        {
            "id": "151",
            "codigo": "19",
            "valor": "STGO NONUALCO ",
            "cod_departamento": "08"
        },
        {
            "id": "152",
            "codigo": "20",
            "valor": "TAPALHUACA ",
            "cod_departamento": "08"
        },
        {
            "id": "153",
            "codigo": "21",
            "valor": "ZACATECOLUCA ",
            "cod_departamento": "08"
        },
        {
            "id": "154",
            "codigo": "22",
            "valor": "SN LUIS LA HERR ",
            "cod_departamento": "08"
        },
        {
            "id": "155",
            "codigo": "01",
            "valor": "CINQUERA ",
            "cod_departamento": "09"
        },
        {
            "id": "156",
            "codigo": "02",
            "valor": "GUACOTECTI ",
            "cod_departamento": "09"
        },
        {
            "id": "157",
            "codigo": "03",
            "valor": "ILOBASCO ",
            "cod_departamento": "09"
        },
        {
            "id": "158",
            "codigo": "04",
            "valor": "JUTIAPA ",
            "cod_departamento": "09"
        },
        {
            "id": "159",
            "codigo": "05",
            "valor": "SAN ISIDRO ",
            "cod_departamento": "09"
        },
        {
            "id": "160",
            "codigo": "06",
            "valor": "SENSUNTEPEQUE ",
            "cod_departamento": "09"
        },
        {
            "id": "161",
            "codigo": "07",
            "valor": "TEJUTEPEQUE ",
            "cod_departamento": "09"
        },
        {
            "id": "162",
            "codigo": "08",
            "valor": "VICTORIA ",
            "cod_departamento": "09"
        },
        {
            "id": "163",
            "codigo": "09",
            "valor": "DOLORES ",
            "cod_departamento": "09"
        },
        {
            "id": "164",
            "codigo": "01",
            "valor": "APASTEPEQUE ",
            "cod_departamento": "10"
        },
        {
            "id": "165",
            "codigo": "02",
            "valor": "GUADALUPE ",
            "cod_departamento": "10"
        },
        {
            "id": "166",
            "codigo": "03",
            "valor": "SAN CAY ISTEPEQ ",
            "cod_departamento": "10"
        },
        {
            "id": "167",
            "codigo": "04",
            "valor": "SANTA CLARA ",
            "cod_departamento": "10"
        },
        {
            "id": "168",
            "codigo": "05",
            "valor": "SANTO DOMINGO ",
            "cod_departamento": "10"
        },
        {
            "id": "169",
            "codigo": "06",
            "valor": "SN EST CATARINA ",
            "cod_departamento": "10"
        },
        {
            "id": "170",
            "codigo": "07",
            "valor": "SAN ILDEFONSO ",
            "cod_departamento": "10"
        },
        {
            "id": "171",
            "codigo": "08",
            "valor": "SAN LORENZO ",
            "cod_departamento": "10"
        },
        {
            "id": "172",
            "codigo": "09",
            "valor": "SAN SEBASTIÁN ",
            "cod_departamento": "10"
        },
        {
            "id": "173",
            "codigo": "10",
            "valor": "SAN VICENTE ",
            "cod_departamento": "10"
        },
        {
            "id": "174",
            "codigo": "11",
            "valor": "TECOLUCA ",
            "cod_departamento": "10"
        },
        {
            "id": "175",
            "codigo": "12",
            "valor": "TEPETITÁN ",
            "cod_departamento": "10"
        },
        {
            "id": "176",
            "codigo": "13",
            "valor": "VERAPAZ ",
            "cod_departamento": "10"
        },
        {
            "id": "177",
            "codigo": "01",
            "valor": "ALEGRÍA ",
            "cod_departamento": "11"
        },
        {
            "id": "178",
            "codigo": "02",
            "valor": "BERLÍN ",
            "cod_departamento": "11"
        },
        {
            "id": "179",
            "codigo": "03",
            "valor": "CALIFORNIA ",
            "cod_departamento": "11"
        },
        {
            "id": "180",
            "codigo": "04",
            "valor": "CONCEP BATRES ",
            "cod_departamento": "11"
        },
        {
            "id": "181",
            "codigo": "05",
            "valor": "EL TRIUNFO ",
            "cod_departamento": "11"
        },
        {
            "id": "182",
            "codigo": "06",
            "valor": "EREGUAYQUÍN ",
            "cod_departamento": "11"
        },
        {
            "id": "183",
            "codigo": "07",
            "valor": "ESTANZUELAS ",
            "cod_departamento": "11"
        },
        {
            "id": "184",
            "codigo": "08",
            "valor": "JIQUILISCO ",
            "cod_departamento": "11"
        },
        {
            "id": "185",
            "codigo": "09",
            "valor": "JUCUAPA ",
            "cod_departamento": "11"
        },
        {
            "id": "186",
            "codigo": "10",
            "valor": "JUCUARÁN ",
            "cod_departamento": "11"
        },
        {
            "id": "187",
            "codigo": "11",
            "valor": "MERCEDES UMAÑA ",
            "cod_departamento": "11"
        },
        {
            "id": "188",
            "codigo": "12",
            "valor": "NUEVA GRANADA ",
            "cod_departamento": "11"
        },
        {
            "id": "189",
            "codigo": "13",
            "valor": "OZATLÁN ",
            "cod_departamento": "11"
        },
        {
            "id": "190",
            "codigo": "14",
            "valor": "PTO EL TRIUNFO ",
            "cod_departamento": "11"
        },
        {
            "id": "191",
            "codigo": "15",
            "valor": "SAN AGUSTÍN ",
            "cod_departamento": "11"
        },
        {
            "id": "192",
            "codigo": "16",
            "valor": "SN BUENAVENTURA ",
            "cod_departamento": "11"
        },
        {
            "id": "193",
            "codigo": "17",
            "valor": "SAN DIONISIO ",
            "cod_departamento": "11"
        },
        {
            "id": "194",
            "codigo": "18",
            "valor": "SANTA ELENA ",
            "cod_departamento": "11"
        },
        {
            "id": "195",
            "codigo": "19",
            "valor": "SAN FCO JAVIER ",
            "cod_departamento": "11"
        },
        {
            "id": "196",
            "codigo": "20",
            "valor": "SANTA MARÍA ",
            "cod_departamento": "11"
        },
        {
            "id": "197",
            "codigo": "21",
            "valor": "STGO DE MARÍA ",
            "cod_departamento": "11"
        },
        {
            "id": "198",
            "codigo": "22",
            "valor": "TECAPÁN ",
            "cod_departamento": "11"
        },
        {
            "id": "199",
            "codigo": "23",
            "valor": "USULUTÁN ",
            "cod_departamento": "11"
        },
        {
            "id": "200",
            "codigo": "01",
            "valor": "CAROLINA ",
            "cod_departamento": "12"
        },
        {
            "id": "201",
            "codigo": "02",
            "valor": "CIUDAD BARRIOS ",
            "cod_departamento": "12"
        },
        {
            "id": "202",
            "codigo": "03",
            "valor": "COMACARÁN ",
            "cod_departamento": "12"
        },
        {
            "id": "203",
            "codigo": "04",
            "valor": "CHAPELTIQUE ",
            "cod_departamento": "12"
        },
        {
            "id": "204",
            "codigo": "05",
            "valor": "CHINAMECA ",
            "cod_departamento": "12"
        },
        {
            "id": "205",
            "codigo": "06",
            "valor": "CHIRILAGUA ",
            "cod_departamento": "12"
        },
        {
            "id": "206",
            "codigo": "07",
            "valor": "EL TRANSITO ",
            "cod_departamento": "12"
        },
        {
            "id": "207",
            "codigo": "08",
            "valor": "LOLOTIQUE ",
            "cod_departamento": "12"
        },
        {
            "id": "208",
            "codigo": "09",
            "valor": "MONCAGUA ",
            "cod_departamento": "12"
        },
        {
            "id": "209",
            "codigo": "10",
            "valor": "NUEVA GUADALUPE ",
            "cod_departamento": "12"
        },
        {
            "id": "210",
            "codigo": "11",
            "valor": "NVO EDÉN S JUAN ",
            "cod_departamento": "12"
        },
        {
            "id": "211",
            "codigo": "12",
            "valor": "QUELEPA ",
            "cod_departamento": "12"
        },
        {
            "id": "212",
            "codigo": "13",
            "valor": "SAN ANT D MOSCO ",
            "cod_departamento": "12"
        },
        {
            "id": "213",
            "codigo": "14",
            "valor": "SAN GERARDO ",
            "cod_departamento": "12"
        },
        {
            "id": "214",
            "codigo": "15",
            "valor": "SAN JORGE ",
            "cod_departamento": "12"
        },
        {
            "id": "215",
            "codigo": "16",
            "valor": "SAN LUIS REINA ",
            "cod_departamento": "12"
        },
        {
            "id": "216",
            "codigo": "17",
            "valor": "SAN MIGUEL ",
            "cod_departamento": "12"
        },
        {
            "id": "217",
            "codigo": "18",
            "valor": "SAN RAF ORIENTE ",
            "cod_departamento": "12"
        },
        {
            "id": "218",
            "codigo": "19",
            "valor": "SESORI ",
            "cod_departamento": "12"
        },
        {
            "id": "219",
            "codigo": "20",
            "valor": "ULUAZAPA ",
            "cod_departamento": "12"
        },
        {
            "id": "220",
            "codigo": "01",
            "valor": "ARAMBALA ",
            "cod_departamento": "13"
        },
        {
            "id": "221",
            "codigo": "02",
            "valor": "CACAOPERA ",
            "cod_departamento": "13"
        },
        {
            "id": "222",
            "codigo": "03",
            "valor": "CORINTO ",
            "cod_departamento": "13"
        },
        {
            "id": "223",
            "codigo": "04",
            "valor": "CHILANGA ",
            "cod_departamento": "13"
        },
        {
            "id": "224",
            "codigo": "05",
            "valor": "DELIC DE CONCEP ",
            "cod_departamento": "13"
        },
        {
            "id": "225",
            "codigo": "06",
            "valor": "EL DIVISADERO ",
            "cod_departamento": "13"
        },
        {
            "id": "226",
            "codigo": "07",
            "valor": "EL ROSARIO ",
            "cod_departamento": "13"
        },
        {
            "id": "227",
            "codigo": "08",
            "valor": "GUALOCOCTI ",
            "cod_departamento": "13"
        },
        {
            "id": "228",
            "codigo": "09",
            "valor": "GUATAJIAGUA ",
            "cod_departamento": "13"
        },
        {
            "id": "229",
            "codigo": "10",
            "valor": "JOATECA ",
            "cod_departamento": "13"
        },
        {
            "id": "230",
            "codigo": "11",
            "valor": "JOCOAITIQUE ",
            "cod_departamento": "13"
        },
        {
            "id": "231",
            "codigo": "12",
            "valor": "JOCORO ",
            "cod_departamento": "13"
        },
        {
            "id": "232",
            "codigo": "13",
            "valor": "LOLOTIQUILLO ",
            "cod_departamento": "13"
        },
        {
            "id": "233",
            "codigo": "14",
            "valor": "MEANGUERA ",
            "cod_departamento": "13"
        },
        {
            "id": "234",
            "codigo": "15",
            "valor": "OSICALA ",
            "cod_departamento": "13"
        },
        {
            "id": "235",
            "codigo": "16",
            "valor": "PERQUÍN ",
            "cod_departamento": "13"
        },
        {
            "id": "236",
            "codigo": "17",
            "valor": "SAN CARLOS ",
            "cod_departamento": "13"
        },
        {
            "id": "238",
            "codigo": "19",
            "valor": "SAN FCO GOTERA ",
            "cod_departamento": "13"
        },
        {
            "id": "239",
            "codigo": "20",
            "valor": "SAN ISIDRO ",
            "cod_departamento": "13"
        },
        {
            "id": "240",
            "codigo": "21",
            "valor": "SAN SIMÓN ",
            "cod_departamento": "13"
        },
        {
            "id": "241",
            "codigo": "22",
            "valor": "SENSEMBRA ",
            "cod_departamento": "13"
        },
        {
            "id": "242",
            "codigo": "23",
            "valor": "SOCIEDAD ",
            "cod_departamento": "13"
        },
        {
            "id": "243",
            "codigo": "24",
            "valor": "TOROLA ",
            "cod_departamento": "13"
        },
        {
            "id": "244",
            "codigo": "25",
            "valor": "YAMABAL ",
            "cod_departamento": "13"
        },
        {
            "id": "245",
            "codigo": "26",
            "valor": "YOLOAIQUÍN ",
            "cod_departamento": "13"
        },
        {
            "id": "246",
            "codigo": "01",
            "valor": "ANAMOROS ",
            "cod_departamento": "14"
        },
        {
            "id": "247",
            "codigo": "02",
            "valor": "BOLÍVAR ",
            "cod_departamento": "14"
        },
        {
            "id": "248",
            "codigo": "03",
            "valor": "CONCEP DE OTE ",
            "cod_departamento": "14"
        },
        {
            "id": "249",
            "codigo": "04",
            "valor": "CONCHAGUA ",
            "cod_departamento": "14"
        },
        {
            "id": "250",
            "codigo": "05",
            "valor": "EL CARMEN ",
            "cod_departamento": "14"
        },
        {
            "id": "251",
            "codigo": "06",
            "valor": "EL SAUCE ",
            "cod_departamento": "14"
        },
        {
            "id": "252",
            "codigo": "07",
            "valor": "INTIPUCÁ ",
            "cod_departamento": "14"
        },
        {
            "id": "253",
            "codigo": "08",
            "valor": "LA UNIÓN ",
            "cod_departamento": "14"
        },
        {
            "id": "254",
            "codigo": "09",
            "valor": "LISLIQUE ",
            "cod_departamento": "14"
        },
        {
            "id": "255",
            "codigo": "10",
            "valor": "MEANG DEL GOLFO ",
            "cod_departamento": "14"
        },
        {
            "id": "256",
            "codigo": "11",
            "valor": "NUEVA ESPARTA ",
            "cod_departamento": "14"
        },
        {
            "id": "257",
            "codigo": "12",
            "valor": "PASAQUINA ",
            "cod_departamento": "14"
        },
        {
            "id": "258",
            "codigo": "13",
            "valor": "POLORÓS ",
            "cod_departamento": "14"
        },
        {
            "id": "259",
            "codigo": "14",
            "valor": "SAN ALEJO ",
            "cod_departamento": "14"
        },
        {
            "id": "260",
            "codigo": "15",
            "valor": "SAN JOSE ",
            "cod_departamento": "14"
        },
        {
            "id": "261",
            "codigo": "16",
            "valor": "SANTA ROSA LIMA ",
            "cod_departamento": "14"
        },
        {
            "id": "262",
            "codigo": "17",
            "valor": "YAYANTIQUE ",
            "cod_departamento": "14"
        },
        {
            "id": "263",
            "codigo": "18",
            "valor": "YUCUAIQUÍN ",
            "cod_departamento": "14"
        },
        {
            "id": "237",
            "codigo": "18",
            "valor": "SAN FERNANDO ",
            "cod_departamento": "13"
        }
    ]';
    }

    function getDepartamentos()
    {
        echo '[{
            "id": "1",
            "codigo": "01",
            "valor": "Ahuachapán "
        },
        {
            "id": "2",
            "codigo": "02",
            "valor": "Santa Ana "
        },
        {
            "id": "3",
            "codigo": "03",
            "valor": "Sonsonate "
        },
        {
            "id": "4",
            "codigo": "04",
            "valor": "Chalatenango "
        },
        {
            "id": "5",
            "codigo": "05",
            "valor": "La Libertad "
        },
        {
            "id": "6",
            "codigo": "06",
            "valor": "San Salvador "
        },
        {
            "id": "7",
            "codigo": "07",
            "valor": "Cuscatlán "
        },
        {
            "id": "8",
            "codigo": "08",
            "valor": "La Paz "
        },
        {
            "id": "9",
            "codigo": "09",
            "valor": "Cabañas "
        },
        {
            "id": "10",
            "codigo": "10",
            "valor": "San Vicente "
        },
        {
            "id": "11",
            "codigo": "11",
            "valor": "Usulután "
        },
        {
            "id": "12",
            "codigo": "12",
            "valor": "San Miguel "
        },
        {
            "id": "13",
            "codigo": "13",
            "valor": "Morazán "
        },
        {
            "id": "14",
            "codigo": "14",
            "valor": "La Unión"
        }
    ]';
    }

    function conversor(Request $request)
    {
        $data = $request->all();

        $pdfe = $data['elpdf'];
        try {
            // Decodifica los datos base64
            $pdfData = base64_decode($pdfe);

            // Verifica si la decodificación fue exitosa
            if ($pdfData !== false) {
                // Guarda el archivo PDF en el servidor
                $filePath = $data['id'] . '.pdf';

                if (Storage::put('public/custom/' . $filePath, $pdfData)) {
                    // El archivo se ha guardado correctamente
                    return response()->json(['message' => 'PDF guardado exitosamente']);
                } else {
                    return response()->json(['error' => 'Error al guardar el archivo PDF']);
                }
            } else {
                return response()->json(['error' => 'Error al decodificar los datos base64']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error inesperado']);
        }
    }

    function updaterRPT(Request $request)
    {
        $data = $request->all();

        $busquedaSucursal = '';
        if ($data['sucursal'] != '') {
            $busquedaSucursal = ',LTIENDA=' . $data['sucursal'];
        }

        $v =  json_decode(shell_exec("curl --location --request GET 'https://sv.lacnetcorp.com/sapapi/functionfs?path=ZRFC_DATOS_TIENDAS&where=LFECHA=" . $data['fecha'] . "$busquedaSucursal'"));
        $v = $v->DATOS_TIENDAS;

        foreach ($v as $val) {
            $c = explode("-", $val->ID_TRANSACCION);
            echo $c[1] . " // " . $c[0];
            $d = RptFacturas::where('id', $c[1])->where('sucursal', $c[0])->where('sellorecibido', '=', '')->orWhereNull('sellorecibido')->first();
            if ($d) {

                $d->codigogeneracion = $val->CAMPO1;
                $d->sellorecibido = $val->CAMPO2;
                $d->mensajemh = $val->STTEXT;
                $d->pedidosap = $val->PEDIDO;
                $d->entregasap = $val->ENTREGA;
                $d->facturasap = $val->FACTURA;
                $d->documcontable = $val->BELNR;
                $d->save();
            }
        }
    }


    function materialCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        $extra = $data['extra'];

        $sku = $datos['clase'] . '-' . $datos['subclase'] . '-';
        $existeSku = Material::where('SKU', 'like', $sku . '%')->orderBy('id', 'desc')->first();
        if (!$existeSku) {
            $sku = $sku . '0001';
        } else {
            $getNumero = explode("-", $existeSku->sku);
            $numero = intVal($getNumero[count($getNumero) - 1]) + 1;
            $sku = $sku . str_pad($numero, 4, "0", STR_PAD_LEFT);
        }


        try {
            $material = new Material;
            $material->sku = $sku; //$datos['sku'];
            $material->sku_alterno = $datos['sku_alterno'];
            $material->codigo_barras = $datos['codigo_barras'];
            $material->descripcion = $datos['descripcion'];
            $material->descripcion_corta = $datos['descripcion_corta'];
            $material->precio_base = $datos['precio_base'];
            $material->peso_bruto = $datos['peso_bruto'];
            $material->peso_neto = $datos['peso_neto'];
            $material->clase = $datos['clase'];
            $material->subclase = $datos['subclase'];
            $material->unidad_med_compra = $datos['unidad_med_compra'];
            $material->cant_min = $datos['cant_min'];
            $material->grupo_impuestos = $datos['grupo_impuestos'];
            $material->udf1 = $datos['udf1'];
            $material->udf2 = $datos['udf2'];
            $material->udf3 = $datos['udf3'];
            $material->udf4 = $datos['udf4'];
            $material->umedida = $datos['umedida'];
            $material->umin = $datos['umin'];
            $material->lu = $datos['lu'];
            $material->ma = $datos['ma'];
            $material->mi = $datos['mi'];
            $material->ju = $datos['ju'];
            $material->vi = $datos['vi'];
            $material->sa = $datos['sa'];
            $material->do = $datos['do'];
            $material->desayuno = $datos['desayuno'];
            $material->almuerzo = $datos['almuerzo'];
            $material->cena = $datos['cena'];
            $material->activo = $datos['activo'];
            $material->lleva_inventario = $datos['lleva_inventario'];
            $material->costo_prom = $datos['costo_prom'];


            $result = $material->save();

            foreach ($extra as $v) {
                $detalle = new MaterialDetalle();
                $detalle->cantidad = $v['cantidad'];
                $detalle->material_id = $v['id'];
                $detalle->material_padre = $material->id;
                $detalle->save();
            }
            if ($result) {
                return response()->json(['msg' => 'Material creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el material'], 402);
            }
        } catch (Exception $e) {
            //var_dump($e);

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }




    function editMateriales(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        $extra = $data['extra'];
        try {
            $material = Material::find($datos['id']);
            $material->sku = $datos['sku'];
            $material->sku_alterno = $datos['sku_alterno'];
            $material->codigo_barras = $datos['codigo_barras'];
            $material->descripcion = $datos['descripcion'];
            $material->descripcion_corta = $datos['descripcion_corta'];
            $material->precio_base = $datos['precio_base'];
            $material->peso_bruto = $datos['peso_bruto'];
            $material->peso_neto = $datos['peso_neto'];
            $material->clase = $datos['clase'];
            $material->subclase = $datos['subclase'];
            $material->unidad_med_compra = $datos['unidad_med_compra'];
            $material->cant_min = $datos['cant_min'];
            $material->grupo_impuestos = $datos['grupo_impuestos'];
            $material->udf1 = $datos['udf1'];
            $material->udf2 = $datos['udf2'];
            $material->udf3 = $datos['udf3'];
            $material->udf4 = $datos['udf4'];
            $material->umedida = $datos['umedida'];
            $material->umin = $datos['umin'];
            $material->lu = $datos['lu'];
            $material->ma = $datos['ma'];
            $material->mi = $datos['mi'];
            $material->ju = $datos['ju'];
            $material->vi = $datos['vi'];
            $material->sa = $datos['sa'];
            $material->do = $datos['do'];
            $material->desayuno = $datos['desayuno'];
            $material->almuerzo = $datos['almuerzo'];
            $material->cena = $datos['cena'];
            $material->activo = $datos['activo'];
            $material->lleva_inventario = $datos['lleva_inventario'];
            $material->costo_prom = $datos['costo_prom'];

            $detalles_existentes = $material->detalles;


            MaterialDetalle::where('material_padre', $material->id)->delete();
            foreach ($extra as $v) {
                MaterialDetalle::Create([
                    'cantidad' => $v['cantidad'],
                    'material_id' => $v['material_id'],
                    'material_padre' => $material->id,

                ]);
            }

            $result = $material->save();
            if ($result) {
                return response()->json(['msg' => 'Material Editado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el material'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }



    function deleteMaterial(Request $request)
    {
        $data = $request->all();
        try {
            $material = Material::find($data['datos']['id']);
            $result = $material->delete();

            if ($result) {
                return response()->json(['msg' => 'Material eliminado'], 200);
            } else {
                return response()->json(['msg' => 'Error al eliminar el Material'], 402);
            }
        } catch (Exception $e) {
            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function editClase(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $clase = Clase::find($datos['id']);
            $clase->nombre = $datos['nombre'];
            $result = $clase->save();
            if ($result) {
                return response()->json(['msg' => 'Clase Editada correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el Clase'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function getClases()
    {
        echo Clase::get()->toJson();
    }

    function claseCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $clase = new Clase;
            $clase->nombre = $datos['nombre'];

            $result = $clase->save();
            if ($result) {
                return response()->json(['msg' => 'Clase creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el Clase'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }




    function subclases()
    {
        $info = [];
        $info['clases'] = Clase::with(['subclases'])->get()->toJson();
        return view('principal.subclases', $info);
    }

    function getSubclases()
    {
        echo Subclase::get()->toJson();
    }

    function editSubclase(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $clase = Subclase::find($datos['id']);
            $clase->nombre = $datos['nombre'];
            $clase->clase_id = $datos['clase_id'];
            $result = $clase->save();
            if ($result) {
                return response()->json(['msg' => 'Clase Editada correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el Clase'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function subclaseCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $clase = new Subclase;
            $clase->nombre = $datos['nombre'];
            $clase->clase_id = $datos['clase_id'];

            $result = $clase->save();
            if ($result) {
                return response()->json(['msg' => 'Clase creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el Clase'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function proveedores()
    {
        $info = [];
        //$info['inventarios'] = Kardex::limit(10)->get()->toJson();
        //$info['materiales'] = Material::get()->toJson();
        //$info['inventarios'] = Kardex::limit(10)->get()->toJson();
        //$info['materiales'] = Material::get()->toJson();
        return view('principal.proveedores', $info);
    }



    function getProveedores(Request $request)
    {
        $data = $request->all();

        echo Proveedores::get()->toJson();
    }

    function editProveedores(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $proveedores = Proveedores::find($datos['id']);
            $proveedores->codigo = $datos['codigo'];
            $proveedores->nombre = $datos['nombre'];
            $proveedores->nit = $datos['nit'];
            $proveedores->nrc = $datos['nrc'];
            $proveedores->telefono = $datos['telefono'];
            $proveedores->dui = $datos['dui'];
            $proveedores->correo = $datos['correo'];
            $proveedores->nombre_contacto = $datos['nombre_contacto'];
            $proveedores->telefono_contacto = $datos['telefono_contacto'];
            $result = $proveedores->save();
            if ($result) {
                return response()->json(['msg' => 'Proveedor Editado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el Proveedor'], 402);
            }
        } catch (Exception $e) {
            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function proveedoresCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $proveedores = new Proveedores;
            $proveedores->codigo = $datos['codigo'];
            $proveedores->nombre = $datos['nombre'];
            $proveedores->nit = $datos['nit'];
            $proveedores->nrc = $datos['nrc'];
            $proveedores->telefono = $datos['telefono'];
            $proveedores->dui = $datos['dui'];
            $proveedores->correo = $datos['correo'];
            $proveedores->nombre_contacto = $datos['nombre_contacto'];
            $proveedores->telefono_contacto = $datos['telefono_contacto'];

            $result = $proveedores->save();
            if ($result) {
                return response()->json(['msg' => 'Proveedor creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el Proveedor'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }










    function inventario()
    {
        $info = [];
        //$info['inventarios'] = Kardex::limit(10)->get()->toJson();
        //$info['materiales'] = Material::get()->toJson();
        $info['inventarios'] = Kardex::limit(10)->get()->toJson();
        $info['materiales'] = Material::get()->toJson();
        return view('principal.inventario', $info);
    }



    function getInventario(Request $request)
    {
        $data = $request->all();

        echo Kardex::whereDate('fecha', $data['fecha'])->get()->toJson();
    }


    function editInventario(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $clase = Subclase::find($datos['id']);
            $clase->nombre = $datos['nombre'];
            $clase->clase_id = $datos['clase_id'];
            $result = $clase->save();
            if ($result) {
                return response()->json(['msg' => 'Clase Editada correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el Clase'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function inventarioCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $kardex = new Kardex;
            $kardex->material_id = $datos['material_id'];
            $kardex->concepto = $datos['concepto'];
            $kardex->cantidad = $datos['cantidad'];
            $kardex->costo = $datos['costo'];
            $kardex->user_id = Auth::user()->id;
            $kardex->tipo_operacion = $datos['tipo_operacion'];
            $kardex->fecha = $datos['fecha'];


            $result = $kardex->save();
            if ($result) {
                return response()->json(['msg' => 'Movimiento creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el movimiento'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function getKardexDate(Request $request)
    {
        $data = $request->all();
        echo Kardex::with(['material', 'material.clases'])->whereBetween('fecha', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }

    function getVentadiaria(Request $request)
    {
        $data = $request->all();

        $result = DB::select("SELECT `insertar_venta_diaria_h`()");
        echo json_encode(DB::select(DB::raw("select * from venta_diaria_h WHERE fecha_docum BETWEEN '" . $data['fechas_ini'] . "' AND '" . $data['fechas_fin'] . "' ")));
    }


    function getToken(Request $request)
    {
        $datos = $request->all();

        $company = Companies::first();
        if (!$company) {
            return response()->json(['error' => 'No se ha configurado la empresa'], 500);
        }

        if ($datos['ambiente'] == 'prod') {
            $fecha_vencimiento = new DateTime($company->fecha_vencimiento);
            $fecha_actual = new DateTime();
            $fecha_actual->add(new DateInterval('PT3H'));

            if ($fecha_vencimiento < $fecha_actual) {
                // La fecha de vencimiento ya pasó, hacer algo
                $response = json_decode(shell_exec("curl --location 'https://api.dtes.mh.gob.sv/seguridad/auth' --form 'user=" . $datos['user'] . "' --form 'pwd=" . $datos['pwd'] . "'"));
                if (isset($response->status)) {
                    if ($response->status == 'OK') {

                        $fecha_actual = new DateTime();
                        $fecha_actual->add(new DateInterval('PT24H'));
                        $company->fecha_vencimiento = $fecha_actual->format('Y-m-d H:i:s');
                        $company->token = $response->body->token;
                        $company->save();

                        return response()->json(['token' => $response->body->token]);
                    } else {
                        return response()->json(['error' => $response->body->estado]);
                    }
                }
            } else {
                // La fecha de vencimiento no ha pasado, hacer otra cosa
                // Por ejemplo, retornar el token actual
                return response()->json(['token' => $company->token]);
            }
        } else {
            $fecha_vencimiento = new DateTime($company->fecha_vencimiento_test);
            $fecha_actual = new DateTime();
            $fecha_actual->add(new DateInterval('PT3H'));

            if ($fecha_vencimiento < $fecha_actual) {
                // La fecha de vencimiento ya pasó, hacer algo
                //$response = json_decode(shell_exec("curl --location 'https://admin.factura.gob.sv/" . $datos['ambiente'] . "/seguridad/auth/portal' --header 'Content-Type: application/x-www-form-urlencoded' --data-urlencode 'user=" . $datos['user'] . "' --data-urlencode 'pwd=" . $datos['pwd'] . "'"));
                $response = json_decode(shell_exec("curl --location 'https://apitest.dtes.mh.gob.sv/seguridad/auth' --form 'user=" . $datos['user'] . "' --form 'pwd=" . $datos['pwd'] . "'"));


                if (isset($response->status)) {
                    if ($response->status == 'OK') {

                        $fecha_actual = new DateTime();
                        $fecha_actual->add(new DateInterval('PT24H'));
                        $company->fecha_vencimiento_test = $fecha_actual->format('Y-m-d H:i:s');
                        $company->token_test = $response->body->token;
                        $company->save();

                        return response()->json(['token' => $response->body->token]);
                    } else {
                        return response()->json(['error' => $response->body->estado]);
                    }
                }
            } else {
                // La fecha de vencimiento no ha pasado, hacer otra cosa
                // Por ejemplo, retornar el token actual
                return response()->json(['token' => $company->token_test]);
            }
        }
    }

    function creditoPlanilla(Request $request)
    {
        $res = [];
        $data = $request->all();

        if (!isset($data['email'])) {
            return response()->json(['error' => 0, 'mensaje' => 'Parametro email no agregado'], 422);
        }



        if (!isset($data['password'])) {
            return response()->json(['error' => 0, 'mensaje' => 'Parametro password no agregado'], 422);
        }

        $r = Auth::attempt(array('email' => $data['email'], 'password' => $data['password']));

        // Generar token de acceso
        if (Auth::check()) {
            //return  json_encode(DB::select(DB::raw("SELECT codigo,max(nombre) nombre, sum(dto_planilla) dto_planilla FROM docum_credito_por_fecha where dto_planilla>0 and fecha_docum between '" . $data['fechaI'] . "' and '" . $data['fechaF'] . "' group by codigo")));
            //return  json_encode(DB::select(DB::raw("select id_enterprise, codigo,max(nombre) nombre, round( sum(dto_planilla),2) dto_planilla from docum_credito_por_fecha where dto_planilla>0 and  fecha_docum between '" . $data['fechaI'] . "' and '" . $data['fechaF'] . "' group by id_enterprise,codigo")));
            return  json_encode(DB::select(DB::raw("select case when d.codigo like 'CLI%' then 0 else d.id_enterprise end as id_enterprise, case when d.codigo like 'CLI%' then 0 else c.idemployee end as id_employee, d.codigo,max(d.nombre)nombre, round(sum(d.dto_planilla),2) dto_planilla from docum_credito_por_fecha d left join clientes c on d.codigo = c.codigo where d.dto_planilla>0 and d.fecha_docum between '" . $data['fechaI'] . "' and '" . $data['fechaF'] . "' group by d.id_enterprise,d.codigo,c.idemployee")));


            //select * from docum_credito_por_fecha WHERE fecha_docum BETWEEN '" . $data['fechaI'] . "' AND '" . $data['fechaF'] . "'
            //echo json_encode($res);
        } else {
            $res['login'] = false;
            $res['message'] = "Correo o password incorrecto";
            return response()->json($res, 422);
        }



        //SELECT material_id,  m.descripcion, SUM(total) total, SUM(cantidad) cantidad FROM rpt_facturas_det r INNER JOIN materiales m on r.material_id = m.id  WHERE fecha_docum BETWEEN '2024-03-01' AND '2024-03-04' GROUP BY material_id ORDER BY SUM(total) desc
        //echo  ReporteJornada::with(['claseDetalle', 'subclaseDetalle'])->whereBetween('fecha_docum', [$data['fechas_ini'], $data['fechas_fin']])->get()->toJson();
    }


    function sucursales()
    {
        return view('principal.sucursales');
    }

    function editSucursal(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $empresa = Sucursales::find($datos['id']);
            $empresa->codigo = $datos['codigo'];
            $empresa->nombre = $datos['nombre'];
            $result = $empresa->save();
            if ($result) {
                return response()->json(['msg' => 'Empresa Editada correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al editar el Empresa'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function getSucursales()
    {
        echo Sucursales::get()->toJson();
    }

    function sucursalCreate(Request $request)
    {
        $data = $request->all();
        $datos = $data['datos'];
        try {
            $empresa = new Sucursales;
            $empresa->nombre = $datos['nombre'];
            $empresa->codigo = $datos['codigo'];

            $result = $empresa->save();
            if ($result) {
                return response()->json(['msg' => 'Empresa creado correctamente'], 200);
            } else {
                return response()->json(['msg' => 'Error al crear el Empresa'], 402);
            }
        } catch (Exception $e) {

            return response()->json(['msg' => "Error en el servidor: " . $e->errorInfo[2]], 500);
        }
    }

    function se()
    {
        return view('se');
    }
}
