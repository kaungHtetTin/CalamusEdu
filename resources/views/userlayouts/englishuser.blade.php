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
              
              <!--main lessons-->
              <option value="b_grammar">Grammar Note</option>
              <option value="b_sentence_construction">Sentence Construction Note</option>
              <option value="b_translation">Translation Note</option>
              
              <option value="basic_grammar">Basic Grammar</option>
              <option value="basic_speaking">Basic Speaking</option>
              
              
              <option value="voa_b_level1">VOA Level 1</option>
              <option value="voa_b_level2">VOA Level 2</option>
              <option value="HowToPronounce">How To Pronounce</option>
              
              <!--additional lesson-->
              <option value="TipsAndSlang">Tips and Slang</option>
              <option value="WordsOnTopics">Words On Topics</option>
              <option value="Proverbs">Proverbs</option>
              <option value="Proverbs">Phrase</option>
              <option value="GeneralNotes">GeneralNotes</option>
              
              <!--video channel-->
              <option value="Idioms">Idioms</option>
              <option value="Translation">Translation</option>
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
                
                <!--main Lesson-->
                <th scope="col">Grammar Note</th>
                <th scope="col">Sentence Construction Note</th>
                <th scope="col">Translation Note</th>
                
                <th scope="col">Basic Grammar</th>
                <th scope="col">Basic Speaking</th>
                
                <th scope="col">VOA Level 1</th>
                <th scope="col">VOA Level 2</th>
                <th scope="col">VOA Pronounce</th>
                
                <!--additional Lessons-->
                <th scope="col">TipsAndSlangs</th> 
                <th scope="col">WordsOnTopics</th> 
                <th scope="col">Proverbs</th>
                <th scope="col">Phrase</th>
                <th scope="col">GeneralNotes</th>
                
                <!--video channel-->
                <th scope="col">Idioms</th>
                <th scope="col">Translations</th>
                <th scope="col">General</th>

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
                    
                     <!--Main Lesson-->
                    <td>{{$easyenglish->b_grammar}}</td>
                    <td>{{$easyenglish->b_sentence_construction}}</td>
                    <td>{{$easyenglish->b_translation}}</td>
                    
                    <td>{{$easyenglish->basic_grammar}}</td>
                    <td>{{$easyenglish->basic_speaking}}</td>
                    
                    <td>{{$easyenglish->voa_b_level1}}</td>
                    <td>{{$easyenglish->voa_b_level2}}</td>
                    <td>{{$easyenglish->HowToPronounce}}</td>
                    
                    <!--Additional Lesson-->
                    <td>{{$easyenglish->TipsAndSlang}}</td>
                    <td>{{$easyenglish->WordsOnTopics}}</td>
                    <td>{{$easyenglish->Proverbs}}</td>
                    <td>{{$easyenglish->Phrase}}</td>
                    <td>{{$easyenglish->GeneralNotes}}</td>
                    
                    <!--Video Channel-->
                    <td>{{$easyenglish->Idioms}}</td>
                    <td>{{$easyenglish->Translation}}</td>
                    <td>{{$easyenglish->General}}</td>
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



