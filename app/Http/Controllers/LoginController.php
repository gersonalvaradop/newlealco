<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        $data=[];
        $data['actualizar']="";

        if (config('app.env') === 'production') {
            if (strpos(url(''), "https") === false) {
                //header('location: https://www.dteguard.com/facturasv/login');
                $data['actualizar'] = "<script>window.location.reload(true)</script>";
            } 
            URL::forceScheme('https');
        }
        if (Auth::check()) {
            return redirect('/');
        }
        $data['logo']=Companies::first()->logo;
        return view('login',$data);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    public function loginDo(Request $request)
    {
        $res = [];
        $data = $request->all();
        //Auth::logout();

        if ($data['email']=='CONNECTAPI') {
            $res['login'] = false;
            $res['message'] = "usuario no autorizado";
            echo json_encode($res);
            die();
        }


        $r = Auth::attempt(array('email' => $data['email'], 'password' => $data['password']));


        if (Auth::check()) {
            $res['login'] = true;
            $res['message'] = "Bienvenido";
            echo json_encode($res);
        } else {
            $res['login'] = false;
            $res['message'] = "Correo o password incorrecto";
            echo json_encode($res);
        }
    }

    public function loginDoApi(Request $request)
    {
        $res = [];
        $data = $request->all();
        if(!isset($data['email'])){
            return response()->json(['error' => 0,'mensaje'=>'Parametro email no agregado'], 422);
        }

        if(!isset($data['password'])){
            return response()->json(['error' => 0,'mensaje'=>'Parametro password no agregado'], 422);
        }

        $r = Auth::attempt(array('email' => $data['email'], 'password' => $data['password']));

        // Generar token de acceso
        if (Auth::check()) {
            $res['login'] = true;
            $res['message'] = "Bienvenido";
            return response()->json($res, 200);
            //echo json_encode($res);
        } else {
            $res['login'] = false;
            $res['message'] = "Correo o password incorrecto";
            return response()->json($res, 422);
        }
        
    }
}
