@extends('layouts.navbar')

@section('content')


@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

@if (session('error'))
<div class="card bg-danger" id="customMessageBox">
    {{session('error')}}
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
      <div class="card">
          <div class="card-body">
            <span class="h4 align-self-center">
                Add an Artist ({{ucwords($major)}})
              <hr>
              <div class="row">
                <div class="col-xl-12 col-sm-12 col-12 mb-2 rounded" style="padding: 20px;">
                
                  <form action="{{route('addArtist')}}" method="POST">
                    @csrf
                    <input type="text" placeholder="Enter Artist Name" id="inputForm" name="name" style="width: 80%; margin-bottom:15px"/>
                    <p class="text-danger" style="font-size: 12px;">{{$errors->first('name')}}</p>
                    <input type="hidden" name="major" value="{{$major}}"/>
        
                    <br><br>
                    <input type="submit"  class="btn-primary rounded" value="Add" style="width: 150px; margin:auto; font-size:20px"/>
                </form>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection