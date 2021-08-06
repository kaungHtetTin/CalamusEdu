@extends('layouts.navbar')

@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a song' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection


@section('content')

<div>
<span class="h4 align-self-center"> Requested Songs ( {{ucwords($major)}} )</span>

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
            
                              <th scope="col">Title</th>
                              <th scope="col">Artist</th>
                              <th scope="col">Vote</th>
                              <th scope="col">Delete</th>
                            </tr>
                          </thead>
                        @foreach ($songs as $song)
                        <tbody>
                          
                            <td>{{$song->title}}</td>
                            <td>{{$song->artist}}</td>
                            <td>{{$song->vote}}
                                <i class="fa fa-thumbs-up" style="font-size:18px;color:#bbb; margin-left:5px"></i>
                            </td>
                           
                            <td>
                                <button
                                    type="button" data-toggle="modal" data-target="#d{{$song->id}}" id="" class="btn">
                                    <i class="fa fa-trash" style="color:rgb(255, 53, 53)" aria-hidden="true"></i>
                                </button>

                                <!-- <--modal__> -->
                                <div class="modal fade" id="d{{$song->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Do you really want to delete?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('deleteRequestedSong')}}">
                                                @csrf
                                                <input type="hidden" value="{{$song->id}}" name="id"/>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                                                <button type="submit" id="{{$song->id}}" class="btn btn-danger">Delete</button>
                                                
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

{{$songs->links()}}
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