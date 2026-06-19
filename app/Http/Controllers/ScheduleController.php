<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Muestra el horario semanal.
     * Admin: ve todos. Docente: sus cursos. Alumno: su carrera.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $schedules = Schedule::with(['course.teacher', 'classroom'])->get();
            $courses = Course::with('career')->get();
            $classrooms = Classroom::where('is_active', true)->get();
        } elseif ($user->isTeacher()) {
            $courseIds = $user->taughtCourses()->pluck('id');
            $schedules = Schedule::with(['course.teacher', 'classroom'])->whereIn('course_id', $courseIds)->get();
            $courses = collect();
            $classrooms = collect();
        } else {
            // Estudiante: horario de su carrera
            $courseIds = Course::where('career_id', $user->career_id)->pluck('id');
            $schedules = Schedule::with(['course.teacher', 'classroom'])->whereIn('course_id', $courseIds)->get();
            $courses = collect();
            $classrooms = collect();
        }

        // Agrupar por día (para la vista clásica o listado)
        $grid = [];
        for ($day = 1; $day <= 6; $day++) {
            $grid[$day] = $schedules->where('day_of_week', $day)->sortBy('start_time')->values();
        }

        // Preparar eventos para FullCalendar
        $calendarEvents = [];
        $dayMapping = [
            1 => 1, // Lunes
            2 => 2, // Martes
            3 => 3, // Miércoles
            4 => 4, // Jueves
            5 => 5, // Viernes
            6 => 6, // Sábado
        ];

        foreach ($schedules as $schedule) {
            $calendarEvents[] = [
                'title' => $schedule->course->name . ' - ' . $schedule->classroom->name,
                'startTime' => $schedule->start_time,
                'endTime' => $schedule->end_time,
                'daysOfWeek' => [$dayMapping[$schedule->day_of_week]],
                'color' => 'var(--accent-red)',
                'extendedProps' => [
                    'course_id' => $schedule->course_id,
                    'classroom' => $schedule->classroom->name,
                    'teacher' => $schedule->course->teacher ? $schedule->course->teacher->name : 'N/A',
                    'schedule_id' => $schedule->id
                ]
            ];
        }

        return view('sections.schedules', compact('grid', 'courses', 'classrooms', 'calendarEvents'));
    }

    /**
     * Admin: crea un nuevo horario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week'  => 'required|integer|between:1,6',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
        ]);

        try {
            Schedule::create($request->only('course_id', 'classroom_id', 'day_of_week', 'start_time', 'end_time'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Conflicto de horario: esa aula ya está ocupada en ese día y hora.');
        }

        return back()->with('success', 'Horario registrado exitosamente.');
    }

    /**
     * Admin: elimina un horario.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Horario eliminado.');
    }

    // ──────────────────────────────────────────
    // ASISTENCIA
    // ──────────────────────────────────────────

    /**
     * Docente: muestra la lista de alumnos de un curso para pasar asistencia.
     */
    public function attendance(Course $course)
    {
        $user = Auth::user();

        // Solo el docente asignado o un admin puede acceder
        if (!$user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403);
        }

        $students = User::where(function ($q) {
            $q->where('role', 'student')->orWhereNull('role');
        })->where('career_id', $course->career_id)->orderBy('id')->get();

        $today = now()->toDateString();
        $existing = Attendance::where('course_id', $course->id)
            ->where('date', $today)
            ->pluck('status', 'user_id');

        return view('sections.attendance', compact('course', 'students', 'today', 'existing'));
    }

    /**
     * Docente: guarda la asistencia del día.
     */
    public function saveAttendance(Request $request, Course $course)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403);
        }

        $date = $request->input('date', now()->toDateString());
        $statuses = $request->input('status', []);

        foreach ($statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                ['user_id' => $studentId, 'course_id' => $course->id, 'date' => $date],
                ['status' => $status]
            );
        }

        return back()->with('success', 'Asistencia guardada correctamente.');
    }
}
