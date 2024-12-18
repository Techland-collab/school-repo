@extends('layouts.master')

@section('content')
    {{-- Display success/error messages --}}
    {!! Toastr::message() !!}

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Student Dashboard</h3>
                    </div>
                </div>
            </div>

            {{-- Step 1: Display Tasks --}}
            <div class="tasks mb-4 bg-white p-4 shadow-sm rounded">
                <h4>List of Tasks</h4>
                @if($tasks && $tasks->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th> <!-- New column for the button -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $key => $task)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->due_date }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>
                                        <!-- Button to view detailed task -->
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">View Task</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No tasks available for this student.</p>
                @endif
            </div>

            {{-- Step 2: Show Summary of Courses --}}
            <div class="summary mb-4 bg-white p-4 shadow-sm rounded">
                <h4>Summary of Enrolled Courses</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total Courses Enrolled</th>
                            <th>Tasks Pending</th>
                            <th>Tasks Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $courses->count() }}</td>
                            <td>{{ $tasks->where('status', 'Pending')->count() }}</td>
                            <td>{{ $tasks->where('status', 'Completed')->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Step 3: Display List of Courses --}}
            <div class="courses mb-4 bg-white p-4 shadow-sm rounded">
                <h4>List of Courses</h4>
                @if($courses && $courses->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Enrollment Date</th>
                                <th>Duration (Weeks)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $key => $course)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->pivot->enrollment_date }}</td>
                                    <td>{{ $course->duration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No courses available for this student.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-white {
            background-color: #fff;
        }

        .p-4 {
            padding: 1.5rem;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .rounded {
            border-radius: 0.25rem;
        }

        table th, table td {
            text-align: center;
            vertical-align: middle;
        }

        table {
            background-color: #fff;
        }

        table thead {
            background-color: #f8f9fa;
        }

        table th {
            font-weight: bold;
        }
    </style>
@endsection
