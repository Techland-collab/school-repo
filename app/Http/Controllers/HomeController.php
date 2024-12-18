<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Task;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /** home dashboard */
    public function index()
    {
        return view('dashboard.home');
    }

    /** profile user */
    public function userProfile()
    {
        return view('dashboard.profile');
    }

    /** teacher dashboard */
    // public function teacherDashboardIndex()
    // {
    //     return view('dashboard.teacher_dashboard');
    // }    



    // public function teacherDashboardIndex()
    // {
    //     // Fetch counts
    //     $totalStudents = Student::count();
    //     $totalCourses = Course::count();
    //     $totalTasks = Task::count();
    //     $pendingTasks = Task::where('status', 'pending')->count();
    //     $completedTasks = Task::where('status', 'completed')->count();

    //     // Fetch recent students and tasks
    //     $recentStudents = Student::latest()->take(5)->get();
    //     $recentTasks = Task::latest()->take(5)->get();

    //     // Pass data to the view
    //     return view('dashboard.teacher_dashboard', compact(
    //         'totalStudents',
    //         'totalCourses',
    //         'totalTasks',
    //         'pendingTasks',
    //         'completedTasks',
    //         'recentStudents',
    //         'recentTasks'
    //     ));
    // }


    public function teacherDashboardIndex()
{
    // Fetch counts
    $totalStudents = Student::count();
    $totalCourses = Course::count();
    $totalTasks = Task::count();
    $pendingTasks = Task::where('status', 'pending')->count();
    $completedTasks = Task::where('status', 'completed')->count();

    // Fetch recent students and tasks
    $recentStudents = Student::orderBy('created_at', 'desc')->take(5)->get();
    $recentTasks = Task::orderBy('created_at', 'desc')->take(5)->get();

    // Pass data to the view
    return view('dashboard.teacher_dashboard', compact(
        'totalStudents',
        'totalCourses',
        'totalTasks',
        'pendingTasks',
        'completedTasks',
        'recentStudents',
        'recentTasks'
    ));
}


    public function studentDashboardIndex()
    {
        $user = Auth::user();
        $student = $user->student; 
    
        if (!$student) {
            Toastr::error('Student record not found for the logged-in user.', 'Error');
            return redirect()->route('home');
        }
   
        $courses = $student->courses; 
        $tasks = Task::where('student_id', $student->id)->get();
    
        return view('dashboard.student_dashboard', compact('student', 'courses', 'tasks'));
    }
    
    

}
