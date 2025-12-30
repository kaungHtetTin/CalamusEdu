<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
            <i class="fas fa-search topbar-search-icon"></i>
            <input type="search" class="topbar-search-input" name="msg" placeholder="Search user" autocomplete="off">
            <button type="submit" class="topbar-search-btn" style="display: none;">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>

      <div class="topbar-right d-flex align-items-center gap-2">
        <button type="button" class="topbar-icon-btn" id="notificationBtn" title="Notifications">
          <i class="fas fa-bell"></i>
          <span class="notification-badge">0</span>
        </button>
        <button type="button" class="topbar-icon-btn theme-toggle-btn" id="themeToggle" title="Switch to light mode">
          <i class="fas fa-sun"></i>
        </button>
        <div class="user-avatar-top">
          <div class="avatar-circle">CA</div>
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
          <i class="material-icons">assessment</i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('getUser') }}" class="admin-nav-item {{ request()->routeIs('getUser') ? 'active' : '' }}">
          <i class="material-icons">people</i>
          <span>Users</span>
        </a>
        <a href="{{ route('lessons.main') }}" class="admin-nav-item {{ request()->routeIs('lessons.*') ? 'active' : '' }}">
          <i class="material-icons">school</i>
          <span>Lessons</span>
        </a>
        <a href="{{ route('showWordOfTheDayMain') }}" class="admin-nav-item {{ request()->routeIs('showWordOfTheDayMain') ? 'active' : '' }}">
          <i class="material-icons">alarm</i>
          <span>Word of the Day</span>
        </a>
        <a href="{{ route('showGameWordMain') }}" class="admin-nav-item {{ request()->routeIs('showGameWordMain') ? 'active' : '' }}">
          <i class="material-icons">extension</i>
          <span>Game Words</span>
        </a>
        <a href="{{ route('showSongMain') }}" class="admin-nav-item {{ request()->routeIs('showSongMain') ? 'active' : '' }}">
          <i class="material-icons">queue_music</i>
          <span>Songs</span>
        </a>
        <a href="{{ route('showMainPostControllerView') }}" class="admin-nav-item {{ request()->routeIs('showMainPostControllerView') ? 'active' : '' }}">
          <i class="material-icons">public</i>
          <span>Posts</span>
        </a>
        <a href="{{ route('showCloudMessage') }}" class="admin-nav-item {{ request()->routeIs('showCloudMessage') ? 'active' : '' }}">
          <i class="material-icons">send</i>
          <span>Cloud Messaging</span>
        </a>
        <a href="{{ route('showDialogueAdder') }}" class="admin-nav-item {{ request()->routeIs('showDialogueAdder') ? 'active' : '' }}">
          <i class="material-icons">forum</i>
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