<!DOCTYPE html>
<html>
<head>
	<title>Grocery</title>
	
	<!-- <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body >
    @if (\Session::has('success'))

    <div class="alert alert-warning alert-dismissible fade show text-center text-muted" role="alert">
        <strong>Warning!</strong> You have not admin access, Please contact your system administrator.
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
		
    </div>
    <script type="text/javascript" src="{{ asset('custom/js/main.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>


</body>
</html>


