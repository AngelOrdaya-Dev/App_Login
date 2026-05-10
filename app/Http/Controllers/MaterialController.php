<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $materials = Material::with(['course', 'user'])->latest()->get();
            $courses = Course::all();
        } elseif ($user->isTeacher()) {
            // Materiales de los cursos que dicta
            $courseIds = $user->taughtCourses()->pluck('id');
            $materials = Material::whereIn('course_id', $courseIds)->with(['course', 'user'])->latest()->get();
            $courses = $user->taughtCourses;
        } else {
            // Materiales de los cursos donde está matriculado
            // Asumiendo que el estudiante tiene cursos vinculados (vía career o similar)
            // Por simplicidad, mostraremos materiales de su carrera
            $careerId = $user->career_id;
            $materials = Material::whereHas('course', function($q) use ($careerId) {
                $q->where('career_id', $careerId);
            })->with(['course', 'user'])->latest()->get();
            $courses = Course::where('career_id', $careerId)->get();
        }

        return view('sections.library', compact('materials', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/materials');
            $url = Storage::url($path);

            Material::create([
                'title' => $request->title,
                'type' => $request->type,
                'course_id' => $request->course_id,
                'file_path' => $url,
                'user_id' => Auth::id(),
            ]);

            return back()->with('success', 'Material subido exitosamente.');
        }

        return back()->with('error', 'No se pudo subir el archivo.');
    }

    public function destroy(Material $material)
    {
        // Solo el admin o el que lo subió puede borrar
        if (!Auth::user()->isAdmin() && $material->user_id !== Auth::id()) {
            abort(403);
        }

        // Borrar archivo físico
        $path = str_replace('/storage/', 'public/', $material->file_path);
        Storage::delete($path);
        
        $material->delete();

        return back()->with('success', 'Material eliminado correctamente.');
    }
}
