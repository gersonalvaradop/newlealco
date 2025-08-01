<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    function traerPDF($id, $token,$ambiente='test')
    {
        $v=($ambiente=='test')?1:2;
        return shell_exec('curl --request POST \ --url https://admin.factura.gob.sv/'.$ambiente.'/generardte/generar-pdf/descargar/base64/codigo-generacion/'.$v.'/' . $id . ' \ --header "Authorization: ' . $token . '"');
    }

    function getJsonFactura($factura, $token,$ambiente='test')
    {
        $d = [];
        $json = json_decode(shell_exec('curl --location --request POST "https://admin.factura.gob.sv/'.$ambiente.'/consulta/query/listaByFilter/" --header "Authorization: ' . $token . '" --header "Content-Type: application/json" --data-raw " { \"codigoGeneracion\": \"' . $factura . '\", \"tipoRpt\": \"R\" }"'));
        if ((isset($json->status) ? $json->status : 'ERROR') == 'ERROR' || is_null($json) || (isset($json->body) ? count($json->body) : 0)==0) {
            $json = json_decode(shell_exec('curl --location --request POST "https://admin.factura.gob.sv/'.$ambiente.'/consulta/query/listaByFilter/" --header "Authorization: ' . $token . '" --header "Content-Type: application/json" --data-raw " { \"codigoGeneracion\": \"' . $factura . '\", \"tipoRpt\": \"E\" }"'));
        }
        $d = $json;
        if(isset($json->body[0])){
            $d->body = $json->body[0];
        }

        return $d;
    }

    function test(Request $request)
    {
        $v = $request->all();
        $ambiente = '';
        if (!isset($v['token'])) {
            return response()->json(array('status' => 'error', 'mensaje' => 'No esta definido el token.'),400);
        }
        if ($v['token']=='') {
            return response()->json(array('status' => 'error', 'mensaje' => 'Defina un token para continuar.'),400);
        }

        if (isset($v['ambiente'])) {
            if ($v['ambiente'] == 'prod') {
                $ambiente = 'prod';
            }
            if ($v['ambiente'] == 'test') {
                $ambiente = 'test';
            }
            if ($ambiente == '') {
                return response()->json(array('status' => 'error', 'mensaje' => 'El ambiente seleccionado no existe'),400);

            }
        } else {
            return response()->json(array('status' => 'error', 'mensaje' => 'No esta definido el ambiente de respuesta.'),400);
        }

        $j = $this->getJsonFactura($v["codigo_dte"], $v['token'],$ambiente);
        if (is_null($j)) {
            return response()->json(array('status' => 'error', 'mensaje' => 'Token invalido.'),400);
        }
        if (isset($j->error)) {
            return response()->json(array('status' => 'error', 'mensaje' => 'Token no autorizado.'),401);
        }


        $pdf = $this->traerPDF($v["codigo_dte"], $v["token"],$ambiente);

        return response()->json(array('pdf' => $pdf, 'json' => $j, 'status' => 'success'),200);
        
    }
}
