@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />

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
          <strong>Send Cloud Messaging For Notification</strong>
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                  <form action="{{route('sendCloudMessage')}}" method="POST">
                    @csrf
                    <div style="display:flex">
                        <div style="width:100px" class="align-self-center">Title:</div>
                        <input type="text" placeholder="Notification title" id="inputForm" name="title" style="width:100%"/><br>
                        
                    </div>
                     <p class="text-danger" style="font-size: 12px;">{{$errors->first('title')}}</p>

                    <div style="display:flex">
                        <div style="width:100px;margin-top:10px;">Message:</div>
                        <textarea name="msg" id="inputForm" placeholder="Enter Notification Message" style="width:100%;margin-top:7px" rows="6"></textarea></textarea>
                        <p class="text-danger" style="font-size: 12px;">{{$errors->first('msg')}}</p> 
                    </div>
                    <br><br>
                    <div style="display:flex">
                        <div style="width:100px;" class="align-self-center"> Audience: </div>
                        <select id="inputForm" name="app">                   
                            <option value="englishUsers">Easy English</option>
                            <option value="koreaUsers">Easy Korean</option>
                            <option value="chineseUsers">Easy Chinese</option>
                            <option value="japaneseUsers">Easy Japanese</option>
                            <option value="russianUsers">Easy Russian</option>
                        </select>
                        
                    </div>

                    <br><br>
                    <div style="display:flex">
                        <div style="width:100px;" class="align-self-center"></div>
                        <input type="submit" class="btn-primary rounded" value="Send" style="float: left;"/><br>
                    </div>
                   
                  
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
</section>

@endsection

