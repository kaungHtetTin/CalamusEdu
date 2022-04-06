@extends('layouts.navbar')

@section('searchbox')

<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection
@section('content')

@foreach ($myCourses as $myCourse)

@php
    
    session()->put($myCourse['title'],$myCourse['data']);
    session()->put('major',$major);

@endphp
     
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
              <div>
                <span class="h4 align-self-center">{{$myCourse['title']}}</span>
                <a href="{{route('showAddLesson',$myCourse['title'])}}" style="float: right; margin-right:15px;">
                  <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
                    <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
                  </span>
                </a>
              </div>
              <hr>
              <div class="row">
                @foreach ($myCourse['data'] as $sub)
                @php
                
                @endphp
                <div class="col-xl-3 col-sm-6 col-12 mb-2 rounded">
                  <a href="{{route('showLessonList',$sub->id)}}?cate={{$sub->category}}&major={{$major}}" >
                  <div class="rounded" style="border:solid thin gray; padding:10px;margin:4px;">
                    <div class="d-flex">
                      <div class="align-self-center">
                        @if ($sub->course_id==9)
                          
                          <img src="https://www.calamuseducation.com/uploads/icons/videoplaylist.png" style="width: 40px; height:40px;"/>
                            
                        @else
                              <img src="{{$sub->image_url}}" style="width: 40px; height:40px;"/>
                        @endif
                          
                      </div>
                      <div class="align-self-center" style="margin-left:5px;">
                        <h5>{{$sub->category_title}}</h5>
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

@endsection