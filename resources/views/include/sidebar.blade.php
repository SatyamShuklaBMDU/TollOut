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

        @if($hasAllPermissions || in_array('notificationmanagement', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed {{ request()->routeIs('show-notification') ? 'active' : '' }}" href="{{ route('show-notification') }}">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </li>
        @endif
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
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i><span>Manage Roles</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('all-role') }}">
                  <i class="bi bi-circle"></i><span>All Roles</span>
                </a>
              </li>
              <li>
                <a href="{{ route('add-role') }}">
                  <i class="bi bi-circle"></i><span>Add Roles</span>
                </a>
              </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-journal-text"></i><span>Manage Admin</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="forms-elements.html">
                  <i class="bi bi-circle"></i><span>All Admin</span>
                </a>
              </li>
              <li>
                <a href="forms-layouts.html">
                  <i class="bi bi-circle"></i><span>Add Admin</span>
                </a>
              </li>
            </ul>
          </li>
    </ul>

</aside><!-- End Sidebar-->
