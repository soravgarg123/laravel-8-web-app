<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-icons.css">
      <link rel="stylesheet" type="text/css" href="assets/css/mdb.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
      <link rel="stylesheet" type="text/css" href="assets/css/sweetalert2.min.css">
      <link rel="icon" type="image/gif" href="assets/img/fav-icon.png" sizes="16x16">
      <title>{{ @$configurations['website_name'] }}</title>
   </head>
   <body>
      <div class="paperForm">
         <div class="logoBox">
            @if(!empty($configurations['website_name']))
               <a href="javascript:void(0)" class="logo"><img src="{{ url('uploads/logo/') }}/{{ $configurations['website_logo'] }}" style="width:100px" class="img-fluid"></a>
            @endif
         </div>
         <div class="formHeading">
            <h2>{{ @$configurations['website_name'] }}</h2>
         </div>
         <form method="POST" id="payment-form" autocomplete="off">
            <div class="form-outline mb-4">
               <input type="text" id="form1ExampleYourName" class="form-control" name="name" required />
               <label class="form-label" for="form1ExampleYourName">Client Full Name*</label>
            </div>
            <div class="form-outline mb-4">
               <input type="email" id="form1ExampleYourEmail" class="form-control" name="email" />
               <label class="form-label" for="form1ExampleYourEmail">Client Email Address*</label>
            </div>
            <div class="form-outline mb-4">
               <input type="text" id="form1ExampleYourPhone" class="form-control" name="phone_number" required />
               <label class="form-label" for="form1ExampleYourPhone">Client Phone Number*</label>
            </div>
            <div class="form-outline mb-4">
               <input type="text" id="form1ExampleAmount" class="form-control validate-no" maxlength="4" min="1" max="{{ $max_amount_limit }}" name="amount" required />
               <label class="form-label" for="form1ExampleAmount">Amount ({{ $configurations['stripe_currency'] }}) *</label>
            </div>
            <div class="form-outline mb-4">
               <input type="text" id="form1ExampleYourAccount" class="form-control" name="account_no" required />
               <label class="form-label" for="form1ExampleYourAccount">Client Account Number*</label>
            </div>
            <div id="card-element">
               
            </div>
            <div class="row">
               <input type="hidden" class="mode" value="{{ $configurations['stripe_mode'] }}">
               <input type="hidden" name = "currency" class="currency" value="{{ trim($configurations['stripe_currency']) }}">
               <input type="hidden" class="pk" value="{{ base64_encode($configurations['stripe_publishable_key']) }}">
            <div class="d-flex">
               <button type="submit" class="btn btn-primary btn-block submit-btn">Submit</button>
               <button type="button" onclick="window.location.reload()" class="btn btn-danger btn-block">Reset</button>
            </div>
         </form>
      </div>
      <script src="https://js.stripe.com/v3/"></script>
      <script src="assets/js/jquery-1.12.0.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/mdb.min.js"></script>
      <script src="assets/js/sweetalert2.min.js"></script>
      <script src="assets/js/custom.js"></script>
     
      <!--  Error & Success Messages -->
      <script type="text/javascript">
       $(document).ready(function(){
            @if(Session::has('error'))
                swal({
                    type: "error", 
                    title: "Error !!",
                    text: "{{ Session::get('error')  }}"
                });
            @endif
            @if(Session::has('success'))
                swal({
                    type: "success", 
                    title: "Success !",
                    text: "{{ Session::get('success')  }}"
                });
            @endif
       });
      </script>
   </body>
</html>