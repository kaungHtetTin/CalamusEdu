@extends('layouts.navbar')


@section('content')

<div>
<span class="h4 align-self-center">Game Words ( {{ucwords($major)}} )</span>
<a href="{{route('showGameWordAdding',$major)}}" style="float: right; margin-right:15px;">
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
                              <th scope="col">id</th>
                              <th scope="col">Word</th>
                              <th scope="col">Image</th>
                              <th scope="col">Audio</th>
                              <th scope="col">A</th>
                              <th scope="col">B</th>
                              <th scope="col">C</th>
                              <th scope="col">Ans</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                        @foreach ($words as $word)
                        <tbody>
                           <form>
                            <td>{{$word->id}}</td>
                            <td>{{$word->display_word}}</td>
                            <td>
                                @if (!empty($word->display_image))
                                <img src="{{$word->display_image}}" style="width:80px; height:45px;" class="rounded"/>
                                @endif
                            </td>
                          
                            <td>
                                @if (!empty($word->display_audio))
                                <i class='fas fa-volume-up' style='font-size:36px;color:rgb(4, 243, 124)'></i>
                                @endif
                            </td>
                            <td>{{$word->a}}</td>
                            <td>{{$word->b}}</td>
                            <td>{{$word->c}}</td>
                            <td>{{$word->ans}}</td>
                            <td>
                                <a href="{{route('editGameWord',$word->id)}}?major={{$major}}">
                                <i class='fas fa-edit' style='font-size:18px;color:rgb(26, 60, 250)'></i>
                                </a>
                            </td>
                           </form>
                           
                        </tbody>
                       
                        @endforeach
                    </table>
                </div>
              
               
            </div>
        </div>
    </div>
</div>

{{$words->links()}}
@endsection