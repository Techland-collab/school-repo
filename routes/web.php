<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('home');
    });
    Route::get('home', function () {
        return view('home');
    });
});

Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

    // ----------------------------- register -------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'storeUser')->name('register');
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->middleware('auth')->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    });

    // ----------------------------- user controller ---------------------//
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'index')->middleware('auth')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data');
        /** get all data users */
    });



    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
        Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
        Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
        Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); 
        Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); 
        Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); 
        Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); 
        Route::get('teacher/edit/{user_id}', 'editRecord'); 
        Route::post('teacher/update', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); 
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); 
    });
   


    Route::controller(CourseController::class)->group(function () {
        Route::get('course/list/page', 'courseList')->middleware('auth')->name('course/list/page'); // course/list/page
        Route::get('course/add/page', 'courseAdd')->middleware('auth')->name('course/add/page'); // course/add/page
        Route::post('course/save', 'saveCourse')->name('course/save'); // course/save
        Route::post('course/update', 'updateCourse')->name('course/update'); // course/update
        Route::post('course/delete', [CourseController::class, 'deleteCourse'])->name('course/delete');

        Route::get('course/edit/{course_id}', 'courseEdit'); // course/edit/page
        Route::get('course/list', 'courseList')->middleware('auth')->name('course/list'); // course/list
        Route::get('course/add', 'courseAdd')->middleware('auth')->name('course/add'); // course/add


    });




    // ----------------------- enrollments -----------------------------//
    // ----------------------- enrollments -----------------------------//
    Route::controller(EnrollmentController::class)->group(function () {
        Route::get('enrollment/list', 'enrollmentList')->middleware('auth')->name('enrollment.index'); // enrollments/list
        Route::get('enrollment/add', 'enrollmentAdd')->middleware('auth')->name('enrollment.add'); // enrollment/add
        Route::post('enrollment/store', 'saveEnrollment')->middleware('auth')->name('enrollment.store'); // enrollment/store
        Route::get('enrollment/edit/{enrollment_id}', 'enrollmentEdit')->middleware('auth')->name('enrollment.edit'); // enrollment/edit/{enrollment_id}
        Route::post('enrollment/update', 'updateEnrollment')->middleware('auth')->name('enrollment.update'); // enrollment/update
        Route::post('enrollment/delete', 'deleteEnrollment')->middleware('auth')->name('enrollment.delete'); // enrollment/delete
    });



    Route::controller(TaskController::class)->group(function () {
        Route::get('task/list/page', 'taskList')->middleware('auth')->name('task/list/page'); // task/list/page
        Route::get('task/add/page', 'taskAdd')->middleware('auth')->name('task/add/page'); // task/add/page
        Route::post('task/save', 'saveTask')->middleware('auth')->name('task.save'); // task/save
        Route::post('task/update', 'updateTask')->middleware('auth')->name('task/update'); // task/update
        Route::post('task/delete', 'deleteTask')->middleware('auth')->name('task.delete'); // task/delete

        Route::get('task/edit/{task_id}', 'taskEdit')->middleware('auth')->name('task.edit'); // task/edit/{task_id}
        Route::get('task/list', 'taskList')->middleware('auth')->name('tasks.list'); // task/list
        Route::get('task/add', 'taskAdd')->middleware('auth')->name('tasks.add'); // task/add
    });
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    
    
});
