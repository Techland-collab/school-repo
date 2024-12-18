@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Course</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('course/list') }}">Courses</a></li>
                        <li class="breadcrumb-item active">Edit Course</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('course/update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Course Information</span></h5>
                                </div>
                                <!-- <div class="col-12 col-sm-4"> -->
                                <input type="hidden" name="id" value="{{ $courseEdit->id }}">
                                <!-- </div> -->
                                <div class="col-12 col-sm-4">


                                    <div class="form-group form-group">
                                        <label>Course Name <span class="login-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $courseEdit->name }}" required>
                                    </div>


                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Description <span class="login-danger">*</span></label>
                                        <textarea name="description" class="form-control" rows="3">{{ $courseEdit->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Duration (in weeks) <span class="login-danger">*</span></label>
                                        <input type="number" class="form-control" name="duration" value="{{ $courseEdit->duration }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="student-submit">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection