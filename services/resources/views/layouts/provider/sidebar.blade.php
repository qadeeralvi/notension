@php
    $total_jobs = App\Models\JobManagement::count();
@endphp

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('servicegiver.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="menu-title">Apps</li>

                <li>
                    <a href="{{route('servicegiver.joblist')}}" class=" waves-effect">
                        <i class="bx bx-map"></i><span class="badge badge-pill badge-info float-right">{{$total_jobs}}</span>
                        <span>Job List</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
