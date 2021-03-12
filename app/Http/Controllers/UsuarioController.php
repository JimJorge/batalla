<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

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
}
