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
          <strong>Send Notification</strong>
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

                @if($koreaData==null)
                <p class="text-danger">We cannot send notification to this user for Easy Korean</p>
                @endif
                @if($englishData==null)
                <p class="text-danger">We cannot send notification to this user for Easy English</p>
                @endif
             
              
            </div>
          
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                <form action="{{route('pushNotification')}}" method="POST">
                  @csrf
                  <div style="display:flex">
                      <div style="width:100px" class="align-self-center">Title:</div>
                      <input type="text" placeholder="Notification title" id="inputForm" name="title" style="width:100%"/><br>
                      
                  </div>
                   <p class="text-danger" style="font-size: 12px;">{{$errors->first('title')}}</p>

                  <div style="display:flex">
                      <div style="width:100px;margin-top:10px;">Message:</div>
                      <textarea name="msg" id="inputForm" placeholder="Enter Notification Message" style="width:100%;margin-top:7px" rows="6"></textarea></textarea>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('msg')}}</p> 
                  </div>
                  <br><br>
                  <div style="display:flex">
                  <div style="width:100px;" class="align-self-center"> App: </div>
                  <select id="inputForm" name="app"> 
                      @if ($englishData!=null)
                        <option value="{{$englishData->token}}">Easy English</option>
                       @endif
                      @if ($koreaData!=null)
                        <option value="{{$koreaData->token}}">Easy Korean</option>
                      @endif
                      
                      @if ($chineseData!=null)
                        <option value="{{$chineseData->token}}">Easy Chinese</option>
                      @endif
                      
                      @if ($japaneseData!=null)
                        <option value="{{$japaneseData->token}}">Easy Japanese</option>
                      @endif
                  </select>
                  </div>
                  <br><br>

                  <div style="display:flex">
                      <div style="width:100px;" class="align-self-center"></div>
                      <input type="submit" class="btn-primary rounded" value="Send" style="float: left;"/><br>
                  </div>
                 
                
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










