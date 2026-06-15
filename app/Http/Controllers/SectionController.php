<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Career;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\RecordsAuditLogs;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\PaymentConfirmedMail;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    use RecordsAuditLogs;
    public function students()
    {
        // Obtener solo usuarios que sean estudiantes (role 'student' o null)
        $students = User::where(function($q) {
            $q->where('role', 'student')->orWhereNull('role');
        })->orderBy('id', 'asc')->paginate(10);
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

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'career_id' => $request->career_id,
            'password' => Hash::make('password123'),
            'terms_accepted' => true,
        ]);

        // Enviar Email de Bienvenida
        Mail::to($student->email)->send(new WelcomeMail($student));

        Notification::create([
            'title' => 'Nuevo Estudiante',
            'message' => "Se ha registrado a {$request->name} en el sistema.",
            'type' => 'success',
        ]);

        $this->recordAuditLog('Registro de Estudiante', "Se registró al estudiante {$request->name} ({$request->email})");

        return back()->with('success', 'Estudiante registrado correctamente. Contraseña temporal: password123');
    }

    public function destroyStudent(User $user)
    {
        $name = $user->name;
        $user->delete();

        Notification::create([
            'title' => 'Estudiante Eliminado',
            'message' => "Se ha eliminado el registro de {$name} del sistema.",
            'type' => 'warning',
        ]);

        $this->recordAuditLog('Eliminación de Estudiante', "Se eliminó al estudiante {$name}");

        return back()->with('success', 'Estudiante eliminado correctamente.');
    }

    public function teachers()
    {
        $teachers = User::where('role', 'teacher')->orderBy('id', 'asc')->paginate(10);
        return view('sections.teachers', compact('teachers'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'teacher',
            'password' => Hash::make('docente123'),
            'terms_accepted' => true,
        ]);

        Notification::create([
            'title' => 'Nuevo Docente',
            'message' => "Se ha registrado al docente {$request->name} en el sistema.",
            'type' => 'success',
        ]);

        $this->recordAuditLog('Registro de Docente', "Se registró al docente {$request->name} ({$request->email})");

        return redirect()->route('teachers')->with('success', 'Docente registrado correctamente. Contraseña temporal: docente123');
    }

    public function destroyTeacher(User $user)
    {
        if ($user->role !== 'teacher') abort(403);
        
        $name = $user->name;
        $user->delete();

        Notification::create([
            'title' => 'Docente Eliminado',
            'message' => "Se ha eliminado el registro del docente {$name}.",
            'type' => 'warning',
        ]);

        return redirect()->route('teachers')->with('success', 'Docente eliminado correctamente.');
    }

    public function classrooms()
    {
        $classrooms = Classroom::orderBy('id', 'asc')->get();
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

        Notification::create([
            'title' => 'Nueva Aula Creada',
            'message' => "Se ha habilitado el aula {$request->name} con capacidad para {$request->capacity} alumnos.",
            'type' => 'success',
        ]);

        return redirect()->route('classrooms')->with('success', 'Aula creada exitosamente.');
    }

    public function destroyClassroom(Classroom $classroom)
    {
        $name = $classroom->name;
        $classroom->delete();

        Notification::create([
            'title' => 'Aula Eliminada',
            'message' => "El aula {$name} ha sido retirada del sistema.",
            'type' => 'warning',
        ]);

        return redirect()->route('classrooms')->with('success', 'Aula eliminada correctamente.');
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

        Notification::create([
            'title' => 'Nueva Carrera',
            'message' => "Se ha añadido la carrera de {$request->name} al catálogo.",
            'type' => 'info',
        ]);

        return redirect()->route('careers')->with('success', 'Carrera creada correctamente.');
    }

    public function destroyCareer(Career $career)
    {
        $name = $career->name;
        if ($career->users()->count() > 0) {
            return redirect()->route('careers')->with('error', 'No se puede eliminar la carrera porque tiene estudiantes asignados.');
        }

        $career->delete();

        Notification::create([
            'title' => 'Carrera Eliminada',
            'message' => "La carrera {$name} ha sido eliminada.",
            'type' => 'warning',
        ]);

        return redirect()->route('careers')->with('success', 'Carrera eliminada correctamente.');
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
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 
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
        $user = Auth::user();
        $enrollments = $user->isAdmin() 
            ? Enrollment::with(['user', 'career'])->latest()->get()
            : Enrollment::where('user_id', $user->id)->with('career')->latest()->get();
            
        return view('sections.enrollments', compact('enrollments'));
    }

    public function storeEnrollment(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'career_id' => 'required|exists:careers,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $userId = Auth::user()->isAdmin() && $request->has('user_id') ? $request->user_id : Auth::id();

        $enrollment = Enrollment::create([
            'user_id' => $userId,
            'career_id' => $request->career_id,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        // Generar un cobro automático por el trámite
        Payment::create([
            'user_id' => $userId,
            'amount' => 50.00, // Costo fijo simulado por trámite
            'description' => "Derecho de " . ucfirst($request->type) . " (#INS-" . str_pad($enrollment->id, 5, '0', STR_PAD_LEFT) . ")",
            'status' => 'pending',
        ]);

        Notification::create([
            'user_id' => $userId,
            'title' => 'Trámite Iniciado',
            'message' => "Tu solicitud de {$request->type} ha sido enviada correctamente.",
            'type' => 'info',
        ]);

        return redirect()->route('dashboard')->with('success', 'Solicitud enviada exitosamente. Se ha generado un cargo en tu estado de cuenta.');
    }

    public function payments()
    {
        $user = Auth::user();
        $payments = $user->isAdmin()
            ? Payment::with('user')->latest()->get()
            : Payment::where('user_id', $user->id)->latest()->get();

        $balance = $user->isAdmin() ? 0 : Payment::where('user_id', $user->id)->where('status', 'pending')->sum('amount');
            
        return view('sections.payments', compact('payments', 'balance'));
    }

    public function approvePayment(Payment $payment)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $payment->update(['status' => 'paid']);

        Notification::create([
            'user_id' => $payment->user_id,
            'title' => 'Pago Confirmado',
            'message' => "Tu pago por '{$payment->description}' ha sido aprobado exitosamente.",
            'type' => 'success',
        ]);

        // Enviar Email
        Mail::to($payment->user->email)->send(new PaymentConfirmedMail($payment->user));

        // Auditoría
        $this->recordAuditLog('Aprobación de Pago', "Se aprobó el pago de S/ {$payment->amount} del usuario {$payment->user->name}");

        return redirect()->route('payments')->with('success', 'Pago aprobado correctamente.');
    }

    public function downloadEnrollmentPDF($id)
    {
        $enrollment = Enrollment::with(['user', 'career'])->findOrFail($id);
        
        // Autorización: Solo el dueño o el admin pueden descargar
        if (!Auth::user()->isAdmin() && $enrollment->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.enrollment', compact('enrollment'));
        return $pdf->download("inscripcion_{$enrollment->id}.pdf");
    }

    public function downloadPaymentPDF($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        
        if (!Auth::user()->isAdmin() && $payment->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));
        return $pdf->download("recibo_{$payment->id}.pdf");
    }

    public function grades()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $grades = Grade::with(['user', 'course'])->latest()->get();
            $courses = Course::all();
            $students = User::where('role', 'student')->get();
            return view('sections.grades_admin', compact('grades', 'courses', 'students'));
        } else {
            $grades = Grade::where('user_id', $user->id)->with('course')->get();
            $gpa = $grades->count() > 0 ? round($grades->avg('grade'), 2) : 0;
            return view('sections.grades_student', compact('grades', 'gpa'));
        }
    }

    public function storeGrade(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|numeric|min:0|max:20',
        ]);

        $course = Course::find($request->course_id);
        
        Grade::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'grade' => $request->grade,
            'status' => $request->grade >= 11 ? 'pass' : 'fail',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'Nueva Calificación',
            'message' => "Se ha publicado una nueva nota en el curso de " . $course->name,
            'type' => 'info',
        ]);

        return redirect()->route('grades')->with('success', 'Calificación registrada correctamente.');
    }

    public function updateGrade(Request $request, Grade $grade)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $request->validate([
            'grade' => 'required|numeric|min:0|max:20',
        ]);

        $grade->update([
            'grade' => $request->grade,
            'status' => $request->grade >= 11 ? 'pass' : 'fail',
        ]);

        Notification::create([
            'user_id' => $grade->user_id,
            'title' => 'Nota Actualizada',
            'message' => "Se ha actualizado tu nota en el curso de " . $grade->course->name,
            'type' => 'warning',
        ]);

        return redirect()->route('grades')->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroyGrade(Grade $grade)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $grade->delete();
        return redirect()->route('grades')->with('success', 'Calificación eliminada correctamente.');
    }

    public function auditLogs()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $logs = AuditLog::with('user')->latest()->paginate(15);
        return view('sections.audit_logs', compact('logs'));
    }

    public function settings()
    {
        return view('sections.settings');
    }

    public function reports()
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $driver = DB::getDriverName();

        // Ingresos totales por mes (compatible MySQL y PostgreSQL)
        if ($driver === 'pgsql') {
            $monthlyRevenue = Payment::where('status', 'paid')
                ->select(
                    DB::raw('SUM(amount) as total'),
                    DB::raw("TO_CHAR(updated_at, 'Month') as month"),
                    DB::raw("EXTRACT(MONTH FROM updated_at) as month_num")
                )
                ->groupBy('month_num', 'month')
                ->orderBy('month_num')
                ->get();
        } else {
            $monthlyRevenue = Payment::where('status', 'paid')
                ->select(
                    DB::raw('SUM(amount) as total'),
                    DB::raw("DATE_FORMAT(updated_at, '%M') as month"),
                    DB::raw("MONTH(updated_at) as month_num")
                )
                ->groupBy('month_num', 'month')
                ->orderBy('month_num')
                ->get();
        }

        // Distribución de estados de pago
        $paymentStatus = Payment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Alumnos por carrera
        $studentsByCareer = Career::withCount('users')->get();

        // Métricas rápidas
        $stats = [
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'active_enrollments' => Enrollment::where('status', 'approved')->count(),
        ];

        return view('sections.reports', compact('monthlyRevenue', 'paymentStatus', 'studentsByCareer', 'stats'));
    }
    public function virtualClasses()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $courses = Course::all();
        } elseif ($user->isTeacher()) {
            $courses = $user->taughtCourses;
        } else {
            // Cursos de su carrera
            $courses = Course::where('career_id', $user->career_id)->get();
        }

        return view('sections.virtual_classes', compact('courses'));
    }

    public function coursesIndex()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $courses = Course::with('teacher', 'career')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('sections.courses', compact('courses', 'teachers'));
    }

    public function assignTeacher(Request $request, Course $course)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $request->validate(['teacher_id' => 'required|exists:users,id']);
        
        $course->update(['teacher_id' => $request->teacher_id]);
        
        return back()->with('success', 'Docente asignado correctamente al curso.');
    }
}
