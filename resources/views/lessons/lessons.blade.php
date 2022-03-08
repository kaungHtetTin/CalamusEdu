@extends('layouts.navbar')

@section('searchbox')

<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection
@section('content')

@php
    $formArr=json_decode($form);
    $firstForm=$formArr->firstform;
    $secondForm=$formArr->secondform;
    $videoForm=$formArr->videoform;
    session()->put('major',$major);
@endphp


@foreach ($firstForm as $courses)
@php
    $mainLesson=json_encode($courses->sub);
    session()->put($courses->title,$mainLesson);

@endphp

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
              <div>
                <span class="h4 align-self-center">{{$courses->title}}</span>
                <a href="{{route('showAddLesson',$courses->title)}}" style="float: right; margin-right:15px;">
                  <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
                    <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
                  </span>
                </a>
              </div>
              <hr>
              <div class="row">
                @foreach ($courses->sub as $sub)
                @php
                session()->put($sub->category_id,$sub->pic)
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 rounded">
                  <a href="{{route('showLessonList',$sub->category_id)}}?cate={{$sub->category}}&major={{$major}}" >
                  <div class="rounded" style="border:solid thin gray; padding:10px;margin:4px;">
                    <div class="d-flex justify-content-between px-md-1">
                      <div class="align-self-center" style="">
                        <img src="{{$sub->pic}}" style="width: 40px; height:40px;"/>
                      </div>
                      <div>
                        <h5 class="">{{$sub->category}}</h5>
                      </div>
                    </div>
                  </div></a>
                </div>
                @endforeach
              </div>
          </div>
      </div>
  </div>
</div>

@endforeach


@php
    $additionalLesson=json_encode($secondForm);
    session()->put('Additional Lesson',$additionalLesson);
@endphp
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <div>
              <span class="h4 align-self-center">Additional Lessons</span>
              <a href="{{route('showAddLesson','Additional Lesson')}}" style="float: right; margin-right:15px;">
                <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
                  <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
                </span>
              </a>
            </div>
              <hr>
              <div class="row">
                @foreach ($secondForm as $sub)
                @php
                session()->put($sub->category_id,$sub->pic)
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 rounded">
                  <a href="{{route('showLessonList',$sub->category_id)}}?cate={{$sub->category}}&major={{$major}}" >
                  
                  <div class="rounded" style="border:solid thin gray; padding:10px;margin:4px;">
                    <div class="d-flex justify-content-between px-md-1">
                      <div class="align-self-center" style="">
                        <img src="{{$sub->pic}}" style="width: 40px; height:40px;"/>
                      </div>
                      <div>
                        <h5 class="">{{$sub->category}}</h5>
                      </div>
                      
                      
                      
                    </div>
                  </div> </a>
                </div>
               
                @endforeach
              </div>
          </div>
      </div>
  </div>
</div>

@php
    $videoLesson=json_encode($videoForm);
    session()->put('Video Channel',$videoLesson);
@endphp

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
              <div>
                <span class="h4 align-self-center">Video Channels</span>
                <a href="{{route('showAddLesson','Video Channel')}}" style="float: right; margin-right:15px;">
                  <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
                    <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
                  </span>
                </a>
              </div>
              <hr>
              <div class="row">
                @foreach ($videoForm as $video)
                <div class="col-xl-3 col-sm-6 col-12 mb-2 rounded">
                  <a href="{{route('showLessonList',$video->category_id)}}?cate={{$video->category}}&major={{$major}}" >

                  <div class="rounded" style="border:solid thin gray; padding:10px;margin:4px;">
                    <div class="d-flex justify-content-between px-md-1">
                      <div class="align-self-center" style="">
                        <img src="{{asset('public/img/video.png')}}" style="width: 40px; height:40px;"/>
                      </div>
                      <div>
                        <h5 class="">{{$video->category}}</h5>
                      </div>
                    </div>
                  </div> </a>
                </div>
               
                @endforeach
              </div>
          </div>
      </div>
  </div>
</div>

@endsection