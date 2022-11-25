<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Calamus Education</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  

</head>
    
    <body>
         <div class="container">
               <div class="card bg-primary" style="color:white;padding:15px;">
                    <h3>Calamus Education</h3>
                    <h4>VIP Registration Statement For Easy {{Ucfirst($major)}} in {{$period}}</h4>
                </div>
        
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      
                      <th scope="col">Name</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($payments as $payment)
                   
                        <tr>
                    
                          <td>{{$payment->learner_name}}</td>
                          <td>{{$payment->learner_phone}}</td>
                          <td>{{$payment->amount}}</td>
                          <td>{{$payment->date}}</td>
                        </tr>
                    
                      @endforeach
                        <tr class="bg-success" style="color:white">
                            <td colspan="2">Total</td>
                            <td colspan="2">{{$total}}</td>
                        </tr>
                        
                  </tbody>
                </table>
                
                <br>
                
                <div class="card bg-primary" style="color:white;padding:15px;">
                    <h4>Project cost For Easy {{Ucfirst($major)}} in {{$period}}</h4>
                </div>
                
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      
                      <th scope="col">Title</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($costs as $cost)
                   
                        <tr>
                    
                          <td>{{$cost->title}}</td>
                          <td>{{$cost->amount}}</td>
                          <td>{{$cost->date}}</td>
                        </tr>
                    
                      @endforeach
                        <tr class="bg-success" style="color:white">
                            <td >Total</td>
                            <td colspan="2">{{$totalCost}}</td>
                        </tr>
                        
                  </tbody>
                </table>
         </div>
    </body>
    
</html>