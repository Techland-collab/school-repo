<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = Student::with('user')->get();
        return view('student.student', compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid', compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        return view('student.add-student');
    }

    /** student save record */
    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'required',
            'upload'        => 'required|image',
        ]);

        try {
            $user = new User();
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make('12345678'); // Assign a default password
            $user->role_name = 'Student'; // Assign the 'student' role
            $user->save();
            $upload_file = rand() . '.' . $request->upload->extension();
            $request->upload->move(storage_path('app/public/student-photos/'), $upload_file);
            if (!empty($request->upload)) {
                $student = new Student;
                $student->user_id = $user->id;
                $student->first_name   = $request->first_name;
                $student->last_name    = $request->last_name;
                $student->gender       = $request->gender;
                $student->date_of_birth = $request->date_of_birth;
                $student->phone_number = $request->phone_number;
                $student->upload = $upload_file;
                $student->save();

                Toastr::success('Has been add successfully :)', 'Success');

                // DB::commit();
            }

            return redirect()->back();
        } catch (\Exception $e) {
            // DB::rollback();
            // Toastr::error('fail, Add new student  :)', 'Error');
            Toastr::error('Failed to add new student. Error: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** view for edit student */
    public function studentEdit($id)
    {
        $studentEdit = Student::with('user')->where('id', $id)->first();
        return view('student.edit-student', compact('studentEdit'));
    }

    /** update record */
    public function studentUpdate(Request $request)
    {
        $request->validate([
            'id'            => 'required|exists:students,id',
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'upload'        => 'nullable|image',
        ]);

        try {

            $user = User::find($request->id);
            if ($user) {
                $user->email = $request->email;
                $user->name = $request->full_name;
                $user->save();
            } else {
                throw new \Exception('User not found');
            }
     
            $upload_file = $request->image_hidden;
            if ($request->hasFile('upload')) {
                Log::info('File upload detected.');
                if (!empty($upload_file) && file_exists(storage_path('app/public/student-photos/' . $upload_file))) {
                    unlink(storage_path('app/public/student-photos/' . $upload_file));
                }
                $upload_file = rand() . '.' . $request->upload->extension();
                $request->upload->move(storage_path('app/public/student-photos/'), $upload_file);
            }

            $student = Student::findOrFail($request->id);
            if ($student) {
                $student->first_name = $request->first_name;
                $student->last_name = $request->last_name;
                $student->gender = $request->gender;
                $student->date_of_birth = $request->date_of_birth;
                $student->phone_number = $request->phone_number;
                $student->upload = $upload_file;
                $student->save(); // Save the teacher object
            } else {
                throw new \Exception('Teacher not found');
            }
            Toastr::success('Student updated successfully!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Student Update Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            Toastr::error('Failed to update student. Error: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }








    /** student delete */
    public function studentDelete(Request $request)
    {
        try {

            if (!empty($request->id)) {
                Student::destroy($request->id);
                unlink(storage_path('app/public/student-photos/' . $request->avatar));
                Toastr::success('Student deleted successfully :)', 'Success');
                return redirect()->back();
            }
        } catch (\Exception $e) {

            Toastr::error('Student deleted fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = User::with('student', 'teacher')->where('id', $id)->first();
        return view('student.student-profile', compact('studentProfile'));
    }
    
}
