@extends('layouts.navbar')

 



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
          
            <div class="">
                <span class="align-self-center" style="">
                    <img src="{{$learner->learner_image}}" style="width: 100px; height:100px; border-radius:50% ; border: solid thin black"/>
                </span>
             
                <h3 class="h3 mb-0">{{$learner->learner_name}}</h2><br>
              
            </div>
          
     
        @if ($learner!=null)
          <div class="row">
    
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

                            @foreach ($mainCourses as $mainCourse)
                              @if ($mainCourse->major=='english')

                              <div class="form-check"  style="margin-bottom:5px">
                                <input class="form-check-input" type="checkbox" name="{{$mainCourse->course_id}}" id="{{$mainCourse->course_id}}"
                                  @foreach ($coursesEnglish as $vipCourse)
                                      @if ($vipCourse==$mainCourse->course_id)
                                            checked 
                                      @endif
                                  @endforeach
                                />
                                <label class="form-check-label" for="{{$mainCourse->course_id}}">{{$mainCourse->title}}</label>
                              </div>

                              @endif
                            
                            @endforeach
                            
                            <!--Gold Plan-->
                            
                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="gold_plan" id="gold_plan"
                              @if($englishData->gold_plan==1) checked   @endif
                              />
                              <label class="form-check-label" for="gold_plan">Gold Plan</label>
                            </div>
                          
                            <input id="inputForm" type="text" name="amount" placeholder="Enter Amount"/>
                         
                         
                            
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
                        
                        

                        @foreach ($mainCourses as $mainCourse)
                            @if ($mainCourse->major=='korea')

                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="{{$mainCourse->course_id}}" id="{{$mainCourse->course_id}}"
                                @foreach ($coursesKorea as $vipCourse)
                                    @if ($vipCourse==$mainCourse->course_id)
                                          checked 
                                    @endif
                                @endforeach
                              />
                              <label class="form-check-label" for="{{$mainCourse->course_id}}">{{$mainCourse->title}}</label>
                            </div>

                            @endif
                          
                          @endforeach
                          
                          
                          <!--Gold Plan-->
                        
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="gold_plan" id="gold_plan"
                          @if($koreaData->gold_plan==1) checked   @endif
                          />
                          <label class="form-check-label" for="gold_plan">Gold Plan</label>
                        </div>
                          
                        <input id="inputForm" type="text" name="amount" placeholder="Enter Amount"/>
                        <input type="submit" class="btn btn-primary" value="Add to Vip" style="width:100%">
                     </form>
                </div>
            </div>
          @endif
          
            <!--Easy Chinese VIP input form-->
          @if($chineseData!=null)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div style="border:solid thin gray;border-radius:5px; margin:5px; padding:5px;">
                     <h5 class="h5" style="text-align:center;">Easy Chinese</h5>
                     
                     <p>Select course and add</p>
                    <form style="padding:5px;" action="{{route('addVip',$learner->id)}}" method="POST">
                        
                        @csrf
                        <input type="hidden" value="chinese" name="major">
                        
                        <!-- VIP mark -->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="vip_chinese" id="vip_chinese"
                          @if($chineseData->is_vip==1) checked   @endif
                          />
                          <label class="form-check-label" for="vip_chinese">VIP access</label>
                        </div>

                        @foreach ($mainCourses as $mainCourse)
                            @if ($mainCourse->major=='chinese')

                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="{{$mainCourse->course_id}}" id="{{$mainCourse->course_id}}"
                                @foreach ($coursesChinese as $vipCourse)
                                    @if ($vipCourse==$mainCourse->course_id)
                                          checked 
                                    @endif
                                @endforeach
                              />
                              <label class="form-check-label" for="{{$mainCourse->course_id}}">{{$mainCourse->title}}</label>
                            </div>

                            @endif
                          
                          @endforeach
                        <input id="inputForm" type="text" name="amount" placeholder="Enter Amount"/>
                        <input type="submit" class="btn btn-primary" value="Add to Vip" style="width:100%">
                     </form>
                </div>
            </div>
          @endif
          
          
           <!--Easy Japanese VIP input form-->
          @if($JapaneseData!=null)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div style="border:solid thin gray;border-radius:5px; margin:5px; padding:5px;">
                     <h5 class="h5" style="text-align:center;">Easy Japanese</h5>
                     
                     <p>Select course and add</p>
                    <form style="padding:5px;" action="{{route('addVip',$learner->id)}}" method="POST">
                        
                        @csrf
                        <input type="hidden" value="japanese" name="major">
                        
                        <!-- VIP mark -->
                        <div class="form-check"  style="margin-bottom:5px">
                          <input class="form-check-input" type="checkbox" name="vip_japanese" id="vip_japanese"
                          @if($JapaneseData->is_vip==1) checked   @endif
                          />
                          <label class="form-check-label" for="vip_japanese">VIP access</label>
                        </div>

                        @foreach ($mainCourses as $mainCourse)
                            @if ($mainCourse->major=='japanese')

                            <div class="form-check"  style="margin-bottom:5px">
                              <input class="form-check-input" type="checkbox" name="{{$mainCourse->course_id}}" id="{{$mainCourse->course_id}}"
                                @foreach ($coursesJapanese as $vipCourse)
                                    @if ($vipCourse==$mainCourse->course_id)
                                          checked 
                                    @endif
                                @endforeach
                              />
                              <label class="form-check-label" for="{{$mainCourse->course_id}}">{{$mainCourse->title}}</label>
                            </div>

                            @endif
                          
                          @endforeach
                        <input id="inputForm" type="text" name="amount" placeholder="Enter Amount"/>
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










