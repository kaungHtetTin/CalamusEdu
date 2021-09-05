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
 <!--Section: Easy Korean-->
 <section class="mb-4">
    <div class="card">
    
      <div class="card-header py-3">
        <h6> Filter</h6>
         <form method="GET" action="{{route('filterKoreaUser')}}"> 
           <label for="">Category:</label>
            <select id="inputForm" name="sqlrow" style="flex-wrap: wrap;">
              <option value="login_time">Login Time</option>
              <option value="game_score">Game Score</option>
              <option value="0">Exam Mark</option>
              <option value="song">Song</option>
              <option value="basic_word_construction">Basic Word Construction</option>
              <option value="basic_writing">Basic Writing</option>
              <option value="basic_grammar">Basic Grammar</option>
              <option value="basic_listening">Basic Listening</option>
              <option value="basic_reading">Basic Reading</option>
              <option value="basic_speaking">Basic Speaking</option>
              <option value="LevelOnePartA">Level One A</option>
              <option value="LevelOnePartB">Level One B</option>
              <option value="LevelOnePartC">Level One C</option>
              <option value="LevelOneReading">Level One Reading</option>
              <option value="Kdrama">K - Drama</option>
              <option value="NumberAndTime">Number And Time</option>
              <option value="TipsAndSlang">Tip & Slangs</option>
              <option value="WordsOnTopics">Word On Topics</option>
              <option value="Phrase">Phrase</option>
              <option value="UsefulVerbs">Useful Verbs</option>
              <option value="Translation">Translation</option>
              <option value="DramaLyrics">Drama Lyrics</option>
              <option value="KidSong">Kid Song</option>
              <option value="General">General</option>
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
          <strong>Easy Korean User</strong>
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
                <th scope="col">Game Score</th>
                <th scope="col">Exam Mark</th>
                <th scope="col">Join On</th>
                <th scope="col">Last Active</th>
                <th scope="col">Song</th>
                <th scope="col">Basic Word Construction</th>
                <th scope="col">Basic Writing</th>
                <th scope="col">Basic Grammar</th>
                <th scope="col">Basic Listening</th>
                <th scope="col">Basic Reading</th>
                <th scope="col">Basic Speaking</th>
                <th scope="col">Level One A</th>
                <th scope="col">Level One B</th>
                <th scope="col">Level One C</th>
                <th scope="col">Level One Reading</th>
                <th scope="col">K - Drama</th>
                <th scope="col">Number And Time</th>
                <th scope="col">Tip & Slangs</th>
                <th scope="col">Word On Topics</th>
                <th scope="col">Phrase</th>
                <th scope="col">Useful Verbs</th>
                <th scope="col">Translation</th>
                <th scope="col">Drama Lyrics</th>
                <th scope="col">Kid Song</th>
                <th scope="col">General</th>

              </tr>
            </thead>

            <tbody>

                @foreach ($users as $easykorean)
                <tr>
                     <td> <a href="{{route('searchUser')}}?phone={{$easykorean->learner_phone}}" style="text-decoration: none"><h6>{{$easykorean->learner_name}}</h6> </a></td>
                    <td>{{$easykorean->learner_phone}}</td>
                    <td>
                        @if ($easykorean->is_vip==0)
                            <span class="text-danger">No</span>
                        @else
                            <span class="text-success">Yes</span>
                        @endif
                    </td>
                    <td>{{$easykorean->login_time}}</td>
                    <td>{{$easykorean->game_score}}</td>
                    <td>0</td>     
                    <td>{{$easykorean->first_join}}</td>
                    <td>{{$easykorean->last_active}}</td>
                    <td>{{$easykorean->song}}</td>
                    <td>{{$easykorean->basic_word_construction}}</td>
                    <td>{{$easykorean->basic_writing}}</td>
                    <td>{{$easykorean->basic_grammar}}</td>
                    <td>{{$easykorean->basic_listening}}</td>
                    <td>{{$easykorean->basic_reading}}</td>
                    <td>{{$easykorean->basic_speaking}}</td>
                    <td>{{$easykorean->LevelOnePartA}}</td>
                    <td>{{$easykorean->LevelOnePartB}}</td>
                    <td>{{$easykorean->LevelOnePartC}}</td>
                    <td>{{$easykorean->LevelOneReading}}</td>
                    <td>{{$easykorean->Kdrama}}</td>
                    <td>{{$easykorean->NumberAndTime}}</td>
                    <td>{{$easykorean->TipsAndSlang}}</td>
                    <td>{{$easykorean->WordsOnTopics}}</td>
                    <td>{{$easykorean->Phrase}}</td>
                    <td>{{$easykorean->UsefulVerbs}}</td>
                    <td>{{$easykorean->Translation}}</td>
                    <td>{{$easykorean->DramaLyrics}}</td>
                    <td>{{$easykorean->KidSong}}</td>
                    <td>{{$easykorean->General}}</td>
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



