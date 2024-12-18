@extends('layouts.master')

@section('content')
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="page-title">Edit Enrollment</h3>
        <form action="{{ route('enrollment.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $enrollment->id }}">
            <div class="form-group">
                <label for="student_id">Student</label>
                <select name="student_id" id="student_id" class="form-control">
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $enrollment->student_id ? 'selected' : '' }}>
                        {{ $student->user->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="course_id">Course</label>
                <select name="course_id" id="course_id" class="form-control">
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $course->id == $enrollment->course_id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="enrollment_date">Enrollment Date</label>
                <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" value="{{ $enrollment->enrollment_date }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>
@endsection