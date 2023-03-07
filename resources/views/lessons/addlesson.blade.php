@extends('layouts.navbar')

@section('content')

@php
    $lessonArr=session($course);
    $isChannel=($course=='Video Channel')?1 : 0;
 
@endphp


@if (session('msgLesson'))
<div class="card bg-success" id="customMessageBox">
    {{session('msgLesson')}}
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <span class="h4 align-self-center">Add {{$course}} in {{session('major')}}</span>
              <hr>
              <div class="row">
                <div class="col-xl-12 col-sm-12 col-12 mb-2 rounded" style="padding: 20px;">
                
                  <form action="{{route('addLesson',$course)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" placeholder="Enter Title Mini" id="inputForm" name="title_mini" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('title_mini')}}</p>
                    
                    <input type="text" placeholder="Enter Title Of Lesson" id="inputForm" name="title" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('title')}}</p>
                    
                    
                    <input type="text" placeholder="Enter youtube Id or Blog Link" id="inputForm" name="link" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('link')}}</p>
                    
                    <input type="text" placeholder="Enter vimeo Link" id="inputForm" name="vimeo" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('vimeo')}}</p>
                    
                    <input type="text" placeholder="Enter post" id="inputForm" name="post" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('post')}}</p>
                    <input type="hidden" name="major" value="{{session('major')}}"/>
        
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        @foreach ($lessonArr as $arr)
                        @php
                            $category=$arr->category_title;
                            $category_id=$arr->id;
                           
                        @endphp

                          <div class="form-check"  style="margin-bottom:5px">
                            <input class="form-check-input" type="radio" name="cate" id="{{$category_id}}" value="{{$category_id}}"/>
                            <label class="form-check-label" for="{{$category_id}}">{{$category}}</label>
                          </div>
                        @endforeach
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('cate')}}</p>
                        
                        <p>Video Thumbnail</p>
                         <input type="file" name="myfile"/> 
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="isVideo" id="isVideo" checked/>
                          <label class="form-check-label" for="isVideo">Video Lesson</label>
                        </div>
                        <br>
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="isChannel" id="isChannel" @if ($course=='Video Channel')
                              checked
                          @endif/>
                          <label class="form-check-label" for="isChannel">Is Channel?</label>
                        </div>
                        <br>
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="isVip" id="isVip"/>
                          <label class="form-check-label" for="isVip">VIP Lesson</label>
                        </div>
                        <br>
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="add_to_discuss" id="add_to_discuss" />
                          <label class="form-check-label" for="add_to_discuss">Add to discussion room</label>
                        </div>
                        
                      </div>
                    </div><br><br>
                    <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                </form>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection