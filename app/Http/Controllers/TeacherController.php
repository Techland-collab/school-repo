<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /** Add teacher page */
    public function teacherAdd()
    {
        $users = User::where('role_name', 'Teachers')->get();
        return view('teacher.add-teacher', compact('users'));
    }

    /** Teacher list */
    public function teacherList()
    {
        $listTeacher = Teacher::with('user')->get();
        return view('teacher.list-teachers', compact('listTeacher'));
    }

    /** Teacher grid */
    public function teacherGrid()
    {
        $teacherGrid = Teacher::all();
        return view('teacher.teachers-grid', compact('teacherGrid'));
    }

    /** Save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'experience'    => 'required|string',
            'date_of_birth' => 'required|date',
            'qualification' => 'required|string',
            'phone_number'  => 'required|string|max:15',
            'address'       => 'required|string',
            'email'         => 'required|email|unique:users,email', // Ensure email is unique for login
        ]);

        try {

            $user = new User();
            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->password = Hash::make('12345678'); // Assign a default password
            $user->role_name = 'Teachers'; // Assign the 'teacher' role
            $user->save();

            $teacher = new Teacher();
            $teacher->full_name = $request->full_name;
            $teacher->user_id = $user->id; // Use the user_id from the created user
            $teacher->gender = $request->gender;
            $teacher->experience = $request->experience;
            $teacher->qualification = $request->qualification;
            $teacher->date_of_birth = $request->date_of_birth;
            $teacher->phone_number = $request->phone_number;
            $teacher->address = $request->address;
            $teacher->save();

            Toastr::success('Teacher added successfully!', 'Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to add teacher.', 'Error');
        }

        return redirect()->back();
    }



    /** Edit record */
    public function editRecord($user_id)
    {
        $teacher = Teacher::with('user')
            ->where('user_id', $user_id)
            ->first();

        return view('teacher.edit-teacher', compact('teacher'));
    }

    /** Update record */

    public function updateRecordTeacher(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'date_of_birth' => 'required|string',
            'qualification' => 'required|string',
            'experience'    => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'email'         => 'required|email', // Ensure email is provided and valid
        ]);

        try {
            // Step 1: Update the user record (email) using object
            $user = User::find($request->user_id); // Assuming user_id is provided in the request
            if ($user) {
                $user->email = $request->email;
                $user->name = $request->full_name; // Update the email
                $user->save(); // Save the user object
            } else {
                throw new \Exception('User not found');
            }

            // Step 2: Update the teacher record using object
            $teacher = Teacher::find($request->id); // Find the teacher by ID
            if ($teacher) {
                $teacher->full_name = $request->full_name;
                $teacher->gender = $request->gender;
                $teacher->date_of_birth = $request->date_of_birth;
                $teacher->qualification = $request->qualification;
                $teacher->experience = $request->experience;
                $teacher->phone_number = $request->phone_number;
                $teacher->address = $request->address;
                $teacher->save(); // Save the teacher object
            } else {
                throw new \Exception('Teacher not found');
            }

            Toastr::success('Teacher updated successfully!', 'Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to update teacher.', 'Error');
        }

        return redirect()->back();
    }

    /** Delete record */
    public function teacherDelete(Request $request)
    {
        try {
            Teacher::destroy($request->id);
            Toastr::success('Teacher deleted successfully!', 'Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to delete teacher.', 'Error');
        }

        return redirect()->back();
    }


    // show perticular record
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.teacher_show', compact('teacher'));
    }
}
