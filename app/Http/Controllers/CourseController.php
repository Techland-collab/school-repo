<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /** List all courses */
    public function courseList()
    {
        $courseList = Course::all();
        return view('courses.course_list', compact('courseList'));
    }

    /** Show the add course page */
    public function courseAdd()
    {
        return view('courses.course_add');
    }

    /** Save a new course */
    public function saveCourse(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer',
        ]);

        try {
            $saveRecord = new Course();
            $saveRecord->name   = $request->name;
            $saveRecord->description          = $request->description;
            $saveRecord->duration          = $request->duration;
            $saveRecord->save();

            Toastr::success('Has been add successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            Toastr::error('fail, Add new record:)', 'Error');
            return redirect()->back();
        }
    }

    /** Show the edit course page */
    public function courseEdit($course_id)
    {
        $courseEdit = Course::findOrFail($course_id);
        return view('courses.course_edit', compact('courseEdit'));
    }

    /** Update an existing course */
    public function updateCourse(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer',
        ]);

        try {

            $updateRecord = [
                'name'        => $request->name,
                'description' => $request->description,
                'duration'    => $request->duration,
            ];
            Course::where('id', $request->id)->update($updateRecord);
            Toastr::success('Course has been updated successfully!', 'Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to update course.', 'Error');
        }

        return redirect()->back();
    }




    /** Delete a course */
    // public function deleteCourse(Request $request)
    // {
    //     try {
    //         Course::destroy($request->id);
    //         Toastr::success('Course has been deleted successfully!', 'Success');
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         Toastr::error('Failed to delete course.', 'Error');
    //     }

    //     return redirect()->back();
    // }


    // In your controller
    public function deleteCourse(Request $request)
    {
        $courseId = $request->course_id; // Get the course ID from the form input

        try {
            // Check if the course exists before deleting
            $course = Course::find($courseId);
            if ($course) {
                $course->delete(); // Delete the course from the database
                Toastr::success('Course has been deleted successfully!', 'Success');
            } else {
                Toastr::error('Course not found.', 'Error');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to delete course.', 'Error');
        }

        return redirect()->route('course/list'); // Redirect after deletion
    }
}
