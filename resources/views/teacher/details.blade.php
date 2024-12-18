@extends('layouts.master')

@section('content')
    <div class="teacher-details">
        <h3>{{ $teacher->name }}'s Details</h3>
        <ul>
            <li><strong>ID:</strong> {{ $teacher->user_id }}</li>
            <li><strong>Name:</strong> {{ $teacher->name }}</li>
            <li><strong>Gender:</strong> {{ $teacher->gender }}</li>
            <li><strong>Phone Number:</strong> {{ $teacher->phone_number }}</li>
            <li><strong>Address:</strong> {{ $teacher->address }}</li>
            <!-- Add more fields as needed -->
        </ul>
    </div>
@endsection
