@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Task Details</h3>
                    </div>
                </div>
            </div>

            <div class="task-details mb-4 bg-white p-4 shadow-sm rounded">
                <h4 class="mb-4">Task Information</h4>
                <div class="row mb-2">
                    <div class="col-sm-3"><strong>Title:</strong></div>
                    <div class="col-sm-9">{{ $task->title }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3"><strong>Description:</strong></div>
                    <div class="col-sm-9">{{ $task->description }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3"><strong>Due Date:</strong></div>
                    <div class="col-sm-9">{{ $task->due_date }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">{{ $task->status }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
