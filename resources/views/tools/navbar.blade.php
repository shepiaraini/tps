<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle" href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown pe-3">
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <span class="d-none d-md-block dropdown-toggle ps-2">
          @if (Auth::check())
            {{ Auth::user()->name }}
          @else
            Login
          @endif
        </span>
      </a><!-- End Profile Image Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        @if (Auth::check())
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
              <i class="bi bi-box-arrow-right"></i>
              <span>Logout</span>
            </a>
          </li>
        @else
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
              <i class="bi bi-person"></i>
              <span>Login</span>
            </a>
          </li>
        @endif
      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->
