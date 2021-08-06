@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('content')
    

{{-- User Profile --}}
 <section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>Edit The Word</strong>
        </h5>
      </div>
      <div class="card-body">
            @if ($word!=null)
                <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <span class="align-self-center" style="">
                      <img src="{{$word->thumb}}" style="width: 160px; height:90px; border: solid thin black" class="rounded"/>
                    </span>
                    <br><br>
                    @if ($major=="korea")
                    <i class="south korea flag"></i>      
                    @endif
    
                    @if ($major=="english")
                    <i class="united kingdom flag"></i>      
                    @endif
                  
                    <span class="h5 mb-0">{{$word->$major}}</span>  ({{$word->speech}})<br>
                    <i class="myanmar flag"></i>
                    <span class="h5 mb-0">{{$word->myanmar}}</span>
                  </div>
                  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    {{$word->example}}
                  </div>
                </div>              
            @else
                <span class="h5 mb-0 text-danger">No word was found!</span>         
             @endif
        </div>
        <div class="card-body">
            <hr>
            <form method="post" action="{{route('updateWordDay')}}" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
                    @csrf
                    <input type="text"  value="{{$word->$major}}" name="word" id="inputForm" required /><br>
                    <input type="text"  value="{{$word->myanmar}}" name="myanmar" id="inputForm" required /><br>
                    <input type="text" value="{{$word->speech}}" name="speech" id="inputForm" required /><br>
                    <input type="hidden" value="{{$word->id}}" name="id" id="inputForm" required/><br>
                    <input type="file" value="Choose Image"  name="myfile">
                    <input type="hidden" value="{{$major}}" name="major"/>
                    <br><br><br>
                    <input type="submit" value="Save Changes" name="example" id="inputForm" class="btn-danger" /><br>
                  
                </div>
                <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
                  <textarea rows="10"placeholder="Example" id="inputForm" name="example" style="width: 100%; ">{{$word->example}}</textarea>
                  <p class="text-danger" style="font-size: 12px;">{{$errors->first('example')}}</p>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
</section>

@endsection





