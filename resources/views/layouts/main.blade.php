<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Calamus Education</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="{{asset("public/css/mdb.min.css")}}" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  

</head>

<body class="admin-layout dark-theme">
  <!-- Top Bar -->
  <nav class="admin-topbar">
    <div class="topbar-content">
      <div class="topbar-left d-flex align-items-center">
        <button type="button" class="btn btn-link text-white p-2 me-2 drawer-toggle" id="drawerToggle">
          <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('overviewIndex') }}" style="font-weight: 600; font-size: 1.25rem;">
          Calamus Education
        </a>
      </div>

      <div class="topbar-center d-none d-lg-flex">
        <form class="topbar-search-form" action="{{route('searchUser')}}" method="GET">
          <div class="topbar-search-wrapper">
            <input type="search" class="topbar-search-input" name="msg" placeholder="Search user" autocomplete="off">
            <button type="submit" class="topbar-search-btn" style="display: none;">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>

      <div class="topbar-right d-flex align-items-center gap-2">
        <a href="{{ route('showAdminNotifications') }}" class="topbar-icon-btn" id="notificationBtn" title="Notifications" style="text-decoration: none; position: relative; color: inherit;">
          <i class="fas fa-bell"></i>
          @php
            $unreadNotificationsCount = \Illuminate\Support\Facades\DB::table('notification')
                ->where('owner_id', 10000)
                ->where('seen', 0)
                ->where('action', '<', 5)
                ->count();
          @endphp
          @if($unreadNotificationsCount > 0)
            <span class="notification-badge">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
          @else
            <span class="notification-badge" style="display: none;">0</span>
          @endif
        </a>
        <button type="button" class="topbar-icon-btn theme-toggle-btn" id="themeToggle" title="Switch to light mode">
          <i class="fas fa-sun"></i>
        </button>
        <div class="user-avatar-dropdown">
          <div class="user-avatar-top" id="userAvatarDropdown" style="cursor: pointer;">
            @if(session('admin_image') && !empty(session('admin_image')))
              <img src="{{ session('admin_image') }}" alt="{{ session('admin_name') ?? 'Admin' }}" class="avatar-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; display: block;">
              <div class="avatar-circle" style="display: none;">{{ strtoupper(substr(session('admin_name') ?? 'Admin', 0, 2)) }}</div>
            @else
              <div class="avatar-circle">{{ strtoupper(substr(session('admin_name') ?? 'Admin', 0, 2)) }}</div>
            @endif
          </div>
          <div class="user-dropdown-menu" id="userDropdownMenu">
            <div class="dropdown-header">
              <div class="dropdown-user-info">
                @if(session('admin_image') && !empty(session('admin_image')))
                  <img src="{{ session('admin_image') }}" alt="{{ session('admin_name') ?? 'Admin' }}" class="dropdown-avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; display: block;">
                  <div class="dropdown-avatar-fallback" style="display: none;">{{ strtoupper(substr(session('admin_name') ?? 'Admin', 0, 2)) }}</div>
                @else
                  <div class="dropdown-avatar-fallback">{{ strtoupper(substr(session('admin_name') ?? 'Admin', 0, 2)) }}</div>
                @endif
              </div>
              <div class="dropdown-user-details">
                <div class="dropdown-user-name">{{ session('admin_name') ?? 'Admin' }}</div>
                <div class="dropdown-user-role">Administrator</div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="{{ route('overviewIndex') }}" class="dropdown-item">
              <i class="fas fa-home"></i>
              <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="dropdown-item">
              <i class="fas fa-user-cog"></i>
              <span>Profile Settings</span>
            </a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
              @csrf
              <button type="submit" class="dropdown-item logout-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Drawer Overlay -->
  <div class="drawer-overlay" id="drawerOverlay"></div>

  <div class="admin-shell">
    <!-- Navigation Drawer -->
    <nav class="admin-sidebar drawer" id="navigationDrawer">
      @php($routeName = Route::currentRouteName())

      <div class="drawer-nav-content">
        <a href="{{ route('overviewIndex') }}" class="admin-nav-item {{ $routeName === 'overviewIndex' ? 'active' : '' }}">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('getUser') }}" class="admin-nav-item {{ request()->routeIs('getUser') ? 'active' : '' }}">
          <i class="fas fa-users"></i>
          <span>Users</span>
        </a>
        <a href="{{ route('lessons.main') }}" class="admin-nav-item {{ request()->routeIs('lessons.*') ? 'active' : '' }}">
          <i class="fas fa-graduation-cap"></i>
          <span>Lessons</span>
        </a>
        <a href="{{ route('showCoursesMain') }}" class="admin-nav-item {{ request()->routeIs('showCoursesMain') ? 'active' : '' }}">
          <i class="fas fa-book"></i>
          <span>Courses</span>
        </a>
        <a href="{{ route('teachers.index') }}" class="admin-nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
          <i class="fas fa-chalkboard-teacher"></i>
          <span>Teachers</span>
        </a>
        <a href="{{ route('languages.index') }}" class="admin-nav-item {{ request()->routeIs('languages.*') ? 'active' : '' }}">
          <i class="fas fa-globe"></i>
          <span>Languages</span>
        </a>
        <a href="{{ route('showWordOfTheDayMain') }}" class="admin-nav-item {{ request()->routeIs('showWordOfTheDayMain') ? 'active' : '' }}">
          <i class="fas fa-calendar-day"></i>
          <span>Word of the Day</span>
        </a>
        <a href="{{ route('showGameWordMain') }}" class="admin-nav-item {{ request()->routeIs('showGameWordMain') ? 'active' : '' }}">
          <i class="fas fa-gamepad"></i>
          <span>Game Words</span>
        </a>
        <a href="{{ route('showSongMain') }}" class="admin-nav-item {{ request()->routeIs('showSongMain') ? 'active' : '' }}">
          <i class="fas fa-music"></i>
          <span>Songs</span>
        </a>
        <a href="{{ route('showMainPostControllerView') }}" class="admin-nav-item {{ request()->routeIs('showMainPostControllerView') ? 'active' : '' }}">
          <i class="fas fa-newspaper"></i>
          <span>Posts</span>
        </a>
        <a href="{{ route('showCloudMessage') }}" class="admin-nav-item {{ request()->routeIs('showCloudMessage') ? 'active' : '' }}">
          <i class="fas fa-cloud"></i>
          <span>Cloud Messaging</span>
        </a>
        <a href="{{ route('showDialogueAdder') }}" class="admin-nav-item {{ request()->routeIs('showDialogueAdder') ? 'active' : '' }}">
          <i class="fas fa-comments"></i>
          <span>Speaking Training</span>
        </a>
      </div>
    </nav>

    <main class="admin-main">
      <div class="container-fluid py-4">
        @yield('content')
      </div>
    </main>
  </div>

  <!-- MDB -->
  <script type="text/javascript" src="{{asset("public/js/mdb.min.js")}}"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="{{asset("public/js/admin.js")}}"></script>
  @stack('scripts')

</body>

</html>