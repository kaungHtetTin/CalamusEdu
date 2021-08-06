@extends('layouts.navbar')

@section('content')

<span class="h4 align-self-center">Lessons Controlling</span>
<hr>
<div class="row">

  <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showLessonCategory','english')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyenglish.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy English</h5>   
        </div>
      </div>
    </div></a>
  </div>
  <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showLessonCategory','korea')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy Korean</h5>        
        </div>
      </div>
    </div></a>
  </div>
</div>
@endsection