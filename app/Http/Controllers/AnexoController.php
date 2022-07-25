<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\AtividadeXAnexo;
use App\Http\Controllers\Controller;

class AnexoController extends BaseController
{
    public function download($id) {
        if (AtividadeXAnexo::where('id', $id)->exists()) {
            $anexo = AtividadeXAnexo::select('anexo')->where('id', $id)->get();
            
            return response($user, 200);
        } else {
            return response()->json([
                "message" => "Atividade sem anexo"
            ], 404);
        }
    }
}