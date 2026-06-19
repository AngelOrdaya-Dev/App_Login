<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function show(Course $course)
    {
        $posts = ForumPost::with('user')->where('course_id', $course->id)->oldest()->get();
        return view('sections.forum', compact('course', 'posts'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        ForumPost::create([
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back();
    }
}
