<?php

namespace App\Http\Controllers;

use App\Models\Tablero;
use Illuminate\Http\Request;

class TableroController extends Controller
{
    // Crear Tablero
    public function crearTablero (){
        $tablero = new Tablero();
        $tablero->codigo = "";
        $tablero->usuario1_id = "";
        $tablero->usuario2_id = "";
        $tablero->estatus = "";
        $tablero->ganador_id = "";
        $verificar = $tablero->save();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Editar Tablero
    public function editar ($id){
        $tablero = Tablero::find($id);
        $tablero->codigo = "";
        $tablero->usuario1_id = "";
        $tablero->usuario2_id = "";
        $tablero->estatus = "";
        $tablero->ganador_id = "";
        $verificar = $tablero->save();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Eliminar Tablero
    public function eliminarTablero ($id){
        $tablero = Tablero::find($id);
        $verificar = $tablero->delete();
        if($verificar){
            echo json_encode(["estatus" => "success"]);
        }else{
            echo json_encode(["estatus" => "error"]);
        }
    }

    // Mostrar Tablero
    public function mostrarTablero ($id){
        $tablero = Tablero::find($id);
        if($tablero)
            echo json_encode(["estatus" => "success","tablero" => $tablero]);
        else
            echo json_encode(["estatus" => "error"]);

    }

    // Mostrar Todo Tablero
    public function mostrarTodoTablero ($id){
        $tableros = Tablero::get();
        if($tableros)
            echo json_encode(["estatus" => "success","tablero" => $tableros]);
        else
            echo json_encode(["estatus" => "error"]);

    }
}
