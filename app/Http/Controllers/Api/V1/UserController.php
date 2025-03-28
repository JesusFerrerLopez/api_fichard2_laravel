<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Método que recibe un código y retorna un usuario
    public function show(Request $request)
    {
        // Vamos a validar la petición
        $request->validate([
            'code' => 'required|exists:users,code',
        ]);

        // Vamos a recuperar al usuario que corresponde al código
        $user = User::where('code', $request->code)->first();

        return response()->json($user);
    }
}
