@extends('layouts.navbar')
@section('content')

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif


@php
    date_default_timezone_set("Asia/Yangon");
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

<div class="row">
    <div class="col-xl-7 col-md-7 col-sm-12" style="margin: auto">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center">

                    @if ($major=='english')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easyenglish.png')}}">
                    @elseif($major=='korea')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easykorean.png')}}">
                    @elseif($major=='chinese')
                        <img style="width: 90px; height:90px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easychineselogo.webp')}}">
                    @endif
                    
                    <br><br>
                    <a href="{{route('showCreatePost',$major)}}">
                        <div style="padding:5px; text-align:center; width:100% " class="rounded ripple btn-primary">
                            Create a post
                        </div>
                    </a>
                </div>
                <br>
                <hr>
                <br>
                
                <div id="postContainer">
                    @if($posts)
                    @foreach ($posts as $post)
                        <div class="dropdown" style="float: right;cursor: pointer;">
                            <i class="material-icons "   id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="clickMore({{$post->postId}});">more_horiz</i>
                        
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">
                                    <i class="material-icons me-3">build</i>Edit Post
                                </a>

                                <form class="dropdown-item" action="{{route('deletePost',$post->postId)}}" method="POST">
                                @csrf
                                <label for="btn_delete{{$post->postId}}">
                                      <i class="material-icons me-3" style="color:red">delete</i>Delete Post
                                </label>
                                  
                                     <input type=submit id="btn_delete{{$post->postId}}" style="display:none" >
                                </form>

                            
                              </div>
                        </div>

                        <br>
                        <img style="width: 40px; height:40px; border-radius:50%; margin-right:10px;" src="{{$post->userImage}}" onclick="storedId();">
                        <span><b>{{$post->userName}}</b></span> <i style="float: right; font-size:13px;">{{date('Y-m-d h:i A',$post->postId/1000)}}</i>
                        <br><br>
                        <p style="">{{$post->body}}</p>
                        @if($post->postImage!=""&&$post->has_video=="0")
                            <img style="min-width:150px;width:100%; height:auto; margin:auto" src="{{$post->postImage}}">
                            <br>
                        @elseif($post->has_video=="1")
                            
                            <div style="padding:53.13% 0 0 0;position:relative;"><iframe src="{{$post->vimeo}}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" 
                                 title=""></iframe>
                            </div>
                        @endif
                        <br>
                        <div style="display: flex;background-color:rgb(240, 240, 240);padding:5px;" class="rounded">
                            <span id="react{{$post->postId}}" onclick="likePost({{$post->postId}},{{$post->is_liked}});" style="cursor: pointer; flex:1;text-align:center" class="ripple"> 
                                @if ($post->is_liked==0)
                                <i class="material-icons" id="noneReactIcon{{$post->postId}}">favorite_border</i>
                                @else
                                <i class="material-icons" id="noneReactIcon{{$post->postId}}" style="color:red">favorite</i>
                                @endif
                                <span id="tvLikes{{$post->postId}}">{{countFormat($post->postLikes,'like')}}</span>
                            </span>
                            <span style=" flex:1;text-align:center" class="ripple" data-toggle="modal" data-target="#commentDialog" onclick="fetchComment({{$post->postId}},'{{$major}}');"><i class="material-icons">speaker_notes</i> {{countFormat($post->comments,'cmt')}}</span>
                           
                           
                            @if ($post->has_video==1)
                            <span style=" flex:1;text-align:center" class="ripple">{{countFormat($post->viewCount,'view')}}</span>
                            @endif
                        </div>
                    
                        <div style="margin-top: 10px; width:100% ; padding:10px;" class="ripple" data-toggle="modal" data-target="#commentDialog" onclick="fetchComment({{$post->postId}},'{{$major}}');">
                            
                            @if ($major=='english')
                                <img style="width: 20px; height:20px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easyenglish.png')}}">
                            @elseif ($major=='korea')
                                <img style="width: 20px; height:20px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easykorean.png')}}">
                            @elseif ($major=='chinese')
                                <img style="width: 20px; height:20px; border-radius:50% ;margin-right:10px;" src="{{asset('public/img/easychineselogo.webp')}}">
                            @endif
                            Write a comment. 
                        </div>
                         <hr>
                         
                    @endforeach
                    @endif
                 
                </div>                
            </div>
        </div>
    </div>
  </div>


{{-- Post Edit Dialog --}}

<div class="modal fade" id="postEditDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">More Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div id="postEditContainer" style="display:flex">
                    <div class="ripple" style="flex:1; text-align:center">Edit Post</div>
                    <div class="ripple" style="flex:1; text-align:center">Delete Post</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Comment Dialog Form --}}

<div class="modal fade" id="commentDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div id="commentContainer">
                     Loading Comments ... .... ...
                </div>
              
            </div>
        </div>
    </div>
</div>




<script>

    var clickPostId=0;
    var currentPage="{{$page}}";

    function clickMore(post_id){
        clickPostId=post_id
        
    }

    var loading=true;

    $(window).on("scroll", function() {
        var scrollHeight = $(document).height();
        var scrollPos =$(window).scrollTop();
        var halfWindowPos=$(window).height()/5;
        halfWindowPos=halfWindowPos-(currentPage*1.5);
      
      
        if(scrollPos+halfWindowPos+1000 >scrollHeight && loading){
             currentPage++;
             var url="{{route('fetchMorePost',$major)}}?mCode={{$mCode}}&page="+currentPage;
             console.log(scrollHeight+ " "+scrollPos);
             console.log(url);
             loading=false;
             loadMorePost(url)

            // document.getElementById('nextPage').click();
        }

    }); 


    function loadMorePost(url){


        var ajax=new XMLHttpRequest();
        ajax.onload =function(){
        if(ajax.status==200 || ajax.readyState==4){

            setPostOnScreen(JSON.parse(ajax.responseText))

        }
        }
        ajax.open("GET",url,true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send('');
  
  }


   function setPostOnScreen(posts){
        for(var i=0;i<posts.length;i++){
            
            var d = new Date(posts[i].postId);
            console.log(posts[i].userName);
          

             $('#postContainer').append(
               
                "<div class='dropdown' style='float: right;cursor: pointer;'>"+
                    "<i class='material-icons'   id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' onclick='clickMore(123);'>more_horiz</i>"+
                    
                    "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                        "<a class='dropdown-item' href='#'>"+
                            "<i class='material-icons me-3'>build</i>Edit Post"+
                        "</a>"+

                    "</div>"+
                "</div>"+

                "<br>"+
                
                "<img style='width: 40px; height:40px; border-radius:50%; margin-right:10px'; src='"+posts[i].userImage+"' onclick=storedId();>"+
                
                "<span><b>"+posts[i].userName+"</b></span> <i style='float: right; font-size:13px;'>"+d.toLocaleString()+"</i>"+
                "<br><br>"+
                "<p style=''>"+posts[i].body+"</p>" +
                checkPostMedia(posts[i].postImage,posts[i].has_video,posts[i].vimeo)+"<br>"+
          
                "<div style='display: flex;background-color:rgb(240, 240, 240);padding:5px;' class='rounded'>"+
                    "<span id='react"+posts[i].postId+"' onclick='likePost("+posts[i].postId+","+posts[i].is_liked+");' style='cursor: pointer; flex:1;text-align:center' class='ripple'>"+
                     checkLike(posts[i].is_liked,posts[i].postId)+
                     "<span id='tvLikes"+posts[i].postId+"'>"+countFormat(posts[i].postLikes,'like')+"</span>"+
                    "</span>"+
                    "<span style='flex:1;text-align:center' class='ripple' data-toggle='modal' data-target='#commentDialog' onclick='fetchComment("+posts[i].postId+",\"{{$major}}\");'><i class='material-icons'>speaker_notes</i> "+countFormat(posts[i].comments,'comment')+"</span>"+
                    isVideo(posts[i].has_video,posts[i].viewCount)+
                "</div>"+

                "<div style='margin-top: 10px; width:100% ; padding:10px;' class='ripple' data-toggle='modal data-target='#commentDialog' onclick='fetchComment("+posts[i].postId+",\"{{$major}}\");'>"+
                            
                checkMajor()+
                "Write a comment."+ 
                "</div>"+
                "<hr>"

                  
             );
        }

        loading=true;
   }

   function checkMajor(){
       var major="{{$major}}";

        if(major=='english'){
            return "<img style='width: 20px; height:20px; border-radius:50% ;margin-right:10px;' src='{{asset('public/img/easyenglish.png')}}'>";
        }else if(major=='korea'){
            return "<img style='width: 20px; height:20px; border-radius:50% ;margin-right:10px;' src='{{asset('public/img/easykorean.png')}}'>";
        }else if(major=='chinese'){
            return "<img style='width: 20px; height:20px; border-radius:50% ;margin-right:10px;' src='{{asset('public/img/easychineselogo.webp')}}'>";
        }
   }

    function isVideo(has_video,viewCount){
         if (has_video==1){
             return "<span style='flex:1;text-align:center' class='ripple'>"+countFormat(viewCount,'view')+"</span>";
         }else{
             return "";
         }
    }

    function countFormat(count ,unit){
      
        if(count==0){
            return "No "+unit;
        }else if(count==1){
            return "1 "+unit;
        }
         else if(count>=1000&&count<1000000){
            count=count/1000;
            count=count.toFixed(1);
            return count+"k "+unit+"s";
        }
        else if(count>=1000000){
            count=count/1000000;
            count=count.toFixed(1);
            return count+"k "+unit+"s";
        }
        
        else{
            return  count+" "+unit+"s";
        }
    }
  
   

   function checkLike(is_liked,postId){
        if (is_liked==0){
            return "<i class='material-icons' id='noneReactIcon"+postId+"'>favorite_border</i>";
        }else{
            return "<i class='material-icons' id='noneReactIcon"+postId+"' style='color:red'>favorite</i>";
        }

   }

   function checkPostMedia(postImage,has_video,vimeo){

        var str="";
     
        if(postImage!="" && has_video=="0"){
            str="<img style='min-width:150px;width:100%; height:auto; margin:auto' src='"+postImage+"'> <br>";
        }else if(has_video=="1"){
            str="<div style='padding:53.13% 0 0 0;position:relative;'>"+
                "<iframe src="+vimeo+"frameborder='0' allow=autoplay; fullscreen; picture-in-picture' allowfullscreen style='position:absolute;top:0;left:0;width:100%;height:100%;' title=''></iframe>"+
                "</div>";

        }
       return str;
   }


    function fetchComment(postId,major){
        if(major=="korea"){
            major="korean";
        }
        var ajax=new XMLHttpRequest();
        ajax.onload =function(){
            if(ajax.status==200 || ajax.readyState==4){
             
                var datas=JSON.parse(ajax.responseText);
                var comments=datas.comments;
                var postId =datas.post[0].postId;
                var ownerId=datas.post[0].userId;
                $('#commentContainer').empty("");
                for(var i=0;i<comments.length;i++){
                    const milliseconds = comments[i].time; // 1575909015000
                    const dateObject = new Date(milliseconds);
                    const humanDateFormat = dateObject.toLocaleString();

                    $('#commentContainer').append(
                    "<div style=' display:flex'>"+
                        "<img style='width: 40px; height:40px; border-radius:50%; margin-right:10px;' src="+comments[i].userImage+">"+
                        "<div style='background-color:#F0F3F5; padding:10px;border-radius: 6px 20px 12px;' id=m"+i+">"+
                            "<b>"+comments[i].userName+"</b>"+
                            "<p>"+comments[i].body+"<p>"+
                        "</div>"+
                    "</div>"+
                    "<div style='display:flex;width:90%;margin-top:10px; margin-left:60px;'>"+
                        "<span style='margin-right:20px;'><i class='material-icons' style='cursor:pointer' id=react"+milliseconds+">favorite</i>"+
                        "<span id=likes"+milliseconds+"></span>"+
                        "</span>"+ 
                        "<span ><i class='material-icons' >reply</i></span>"+ 
                        "<span style='flex:1.5; text-align:center;'>"+humanDateFormat+"</span>"+
                    "</div>"+
                    "<br>"
                    );
                    
                    if(comments[i].likes!=0){
                        $('#likes'+milliseconds).text(comments[i].likes);
                    }

                    if(comments[i].is_liked=="0"){
                        $('#react'+milliseconds).text('favorite_border');
                    }else{
                        $('#react'+milliseconds).text('favorite');
                        $('#react'+milliseconds).attr('style','color:red ; cursor:pointer');
                       
                    }

                    if(comments[i].commentImage!=""){
                        $('#m'+i).append(
                            "<img class='rounded' style='width:200px; height:auto;' src="+comments[i].commentImage+">"
                        );
                    }

                    $('#react'+milliseconds).click(function(){
                        likeComment(postId,milliseconds);
                    })

                   
                }

                $('#commentContainer').append(
                    "<hr>"+
                    "  <input id='commentInput' type='text' style='border-radius: 7px; border:solid thin gray; width:80%'>"+
                    "<button class='btn-primary rounded' style='float: right;' onclick=addComment("+postId+","+ownerId+",0,'{{$major}}');> Send </button>"
                    );
    
            }
        }
        ajax.open("POST","https://www.calamuseducation.com/calamus/api/comments/"+major,true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("user_id=10000&post_id="+postId+"&time=''");
        
    }


    function addComment(post_id,owner_id,action,major){
        var cmt =$('#commentInput').val();
       
        if(cmt.length<1){
            alert('Please enter a comment!');
        }else{
            var ajax=new XMLHttpRequest();
            ajax.onload =function(){
            if(ajax.status==200 || ajax.readyState==4){
                    fetchComment(post_id,major)
                }
            }
            ajax.open("POST","https://www.calamuseducation.com/calamus/api/comments/add",true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send("writer_id=10000&post_id="+post_id+"&time=<?php echo round(microtime(true) * 1000);?>&body="+cmt+"&owner_id="+owner_id+"&action="+action);
        }
    }


    function likeComment(post_id,comment_id){

        var ajax=new XMLHttpRequest();
        ajax.onload =function(){
        if(ajax.status==200 || ajax.readyState==4){
                var myArr=JSON.parse(ajax.responseText);
                var likeCount=myArr.count;
                var alreadyLike=myArr.isLike;
               
                if(likeCount>0){
                    $('#likes'+comment_id).text(likeCount);
                }

               
                if(alreadyLike){ 
                    $('#react'+comment_id).text('favorite_border');
                    $('#react'+comment_id).attr('style','cursor:pointer');
                }else{
                    $('#react'+comment_id).text('favorite');
                    $('#react'+comment_id).attr('style','color:red ; cursor:pointer');
                }

               
            }
        }
        ajax.open("POST","https://www.calamuseducation.com/calamus/api/comments/like",true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("user_id=10000&post_id="+post_id+"&time=<?php echo round(microtime(true) * 1000);?>&comment_id="+comment_id);
    }

    function likePost(postId, isLiked){

    var noneReatIcon=document.getElementById('noneReactIcon'+postId);
    var tvLikes=document.getElementById('tvLikes'+postId);

    var ajax=new XMLHttpRequest();
    ajax.onload =function(){
      if(ajax.status==200 || ajax.readyState==4){
          var myArr=JSON.parse(ajax.responseText);
            var likeCount=myArr.count;
            var alreadyLike=myArr.isLike;
            if(likeCount>1){
                tvLikes.innerHTML=likeCount.toString().concat(' likes');
            }else{
                tvLikes.innerHTML=likeCount.toString().concat(' like');
            }
            if(alreadyLike){ 
                noneReatIcon.innerHTML="favorite_border";
                noneReatIcon.removeAttribute('style');
            }else{
                noneReatIcon.innerHTML="favorite";
                noneReatIcon.setAttribute('style','color:red');
            }
      }
    }
    ajax.open("POST","https://www.calamuseducation.com/calamus/api/posts/like",true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("user_id=10000&post_id="+postId+"&time=<?php echo round(microtime(true) * 1000);?>");
  
  }
       
</script>

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
<script src="https://player.vimeo.com/api/player.js"></script>
