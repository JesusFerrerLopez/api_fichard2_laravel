<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;

class TimeController extends Controller
{
    // Listado de t.odos los tiempos
    public function index()
    {
        // return 'hola mundo';
        return Time::all();
    }

    // Método para iniciar la jornada
    public function play(Request $request)
    {
        $user = $this->validateCode($request);

        // Recuperamos la última entrada de la tabla de tiempos del usuario
        $lastTime = Time::where('user_id', $user->id)->orderBy('datetime', 'desc')->first();

        // Si el usuario ya tiene una jornada iniciada, entonces vamos a responder con un error
        if ($lastTime && $lastTime->type == 'play') {
            return response()->json([
                'message' => 'Ya tienes una jornada iniciada',
            ], 400);
        }

        // Si el usuario tiene una jornada pausada, entonces vamos a reanudarla
        if ($lastTime && $lastTime->type === 'pause') {
            $time = new Time();
            $time->user_id = $user->id;
            $time->type = 'play';
            $time->datetime = now();
            $time->time = now()->format('H:i:s');
            $time->date = now()->format('Y-m-d');
            $time->save();

            return response()->json([
                'message' => 'Jornada reanudada',
            ]);
        }

        // Si el usuario no tiene una jornada iniciada, entonces vamos a iniciarla
        $time = new Time();
        $time->user_id = $user->id;
        $time->type = 'play';
        $time->datetime = now();
        $time->time = now()->format('H:i:s');
        $time->date = now()->format('Y-m-d');
        $time->save();

        return response()->json(['message' => 'Jornada iniciada'], 200);
    }

    // Método para pausar la jornada
    public function pause(Request $request)
    {
        $user = $this->validateCode($request);

        // Recuperamos la última entrada de la tabla de tiempos del usuario
        $lastTime = Time::where('user_id', $user->id)->orderBy('datetime', 'desc')->first();

        // Si el usuario no tiene una jornada iniciada, entonces vamos a responder con un error
        if (!$lastTime || $lastTime->type !== 'play') {
            return response()->json([
                'message' => 'No tienes una jornada iniciada',
            ], 400);
        }

        // Si el usuario ya tiene una jornada pausada, entonces vamos a responder con un error
        if ($lastTime->type === 'pause') {
            return response()->json([
                'message' => 'Ya tienes una jornada pausada',
            ], 400);
        }

        // Si el usuario tiene una jornada iniciada, entonces vamos a   la
        $time = new Time();
        $time->user_id = $user->id;
        $time->type = 'pause';
        $time->datetime = now();
        $time->time = now()->format('H:i:s');
        $time->date = now()->format('Y-m-d');
        $time->pause_reason = $request->pause_reason;
        $time->save();

        return response()->json(['message' => 'Jornada pausada'], 200);
    }

    // Método para finalizar la jornada
    public function stop(Request $request)
    {
        $user = $this->validateCode($request);

        // Recuperamos la última entrada de la tabla de tiempos del usuario
        $lastTime = Time::where('user_id', $user->id)->orderBy('datetime', 'desc')->first();

        // Si el usuario no tiene una jornada iniciada, entonces vamos a responder con un error
        if (!$lastTime || $lastTime->type !== 'play') {
            // En función del type, mandamos un mensaje u otro
            if ($lastTime && $lastTime->type === 'pause') {
                $message = 'Tienes una jornada pausada';
            }
            else {
                $message = 'No tienes una jornada iniciada';
            }

            return response()->json([
                'message' => $message,
            ], 400);
        }

        // Si el usuario tiene una jornada iniciada, entonces vamos a finalizarla
        $time = new Time();
        $time->user_id = $user->id;
        $time->type = 'stop';
        $time->datetime = now();
        $time->time = now()->format('H:i:s');
        $time->date = now()->format('Y-m-d');
        $time->save();

        return response()->json(['message' => 'Jornada finalizada'], 200);
    }

    // Método que devuelve un resumen de las jornadas de un usuario según fechas
    public function resumen(Request $request) {
        $user = $this->validateCode($request);

        // validamos los campos que aún faltan por validar
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Vamos a recuperar las jornadas del usuario en el rango de fechas
        $times = Time::where('user_id', $user->id)
            ->where('date', '>=', $request->start_date)
            ->where('date', '<=', $request->end_date)
            ->orderBy('date', 'asc')
            ->select(['datetime', 'type'])
            ->get();

        // Devolvemos la información
        return response()->json([
            'times' => $times,
        ]);
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

}
