@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('content')
{{-- User Profile --}}

@php
    $views=countFormat($post->view_count,"view");
    $commentCount=countFormat($post->comments,"comment");
    $likes=countFormat($post->postLikes,"like");
    function countFormat($count ,$unit){
      if($count==0){
            return "No ".$unit;

        }else if($count==1){
            return "1 ".$unit;
        }else if($count>=1000&&$count<1000000){
            $count=number_format($count/1000,1);

            return $count."k ".$unit."s";
        }else if($count>=1000000){
            $count=number_format($count/1000000,1);
            return $count."M ".$unit."s";
        }else{
            return  $count." ".$unit."s";
        }
    }
@endphp

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif

<section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>{{$lesson->title}}</strong>
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-7 col-md-7 mb-4">
            <!--<iframe class="rounded" src="https://www.youtube.com/embed/{{$lesson->link}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen-->
            <!--  style="width:100% ; height:300px"></iframe> -->
              
              <div style="padding:53.13% 0 0 0;position:relative;"><iframe src="{{$post->vimeo}}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" 
                  title="{{$lesson->title}}"></iframe>
              </div>
              <script src="https://player.vimeo.com/api/player.js"></script>
              
            <div style="border:solid thin black;margin-top:3px;padding:5px;" class="rounded">
            
              <span id="react" onclick="likeVideo();" style="cursor: pointer"> 
                  @if ($post->is_liked==0)
                  <i class="material-icons" id="noneReactIcon">favorite_border</i>
                  @else
                  <i class="material-icons" id="noneReactIcon" style="color:red">favorite</i>
                  @endif
                  <span id="tvLikes">{{$likes}}</span>
              </span>

              <span style="margin-left:3px"><i class="material-icons">speaker_notes</i> {{$commentCount}}</span>
              <span style=" float: right">{{$views}}</span> 
            </div>
          </div>
         
            <div class="col-xl-5 col-md-5 mb-4">
             <h6 class="h6">Upload Video For Downloading This Lesson</h6>
             <form enctype="multipart/form-data" action="{{route('uploadVideoForLessonDownload')}}" method="POST">
             @csrf
                 <input type="file" name="myfile">
                 <input type="submit" class="btn-primary rounded" value="upload"/>
                 <input type="hidden" name="postid" value="{{$post->post_id}}"/>
             </form>
             <br>
             @if($post->video_url=="")
             No Video is uploaded for downloading
             @else
             The DownloadUrl >>> <br>
             {{$post->video_url}}
             @endif
             <hr>
             <p>Add To Lesson Plan </p>
             <form enctype="multipart/form-data" action="{{route('addLessonToStudyPlan')}}" method="post">
                 @csrf
                 <Input type="text" name="day" placeholder="Enter the day"/>
                 <input type="hidden" name="id" value="{{$lesson->id}}"/>
                 <input type="submit" class="btn-primary rounded" value="Add"/>
             </form>
             
            
             <br>
            </div>
            

          <form action="" method="" class="col-xl-7 col-md-7 mb-4">
            @csrf
            <input type="submit" class="btn-primary rounded" value="Send"/>
            <input type="text" placeholder="Write a comment" id="inputForm" name="pw"/>
            <input type="hidden" name="phone" value=""/>
          </form>

          <div class="col-xl-6 col-md-6 mb-4">
            @foreach ($comments as $comment)
            <div style="display:flex;">
               <div >
                   <img src="{{$comment->userImage}}" style="width: 30px; height:30px; margin-right:4px; border-radius :50%; border: solid 2px white;">
               </div>
               <div style ="background-color:#F0F3F5; padding:5px;border-radius: 6px 20px 12px; "> 
                    <div  style="font-weight:bold;color:#405d9b;	padding-top:3px;" >
                         {{$comment->userName}}
                    </div>
                    <div  style="padding-top:5px;" > 
                       {{$comment->body}}  
                    </div>         
                    <span style="color :#999; padding-top:3px; margin-bottom:5px;">
                    <?php 
                        $s = $comment->time/ 1000;
                        $d= date("d/M/Y", $s);
                        echo $d;
                    ?>
                   </span>
               </div>
            </div>
           <br>
           @endforeach
          </div>

        </div>
      </div>
    </div>
</section>

@endsection

 
<script>

  var isAlreadyLike = "<?php echo $post->is_liked ?>"==1 ? true : false;

  var likeCount="<?php echo $post->postLikes?>"

  function likeVideo(){
    var noneReatIcon=document.getElementById('noneReactIcon');
    var tvLikes=document.getElementById('tvLikes');
    if(isAlreadyLike){
      isAlreadyLike=false;
      noneReatIcon.innerHTML="favorite_border";
      noneReatIcon.removeAttribute('style');
      likeCount--;
    
    }else{
      isAlreadyLike=true;
      noneReatIcon.innerHTML="favorite";
      noneReatIcon.setAttribute('style','color:red');
      likeCount++;
     
    }
    var ajax=new XMLHttpRequest();
    ajax.onload =function(){
      if(ajax.status==200 || ajax.readyState==4){
        if(likeCount<=999){
          if(likeCount>1){
            tvLikes.innerHTML=likeCount.toString().concat(' likes');
          }else{
            tvLikes.innerHTML=likeCount.toString().concat(' like');
          }
        
        }else{
          tvLikes.innerHTML='<?php echo $likes?>';
        }
      }
    }
    ajax.open("POST","https://www.calamuseducation.com/calamus/api/posts/like",true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("user_id=10000&post_id=<?php echo $post->post_id?>&time=<?php echo time()?>");
  }
  
</script>

