@php
$permission = auth()->user()->permissions;
$jsondecodepermission = json_decode($permission, true);
$hasAllPermissions = in_array('All', $jsondecodepermission);
@endphp
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashborad') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if($hasAllPermissions || in_array('usermanagement', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users') }}">
                <i class="bi bi-person"></i>
                <span>All Users</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if($hasAllPermissions || in_array('faqmanagement', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('faq-index') }}">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->
        @endif

        {{-- @if($hasAllPermissions || in_array('notificationmanagement', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed {{ request()->routeIs('show-notification') ? 'active' : '' }}" href="{{ route('show-notification') }}">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li>
        @endif --}}
        <!-- End Notifications Page Nav -->

        @if($hasAllPermissions || in_array('categorymanagement', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('show-category') }}">
                <i class="bi bi-envelope"></i>
                <span>Feedback</span>
            </a>
        </li><!-- End Contact Page Nav -->
        @endif

        @if($hasAllPermissions)
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('manage-admin') }}">
                <i class="bi bi-card-list"></i>
                <span>Manage Admin</span>
            </a>
        </li><!-- End Register Page Nav -->
        @endif

    </ul>

</aside><!-- End Sidebar-->
