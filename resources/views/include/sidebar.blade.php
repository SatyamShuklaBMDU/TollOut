@php
$permission = auth()->user()->Role->permissions;
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

        @if($hasAllPermissions || in_array('User', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users') }}">
                <i class="bi bi-person"></i>
                <span>All User</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @endif

        @if($hasAllPermissions || in_array('Faq', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('faq-index') }}">
                <i class="bi bi-question-circle"></i>
                <span>FAQ's</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->
        @endif

        @if($hasAllPermissions || in_array('Notification', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed {{ request()->routeIs('show-notification') ? 'active' : '' }}" href="{{ route('show-notification') }}">
                <i class="bi bi-bell"></i>
                <span>Notification</span>
            </a>
        </li>
        @endif
        <!-- End Notifications Page Nav -->

        @if($hasAllPermissions || in_array('Feedback', $jsondecodepermission))
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('show-category') }}">
                <i class="bi bi-envelope"></i>
                <span>Feedback</span>
            </a>
        </li>
        @endif
        <!-- End Contact Page Nav -->

        @if($hasAllPermissions)
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('wishlist') }}">
              <i class="bi bi-envelope"></i>
              <span>Wish List</span>
          </a>
        </li>
        @endif

        @if($hasAllPermissions)
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
        @endif

        @if($hasAllPermissions)
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-journal-text"></i><span>Manage Admin</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('manage-admin') }}">
                  <i class="bi bi-circle"></i><span>All Admin</span>
                </a>
              </li>
              <li>
                <a href="{{ route('add-admin') }}">
                  <i class="bi bi-circle"></i><span>Add Admin</span>
                </a>
              </li>
            </ul>
          </li>
          @endif
    </ul>

</aside><!-- End Sidebar-->
