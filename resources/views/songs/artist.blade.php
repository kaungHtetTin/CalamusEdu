@extends('layouts.navbar')

@section('content')

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

@if (session('error'))
<div class="card bg-danger" id="customMessageBox">
    {{session('error')}}
</div>
@endif

<div>
<span class="h4 align-self-center">{{ucwords($major)}} Artists</span>
<a href="{{route('showAddArtist',$major)}}" style="float: right; margin-right:15px;">
    <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
      <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
    </span>
  </a>
<hr>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                  @foreach ($artists as $artist)

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="display: flex;">
                      <a label class="py-2 ripple"  href="{{route('showRequestedSongByArtist',$artist->id)}}" style="text-decoration:none;flex:4.5;cursor: pointer;padding:5px; border:solid thin black; border-radius:3px;margin:3px;">
                        <div style="">
                         
                            <h5 class="h5">{{$artist->name}}</h5>
  
                        </div>
                      </a> 
                        <label class="py-2 ripple" for="{{$artist->id}}" style="padding:5px; border:solid thin black; border-radius:3px;margin:3px;text-align:center;cursor:pointer;">
                        <div>
                          <form method="POST" action="{{route('deleteArtist')}}">  
                          @csrf
                            <input type="hidden" value="{{$artist->id}}" name="id"/>
                            <input type="hidden" value="{{$artist->name}}" name="artist"/>
                            <label for="{{$artist->id}}"> <i class="fa fa-trash" style="color:rgb(255, 53, 53);cursor:pointer" aria-hidden="true"></i></label>
                           <input type="submit" id="{{$artist->id}}" style="display: none"/>
                          </form>
                       </div>
                      </label>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection