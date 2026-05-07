<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Career;

class SectionController extends Controller
{
    public function students()
    {
        $students = User::latest()->paginate(10);
        $careers = Career::all();
        return view('sections.students', compact('students', 'careers'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'career_id' => 'required|exists:careers,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'career_id' => $request->career_id,
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'terms_accepted' => true,
        ]);

        \App\Models\Notification::create([
            'title' => 'Nuevo Estudiante',
            'message' => "Se ha registrado a {$request->name} en el sistema.",
            'type' => 'success',
        ]);

        return back()->with('success', 'Estudiante registrado correctamente. Contraseña temporal: password123');
    }

    public function destroyStudent(User $user)
    {
        $name = $user->name;
        $user->delete();

        \App\Models\Notification::create([
            'title' => 'Estudiante Eliminado',
            'message' => "Se ha eliminado el registro de {$name} del sistema.",
            'type' => 'warning',
        ]);

        return back()->with('success', 'Estudiante eliminado correctamente.');
    }

    public function classrooms()
    {
        $classrooms = Classroom::latest()->get();
        return view('sections.classrooms', compact('classrooms'));
    }

    public function storeClassroom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Classroom::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'is_active' => true,
        ]);

        \App\Models\Notification::create([
            'title' => 'Nueva Aula Creada',
            'message' => "Se ha habilitado el aula {$request->name} con capacidad para {$request->capacity} alumnos.",
            'type' => 'success',
        ]);

        return back()->with('success', 'Aula creada exitosamente.');
    }

    public function destroyClassroom(Classroom $classroom)
    {
        $name = $classroom->name;
        $classroom->delete();

        \App\Models\Notification::create([
            'title' => 'Aula Eliminada',
            'message' => "El aula {$name} ha sido retirada del sistema.",
            'type' => 'warning',
        ]);

        return back()->with('success', 'Aula eliminada correctamente.');
    }

    public function careers()
    {
        $careers = Career::withCount('users')->get();
        return view('sections.careers', compact('careers'));
    }

    public function storeCareer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:careers,name',
        ]);

        Career::create(['name' => $request->name]);

        \App\Models\Notification::create([
            'title' => 'Nueva Carrera',
            'message' => "Se ha añadido la carrera de {$request->name} al catálogo.",
            'type' => 'info',
        ]);

        return back()->with('success', 'Carrera creada correctamente.');
    }

    public function destroyCareer(Career $career)
    {
        $name = $career->name;
        // Check if there are users assigned
        if ($career->users()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la carrera porque tiene estudiantes asignados.');
        }

        $career->delete();

        \App\Models\Notification::create([
            'title' => 'Carrera Eliminada',
            'message' => "La carrera {$name} ha sido eliminada.",
            'type' => 'warning',
        ]);

        return back()->with('success', 'Carrera eliminada correctamente.');
    }

    public function exportStudents()
    {
        $students = User::with('career')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="estudiantes_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, ['ID', 'Nombre', 'Correo', 'Carrera', 'Registro vía']);
            foreach ($students as $student) {
                fputcsv($file, [
                    '#' . str_pad($student->id, 4, '0', STR_PAD_LEFT),
                    $student->name,
                    $student->email,
                    $student->career ? $student->career->name : 'No Asignada',
                    $student->google_id ? 'Google' : 'Formulario',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportClassrooms()
    {
        $classrooms = Classroom::all();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="aulas_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($classrooms) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID', 'Nombre del Aula', 'Capacidad', 'Estado']);
            foreach ($classrooms as $c) {
                fputcsv($file, [
                    '#CL-' . str_pad($c->id, 3, '0', STR_PAD_LEFT),
                    $c->name,
                    $c->capacity,
                    $c->is_active ? 'Disponible' : 'Ocupada',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function enrollments()
    {
        return view('sections.enrollments');
    }

    public function payments()
    {
        return view('sections.payments');
    }

    public function settings()
    {
        return view('sections.settings');
    }
}
