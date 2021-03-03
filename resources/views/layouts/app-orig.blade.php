<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="name" content="{{ Auth::user()->name }}">
  <meta name="server-datetime" content="{{ now() }}" >
  <title>Alturush | GROCERY-ADMIN</title>
  <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

  <!-- Custom styles for this template -->
  <link href="{{ asset('css/loading.css')}}" rel="stylesheet">
  <link href="{{ asset('css/shop-homepage.css')}}" rel="stylesheet">
  <link href="{{ asset('css/datatables/datatables.min.css')}}" rel="stylesheet">


  {{-- <link href="{{ asset('css/ionicons.min.css')}}" rel="stylesheet"> --}}
</head>

<body>
<div id='app' >
    <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-orange fixed-top mb-4 elevation-1">
    <div class="container-fluid ">
      <a href="{{ route('home')}}" class="navbar-brand home" >
        {{-- <img src="AlturushDeliveryTextColored.png" width="30" height="30" class="d-inline-block align-top" alt=""> --}}
        {{-- GROCERY-ADMIN --}}
        <h3 >GROCERY-ADMIN</h3>
      </a>  
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> 
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{-- <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" width="40" height="40" class="rounded-circle"> --}}
                <i class="fas fa-user-alt text-white "></i>
              </a>
              {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->username }}
              </a> --}}

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                
                  <a class="dropdown-item px-2 py-2" data-toggle="modal" data-target="#useraccount">
                  <i class="fas fa-user-alt text-gray mx-2"></i>
                  <span class="text-gray">Account</span> 
                  </a>
                  <a class="dropdown-item px-2 py-2" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt text-gray mx-2"></i>
                     <span class="text-gray">Sign out</span> 
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
            </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  {{-- <div class="container-fluid mt-5"> --}}
<div class="container-fluid mt-5">
  @yield('menu')
</div>
  {{-- </div> --}}
  <!-- /.container -->

  <!-- Footer -->
  {{-- <footer class="custom-footer text-gray py-2">
    <div class="container">
      <p class="m-0 text-center">Copyright &copy; 2019-2020 <strong>GROCERY-ADMIN</strong>. All rights reserved.</p>
    </div>  
    <!-- /.container -->
  </footer> --}}
  {{-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright © 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer> --}}

  <div class="modal fade" id="useraccount" tabindex="-1" role="dialog" aria-labelledby="useraccount" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"><span class="float-left"></span>  Your Account</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <center>
            <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" name="aboutme" width="140" height="140" border="0" class="img-circle"></a>
            <h3> {{ Auth::user()->name }} </h3>
            {{-- <span>
              <strong>Skills: </strong>
            </span>
                <span class="label label-warning">HTML5/CSS</span>
                <span class="label label-info">Adobe CS 5.5</span>
                <span class="label label-info">Microsoft Office</span>
                <span class="label label-success">Windows XP, Vista, 7 </span> --}}
            </center>
            <hr class="py-1 px-1">
              <button class="text-left btn btn-outline-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Change Username & Password
            </button>
            <div class="collapse mt-2" id="collapseExample">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                      v-model="form.username" 
                      type="text" class="form-control" 
                      name="username" 
                      id="username"  
                      :class="{ 'is-invalid': form.errors.has('username') }" 
                    >
                    <has-error :form="form" field="username"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="passsword">New Password</label>
                    <input 
                      v-model="form.password" 
                      type="password" 
                      class="form-control"
                    >
                  </div>
                </div>
                <div class="col-md-12">
                  <button 
                    type="button" 
                    class="btn btn-outline-success" 
                    @click.prevent="updateProfile"
                    v-bind:disabled="form.username.length == 0 && form.password.length == 0"
                  >
                  Save changes</button>
                </div>
              </div>

            </div>            
        </div>
        <div class="modal-footer">
            <center>
            <button type="button" class="btn btn-outline-success" data-dismiss="modal">Close</button>
            </center>
        </div>
    </div>
    </div>
  </div>

</div>

{{-- @auth
<script>
    window.user = @json(auth()->user()->usertype_id)
</script>
@endauth --}}
  <!-- Main core JavaScript -->
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- DataTables core JavaScript -->
  <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
  {{-- <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script> --}}

</body>

</html>

