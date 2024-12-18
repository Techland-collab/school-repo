<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    /** List all enrollments */
    public function enrollmentList()
    {
        $enrollmentList = Enrollment::with('student', 'course')->get(); // eager loading to reduce queries
        return view('enrollments.enrollment_list', compact('enrollmentList'));
    }

    /** Show the add enrollment page */
    public function enrollmentAdd()
    {
        $students = Student::with('user')->get(); // Get all students
        $courses = Course::all(); // Get all courses
        // print_r($students);die;

        return view('enrollments.enrollment_add', compact('students', 'courses'));
    }

    /** Save a new enrollment */
    // public function saveEnrollment(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'course_id' => 'required|exists:courses,id',
    //         'enrollment_date' => 'required|date',
    //     ]);

    //     try {
    //         $enrollment = new Enrollment();
    //         $enrollment->student_id = $request->student_id;
    //         $enrollment->course_id = $request->course_id;
    //         $enrollment->enrollment_date = $request->enrollment_date;
    //         $enrollment->save();

    //         Toastr::success('Enrollment has been added successfully!', 'Success');
    //         return redirect()->route('enrollment/list');
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         Toastr::error('Failed to add enrollment.', 'Error');
    //         return redirect()->back();
    //     }
    // }

    public function saveEnrollment(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'course_id' => 'required|exists:courses,id',
        'enrollment_date' => 'required|date',
    ]);

    try {
        Log::info('Attempting to save enrollment');
        $enrollment = new Enrollment();
        $enrollment->student_id = $request->student_id;
        $enrollment->course_id = $request->course_id;
        $enrollment->enrollment_date = $request->enrollment_date;
        $enrollment->save();

        Log::info('Enrollment saved successfully');
        Toastr::success('Enrollment has been added successfully!', 'Success');
        return redirect()->route('enrollment/list');
    } catch (\Exception $e) {
        Log::error('Error saving enrollment: ' . $e->getMessage());
        Toastr::error('Failed to add enrollment.', 'Error');
        return redirect()->back();
    }
}


    /** Show the edit enrollment page */
    public function enrollmentEdit($enrollment_id)
    {
        $enrollment = Enrollment::findOrFail($enrollment_id);
        $students = Student::all(); // Get all students
        $courses = Course::all(); // Get all courses
        return view('enrollments.enrollment_edit', compact('enrollment', 'students', 'courses'));
    }

    /** Update an existing enrollment */
    public function updateEnrollment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
        ]);

        try {
            $enrollment = Enrollment::findOrFail($request->id);
            $enrollment->update([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'enrollment_date' => $request->enrollment_date,
            ]);

            Toastr::success('Enrollment has been updated successfully!', 'Success');
            return redirect()->route('enrollment/list');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to update enrollment.', 'Error');
            return redirect()->back();
        }
    }

    /** Delete an enrollment */
    public function deleteEnrollment(Request $request)
    {
        $enrollmentId = $request->enrollment_id;

        try {
            $enrollment = Enrollment::find($enrollmentId);
            if ($enrollment) {
                $enrollment->delete();
                Toastr::success('Enrollment has been deleted successfully!', 'Success');
            } else {
                Toastr::error('Enrollment not found.', 'Error');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to delete enrollment.', 'Error');
        }

        // return redirect()->route('enrollment/list');
        return redirect()->back();
    }
}
