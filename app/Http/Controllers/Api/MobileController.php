<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Appointment;

class MobileController extends Controller
{
    // 1. LOGIN DE LA APP (Devuelve un Token seguro)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Borramos tokens viejos para no acumular basura
            $user->tokens()->delete();
            
            // Creamos un nuevo token para Flutter
            $token = $user->createToken('FlutterApp')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Bienvenido a Mimate App',
                'user' => $user,
                'token' => $token, // <--- FLUTTER DEBE GUARDAR ESTO
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Credenciales incorrectas'], 401);
    }

    // 2. LISTA DE SERVICIOS (Público)
    public function services()
    {
        // Retorna JSON puro con todos los servicios
        return response()->json(Service::all());
    }

    // 3. MIS CITAS (Protegido con Token)
    public function myAppointments(Request $request)
    {
        // Obtenemos el usuario gracias al Token que envía la App
        $user = $request->user();

        // Buscamos las citas de este paciente
        // (Asumiendo que el paciente tiene el mismo email que el usuario)
        $appointments = Appointment::with('service')
            ->whereHas('patient', function ($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json($appointments);
    }
}