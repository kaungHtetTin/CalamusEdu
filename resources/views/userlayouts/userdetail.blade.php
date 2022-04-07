@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('content')
  

{{-- User Profile --}}
 <section class="mb-4">

    <div class="card">
      <div class="card-header text-center py-3">
        <h5 class="mb-0 text-center">
          <strong>User Data Details</strong>
        </h5>
      </div>
      <div class="card-body">
            @if ($learner!=null)
                <span class="align-self-center" style="">
                    <img src="{{$learner->learner_image}}" style="width: 100px; height:100px; border-radius:50% ; border: solid thin black"/>
                </span>
                <h3 class="h3 mb-0">{{$learner->learner_name}}</h2><br>
                <i class="fa fa-phone me-3" aria-hidden="true"></i>
                <span class="h5 mb-0">{{$learner->learner_phone}}</span><br><br>
                <i class="fa fa-envelope me-3" aria-hidden="true"></i>
                <span class="h5 mb-0">{{$learner->learner_email}}</span>

                <br><br>
                <div style="display: flex">
                    <a href="{{route('showPasswordReset',$learner->learner_phone)}}" class="btn-primary" id="customUserBtn">Password Reset</a>  
                    <a href="{{route('showSendEmail',$learner->id)}}" class="btn-primary" id="customUserBtn">Send Email</a>
                    <a href="{{route('showPushNotification',$learner->id)}}" class="btn-primary" id="customUserBtn">Send Notification</a>
                    
                    <a href="{{route('showVipsetting',$learner->id)}}" class="btn-primary" id="customUserBtn">Add Vip</a>
                </div>
            @else
                <span class="h5 mb-0 text-danger">No user was found!</span>         
             @endif
        </div>
      </div>
    </div>
</section>


 
 <!--Section: Easy English-->
 @if ($easyenglish!=null)
 <section class="mb-4">
    <div class="card">
      <div class="card-header text-center py-3">
        <h6 class="mb-0 text-center">
          <strong>Easy English</strong>
        </h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th scope="col">VIP User</th>
                <th scope="col">Login Time</th>
                <th scope="col">Game Score</th>
                <th scope="col">Exam Mark</th>
                <th scope="col">Join On</th>
                <th scope="col">Last Active</th>
                <th scope="col">Song</th>
               
                       
              </tr>
            </thead>
            <tbody>
                <td>
                    @if ($easyenglish->is_vip==0)
                        <span class="text-danger">No</span>
                    @else
                        <span class="text-success">Yes</span>
                    @endif
                </td>
                <td>{{$easyenglish->login_time}}</td>
                <td>{{$easyenglish->game_score}}</td>
                <td>0</td>
                <td>{{$easyenglish->first_join}}</td>
                <td>{{$easyenglish->last_active}}</td>
                <td>{{$easyenglish->song}}</td>
                
    
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  @endif
 <!--Section: Easy English-->
  
 <!--Section: Easy Korean-->
 @if ($easykorean!=null)
 <section class="mb-4">
    <div class="card">
      <div class="card-header text-center py-3">
        <h6 class="mb-0 text-center">
          <strong>Easy Korean</strong>
        </h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th scope="col">VIP User</th>
                <th scope="col">Login Time</th>
                <th scope="col">Game Score</th>
                <th scope="col">Exam Mark</th>
                <th scope="col">Join On</th>
                <th scope="col">Last Active</th>
                <th scope="col">Song</th>
                
        

              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    @if ($easykorean->is_vip==0)
                        <span class="text-danger">No</span>
                    @else
                        <span class="text-success">Yes</span>
                    @endif
                </td>
                <td>{{$easykorean->login_time}}</td>
                <td>{{$easykorean->game_score}}</td>
                <td>0</td>
                <td>{{$easykorean->first_join}}</td>
                <td>{{$easykorean->last_active}}</td>
                <td>{{$easykorean->song}}</td>
            
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
@endif
<!--Section: Easy Korean-->

@endsection





