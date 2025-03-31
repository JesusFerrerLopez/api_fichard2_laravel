<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    // Método de login
    public function login(Request $request)
    {
        // Validamos la petición
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Verificamos si la compañía existe
        $company = Company::where('email', $request->email)->first();

        // Si no existe la compañía, retornamos un error
        if (!$company) {
            return response()->json(['message' => 'Compañía no encontrada'], 404);
        }

        // Verificamos si la contraseña corresponde a la compañía
        if (!password_verify($request->password, $company->password)) {
            return response()->json(['message' => 'Credenciales incorrectos'], 401);
        }

        // Generamos el token de acceso
        $token = $company->createToken('access_token')->plainTextToken;

        // Retornamos la compañía y el token
        return response()->json([
            'company' => $company,
            'token' => $token
        ]);

        return response()->json($company);
    }
}
