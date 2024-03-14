<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Inertia\Inertia;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Code\Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    public function index()
    {

        $users = User::all();
        return Inertia::render('Usuarios/index', [
             'users' => $users
        ]);

    }

    public function getViewUser () {

        if (Auth::check()) {
            $user = Auth::user();
            $token = csrf_token();
            return Inertia::render('Usuarios/CrearUser', [
                'csrfToken' => $token
            ]);
        } else {
            
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {


        try {
            // Validar los datos del formulario
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'rol' => 'required|in:admin,student',
            ]);

         
    
            // Verificar si hay errores de validación
            if ($validator->fails()) {
                // Devolver una respuesta de validación fallida en formato Inertia
                return Redirect::back()->withErrors($validator)->withInput();
            }
    
           
            // Crear y guardar el usuario en la base de datos
            
            $user=User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                 'role' => $request->input('rol'),
            ]);
    
           
            return response()->json($user, 201);
        } catch (\Exception $e) {

            dd($e);
            // Manejar cualquier excepción lanzada durante el proceso
            return Redirect::back()->with('error', 'Hubo un error al procesar la solicitud. Por favor, inténtalo de nuevo más tarde.');
        }
    }
    
}
