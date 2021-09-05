@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('content')
{{-- User Profile --}}
<section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>{{$cate}}</strong>
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
            @foreach ($lessons as $lesson)
            @php
                if($lesson->isVideo==1){
                  $viewLesson=route('viewVideoLesson',$lesson->id);
                }else{
                  $viewLesson=route('viewBlogLesson',$lesson->id);
                }
              
            @endphp
            <div class="col-xl-12 col-sm-6 col-12 mb-2 rounded">
              <a href="{{$viewLesson}}" style="text-decoration: none">
              <div class="rounded" style="border:solid thin gray; padding:10px;margin:4px;">
                <div class="d-flex">
                  <span class="align-self-center" style="">
                      @if ($lesson->isVideo==1)
                      <img src="https://img.youtube.com/vi/{{$lesson->link}}/0.jpg" style="width: 50px; height:40px;"/>
                      @else
                      <img src="{{$icon}}" style="width: 40px; height:40px;"/>
                      @endif
                  </span>
                  <div style="color: rgb(85, 85, 85); margin-left:5px;" class="align-self-center">
                    <h6 class="h6">{{$lesson->title}}</h6>
                  </div>
                </div>
              </div> </a>
            </div>
           
            @endforeach
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
