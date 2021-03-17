<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Tablero;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    public function crear()
    {
        $usuario = new Usuario();
        $usuario->correo = "";
        $usuario->password = "";
        $verificar = $usuario->save();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    public function editar($id)
    {
        $usuario = Usuario::find($id);
        $usuario->correo = "";
        $usuario->password = "";
        $verificar = $usuario->save();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    public function mostrar($id)
    {
        $usuario = Usuario::find($id);
        if($usuario){
            echo json_encode(["estatus" => "success","usuario" => $usuario]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    public function mostrarTodo()
    {
        $usuarios = Usuario::get();
        if($usuarios){
            echo json_encode(["estatus" => "success","usuarios" => $usuarios]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    public function eliminar($id)
    {
        $usuario = Usuario::find($id);
        $verificar = $usuario->delete();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    public function bienvenida(){
        return view("bienvenida");
    }

    public function login(){
        return view("login");
    }

    public function registro(){
        return view("registro");
    }

    public function menu(){
        return view("menu");
    }

    public function registroForm(Request $datos){

        if(!$datos->correo || !$datos->password1 || !$datos->pasword2)
            return view("registo",["estatus"=> "error", "mensaje"=> "¡Falta información!"]);

        $usuario = Usuario::where('correo',$datos->correo)->first();
        if($usuario)
            return view("registo",["estatus"=> "error", "mensaje"=> "¡El correo ya se encuentra registrado!"]);

        $correo = $datos->correo;
        $password2 = $datos->password2;
        $password1 = $datos->password1;

        if($password1 != $password2){
            return view("registro",["estatus" => "¡Las contraseñas son diferentes!"]);
        }

        $usuario = new Usuario();
        $usuario->correo =  $correo;
        $usuario->password = bcrypt($password1);
        $usuario->save();
            return view("login",["estatus"=> "success", "mensaje"=> "¡Cuenta Creada!"]);

    }

    public function verificarCredenciales(Request $datos){

        if(!$datos->correo || !$datos->password)
            return view("login",["estatus"=> "error", "mensaje"=> "¡Completa los campos!"]);

        $usuario = Usuario::where("correo",$datos->correo)->first();
        if(!$usuario)
            return view("login",["estatus"=> "error", "mensaje"=> "¡El correo no esta registrado!"]);

        if(!Hash::check($datos->password,$usuario->password))
            return view("login",["estatus"=> "error", "mensaje"=> "¡Datos incorrectos!"]);

        Session::put('usuario',$usuario);

        if(isset($datos->url)){
            $url = decrypt($datos->url);
            return redirect($url);
        }else{
            return redirect()->route('usuario.menu');
        }

    }

    public function cerrarSesion(){
        if(Session::has('usuario'))
            Session::forget('usuario');

        return redirect()->route('cerrar.sesion');
    }

    public function saludo(){
        echo "Ya rifaste";
    }

    public function peticion(){
        echo json_encode(["ok" => ":D"]);
    }

    public function crearTablero(){
        return view('crear-tablero');
    }



}
