<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Time;

class UserController extends Controller
{
    // Método que recibe un código y retorna un usuario
    public function show(Request $request)
    {
        $user = $this->validateCode($request);

        return response()->json($user);
    }

    /**
     * Actualiza la información de un usuario.
     * 
     * @param request Petición recibida del cliente.
     * @returns Mensaje json de error si no se encuentra un usuario.
     * @returns La información del usuario si se encuentra.
     */
    public function update(Request $request)
    {
        $user = $this->validateCode($request);

        $user->update([
            'name' => $request->name,
            'code' => $request->new_code
        ]);
        $user->save();
        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ]);
    }

    /**
     * Elimina un usuario.
     * 
     * @param request Petición recibida del cliente.
     * @returns Mensaje json de error si no se encuentra un usuario.
     * @returns Mensaje json de éxito si se elimina el usuario.
     */
    public function destroy(Request $request)
    {
        return response()->json([
            'message' => 'La eliminación de usuarios no está disponible en este momento'
        ], 403);
        // ESTO FUNCIONA, SOLO ESTÁ COMENTADO PARA EVITAR PROBLEMAS
        // $user = $this->validateCode($request);

        // $user->delete();

        // return response()->json([
        //     'message' => 'Usuario eliminado correctamente'
        // ]);
    }

    /**
     * Valida el código recibido desde la petición del cliente.
     * 
     * @param request Petición recibida del cliente.
     * @returns Mensaje json de error si no se encuentra un usuario.
     * @returns La información del usuario si se encuentra.
     */
    private function validateCode($request)
    {
        // Recuperamos la compañía que pertenece al token de la petición
        $company = $request->user()->id;

        // Comprobamos si el código de la petición pertenece a algún empleado de la compañia
        $user = User::where('code', $request->code)
            ->where('company_id', $company)
            ->first();
        // Si no existe el código, devolvemos un mensaje de error
        if (!$user) {
            abort(response()->json([
                'message' => 'Este código no pertenece a ningún empleado de la compañia'
            ], 400));
        }

        // Si existe el código, devolvemos la información del usuario
        return $user;
    }

    /**
     * Retorna un json de todos los usuarios de la compañia logeada 
     * junto a su último registro en la tabla times
     * 
     * @param request Petición recibida del cliente.
     * @returns Información de todos los usuarios de la compañia logeada.
     */
    public function index(Request $request) 
    {
        $company = $request->user()->id;

        $users = User::where('company_id', $company)
            ->where('status', 'enabled')
            ->with('lastAction')
            ->get();

        return response()->json([
            'users' => $users
        ]);
    }


}
