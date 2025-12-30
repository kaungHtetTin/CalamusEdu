@extends('layouts.navbar')

@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a word' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection


@section('content')

<div>
<span class="h4 align-self-center">Words Of The Day( {{ucwords($major)}} )</span>
<a href="{{route('showWordDayAdding',$major)}}" style="float: right; margin-right:15px;">
    <span style="background-color: rgb(195, 216, 255) ;padding:7px;border-radius:50%;border:solid thin gray">
      <i class='fas fa-plus' style='font-size:24px;color:rgb(26, 60, 250);'></i>
    </span>
  </a>
<hr>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">

               
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">{{ucwords($major)}}</th>
                              <th scope="col">Myanmar</th>
                              <th scope="col">Speech</th>
                            </tr>
                          </thead>
                        @foreach ($words as $word)
                        <tbody>
                          
                            <td>
                                <a href="{{route('showDetailWordDay',$word->id)}}?major={{$major}}" style="text-decoration:none;">
                                <img src="{{$word->thumb}}" style="width:80px; height:45px;" class="rounded"/>
                                </a>
                            </td>
                            <td>{{$word->$major}}</td>
                            <td>{{$word->myanmar}}</td>
                            <td>{{$word->speech}}</td>
                            
                        </tbody>
                       
                        @endforeach
                    </table>
                </div>
              
               
            </div>
        </div>
    </div>
</div>

{{$words->links('pagination.default')}}
@endsection