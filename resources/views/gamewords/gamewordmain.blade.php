@extends('layouts.navbar')

@section('content')

<span class="h4 align-self-center">Game Word Controlling</span>
<hr>
<div class="row">

  <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showGameWord','english')}}">
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
    <a href="{{route('showGameWord','korea')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy Korean</h5>        
        </div>
      </div>
    </div></a>
  </div>
  
    <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showGameWord','chinese')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easychinese.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy Chinese</h5>        
        </div>
      </div>
    </div></a>
  </div>
  
    <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showGameWord','japanese')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy Japanese</h5>        
        </div>
      </div>
    </div></a>
  </div>
  
  
    <div class="col-xl-6 col-md-6 mb-4">
    <a href="{{route('showGameWord','russian')}}">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyrussian.png')}}" style="width: 50px;height:50px"/>
            <h5>Easy Russian</h5>        
        </div>
      </div>
    </div></a>
  </div>
   
  
</div>
@endsection