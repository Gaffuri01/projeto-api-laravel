<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Curso;
use App\Http\Controllers\Controller;

class CursoController extends BaseController
{
    public function getAllCursos() {
        $cursos = Curso::get()->toJson(JSON_PRETTY_PRINT);
        return response($cursos, 200);
    }

    public function createCurso(Request $request) {

        try{
            $curso->nome = $request->name;
            $curso->setor = $request->setor;
            $curso->duracao = Controller::onlyNumbers($request->duracao);
            $vals = [
                'nome' => $request->name,
                'setor' => $request->setor,
                'duracao' => Controller::onlyNumbers( $request->duracao )
            ];
            Curso::where('id', $id)->update($vals);
            
    
            return response()->json([
                "message" => "Curso saved!"
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCurso($id) {
        if (Curso::where('id', $id)->exists()) {
            $curso = Curso::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($curso, 200);
        } else {
            return response()->json([
                "message" => "Curso not found"
            ], 404);
        }
    }

    public function updateCurso(Request $request, $id) {
        try{
            if (Curso::where('id', $id)->exists()) {
                $curso = Curso::find($id);
                $vals = [
                    'nome' => is_null($request->name) ? $curso->name : $request->name,
                    'setor' => is_null($request->setor) ? $curso->setor : $request->setor,
                    'duracao' => Controller::onlyNumbers( is_null($request->duracao) ? $curso->duracao : $request->duracao )
                ];

                Curso::where('id', $id)->update($vals);

                return response()->json([
                    "message" => "Curso updated!"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Curso not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }
  
      public function deleteCurso($id) {
        if(Curso::where('id', $id)->exists()) {
            $curso = Curso::find($id);
            $curso->delete();
    
            return response()->json([
                "message" => "Curso deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Curso not found"
            ], 404);
        }
    }
}