@extends('layouts.main')

@section('content')

<span class="h4 align-self-center">Post Quick Access</span>
<hr>

<div class="row mb-4">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Quick Actions</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="{{ route('postStatistics') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px solid var(--primary-color);">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div class="mb-3">
                    <i class="fas fa-chart-bar fa-3x" style="color: var(--primary-color);"></i>
                  </div>
                  <h6 class="card-title mb-0">View Statistics</h6>
                  <small class="text-muted">Post analytics & insights</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="{{ route('showMainPostControllerView') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px solid var(--primary-color);">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div class="mb-3">
                    <i class="fas fa-list fa-3x" style="color: var(--primary-color);"></i>
                  </div>
                  <h6 class="card-title mb-0">All Posts</h6>
                  <small class="text-muted">Browse all language posts</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="{{ route('showCloudMessage') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px solid var(--primary-color);">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div class="mb-3">
                    <i class="fas fa-bullhorn fa-3x" style="color: var(--primary-color);"></i>
                  </div>
                  <h6 class="card-title mb-0">Send Notification</h6>
                  <small class="text-muted">Push notifications</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="{{ route('overviewIndex') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px solid var(--primary-color);">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div class="mb-3">
                    <i class="fas fa-home fa-3x" style="color: var(--primary-color);"></i>
                  </div>
                  <h6 class="card-title mb-0">Dashboard</h6>
                  <small class="text-muted">Back to overview</small>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Language Timelines</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showTimeline', 'english') }}?mCode=ee&page=1" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center">
                <div class="card-body">
                  <div class="mb-3">
                    <img src="{{ asset('public/img/easyenglish.png') }}" style="width: 60px; height: 60px; border-radius: 50%;" alt="Easy English"/>
                  </div>
                  <h6 class="card-title mb-1">Easy English</h6>
                  <small class="text-muted">View timeline</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showTimeline', 'korea') }}?mCode=ko&page=1" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center">
                <div class="card-body">
                  <div class="mb-3">
                    <img src="{{ asset('public/img/easykorean.png') }}" style="width: 60px; height: 60px; border-radius: 50%;" alt="Easy Korean"/>
                  </div>
                  <h6 class="card-title mb-1">Easy Korean</h6>
                  <small class="text-muted">View timeline</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showTimeline', 'chinese') }}?mCode=cn&page=1" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center">
                <div class="card-body">
                  <div class="mb-3">
                    <img src="{{ asset('public/img/easychinese.png') }}" style="width: 60px; height: 60px; border-radius: 50%;" alt="Easy Chinese"/>
                  </div>
                  <h6 class="card-title mb-1">Easy Chinese</h6>
                  <small class="text-muted">View timeline</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showTimeline', 'japanese') }}?mCode=jp&page=1" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center">
                <div class="card-body">
                  <div class="mb-3">
                    <img src="{{ asset('public/img/easyjapanese.png') }}" style="width: 60px; height: 60px; border-radius: 50%;" alt="Easy Japanese"/>
                  </div>
                  <h6 class="card-title mb-1">Easy Japanese</h6>
                  <small class="text-muted">View timeline</small>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showTimeline', 'russian') }}?mCode=ru&page=1" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center">
                <div class="card-body">
                  <div class="mb-3">
                    <img src="{{ asset('public/img/easyrussian.png') }}" style="width: 60px; height: 60px; border-radius: 50%;" alt="Easy Russian"/>
                  </div>
                  <h6 class="card-title mb-1">Easy Russian</h6>
                  <small class="text-muted">View timeline</small>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Create New Post</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showCreatePost', 'english') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px dashed var(--primary-color);">
                <div class="card-body">
                  <div class="mb-2">
                    <i class="fas fa-plus-circle fa-2x" style="color: var(--primary-color);"></i>
                  </div>
                  <img src="{{ asset('public/img/easyenglish.png') }}" style="width: 40px; height: 40px; border-radius: 50%;" alt="Easy English"/>
                  <h6 class="card-title mb-0 mt-2">English Post</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showCreatePost', 'korea') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px dashed var(--primary-color);">
                <div class="card-body">
                  <div class="mb-2">
                    <i class="fas fa-plus-circle fa-2x" style="color: var(--primary-color);"></i>
                  </div>
                  <img src="{{ asset('public/img/easykorean.png') }}" style="width: 40px; height: 40px; border-radius: 50%;" alt="Easy Korean"/>
                  <h6 class="card-title mb-0 mt-2">Korean Post</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showCreatePost', 'chinese') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px dashed var(--primary-color);">
                <div class="card-body">
                  <div class="mb-2">
                    <i class="fas fa-plus-circle fa-2x" style="color: var(--primary-color);"></i>
                  </div>
                  <img src="{{ asset('public/img/easychinese.png') }}" style="width: 40px; height: 40px; border-radius: 50%;" alt="Easy Chinese"/>
                  <h6 class="card-title mb-0 mt-2">Chinese Post</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showCreatePost', 'japanese') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px dashed var(--primary-color);">
                <div class="card-body">
                  <div class="mb-2">
                    <i class="fas fa-plus-circle fa-2x" style="color: var(--primary-color);"></i>
                  </div>
                  <img src="{{ asset('public/img/easyjapanese.png') }}" style="width: 40px; height: 40px; border-radius: 50%;" alt="Easy Japanese"/>
                  <h6 class="card-title mb-0 mt-2">Japanese Post</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{ route('showCreatePost', 'russian') }}" class="quick-access-card" style="text-decoration: none; display: block;">
              <div class="card h-100 text-center" style="border: 2px dashed var(--primary-color);">
                <div class="card-body">
                  <div class="mb-2">
                    <i class="fas fa-plus-circle fa-2x" style="color: var(--primary-color);"></i>
                  </div>
                  <img src="{{ asset('public/img/easyrussian.png') }}" style="width: 40px; height: 40px; border-radius: 50%;" alt="Easy Russian"/>
                  <h6 class="card-title mb-0 mt-2">Russian Post</h6>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
