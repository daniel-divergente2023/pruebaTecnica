<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Code\Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\CouserUser;



class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return Inertia::render('cursos/index', ['courses' => $courses]);
       
    }

    public function getViewCursos() {

        if (Auth::check()) {
            $user = Auth::user();
            $token = csrf_token();
            return Inertia::render('cursos/CrearCursos', [
                'csrfToken' => $token
            ]);
        } else {
            
            return redirect()->route('login');
        }
    }

    public function getViewCusrsosAsosiados() {

        if (Auth::check()) {

            $users = User::all();
            $courses = Course::all();
            $token = csrf_token();

            return Inertia::render('cursos/AsociarCursos', [
                'csrfToken' => $token,
                'users' => $users,
                'courses' => $courses,
            ]);
        } else {
            
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        try {
            
            $course = Course::create([
                'name' => $request->nombre,
                'duration_hours' => $request->duracion,
            ]);


            return response()->json($course, 201);
        } catch (\Exception $e) {
            // Manejar cualquier excepción capturada durante la creación del curso
            return response()->json(['message' => 'Error al crear el curso: ' . $e->getMessage()], 500);
        }
    }

    public function storeAsoiado(Request $request)
    {

        try {
            
            $userCourses = $request->input('userCourses');

            foreach ($userCourses as $association) {
               
                $asociado = new CouserUser();
                $asociado->course_id = $association['course'];
                $asociado->user_id = $association['user'];
            
                $asociado->save();
            }
    
            // Retorna una respuesta de éxito
            return response()->json(['message' => 'Asociaciones guardadas correctamente'], 200);
        } catch (\Exception $e) {

            dd($e);
            // Retorna una respuesta de error si ocurre algún problema
            return response()->json(['message' => 'Error al guardar las asociaciones'], 500);
        }
    }
    
}

