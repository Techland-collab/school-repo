@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Teacher Dashboard</h3>
        </div>

        <div class="row d-flex align-items-stretch">
            <!-- Total Students -->
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <h6>Total Students</h6>
                        <h3>{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
            <!-- Total Courses -->
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <h6>Total Courses</h6>
                        <h3>{{ $totalCourses }}</h3>
                    </div>
                </div>
            </div>
            <!-- Total Tasks -->
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <h6>Total Tasks</h6>
                        <h3>{{ $totalTasks }}</h3>
                        <p>Pending: {{ $pendingTasks }}</p>
                        <p>Completed: {{ $completedTasks }}</p>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <!-- Recently Added Students -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Recently Added Students</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStudents as $key => $student)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->first_name }}</td>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->phone_number }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Recently Added Tasks -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Recently Added Tasks</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Title</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTasks as $key => $task)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection