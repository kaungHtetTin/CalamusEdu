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

<body>
  <!--Main Navigation-->
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            
          <a href="{{route('overviewIndex')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">assessment</i><span>Project Overview</span></a>
            
          <a href="{{route('getUser')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">people</i><span>Users</span></a>
          <a href="{{route('showLessonMain')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">school</i><span>Lessons</span>
          </a>
          <a href="{{route('showWordOfTheDayMain')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">alarm</i><span>Word Of The Day</span>
          </a>
          <a href="{{route('showGameWordMain')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">extension</i><span>Game Words</span></a>
          <a href="{{route('showMainPostControllerView')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">public</i><span>Posts</span></a>
          <a href="{{route('showSongMain')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">queue_music</i><span>Songs</span></a>
            
          <a href="{{route('showCloudMessage')}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="material-icons me-3">send</i><span>Cloud Messaging</span></a>
         
        </div>
      </div>
    </nav>
    <!-- Sidebar -->
    @yield('navbar')
  </header>
  <!--Main Navigation-->
  <main style="margin-top: 58px">
    <div class="container pt-4">
      @yield('content')
    </div>
  </main>
  <!-- MDB -->
  <script type="text/javascript" src="{{asset("public/js/mdb.min.js")}}"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="{{asset("public/js/admin.js")}}"></script>

</body>

</html>