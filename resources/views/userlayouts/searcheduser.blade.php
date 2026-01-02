@extends('layouts.navbar')

@section('searchbox')

<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user with name or phone' style="min-width: 225px" name="msg" />
</form>

@endsection


@section('content')

<div class="card">
    <div class="card-body">
      
    @if(count($learners)>0)
        <div class="row g-3">
            @foreach($learners as $learner)
            <div class="col-xl-4 col-sm-6 col-12">
              <a href="{{route('detail')}}?phone={{$learner->learner_phone}}" class="user-search-card">
                <div class="d-flex align-items-center gap-3">
                      <div class="user-search-avatar">
                        <img src="{{$learner->learner_image}}" alt="{{$learner->learner_name}}"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{substr($learner->learner_name, 0, 1)}}%3C/text%3E%3C/svg%3E'"/>
                      </div>
                      <div class="flex-grow-1">
                        <h5 class="user-search-name mb-0">{{$learner->learner_name}}</h5>
                      </div>
                </div> 
              </a>
            </div>
            @endforeach
          </div>
        </div>
    @else 
    
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>No user was found!
    </div>
    
    @endif
    
</div>


@endsection