@extends('layouts.navbar')


@section('content')

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

<div>
<span class="h4 align-self-center">Game Words ( {{ucwords($major)}}  )</span> <span class="h6 align-self-center text-primary">Total - {{$count}}</span>
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
                                <button
                                    type="button" data-toggle="modal" data-target="#d{{$word->id}}" id="" class="btn">
                                    <i class="fa fa-trash" style="color:rgb(255, 53, 53)" aria-hidden="true"></i>
                                </button>
                                
                                 <!-- <--modal__> -->
                                <div class="modal fade" id="d{{$word->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Do you really want to delete?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('deleteGameWord')}}">
                                                @csrf
                                                <input type="hidden" value="{{$word->id}}" name="id"/>
                                                <input type="hidden" value="{{$major}}" name="major"/>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                                                <button type="submit" id="{{$word->id}}" class="btn btn-danger">Delete</button>
                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- <--modal__> -->
                                
                            </td>
                           
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

<script
src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
crossorigin="anonymous"
></script>
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
crossorigin="anonymous"
></script>