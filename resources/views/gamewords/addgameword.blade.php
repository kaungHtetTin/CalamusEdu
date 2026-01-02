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
            <span class="h4 align-self-center">Add Game Word For {{ucwords($major)}}</span>
              <hr>
              <div class="row">

                <div class="col-xl-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;">
                    <h5>Display Word</h5>
                    <form action="{{route('addGameWord',$major)}}" method="POST">
                      @csrf
                      <input type="text" placeholder="Display Word" id="inputForm" name="displayword" style="width: 80%;"/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('displayword')}}</p>
                      <input type="text" placeholder="Ans - A" id="inputForm" name="ansA" style="width: 80%;" required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansA')}}</p>
                      <input type="text" placeholder="Ans - B" id="inputForm" name="ansB" style="width: 80%;" required/>
                      <p class="text-danger" style="True Ans: 12px;">{{$errors->first('ansB')}}</p>
                      <input type="text" placeholder="Ans - C" id="inputForm" name="ansC" style="width: 80%;" requried/>
                      <p class="text-danger" style="True Ans: 12px;">{{$errors->first('ansC')}}</p>
                      
                      <input type="hidden" value="1" name="category"/>
                      
                      <input type="radio" name="ans" value="a"/>  a &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="ans" value="b"/>  b &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="ans" value="c"/>  c 
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ans')}}</p>
                        <br><br>
                      <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                  </form>
                  </div>


                  <div class="col-xl-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;">
                    <h5>Display Audio</h5>
                    <form action="{{route('addGameWord',$major)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="text" placeholder="Ans - A" id="inputForm" name="ansA" style="width: 80%;" required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansA')}}</p>
                      <input type="text" placeholder="Ans - B" id="inputForm" name="ansB" style="width: 80%;" required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansB')}}</p>
                      <input type="text" placeholder="Ans - C" id="inputForm" name="ansC" style="width: 80%; " required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansC')}}</p>
                      
                       <input type="hidden" value="3" name="category"/>
                      
                    
                         Choose Audio<br>
                         <input type="file"  value="Choose Image"  name="myfile">
                     
                        <br><br>
                        <input type="radio" name="ans" value="a"/>  a &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ans" value="b"/>  b &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ans" value="c"/>  c 
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('ans')}}</p>
                        <br><br>
                      <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                  </form>
                  </div>

                  <div class="col-xl-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;">
                    <h5>Display Image</h5>
                    <form action="{{route('addGameWord',$major)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="text" placeholder="Ans - A" id="inputForm" name="ansA" style="width: 80%;" required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansA')}}</p>
                      <input type="text" placeholder="Ans - B" id="inputForm" name="ansB" style="width: 80%;" required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansB')}}</p>
                      <input type="text" placeholder="Ans - C" id="inputForm" name="ansC" style="width: 80%; " required/>
                      <p class="text-danger" style="font-size: 12px;">{{$errors->first('ansC')}}</p>
                      
                       <input type="hidden" value="2" name="category"/>
                      
                        Choose Image<br>
                        <input type="file" value="Choose Image"  name="myfile">
                      
                        <br><br>
                        <input type="radio" name="ans" value="a"/>  a &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ans" value="b"/>  b &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ans" value="c"/>  c 
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('ans')}}</p>
                        <br><br>
                      <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto"/>
                  </form>
                  </div>


                <div class="col-xl-6 col-sm-12 col-md-6 mb-2 rounded" style="padding: 20px;">
                    This is Image Area
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection