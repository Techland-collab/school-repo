@extends('layouts.master')

@section('content')
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <h3 class="page-title">Task List</h3>
            <a href="{{ route('tasks.add') }}" class="btn btn-primary">Add Task</a>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Teacher</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskList as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->student->user->name }}</td>
                            <td>{{ $task->teacher->full_name }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('task.delete') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $task->id }}">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
