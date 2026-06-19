<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Career;
use App\Models\Classroom;
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where(function($q){ $q->where('role', 'student')->orWhereNull('role'); })->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCareers = Career::count();
        $totalClassrooms = Classroom::count();
        $activeClassrooms = Classroom::where('is_active', true)->count();
        
        $enrolledStudents = User::where(function($q){ $q->where('role', 'student')->orWhereNull('role'); })
            ->whereNotNull('career_id')
            ->count();
        $enrolledPercentage = $totalStudents > 0 ? round(($enrolledStudents / $totalStudents) * 100) : 0;

        $careers = Career::withCount('users')->get();
        $careerStats = [
            'labels' => $careers->pluck('name')->toArray(),
            'data' => $careers->pluck('users_count')->toArray(),
        ];

        // Datos de inscripciones mensuales (simulados por ahora pero estructurados)
        $monthlyStats = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            'data' => [12, 19, 15, 25, 22, 30] // En una app real esto sería una query con groupByMonth
        ];

        // Student Analytics
        $studentGrades = [];
        $user = auth()->user();
        if ($user && !$user->isAdmin() && !$user->isTeacher()) {
            // Es estudiante
            $grades = \App\Models\Grade::with('course')->where('user_id', $user->id)->get();
            $studentGrades = [
                'labels' => $grades->pluck('course.name')->toArray(),
                'data' => $grades->pluck('score')->toArray(),
            ];
        }

        return view('dashboard', compact(
            'totalStudents', 
            'totalTeachers',
            'totalCareers', 
            'totalClassrooms', 
            'activeClassrooms', 
            'enrolledPercentage', 
            'careers',
            'careerStats',
            'monthlyStats',
            'studentGrades'
        ));
    }
}
