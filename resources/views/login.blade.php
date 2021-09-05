<!DOCTYPE html>
<html lang="en">
<head>

    <link href="{{ asset ('public/css/mdb.min.css')}}" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
      #login-form{
        margin: auto; 
        text-align:center;
        width:350px;
        margin-top:-150px; 
        height:400px;
        background-color:white;
        border-radius: 5px;
      }
    </style>

</head>
<body style="background-color: whitesmoke">
  
  <!-- Blue Bar-->
  <div class="bg-primary" style="width: 100%; height:200px;"></div>

  <!-- login form -->
  <div id="login-form">
  <br><br>  
    <form style="width: 300px; height:200px; text-align:center;margin:auto" action="{{route('home')}}" method="post">
      @csrf
      <h5>Login to Admin Pannel</h5>
      <br><br>

      <div class="form-group">
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
        <p class="text-danger"  style="font-size: 12px;">{{$errors->first('email')}}</p>
      </div>
      <br>

      <div class="form-group">
        <input type="password" class="form-control " id="exampleInputPassword1" placeholder="Password" name="password">
        <p class="text-danger" style="font-size: 12px;">{{$errors->first('password')}}</p>
      </div>
     
      <br><br>

      <button type="submit" class="btn btn-primary">Login</button>

    </form>  
  </div>
   
    <script type="text/javascript" src="{{ asset ('public/js/mdb.min.js')}}"></script>
    <script type="text/javascript"></script>

</body>
</html>