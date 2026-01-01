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
        <div class="row">
            @foreach($learners as $learner)
            <div class="col-xl-4 col-sm-6 col-12 mb-4">
              <a href="{{route('detail')}}?phone={{$learner->learner_phone}}" style="text-decoration: none">
                <div class="d-flex justify-content-between px-md-1" style="border:solid thin gray; border-radius:3px;padding:10px;">
                      <div class="align-self-center">
                        <img src="{{$learner->learner_image}}" style="width: 40px; height:40px; border-radius:50%;margin-left:5px"/>
                      </div>
                      <div style="margin-right:5px;">
                        <h5 class="">{{$learner->learner_name}}</h5>
                      </div>
                </div> 
              </a>
            </div>
            @endforeach
          </div>
        </div>
    @else 
    
    <div class = "alert alert-warning">
        No user was found!
    </div>
    
    @endif
    
</div>


@endsection