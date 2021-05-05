<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="server-datetime" content="{{ now() }}" >
    <meta name="name" content="">
    <meta name="user-type" content="">
    <meta name="id" content="">
    <title>Alturush | Grocery-Admin</title>
    <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png">

	
	<!-- <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script> -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>


</head>
<body >
    @if (\Session::has('error'))

    <div class="alert alert-warning alert-dismissible fade show text-center text-muted" role="alert" id="alert">
        <strong>Warning!</strong>{!! \Session::get('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="white">&times;</span>
        </button>
    </div>

    @endif
    
	<img class="wave" src="custom/img/wave.png">
	<div class="container">

		<div class="img">
			<img src="custom/img/grocery.svg">
		</div>
		<div class="login-content">

            <form method="POST" action="{{ route('login') }}" id='myForm'>
                @csrf
                                                +                                   
				<img src="custom/img/avatar.svg">
                <h3 class="title">Administrator</h3>
                
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
                        <input  type="text" class="input" name="username" value="{{ old('username') }}" tabindex="1">
                    </div>                
                </div>
                
                @error('username')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
                      </div>
                      
           		   <div class="div">
           		    	<h5>Password</h5>
                        <input  id="password" type="password" class="input" name="password" tabindex="2">
                   </div>
                </div>

                @error('password')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                {{-- <a href="#">Forgot Password?</a> --}}
                {{-- @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif --}}

                {{-- <input type="submit" class="btn-login" value="Login"> --}}

                <button type="submit" class="btn-login" tabindex="3">
                    {{ __('Login') }}
                </button>




            </form>




            
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('custom/js/main.js')}}"></script>

    <script>
         $(document).ready(function(){
            $("#alert").delay(3000).slideUp(500, function() {
                $(this).alert('close');
            });
         });
    </script>
</body>
</html>


