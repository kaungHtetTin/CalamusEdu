
@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('content')

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
          <div class="card-body">
            @php
            $lessonData=$lessonData->entry->content;
            foreach ($lessonData as $key => $value) {
            echo str_replace("html","Calamus",$value);
            }
            @endphp    
          </div>
        </div>
      </div>
</div>
@endsection