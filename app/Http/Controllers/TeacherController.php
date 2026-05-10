<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function courses()
    {
        $courses = Auth::user()->taughtCourses()->with('career')->get();
        return view('sections.teacher_courses', compact('courses'));
    }
}
