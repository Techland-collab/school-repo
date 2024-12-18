<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <li class="submenu {{set_active(['home','teacher/dashboard','student/dashboard'])}}">
                    <a>
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if(Auth::check() && Auth::user()->role_name === 'Admin')
                        <li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>
                        @endif
                        @if(Auth::check() && Auth::user()->role_name === 'Teacher')
                        <li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>
                        @endif
                        {{-- Check if the user is authenticated and has the 'student' role --}}
                        @if(Auth::check() && Auth::user()->role_name === 'Student')
                        <li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>
                        @endif
                    </ul>
                </li>
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teacher')
                <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-shield-alt"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                    </ul>
                </li>
              
            

                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student/list') }}" class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                        <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>
                        <li><a href="" class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>
                    </ul>
                </li>

                <li class="submenu  {{set_active(['teacher/add/page','teacher/list/page','teacher/grid/page','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Teachers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Teacher List</a></li>
                        <li><a href="teacher-details.html">Teacher View</a></li>
                        <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Teacher Add</a></li>
                        <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Teacher Edit</a></li>
                    </ul>
                </li>


                <li class="submenu {{set_active(['course/list/page','course/add/page'])}} {{ request()->is('course/edit/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Courses</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['course/list/page'])}} {{ request()->is('course/edit/*') ? 'active' : '' }}" href="{{ route('course/list/page') }}">Course List</a></li>
                        <li><a class="{{set_active(['course/add/page'])}}" href="{{ route('course/add/page') }}">Course Add</a></li>
                        <li><a>Course Edit</a></li>
                    </ul>
                </li>



                <li class="submenu {{ set_active(['enrollment/list', 'enrollment/add']) }} {{ request()->is('enrollment/edit/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-graduate"></i>
                        <span> Enrollments</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!-- Enrollment List -->
                        <li>
                            <a class="{{ set_active(['enrollment/list']) }} {{ request()->is('enrollments/edit/*') ? 'active' : '' }}"
                                href="{{ route('enrollment.index') }}">
                                Enrollment List
                            </a>
                        </li>
                        <!-- Add Enrollment -->
                        <li>
                            <a class="{{ set_active(['enrollment/add']) }}"
                                href="{{ route('enrollment.add') }}">
                                Add Enrollment
                            </a>
                        </li>
                        <li><a>Subject Edit</a></li>
                    </ul>
                </li>



                <li class="submenu {{set_active(['task/list/page','task/add/page'])}} {{ request()->is('task/edit/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-tasks"></i>
                        <span> Tasks</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['task/list/page'])}} {{ request()->is('task/edit/*') ? 'active' : '' }}" href="{{ route('tasks.list') }}">Task List</a></li>
                        <li><a class="{{set_active(['task/add/page'])}}" href="{{ route('tasks.add') }}">Task Add</a></li>
                        <li><a>Task Edit</a></li>
                    </ul>
                </li>
@endif
            </ul>
        </div>
    </div>
</div>