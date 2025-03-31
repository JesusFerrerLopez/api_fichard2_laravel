<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        
        // Vamos a validar la petición
        $request->validate([
            'code' => 'required|exists:users,code',
        ]);
        
        // Vamos a recuperar al usuario que corresponde al código
        $user = User::where('code', $request->code)->first();

        // Vamos a verificar si el usuario ya tiene una jornada iniciada
        // 1. Comprobamos si el usuario tiene alguna entrada en la tabla de tiempos
        // 2. Comprobamos el type de la entrada más reciente
        // 3. Si el type es 'start', entonces el usuario ya tiene una jornada iniciada
        // 4. Si el type es 'pause', entonces el usuario tiene una jornada pausada y la vamos a reanudar
        // 5. Si el type es 'stop', entonces el usuario no tiene una jornada iniciada y vamos a iniciarla
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
        // Vamos a validar la petición
        $request->validate([
            'code' => 'required|exists:users,code',
            'pause_reason' => 'required'
        ]);

        // Vamos a recuperar al usuario que corresponde al código
        $user = User::where('code', $request->code)->first();

        // Vamos a verificar si el usuario tiene una jornada iniciada
        // 1. Comprobamos si el usuario tiene alguna entrada en la tabla de tiempos
        // 2. Comprobamos el type de la entrada más reciente
        // 3. Si el type es 'start', entonces el usuario tiene una jornada iniciada y vamos a pausarla
        // 4. Si el type es 'pause', entonces el usuario ya tiene una jornada pausada
        // 5. Si el type es 'stop', entonces el usuario no tiene una jornada iniciada
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

        // Si el usuario tiene una jornada iniciada, entonces vamos a pausarla
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
        // Vamos a validar la petición
        $request->validate([
            'code' => 'required|exists:users,code',
        ]);

        // Vamos a recuperar al usuario que corresponde al código
        $user = User::where('code', $request->code)->first();

        // Vamos a verificar si el usuario tiene una jornada iniciada
        // 1. Comprobamos si el usuario tiene alguna entrada en la tabla de tiempos
        // 2. Comprobamos el type de la entrada más reciente
        // 3. Si el type es 'start', entonces el usuario tiene una jornada iniciada y vamos a finalizarla
        // 4. Si el type es 'pause', entonces el usuario tiene una jornada pausada y vamos a finalizarla
        // 5. Si el type es 'stop', entonces el usuario no tiene una jornada iniciada
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
        // validamos la información recibida
        $request->validate([
            'code' => 'required|exists:users,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Vamos a recuperar al usuario que corresponde al código
        $user = User::where('code', $request->code)
            ->where('company_id', 1)
            ->first();

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
}
