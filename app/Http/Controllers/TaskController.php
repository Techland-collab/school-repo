<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /** List all tasks */
    public function taskList()
    {
        $taskList = Task::with('student', 'teacher')->get();
        return view('tasks.task_list', compact('taskList'));
    }

    /** Show the add task page */
    public function taskAdd()
    {
        $students = Student::with('user')->get();
        $teachers = Teacher::with('user')->get();
        return view('tasks.task_add', compact('students', 'teachers'));
    }

    /** Save a new task */
    public function saveTask(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'teacher_id'   => 'required|exists:teachers,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'due_date'      => 'required|date',
            'status'        => 'required|in:Pending,Completed',
        ]);

        try {
            $saveRecord = new Task();
            $saveRecord->student_id   = $request->student_id;
            $saveRecord->teacher_id   = $request->teacher_id;
            $saveRecord->title        = $request->title;
            $saveRecord->description  = $request->description;
            $saveRecord->due_date     = $request->due_date;
            $saveRecord->status       = $request->status;
            $saveRecord->save();

            
            Toastr::success('Task has been added successfully!', 'Success');
            return redirect()->route('tasks.list');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to add task.', 'Error');
            return redirect()->back();
        }
    }

    /** Show the edit task page */
    public function taskEdit($task_id)
    {
        $task = Task::findOrFail($task_id);
        $students = Student::all();
        $teachers = Teacher::all();
        return view('tasks.task_edit', compact('task', 'students', 'teachers'));
    }

    /** Update an existing task */
    public function updateTask(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'teacher_id'   => 'required|exists:teachers,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'due_date'      => 'required|date',
            'status'        => 'required|in:Pending,Completed',
        ]);

        try {
            $task = Task::findOrFail($request->id);
            $task->student_id  = $request->student_id;
            $task->teacher_id  = $request->teacher_id;
            $task->title       = $request->title;
            $task->description = $request->description;
            $task->due_date    = $request->due_date;
            $task->status      = $request->status;
            $task->save();

            Toastr::success('Task has been updated successfully!', 'Success');
            return redirect()->route('tasks.list');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to update task.', 'Error');
            return redirect()->back();
        }
    }

    /** Delete a task */
    public function deleteTask(Request $request)
    {
        try {
            $task = Task::findOrFail($request->id);
            $task->delete();

            Toastr::success('Task has been deleted successfully!', 'Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Failed to delete task.', 'Error');
        }

        return redirect()->route('tasks.list');
    }



    public function show($taskId)
    {
        $task = Task::findOrFail($taskId); // Get task details
        return view('tasks.task_show', compact('task'));
    }
}
