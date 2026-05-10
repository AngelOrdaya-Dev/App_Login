<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Career;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json(['students' => [], 'careers' => []]);
        }

        $user = $request->user();

        // Solo los administradores pueden buscar estudiantes y carreras globalmente
        if (!$user || !$user->isAdmin()) {
            return response()->json([
                'students' => [],
                'careers' => []
            ]);
        }

        // Buscar estudiantes por nombre o email
        $students = User::where(function($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })
                        ->where(function($q) {
                            $q->where('role', 'student')->orWhereNull('role');
                        })
                        ->take(5)
                        ->get(['id', 'name', 'email', 'avatar']);

        // Buscar docentes por nombre o email
        $teachers = User::where(function($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })
                        ->where('role', 'teacher')
                        ->take(5)
                        ->get(['id', 'name', 'email', 'avatar']);

        // Buscar carreras por nombre
        $careers = Career::where('name', 'LIKE', "%{$query}%")
                         ->take(3)
                         ->get(['id', 'name']);

        return response()->json([
            'students' => $students,
            'teachers' => $teachers,
            'careers' => $careers
        ]);
    }
}
