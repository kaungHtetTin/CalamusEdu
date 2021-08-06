@extends('layouts.navbar')

@section('content')


@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <span class="h4 align-self-center">Add Word Of The Day For {{ucwords($major)}}</span>
              <hr>
              
               <form enctype="multipart/form-data" action="{{route('addWordDay',$major)}}" method="POST">
                    @csrf
                  <div class="row">
                      
                    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;">
                     
                        <input type="text" placeholder="{{ucwords($major) }}" id="inputForm" name="{{$major}}" style="width: 100%;"/>
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first($major)}}</p>
                        <input type="text" placeholder="Myanmar" id="inputForm" name="myanmar" style="width: 100%;"/>
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('myanmar')}}</p>
                        <input type="text" placeholder="Speech" id="inputForm" name="speech" style="width: 100%;"/>
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('speech')}}</p>
                      
                        <input type="file" style="" value="Choose Image"  name="image">
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('image')}}</p>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;" >
                         <textarea rows="10" placeholder="Example" id="inputForm" name="example" style="width: 100%; "></textarea>
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('example')}}</p>
                    </div>
                 
                  </div>
                  
                    <br><br>
                    <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
               </form>
          </div>
      </div>
  </div>
</div>

@endsection