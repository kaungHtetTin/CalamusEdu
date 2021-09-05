@extends('layouts.navbar')

@php

    //Easy English
    $basic_english=in_array( "Basic English Course", $coursesEnglish)?true:false;
    $voa=in_array( "Let's Learn English (VOA)", $coursesEnglish)?true:false;
    
    //Easy Korean
    $basic_korea=in_array( "Basic course", $coursesKorea)?true:false;
    $lv_one_korea=in_array( "Level One Course", $coursesKorea)?true:false;
    $lv_two_korea=in_array( "Level Two Course", $coursesKorea)?true:false;
    $lv_three_korea=in_array( "Level Three Course", $coursesKorea)?true:false;
    $lv_four_korea=in_array( "Level Four Course", $coursesKorea)?true:false;
    $kdrama=in_array( "Lesson With K-Drama", $coursesKorea)?true:false;
    $kTranslation=in_array("Translation", $coursesKorea)?true:false;
    $DramaLyrics=in_array("DramaLyrics", $coursesKorea)?true:false;
    $KidSong=in_array("KidSong", $coursesKorea)?true:false;
    $kGeneral=in_array("kGeneral", $coursesKorea)?true:false;

@endphp




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
          <strong>Vip Registration Setting</strong>
        </h5>
      </div>
      <div class="card-body">
     
        @if ($learner!=null)
          <div class="row">
        
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <span class="align-self-center" style="">
                    <img src="{{$learner->learner_image}}" style="width: 100px; height:100px; border-radius:50% ; border: solid thin black"/>
                </span>
             
                <h3 class="h3 mb-0">{{$learner->learner_name}}</h2><br>
              
            </div>
            
           <!--Easy English VIP input form-->
            @if($englishData!=null)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div style="border:solid thin gray;border-radius:5px; margin:5px; padding:5px;">
                         <h5 class="h5" style="text-align:center;">Easy English</h5>
                        
                         <p>Select course and add</p>
                         <form style="padding:5px;" action="{{route('addVip',$learner->id)}}" method="POST">
                             @csrf;
                            <input type="hidden" value="english" name="major">
                            
                            <!-- VIP mark -->
                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="vip_english" id="vip_english"
                              @if($englishData->is_vip==1) checked   @endif
                              />
                              <label class="form-check-label" for="vip_english">VIP access</label>
                            </div>
                            
                            <!--basic course-->
                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="basic_english" id="basic_english"
                                @if($basic_english) checked   @endif
                              />
                              <label class="form-check-label" for="basic_english">Basic Course</label>
                            </div>
                            
                            <!--voa course-->
                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="voa" id="voa"
                                @if($voa) checked   @endif
                              />
                              <label class="form-check-label" for="voa">Let's Learn English (VOA)</label>
                            </div>
                            
                            <input type="submit" class="btn btn-primary" value="Add to Vip" style="width:100%">
                         </form>
                    </div>
                  
                </div>
            @endif
           
           <!--Easy Korea VIP input form-->
          @if($koreaData!=null)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div style="border:solid thin gray;border-radius:5px; margin:5px; padding:5px;">
                     <h5 class="h5" style="text-align:center;">Easy Korean</h5>
                     
                     <p>Select course and add</p>
                    <form style="padding:5px;" action="{{route('addVip',$learner->id)}}" method="POST">
                        
                        @csrf
                        <input type="hidden" value="korea" name="major">
                        
                        <!-- VIP mark -->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="vip_korea" id="vip_korea"
                          @if($koreaData->is_vip==1) checked   @endif
                          />
                          <label class="form-check-label" for="vip_korea">VIP access</label>
                        </div>
                        
                        
                        <!--basic course-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="basic_korea" id="basic_korea"
                          @if($basic_korea) checked   @endif
                          />
                          <label class="form-check-label" for="basic_korea">Basic Course</label>
                        </div>
                        
                        <!--level one  course-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="lv_one_korea" id="lv_one_korea"
                             @if($lv_one_korea) checked   @endif
                          />
                          <label class="form-check-label" for="lv_one_korea">Level One Course</label>
                        </div>
                        
                         <!--level two  course-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="lv_two_korea" id="lv_two_korea"
                             @if($lv_two_korea) checked   @endif
                          />
                          <label class="form-check-label" for="lv_two_korea">Level Two Course</label>
                        </div>
                        
                        
                         <!--level three  course-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="lv_three_korea" id="lv_three_korea"
                             @if($lv_three_korea) checked   @endif
                          />
                          <label class="form-check-label" for="lv_three_korea">Level Three Course</label>
                        </div>
                        
                        
                         <!--level four course-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="lv_four_korea" id="lv_four_korea"
                             @if($lv_four_korea) checked   @endif
                          />
                          <label class="form-check-label" for="lv_four_korea">Level Four Course</label>
                        </div>
                        
                          <!--lesson with k drama -->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="kdrama" id="kdrama" 
                             @if($kdrama) checked   @endif
                          />
                          <label class="form-check-label" for="kdrama">Lesson With K-Drama</label>
                        </div>
                        
                          <!--Translation video channel-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="kTranslation" id="kTranslation" 
                             @if($kTranslation) checked   @endif
                          />
                          <label class="form-check-label" for="kTranslation">Translation</label>
                        </div>
                        
                          <!--Dramalyrics video channel-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="DramaLyrics" id="DramaLyrics" 
                             @if($DramaLyrics) checked   @endif
                          />
                          <label class="form-check-label" for="DramaLyrics">Drama Lyrics</label>
                        </div>
                        
                        
                          <!--Kid song video channel -->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="KidSong" id="KidSong" 
                             @if($KidSong) checked   @endif
                          />
                          <label class="form-check-label" for="KidSong">Kid Song</label>
                        </div>
                        
                        
                          <!--General video channel-->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="kGeneral" id="kGeneral" 
                             @if($kGeneral) checked   @endif
                          />
                          <label class="form-check-label" for="kGeneral">General</label>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Add to Vip" style="width:100%">
                     </form>
                </div>
            </div>
          @endif
    
        </div>
        
    
         @else
            <span class="h5 mb-0 text-danger">No user was found!</span>         
         @endif
        </div>
       
      </div>
    </div>
</section>
@endsection










