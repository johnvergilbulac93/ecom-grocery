<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <title>Alturush | GROCERY-ADMIN</title>
  {{-- <script>
    (function () {
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    })();
</script> --}}
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">




</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper" id='app' >

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars orange"></i></a>
        </li>
      </ul>
  
      <ul class="navbar-nav ml-auto">
                      
       {{-- <li class="nav-item dropdown">
         <a class="nav-link" data-toggle="dropdown" href="#">
           <span class="text-bold"> {{ Auth::user()->name }}</span>
           <i class="fas fa-caret-down"></i>
           
         </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
  
           <a class="dropdown-item text-center text-muted" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
           <p>{{ __('Logout') }}</p>
          </a>
  
         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
             @csrf
         </form>
  
         <div class="dropdown-divider"></div>
  
           <router-link to="/profile" class="dropdown-item text-center text-muted">
             <p>Profile</p>
          </router-link>
  
         </div>
       </li> --}}
       <li class="nav-item dropdown user-menu show">
         <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
           {{-- <img src="img/user1.jpg" class="user-image img-circle elevation-2" alt="User Image"> --}}
           <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
         </a>
         <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
           {{-- <!-- User image --> --}}
           <li class="user-header bg-gradient-orange ">
             <img src="img/user1.png" class="img-circle elevation-2" alt="User Image">
             <p>
               {{ Auth::user()->name }}
             </p>
           </li>
           <!-- Menu Body -->
           {{-- <li class="user-body">
             <div class="row">
               <div class="col-4 text-center">
                 <a href="#">Followers</a>
               </div>
               <div class="col-4 text-center">
                 <a href="#">Sales</a>
               </div>
               <div class="col-4 text-center">
                 <a href="#">Friends</a>
               </div>
             </div>
             <!-- /.row -->
           </li> --}}
           <!-- Menu Footer-->
           <li class="user-footer">
             <a href="#" class="btn btn-default btn-flat">Profile</a>
             <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right"  
             onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">Sign out</a>               
           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
           </form>
           </li>
         </ul>
       </li>
  
      </ul>
    </nav>
    <!-- /.navbar -->
  
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-1">
      <!-- Brand Logo -->
      <router-link to="/" class="brand-link">
        <img src="img/admin.png" alt="AdminLTE Logo" class="brand-image "
             style="opacity: .8">
       <center><span class="brand-text ">GROCERY-ADMIN</span></center> 
      </router-link>
  
      <!-- Sidebar -->
      <div class="sidebar" style="height: auto;">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="img/user1.jpg" class="img-circle elevation-1" alt="User Image">
          </div>
          <div class="info">
            {{ Auth::user()->name }}</h5> 
          </div>
        </div> --}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @can('isSuperAdmin')
            <li class="nav-item">
                 <router-link to="/" class="nav-link">
                      <i class="nav-icon fas fa-home orange"></i>
                      <p>
                          Dashboard
                      </p>
                 </router-link>
            </li>
            @endcan
            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/" class="nav-link">
                   <i class="nav-icon fas fa-home orange"></i>
                   <p>
                       Dashboard
                   </p>
              </router-link>
            </li>
            @endcan
            @can('isSuperAdmin')
            <li class="nav-item">
              <router-link to="/uploading" class="nav-link">
                   <i class="nav-icon fas fa-upload orange"></i>
                   <p>
                       Uploading
                   </p>
              </router-link>
           </li>
           @endcan
           @can('isSuperAdmin')
            <li class="nav-item">
              <router-link to="/central_item" class="nav-link">
                   <i class="fas fa-shopping-basket nav-icon orange"></i>
                   <p>
                    Item Masterfile
                   </p>
              </router-link>
            </li>
            @endcan
            
            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/item" class="nav-link">
                   <i class="fas fa-shopping-basket nav-icon orange"></i>
                   <p>
                    Item Masterfile
                   </p>
              </router-link>
            </li>
            @endcan
            @can('isSuperAdmin')
            <li class="nav-item">
              <router-link to="/business_rule" class="nav-link">
                   <i class="fas fa-cog nav-icon orange"></i>
                   <p>
                    Business Rules Setup
                   </p>
              </router-link>
            </li>
            @endcan
            <li class="nav-item">
              <router-link to="/picker_time" class="nav-link">
                   <i class="fas fa-cog nav-icon orange"></i>
                   <p>
                    Picker Allowed Time
                   </p>
              </router-link>
            </li>
            @can('isSuperAdmin')
            <li class="nav-item">
              <router-link to="/users" class="nav-link">
                   <i class="fas fa-users-cog nav-icon orange"></i>
                   <p>
                    Setup Users
                   </p>
              </router-link>
            </li>
            @endcan
            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/pickup" class="nav-link">
                   <i class="fas fa-users-cog nav-icon orange"></i>
                   <p>
                    Pick-Up Time Cut-off
                   </p>
              </router-link>
            </li>
            @endcan
            @can('isAdmin')
            <li class="nav-item">
              <router-link to="/users_bu" class="nav-link">
                   <i class="fas fa-users-cog nav-icon orange"></i>
                   <p>
                    Users
                   </p>
              </router-link>
            </li>
            @endcan
            {{-- <li class="nav-item">
              <router-link to="/reprint_barcode" class="nav-link">
                   <i class="fas fa-print nav-icon orange"></i>
                   <p>
                    Allow Reprint Barcode
                   </p>
              </router-link>
            </li> --}}


             {{-- <li class="nav-item has-treeview ">
              <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-cog orange"></i>
                <p>
                 Set-Up
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/business_rule" class="nav-link">
                    <i class="far fa-clock nav-icon" ></i>
                    <p>Business Rules</p>
                  </router-link>
                </li>

              </ul>
            </li> --}}
  
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      {{-- <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Starter Page</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div> --}}
      <!-- /.content-header -->
  
      <!-- Main content -->
      <div class="content">
  
          <router-view></router-view>
          
       
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->
  
    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Alturush | GROCERY-ADMIN
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2019-2020 <a href="#" class="text-orange">Alturush</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  @auth
  <script>
      window.user = @json(auth()->user()->user_type)
  </script>
  @endauth
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>