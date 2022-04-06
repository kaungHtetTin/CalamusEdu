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
 <!--Section: Easy English-->
 <section class="mb-4">
    <div class="card">
    
      <div class="card-header py-3">
        <h6> Filter</h6>
         <form method="GET" action="{{route('filterEnglishUser')}}"> 
           <label for="">Category:</label>
            <select id="inputForm" name="sqlrow" style="flex-wrap: wrap;">
              <option value="login_time">Login Time</option>
              <option value="level_test">Level Test</option>
              <option value="game_score">Game Score</option>
              <option value="0">Exam Mark</option>
              <option value="song">Song</option>
              
        
            </select>
           <input name="count" type="text"class="" placeholder="count" style="width: 100px;" id="inputForm">
            <input name="ago" type="text"class="" placeholder="last days" style="width: 100px;" id="inputForm">
           <label class="">
            <input name="vip" class="" type="checkbox"> VIP User
          </label>
          <input type="submit" style="float: right;" value="Search" class="btn-primary rounded"/>
         </form>
    
      </div>

      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>Easy English User</strong>
        </h5>
      </div>
      <div class="card bg-success" id="customMessageBox">
        {{$counts}} Users
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">VIP User</th>
                <th scope="col">Login Time</th>
                <th scope="col">Level Test</th>
                <th scope="col">Game Score</th>
                <th scope="col">Exam Mark</th>
                <th scope="col">Join On</th>
                <th scope="col">Last Active</th>
                <th scope="col">Song</th>
                
           
              </tr>
            </thead>

            <tbody>

                @foreach ($users as $easyenglish)
                <tr>
                     <td> <a href="{{route('searchUser')}}?phone={{$easyenglish->learner_phone}}" style="text-decoration: none"><h6>{{$easyenglish->learner_name}}</h6> </a></td>
                    <td>{{$easyenglish->learner_phone}}</td>
                    <td>
                        @if ($easyenglish->is_vip==0)
                            <span class="text-danger">No</span>
                        @else
                            <span class="text-success">Yes</span>
                        @endif
                    </td>
                    <td>{{$easyenglish->login_time}}</td>
                    <td>{{$easyenglish->level_test}}</td>
                    <td>{{$easyenglish->game_score}}</td>
                    <td>0</td>     
                    <td>{{$easyenglish->first_join}}</td>
                    <td>{{$easyenglish->last_active}}</td>
                    <td>{{$easyenglish->song}}</td>
                  
                  </tr>
    
                @endforeach

            </tbody>

          </table>
        </div>
      </div>
    </div>
  </section>
  {{$users->links()}}
@endsection



