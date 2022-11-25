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
                <strong>Create Post</strong>
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12" style="text-align: center">
                    @if ($major=='english')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easyenglish.png')}}">
                        <h6 class="h6">Easy English</h6>
                    @elseif($major=='korea')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easykorean.png')}}">
                        <h6 class="h6">Easy Korean</h6>
                        
                    @elseif($major=='chinese')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easychineselogo.webp')}}">
                        <h6 class="h6">Easy Chinese</h6>
                        
                    @endif

                </div>
            
                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                    <form action="{{route('addPost',$major)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="body" id="inputForm" placeholder="What's on your mind, Admin!" style="width:100%;margin-top:7px" rows="6"></textarea></textarea>
                        <br><br>
                        <input type="file" name="myfile"/>
                        <br><br><br>
                        <input type="submit" style="padding:5px; text-align:center; width:100% " class="rounded ripple btn-primary" value="Post">

                    </form>
                
                </div>
    
            </div>
        </div>
    </div>
</section>
@endsection