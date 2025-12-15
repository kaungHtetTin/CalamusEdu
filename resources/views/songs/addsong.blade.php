@extends('layouts.navbar')

@section('content')


@if (session('msgSong'))
<div class="card bg-success" id="customMessageBox">
    {{session('msgSong')}}
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <span class="h4 align-self-center">
                @if ($major=="english")
                    Add an English Song
                @else
                    Add a {{ucwords($major)}} Song
                @endif
            </span> 
              <hr>
              <div class="row">
                <div class="col-xl-12 col-sm-12 col-12 mb-2 rounded" style="padding: 20px;">
                
                  <form action="{{route('addSong',$major)}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <input type="text" placeholder="Enter Title Of Song" id="inputForm" name="title" style="width: 80%; margin-bottom:15px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('title')}}</p>
                    <input type="text" placeholder="Enter Artist Name" id="inputForm" name="artist" style="width: 80%; margin-bottom:15px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('artist')}}</p>
                    <input type="text" placeholder="Enter Drama Name Or Single Artist" id="inputForm" name="drama" style="width: 80%; margin-bottom:15px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('drama')}}</p>
                    <input type="hidden" name="major" value="{{$major}}"/>
                    <br>
                    
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                           mp3 (.mp3)<br>
                          <i class="material-icons me-3">audiotrack</i>
                          <input type="file" accept=".mp3"name="audioFile"/>
                          <p class="text-danger" style="font-size: 12px;">{{$errors->first('audioFile')}}</p>
                          <br><br>
                        </div>
                        <div class="col-xl-4 col-lg-4col-md-12 col-sm-12">
                          Image (.png) for Mobile<br>
                          <i class="material-icons me-3">insert_photo</i>
                          <input type="file" accept=".png" name="imageFile"/>
                          <p class="text-danger" style="font-size: 12px;">{{$errors->first('imageFile')}}</p>
                          <br><br>
                        </div>
                        <div class="col-xl-4 col-lg-4col-md-12 col-sm-12">
                          Image (.png) for Web<br>
                          <i class="material-icons me-3">insert_photo</i>
                          <input type="file" accept=".png" name="imageFileWeb"/>
                          <p class="text-danger" style="font-size: 12px;">{{$errors->first('imageFileWeb')}}</p>
                          <br><br>
                        </div>
                        
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                          Lyrics Text (.txt)<br>
                          <i class="material-icons me-3">insert_comment</i>
                          <input type="file" accept=".txt" name="lyricsFile"/>
                          <p class="text-danger" style="font-size: 12px;">{{$errors->first('lyricsFile')}}</p>
                          <br><br>
                        </div>
                      </div>
                
                    
                    <br><br>
                    <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto; font-size:20px"/>
                </form>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection