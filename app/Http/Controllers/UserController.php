<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    public function getAllUsers() {
        $users = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($users, 200);
    }

    public function createUser(Request $request) {

        try{
            $user = new User;
            $user->nome = $request->name;
            $user->email = $request->email;
            $user->telefone = Controller::onlyNumbers($request->fone);
            $user->id_curso = $request->id_curso;
            $user->save();

            return response()->json([
                "message" => "User saved!"
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getUser($id) {
        if (User::where('id', $id)->exists()) {
            $user = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($user, 200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    public function updateUser(Request $request, $id) {
        try{
            if (User::where('id', $id)->exists()) {
                $user = User::find($id);
                $vals = [
                    'nome' => is_null($request->name) ? $user->name : $request->name,
                    'email' => is_null($request->email) ? $user->email : $request->email,
                    'telefone' => Controller::onlyNumbers( is_null($request->fone) ? $user->telefone : $request->fone ),
                    'id_curso' => is_null($request->id_curso) ? $user->id_curso : $request->id_curso
                ];

                User::where('id', $id)->update($vals);

                return response()->json([
                    "message" => "User updated!"
                ], 200);
            } else {
                return response()->json([
                    "message" => "User not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }
  
      public function deleteUser($id) {
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->delete();
    
            return response()->json([
                "message" => "User deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
}