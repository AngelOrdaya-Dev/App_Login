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
        $totalStudents = User::count();
        $totalCareers = Career::count();
        $totalClassrooms = Classroom::count();
        $activeClassrooms = Classroom::where('is_active', true)->count();
        
        $enrolledStudents = User::whereNotNull('career_id')->count();
        $enrolledPercentage = $totalStudents > 0 ? round(($enrolledStudents / $totalStudents) * 100) : 0;

        return view('dashboard', compact('totalStudents', 'totalCareers', 'totalClassrooms', 'activeClassrooms', 'enrolledPercentage'));
    }
}
