 @extends('layouts.navbar')
 @section('content')
 
    <div class="row">
      <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between p-md-1">
              <div class="d-flex flex-row">
                <div class="align-self-center">
                 <img src="{{asset('public/assets/svg/feather.svg')}}" style="width: 90px;height:90px"/>
                </div>
                <div>
                  <h4>Total Users</h4>
                  <p class="mb-0">Total numbers of all users</p>
                </div>
              </div>
              <div class="align-self-center">
                <h2 class="h1 mb-0">{{$learner_count}}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between p-md-1">
              <div class="d-flex flex-row">
                <div class="align-self-center">
                 <img src="{{asset('public/img/easyenglish.png')}}" style="width: 50px;height:50px"/>
                  <h5>Easy English</h5>
                </div>
              </div>
              <div class="align-self-center">
                <h2 class="h3 mb-0">{{$english_user_count}}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    
     
      <div class="col-xl-6 col-md-6 mb-4">
        <a href="{{route('easyKoreanUserDatas')}}" style="text-decoration: none">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                  <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px"/>
                    <h5>Easy Korean</h5>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h3 mb-0">{{$koeran_user_count}}</h2>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    
     <div class="col-xl-6 col-md-6 mb-4">
        <a href="{{route('easyChineseUserDatas')}}" style="text-decoration: none">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                  <img src="{{asset('public/img/easychinese.png')}}" style="width: 50px;height:50px"/>
                    <h5>Easy Chinese</h5>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h3 mb-0">{{$chinese_user_count}}</h2>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
  
      
      <div class="col-xl-6 col-md-6 mb-4">
        <a href="{{route('easyJapaneseUserDatas')}}" style="text-decoration: none">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                  <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 50px;height:50px"/>
                    <h5>Easy Japanese</h5>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h3 mb-0">{{$japanese_user_count}}</h2>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
      
      
      <div class="col-xl-6 col-md-6 mb-4">
        <a href="{{route('easyRussianUserDatas')}}" style="text-decoration: none">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                  <img src="{{asset('public/img/easyrussian.png')}}" style="width: 50px;height:50px"/>
                    <h5>Easy Russian</h5>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h3 mb-0">{{$russian_user_count}}</h2>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
  
        
 </div>


  @endsection