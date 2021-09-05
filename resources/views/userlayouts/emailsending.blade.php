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

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

@if (session('err'))
<div class="card bg-success" id="customMessageBox">
    {{session('err')}}
</div>
@endif

{{-- User Profile --}}
 <section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>Send Email</strong>
        </h5>
      </div>
      <div class="card-body">
        @if ($learner!=null)
          <div class="row">
              
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <span class="align-self-center" style="">
                    <img src="{{$learner->learner_image}}" style="width: 100px; height:100px; border-radius:50% ; border: solid thin black"/>
                </span>
                <h3 class="h3 mb-0">{{$learner->learner_name}}</h2><br>
                @if($learner->learner_email=="")
                <p class="text-danger">{{$learner->learner_name}} did not input email address.</p>
                <p class="text-danger">We cannot send email to this user.</p>
                @endif
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                  <form action="{{route('sendEmail')}}" method="POST">
                    @csrf
                    <div style="display:flex">
                        <div style="width:70px" class="align-self-center">To:</div>
                        <input type="text" placeholder="User Email" id="inputForm" name="email" value="{{$learner->learner_email}}" style="width:100%"/><br>
                        
                    </div>
                     <p class="text-danger" style="font-size: 12px;">{{$errors->first('email')}}</p>
                    <div style="display:flex">
                        <div style="width:70px" class="align-self-center">Header:</div>
                        <input type="text" placeholder="Header" id="inputForm" name="header" value="calamuseducation@calamuseducation.com" style="width:100%"/><br>
                    </div>
                     <p class="text-danger" style="font-size: 12px;">{{$errors->first('header')}}</p>
                    <div style="display:flex">
                        <div style="width:70px" class="align-self-center">Subject:</div>
                        <input type="text" placeholder="Subject" id="inputForm" name="subject" style="width:100%"/><br>
                    </div>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('subject')}}</p>
                    <input type="hidden" name="id" value="{{$learner->id}}"/>
                    
                    <textarea name="msg" placeholder="Type Email Here" style="width:100%;margin-top:7px" rows="6"></textarea></textarea>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('msg')}}</p> 
                    <br><br>
                    <input type="submit" class="btn-primary rounded" value="Send"/><br>
                  
                </form>
            </div>
        </div>
        
    
         @else
            <span class="h5 mb-0 text-danger">No user was found!</span>         
         @endif
        </div>
       
      </div>
    </div>
</section>

@endsection










