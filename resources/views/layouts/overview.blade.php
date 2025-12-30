 @extends('layouts.navbar')
 
 @section('searchbox')

<form class="d-none d-md-flex input-group w-auto my-auto" action="{{ route('searchUser') }}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder="Search user by name or phone" style="min-width: 260px" name="msg" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection

@section('content')
@php
  $totalByMajor = $korean_user_count + $english_user_count + $chinese_user_count + $japanese_user_count + $russian_user_count;
  $share = function ($count) use ($learner_count) {
      return $learner_count > 0 ? round(($count / $learner_count) * 100) : 0;
  };
@endphp

  <div class="mb-4">
    <h4 class="mb-1">Dashboard</h4>
    <p class="text-muted mb-0">High level overview of your learners and language apps.</p>
  </div>

  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <small class="text-muted text-uppercase">Total users</small>
          <h2 class="mt-2 mb-1">{{ number_format($learner_count) }}</h2>
          <p class="text-muted mb-0">All learners across all Easy* apps.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <small class="text-muted text-uppercase">Tracked by language</small>
          <h4 class="mt-2 mb-1">{{ number_format($totalByMajor) }}</h4>
          <p class="text-muted mb-0">Users who have activity in a specific Easy* app.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <small class="text-muted text-uppercase">Active properties</small>
          <h4 class="mt-2 mb-1">5</h4>
          <p class="text-muted mb-0">Easy English, Korean, Chinese, Japanese, Russian.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-7 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Users by language</span>
        </div>
        <div class="card-body">
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('public/img/easyenglish.png') }}" style="width: 32px; height:32px" class="me-2"/>
              <strong>Easy English</strong>
            </div>
            <span>{{ number_format($english_user_count) }} ({{ $share($english_user_count) }}%)</span>
          </div>
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('public/img/easykorean.png') }}" style="width: 32px; height:32px" class="me-2"/>
              <strong>Easy Korean</strong>
            </div>
            <span>{{ number_format($korean_user_count) }} ({{ $share($korean_user_count) }}%)</span>
          </div>
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('public/img/easychinese.png') }}" style="width: 32px; height:32px" class="me-2"/>
              <strong>Easy Chinese</strong>
            </div>
            <span>{{ number_format($chinese_user_count) }} ({{ $share($chinese_user_count) }}%)</span>
          </div>
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('public/img/easyjapanese.png') }}" style="width: 32px; height:32px" class="me-2"/>
              <strong>Easy Japanese</strong>
            </div>
            <span>{{ number_format($japanese_user_count) }} ({{ $share($japanese_user_count) }}%)</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="{{ asset('public/img/easyrussian.png') }}" style="width: 32px; height:32px" class="me-2"/>
              <strong>Easy Russian</strong>
            </div>
            <span>{{ number_format($russian_user_count) }} ({{ $share($russian_user_count) }}%)</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 mb-4">
      <div class="card h-100">
        <div class="card-header">
          Quick actions
        </div>
        <div class="card-body">
          <div class="list-group list-group-flush">
            <a href="{{ route('getUser') }}" class="list-group-item list-group-item-action">
              Manage users
            </a>
            <a href="{{ route('lessons.main') }}" class="list-group-item list-group-item-action">
              Manage lessons
            </a>
            <a href="{{ route('showSongMain') }}" class="list-group-item list-group-item-action">
              Manage songs
            </a>
            <a href="{{ route('showMainPostControllerView') }}" class="list-group-item list-group-item-action">
              Review posts
            </a>
            <a href="{{ route('showCloudMessage') }}" class="list-group-item list-group-item-action">
              Send push notification
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection