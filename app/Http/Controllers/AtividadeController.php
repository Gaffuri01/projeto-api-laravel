<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Atividade;
use App\Models\AtividadeXAnexo;
use App\Models\AtividadeXCurso;
use App\Http\Controllers\Controller;

class AtividadeController extends BaseController
{
    public function getAllAtividades() {
        $atividades = Atividade::get()->toJson(JSON_PRETTY_PRINT);
        return response($atividades, 200);
    }

    public function createAtividade(Request $request) {
        try{
            $vals = [
                'nome' => $request->name,
                'valor' => Controller::onlyNumbers($request->valor)
            ];

            $id_atividade = Atividade::insertGetId($vals);

            if(isset($request->atividade)){
                foreach($request->atividade as $data){
                    AtividadeXCurso::insert(['id_atividade' => $id_atividade, 'id_curso' => $data]);
                }
            }

            $anexo = $this->saveAnexo();

            if($anexo == true){
                return response()->json([
                    "message" => "Atividade saved!"
                ], 201);
            } else{
                throw "Error saved anexo!";
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public static function saveAnexo(){
        try {
            // print_r($_FILES);
            // die;
            if(!is_null($_FILES['arquivo']['name'])){
                $_UP['pasta'] = '../public/anexos';
                $_UP['extensoes'] = array('jpg', 'jpeg', 'pdf', 'png', 'gif', 'zip');
        
                if ($_FILES['arquivo']['error'] != 0) {
                    die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
                    exit; // Para a execução do script
                }
            
                $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
                if (array_search($extensao, $_UP['extensoes']) === false) {
                    die ("Essa extenção não é aceita");
                }
        
                $nome_final =$_FILES['arquivo']['name']."_". time().$extensao;
        
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAtividade($id) {
        if (Atividade::where('id', $id)->exists()) {
            $atividade = Atividade::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($atividade, 200);
        } else {
            return response()->json([
                "message" => "Curso not found"
            ], 404);
        }
    }

    public function getAllCursosAtividade($id){
        if (AtividadeXCurso::where('id_atividade', $id)->exists()) {
            $atividade = AtividadeXCurso::where('id_atividade', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($atividade, 200);
        } else {
            return response()->json([
                "message" => "Curso not found"
            ], 404);
        }
    }

    public function updateAtividade(Request $request, $id) {
        try{
            if (Atividade::where('id', $id)->exists()) {
                $atividade = Atividade::find($id);
                $vals = [
                    'nome' => is_null($request->name) ? $atividade->name : $request->name,
                    'valor' => is_null($request->valor) ? $atividade->valor : $request->valor
                ];

                Atividade::where('id', $id)->update($vals);

                if(isset($request->atividade)){
                    AtividadeXCurso::where('id_atividade', $id)->delete();
            
                    foreach($request->atividade as $data){
                        AtividadeXCurso::insert(['id_atividade' => $id, 'id_curso' => $data]);
                    }
                }

                $anexo = $this->saveAnexo();

                if($anexo == true){
                    return response()->json([
                        "message" => "Atividade updated!"
                    ], 201);
                } else{
                    throw "Error saved anexo!";
                }
            } else {
                return response()->json([
                    "message" => "Atividade not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }
  
      public function deleteAtividade($id) {
        if(Atividade::where('id', $id)->exists()) {
            $atividade = Atividade::find($id);
            $atividade->delete();
    
            return response()->json([
                "message" => "Atividade deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Atividade not found"
            ], 404);
        }
    }
}