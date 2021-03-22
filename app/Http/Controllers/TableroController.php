<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Tablero;
use App\Models\Tablero_Barcos;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TableroController extends Controller
{
    // Crear Tablero
    public function crearTablero (Request $request){
        $tablero = new Tablero();
        $tablero->codigo = $request->codigo;
        $tablero->usuario1_id = $request->idUsuario;
        $tablero->usuario2_id = $request->idUsuario;
        $tablero->estatus = "nuevo";
        $tablero->ganador_id = $request->idUsuario;
        $verificar = $tablero->save();
        if($verificar){
            return redirect()->route('usuario.detalle.tablero',['codigo' => $tablero->codigo]);
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

    public function crearCodigotablero(){
        // -- :D
        $verificar = 1;
        do{
            $codigo = Herramienta::crearCodigo(5);
            $tablero = Tablero::where('codigo',$codigo)->first();
            if (!$tablero)
                $verificar = 0;

        }while( $verificar == 1);

        echo json_encode(["estatus" => "success", "codigo" => $codigo]);
    }

    public function detalleTablero($codigo){
        $tablero = Tablero::where('codigo',$codigo)->first();
        if(!$tablero){
            return redirect()->route('usuario.menu');
        }
        $tableroBarco = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id",session('usuario')->id)->first();
        $tableroBarco2 = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id","!=",session('usuario')->id)->first();
        if($tableroBarco2){
            $usuario = Usuario::find($tableroBarco2->usuario_id);
            $tableroBarco2->nombreUsuario = $usuario->correo;
        }

        return view("tablero",["tablero" => $tablero,"tableroBarco" => $tableroBarco, "tableroBarco2" => $tableroBarco2]);
    }

    public function agregarBarcos($codigo,$conjuntoBarcos){

        $tablero = Tablero::where("codigo",$codigo)->first();
        $ubicaciones = explode(",",$conjuntoBarcos);

        $tableroBarco = Tablero_Barcos::where('tablero_id',$tablero->id)->where("usuario_id",session('usuario')->id)->first();
        if(!$tableroBarco){
            $tableroBarco = new Tablero_Barcos();
            $tableroBarco->tablero_id = $tablero->id;
            $tableroBarco->usuario_id = session('usuario')->id;
            $tableroBarco->barco1 = $ubicaciones[0];
            $tableroBarco->barco2 = $ubicaciones[1];
            $tableroBarco->barco3 = $ubicaciones[2];
            $tableroBarco->save();

            $varificarEstatus = Tablero_Barcos::where('tablero_id',$tablero->id)->count();
            if($varificarEstatus < 2)
                $tablero->estatus = "activo";
            else
                $tablero->estatus = "jugando";

            $tablero->save();
            echo json_encode(["estatus" => "succes","mensaje" => "Barcos guardados correctamente"]);
        }
    }

    public function buscarBarcosTablero ($codigo){
        $tablero = Tablero::where("codigo",$codigo)->first();
        if(!$tablero)
            return json_encode(["estatus" => "error","mensaje" => "No fue posible encontrar el tablero"]);

        $posicionesBarcos = Tablero_Barcos::where('tablero_id',$tablero->id)->get();

        return json_encode(["tablero" => $tablero, "posicionesBarcos" => $posicionesBarcos]);
    }
}
