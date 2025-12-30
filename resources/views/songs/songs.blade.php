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
<span class="h4 align-self-center">Songs ( {{ucwords($major)}} )</span>
<a href="{{route('showAddSong',$major)}}" style="float: right; margin-right:15px;">
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
                              <th scope="col">Title</th>
                              <th scope="col">Artist</th>
                              <th scope="col">Drama</th>
                              <th scope="col">Likes</th>
                              <th scope="col">Downloads</th>
                              <th scope="col">Audio</th>
                            </tr>
                          </thead>
                        @foreach ($songs as $song)
                        <tbody>
                          
                            <td>
                                <img src="https://www.calamuseducation.com/uploads/songs/image/{{$song->url}}.png" style="width:80px; height:45px;" class="rounded"/>
                            </td>
                            <td>{{$song->title}}</td>
                            <td>{{$song->artist}}</td>
                            <td>{{$song->drama}}</td>
                            <td>{{$song->like_count}}</td>
                            <td>{{$song->download_count}}</td>
                          
                        </tbody>
                       
                        @endforeach
                    </table>
                </div>
              
               
            </div>
        </div>
    </div>
</div>

{{$songs->links('pagination.default')}}
@endsection