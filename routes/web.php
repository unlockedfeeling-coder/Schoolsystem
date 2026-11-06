<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\AcademicSession;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Announcement;
use App\Models\ExamResult;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\FeeStructure;
use App\Models\FeePayment;

// ==========================================
// PUBLIC WEBSITE ROUTES
// ==========================================
Route::get('/', function () {
    $announcements = Announcement::latest()->take(3)->get();
    return view('public.home', compact('announcements'));
});

Route::get('/news', function () {
    $announcements = Announcement::latest()->get();
    return view('public.news', compact('announcements'));
});

Route::get('/apply', function () {
    return view('apply-page');
});

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', function () {
    if (Auth::check()) {
        if (auth()->user()->role === 'teacher') return redirect('/teacher/dashboard');
        if (auth()->user()->role === 'parent') return redirect('/parent/dashboard');
        if (auth()->user()->role === 'student') return redirect('/student/dashboard');
        return redirect('/dashboard');
    }
    return view('login-page');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ==========================================
// PROTECTED ROUTES (Admin, Teacher, Parent, Student)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    Route::get('/change-password', function () {
        return view('change-password-page');
    });

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'teacher') return redirect('/teacher/dashboard');
        if (auth()->user()->role === 'parent') return redirect('/parent/dashboard');
        if (auth()->user()->role === 'student') return redirect('/student/dashboard');

        return view('dashboard-page', [
            'totalStudents' => Student::count(),
            'totalClasses' => ClassLevel::count(),
            'totalSessions' => AcademicSession::count(),
            'totalSections' => Section::count(),
        ]);
    });
    
    Route::get('/levels', function () { return view('levels-page'); });
    Route::get('/sessions', function () { return view('sessions-page'); });
    Route::get('/sections', function () { return view('sections-page'); });
    Route::get('/students/{id}', function ($id) { 
        $student = Student::with(['classLevel', 'section'])->findOrFail($id); 
        return view('student-profile-page', compact('student')); 
    });
    Route::get('/students/{id}/report', function ($id) { 
        $student = Student::with(['classLevel', 'section'])->findOrFail($id);
        $exams = ExamResult::where('student_id', $id)->with('subject')->get();
        $attendance = Attendance::where('student_id', $id)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        return view('student-report', compact('student', 'exams', 'attendance')); 
    });
    Route::get('/students/{id}/report/download', function ($id) { 
        $student = Student::with(['classLevel', 'section'])->findOrFail($id);
        $exams = ExamResult::where('student_id', $id)->with('subject')->get();
        $attendance = Attendance::where('student_id', $id)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $pdf = Pdf::loadView('pdf.report-card', compact('student', 'exams', 'attendance'));
        return $pdf->download('Report_Card_' . $student->admission_number . '.pdf');
    });
    Route::get('/students', function () { return view('students-page'); });
    Route::get('/teachers', function () { return view('teachers-page'); });
    Route::get('/subjects', function () { return view('subjects-page'); });
    Route::get('/attendance', function () { return view('attendance-page'); });
    Route::get('/exams', function () { return view('exam-page'); });
    Route::get('/fees', function () { return view('fees-page'); });
    Route::get('/announcements', function () { return view('announcements-page'); });
    Route::get('/promotions', function () { return view('promotions-page'); });
    Route::get('/library', function () { return view('library-page'); });
    Route::get('/admissions', function () { return view('admissions-page'); });
    Route::get('/manage-users', function () { return view('manage-users-page'); });
    Route::get('/timetable', function () { return view('timetable-page'); });

    Route::get('/admin/fees/receipt/{id}', function ($id) {
        $payment = FeePayment::with(['student.classLevel', 'feeType', 'session'])->findOrFail($id);
        $student = $payment->student;
        $session = $payment->session ?? AcademicSession::where('is_active', true)->first();
        
        $structure = FeeStructure::where('fee_type_id', $payment->fee_type_id)
            ->where('class_level_id', $student->class_level_id)
            ->where('academic_session_id', $session->id)
            ->first();

        $totalRequired = $structure?->amount ?? 0;
        $totalPaid = FeePayment::where('student_id', $student->id)
            ->where('fee_type_id', $payment->fee_type_id)
            ->where('academic_session_id', $session->id)
            ->sum('amount_paid');

        $studentName = mb_convert_encoding($student->first_name . ' ' . $student->last_name, 'UTF-8', 'auto');
        $feeTypeName = mb_convert_encoding($payment->feeType->name ?? 'Unknown', 'UTF-8', 'auto');
        $className = mb_convert_encoding($student->classLevel->name ?? 'N/A', 'UTF-8', 'auto');
        $sessionName = mb_convert_encoding($session->name ?? 'N/A', 'UTF-8', 'auto');

        $html = view('pdf.fee-receipt', compact('payment', 'student', 'totalRequired', 'totalPaid', 'studentName', 'feeTypeName', 'className', 'sessionName'))->render();
        $cleanHtml = mb_convert_encoding($html, 'UTF-8', 'auto');
        
        $pdf = Pdf::loadHtml($cleanHtml)->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        return $pdf->download('Receipt_' . $student->admission_number . '_' . $payment->id . '.pdf');
    });
});

// ==========================================
// TEACHER ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('teacher')->group(function () {
    
    // FIXED TEACHER DASHBOARD ROUTE
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'teacher') return redirect('/dashboard');
        
        // FIX: Search by 'user_id' instead of 'id' to match the login account
        $teacherProfile = Teacher::where('user_id', auth()->id())->with(['classLevel', 'subject'])->first();
        
        $totalStudents = 0;
        if ($teacherProfile && $teacherProfile->class_level_id) {
            $totalStudents = Student::where('class_level_id', $teacherProfile->class_level_id)->count();
        }

        return view('teacher-dashboard', [
            'myClass' => $teacherProfile, 
            'totalStudents' => $totalStudents
        ]);
    });

    Route::get('/attendance', function () { return view('teacher-attendance-page'); });
    Route::get('/exams', function () { return view('teacher-exams-page'); });
    Route::get('/timetable', function () { return view('teacher-timetable-page'); });
});

// ==========================================
// PARENT ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('parent')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'parent') return redirect('/dashboard');
        $child = Student::where('parent_id', auth()->id())->with(['classLevel', 'section'])->first();
        
        $attendance = $child ? Attendance::where('student_id', $child->id)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray() : [];
        $exams = $child ? ExamResult::where('student_id', $child->id)->with('subject')->latest()->take(5)->get() : collect();
        
        $totalFees = 0;
        $paidFees = 0;
        if ($child) {
            $session = AcademicSession::where('is_active', true)->first();
            if ($session) {
                $structures = FeeStructure::where('class_level_id', $child->class_level_id)->where('academic_session_id', $session->id)->get();
                $totalFees = $structures->sum('amount');
                
                $payments = FeePayment::where('student_id', $child->id)->where('academic_session_id', $session->id)->get();
                $paidFees = $payments->sum('amount_paid');
            }
        }

        return view('parent-dashboard', [
            'child' => $child, 
            'attendance' => $attendance, 
            'exams' => $exams,
            'totalFees' => $totalFees,
            'paidFees' => $paidFees
        ]);
    });
    
    Route::get('/grades', function () {
        if (auth()->user()->role !== 'parent') return redirect('/dashboard');
        $child = Student::where('parent_id', auth()->id())->first();
        $exams = $child ? ExamResult::where('student_id', $child->id)->with('subject')->latest()->get() : collect();
        return view('parent-grades', ['child' => $child, 'exams' => $exams]);
    });
    
    Route::get('/attendance', function () {
        if (auth()->user()->role !== 'parent') return redirect('/dashboard');
        $child = Student::where('parent_id', auth()->id())->first();
        $records = $child ? Attendance::where('student_id', $child->id)->latest()->get() : collect();
        return view('parent-attendance', ['child' => $child, 'records' => $records]);
    });
    
    Route::get('/fees', function () {
        if (auth()->user()->role !== 'parent') return redirect('/dashboard');
        
        $child = Student::where('parent_id', auth()->id())->first();
        
        $totalRequired = 0;
        $totalPaid = 0;
        $payments = collect();
        
        if ($child) {
            $session = AcademicSession::where('is_active', true)->first();
            
            if ($session) {
                $structures = FeeStructure::where('class_level_id', $child->class_level_id)
                                          ->where('academic_session_id', $session->id)
                                          ->get();
                $totalRequired = $structures->sum('amount');
                
                $payments = FeePayment::where('student_id', $child->id)
                                      ->where('academic_session_id', $session->id)
                                      ->with('feeType')
                                      ->latest()
                                      ->get();
                $totalPaid = $payments->sum('amount_paid');
            }
        }
        
        $balance = $totalRequired - $totalPaid;
        
        return view('parent-fees', [
            'child' => $child, 
            'totalRequired' => $totalRequired, 
            'totalPaid' => $totalPaid,
            'balance' => $balance,
            'payments' => $payments
        ]);
    });

    Route::get('/fees/{id}/receipt', function ($id) {
        if (auth()->user()->role !== 'parent') return redirect('/dashboard');
        
        $payment = FeePayment::with(['student.classLevel', 'feeType', 'session'])->findOrFail($id);
        $student = $payment->student;
        
        if (!$student || $student->parent_id !== auth()->id()) return redirect('/parent/fees');

        $session = $payment->session ?? AcademicSession::where('is_active', true)->first();
        if (!$session) return abort(404, 'No session found');

        $structure = FeeStructure::where('fee_type_id', $payment->fee_type_id)
                                 ->where('class_level_id', $student->class_level_id)
                                 ->where('academic_session_id', $session->id)
                                 ->first();
                                 
        $totalRequired = $structure ? $structure->amount : 0;
        $totalPaid = FeePayment::where('student_id', $student->id)
                               ->where('fee_type_id', $payment->fee_type_id)
                               ->where('academic_session_id', $session->id)
                               ->sum('amount_paid');

        $html = view('pdf.fee-receipt', compact('payment', 'student', 'totalRequired', 'totalPaid'))->render();
        $cleanHtml = mb_convert_encoding($html, 'UTF-8', 'auto');
        
        $pdf = Pdf::loadHtml($cleanHtml)->setOptions(['defaultFont' => 'DejaVu Sans', 'isHtml5ParserEnabled' => true]);
        return $pdf->download('Receipt_' . $student->admission_number . '_' . $payment->id . '.pdf');
    });
});

// ==========================================
// STUDENT ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'student') return redirect('/dashboard');
        return view('student-dashboard');
    });
    
    Route::get('/grades', function () {
        if (auth()->user()->role !== 'student') return redirect('/dashboard');
        $student = Student::where('first_name', auth()->user()->name)->first();
        $exams = $student ? ExamResult::where('student_id', $student->id)->with('subject')->get() : collect();
        return view('student-grades', ['exams' => $exams, 'student' => $student]);
    });
    
    Route::get('/attendance', function () {
        if (auth()->user()->role !== 'student') return redirect('/dashboard');
        $student = Student::where('first_name', auth()->user()->name)->first();
        $records = $student ? Attendance::where('student_id', $student->id)->latest()->get() : collect();
        return view('student-attendance', ['records' => $records, 'student' => $student]);
    });
    
    Route::get('/timetable', function () {
        if (auth()->user()->role !== 'student') return redirect('/dashboard');
        return view('student-timetable');
    });
});