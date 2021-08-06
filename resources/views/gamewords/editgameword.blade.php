@extends('layouts.navbar')


@section('content')

<div>
<span class="h4 align-self-center">Edit Game Words ( {{ucwords($major)}} )</span>

<hr>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                              <th scope="col">id</th>
                              @if (!empty($word->display_word))<th scope="col">Word</th>@endif
                              @if (!empty($word->display_image))<th scope="col">Image</th>@endif
                              @if (!empty($word->display_audio))<th scope="col">Audio</th>@endif
                              <th scope="col">A</th>
                              <th scope="col">B</th>
                              <th scope="col">C</th>
                              <th scope="col">Ans</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                         
                        <tbody>
                           
        
                            <td>{{$word->id}}</td>
                            @if (!empty($word->display_word))
                            <td><input type="text" value="{{$word->display_word}}" name="display_word"/></td>
                            @endif
                          
                            @if (!empty($word->display_image))
                            <td><input type="file" name="myfile"></td>
                            @endif
                           
                            @if (!empty($word->display_audio))
                            <td><input type="file" name="myfile"></td>
                            @endif
                            
                
                            <td><input type="text" value="{{$word->a}}" name="a"/></td>
                            <td><input type="text" value="{{$word->b}}" name="b"/></td>
                            <td><input type="text" value="{{$word->c}}" name="c"/></td>
                            <td><input type="text" value="{{$word->ans}}" name="ans"/></td>

                        </tbody>
                       
                  
                       
                    </table>
                </div><br>
                <input type="submit" class="btn-primary rounded" value="Update" style="float:right"/>
            </form>
               
            </div>
        </div>
    </div>
</div>

@endsection