@extends('layouts.navbar')

@section('content')

<span class="h4 align-self-center">Songs Controlling</span>
<hr>
<div class="row">

  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyenglish.png')}}" style="width: 50px;height:50px"/>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showArtist','english')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Artists</div>
              </a>
              <a href="{{route('showRequestedSong','english')}}"  style="flex:1; margin:10px;">
                <div class="btn-primary rounded">Requested Songs</div>
              </a>
            </div>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showSongs','english')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Songs</div>
              </a>
            </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px"/>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showArtist','korea')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Artists</div>
              </a>
              <a href="{{route('showRequestedSong','korea')}}"  style="flex:1; margin:10px;">
                <div class="btn-primary rounded">Requested Songs</div>
              </a>
            </div>

            <div style="display: flex; margin-top:10px">
              <a href="{{route('showSongs','korea')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Songs</div>
              </a>
            </div>
        </div>
      </div>
    </div>
  </div>
  
    <div class="col-xl-6 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easychinese.png')}}" style="width: 50px;height:50px"/>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showArtist','chinese')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Artists</div>
              </a>
              <a href="{{route('showRequestedSong','chinese')}}"  style="flex:1; margin:10px;">
                <div class="btn-primary rounded">Requested Songs</div>
              </a>
            </div>

            <div style="display: flex; margin-top:10px">
              <a href="{{route('showSongs','chinese')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Songs</div>
              </a>
            </div>
        </div>
      </div>
    </div>
  </div>
  
   <div class="col-xl-6 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 50px;height:50px"/>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showArtist','japanese')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Artists</div>
              </a>
              <a href="{{route('showRequestedSong','japanese')}}"  style="flex:1; margin:10px;">
                <div class="btn-primary rounded">Requested Songs</div>
              </a>
            </div>

            <div style="display: flex; margin-top:10px">
              <a href="{{route('showSongs','japanese')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Songs</div>
              </a>
            </div>
        </div>
      </div>
    </div>
  </div>
  
    <div class="col-xl-6 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="" style="text-align: center;">
            <img src="{{asset('public/img/easyrussian.png')}}" style="width: 50px;height:50px"/>
            <div style="display: flex; margin-top:10px">
              <a href="{{route('showArtist','russian')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Artists</div>
              </a>
              <a href="{{route('showRequestedSong','russian')}}"  style="flex:1; margin:10px;">
                <div class="btn-primary rounded">Requested Songs</div>
              </a>
            </div>

            <div style="display: flex; margin-top:10px">
              <a href="{{route('showSongs','russian')}}" style="flex:1 ;margin:10px;">
                <div class="btn-primary rounded">Songs</div>
              </a>
            </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection