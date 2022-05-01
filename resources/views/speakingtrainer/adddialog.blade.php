@extends('layouts.navbar')

@section('content')



@if (session('msgLesson'))
<div class="card bg-success" id="customMessageBox">
    {{session('msgLesson')}}
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <span class="h4 align-self-center">Add Dialogue For English Speaking Trainner</span>
              <hr>
              <div class="row">
                <div class="col-xl-8 col-sm-12 col-8 mb-2 rounded" style="padding: 20px;">
                
                  <form action="{{route('addDialogue')}}" method="POST">
                    @csrf
                    <input type="text" placeholder="Person A English" id="inputForm" name="person_a" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('person_a')}}</p>
                    
                    <input type="text" placeholder="Person A Myanmar" id="inputForm" name="person_a_mm" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('person_a_mm')}}</p>
                    
                    <input type="text" placeholder="Person B English" id="inputForm" name="person_b" style="width: 80%; margin-bottom:20px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('person_b')}}</p>
                    
                    <input type="text" placeholder="Person B Myanmar" id="inputForm" name="person_b_mm" style="width: 80%; margin-bottom:20px"/>
                     <p class="text-danger" style="font-size: 12px;">{{$errors->first('person_b_mm')}}</p>
    
                     <select id="inputForm" name="saturation" style="flex-wrap: wrap;">
                          @foreach($saturations as $saturation)
                         <option value="{{$saturation->saturation_id}}">{{$saturation->title}}</option>
                          @endforeach
                     </select>
                       
        
                    <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                </form>
                </div>
                
                 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                     <h6>Add New Saturation</h6>
                     
                     <form action="{{route('addNewSaturation')}}" method="POST">
                         @csrf
                         <input type="text" placeholder="Title" id="inputForm" name="title" style="width: 80%; margin-bottom:20px"/>
                         <p class="text-danger" style="font-size: 12px;">{{$errors->first('title')}}</p>
                         <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                     </form>
                    
                  </div>
                      
              </div>
          </div>
      </div>
  </div>
</div>

@endsection