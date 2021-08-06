@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>
@endsection

@section('content')

@if (session('resetSuccess'))
<div class="card bg-success" id="customMessageBox">
    {{session('resetSuccess')}}
</div>
@endif

@if (session('resetErr'))
<div class="card bg-success" id="customMessageBox">
    {{session('resetErr')}}
</div>
@endif

{{-- User Profile --}}
 <section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>Password Reset</strong>
        </h5>
      </div>
      <div class="card-body">
            @if ($learner!=null)
                <span class="align-self-center" style="">
                    <img src="{{$learner->learner_image}}" style="width: 100px; height:100px; border-radius:50% ; border: solid thin black"/>
                </span>
                <h3 class="h3 mb-0">{{$learner->learner_name}}</h2><br>
                
                <br><br>
              
                <form action="{{route('resetPassword')}}" method="POST">
                    @csrf
                    <input type="text" placeholder="Enter the new password" id="inputForm" name="password"/>
                    <input type="hidden" name="phone" value="{{$learner->learner_phone}}"/>
                    <input type="submit" class="btn-danger rounded" value="Reset"/><br>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('password')}}</p>
                </form>
              
               
            
            @else
                <span class="h5 mb-0 text-danger">No user was found!</span>         
             @endif
        </div>
       
      </div>
    </div>
</section>

@endsection

















