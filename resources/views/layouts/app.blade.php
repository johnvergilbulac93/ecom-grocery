<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="name" content="{{ Auth::user()->name }}">
    <meta name="user-type" content="{{ Auth::user()->usertype_id }}">
    <meta name="server-datetime" content="{{ now() }}">
    <title>Alturush | GROCERY-ADMIN</title>
    <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet">
    <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables/datatables.min.css') }}" rel="stylesheet">


    {{-- <link href="{{ asset('css/ionicons.min.css')}}" rel="stylesheet"> --}}
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');

    header {
        font-family: 'Roboto', sans-serif;
    }

    .user {
        font-family: 'Roboto', sans-serif;
    }

</style>



<body>
    <div id='app'>
        <!-- Navigation -->
        <div class="wrapper">
            <nav class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
                <div class="container">
                    <router-link to="/" class="navbar-brand">
                        <img src="{{ URL::asset('/img/alturush.png') }}" alt="Logo"
                            style="height: 3rem; object-fit: cover" style="opacity: .8">
                        {{-- <span class="brand-text font-weight-light">GROCERY|ADMIN</span> --}}
                    </router-link>
                    <!-- Right navbar links -->
                    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">


                        <!-- User Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <img src="{{ URL::asset('/img/user1.png') }}" class="img-circle elevation-1"
                                    alt="User Image" style="height: 2rem;">
                                <span class="user text-uppercase">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="font-size: 15px;">
                                <a href="#" class="dropdown-item px-3 py-1" data-toggle="modal"
                                    data-target="#useraccount">
                                    <i class="fas fa-user-alt text-gray mx-2"></i> 
                                    <span class="text-gray">ACCOUNT</span> 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item px-3 py-1" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt text-gray mx-2"></i>
                                    <span class="text-gray">SIGN OUT</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Page Content -->
            @yield('menu')
{{-- 
            <footer class="footer-main">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Version 3.2.1
                </div>
                <!-- Default to the left -->
                <strong>Copyright © 2019-2020 <a href="https://admin.alturush.com"> ALTURUSH GROCERY |
                        ADMIN</a>.</strong> All rights reserved.
            </footer> --}}

            <div class="modal fade" id="useraccount" tabindex="-1" role="dialog" aria-labelledby="useraccount"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span class="float-left"></span> Your Account</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <center>
                                <img src="{{ URL::asset('/img/user1.png') }}" class="img-circle elevation-1"
                                    alt="User Image" style="height: 3rem;">
                                <h3> {{ Auth::user()->name }} </h3>

                            </center>
                            <hr class="py-1 px-1">
                            <button class="text-left btn btn-outline-primary btn-sm" type="button"
                                data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                                aria-controls="collapseExample">
                                CHANGE USERNAME & PASSWORD
                            </button>
                            <div class="collapse mt-2" id="collapseExample">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="username">USERNAME</label>
                                            <input v-model="form.username" type="text"
                                                class="form-control form-control-sm" name="username" id="username"
                                                :class="{ 'is-invalid': form.errors.has('username') }">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="passsword">NEW PASSWORD</label>
                                            <input v-model="form.password" type="password"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            @click.prevent="updateProfile"
                                            v-bind:disabled="form.username.length == 0 && form.password.length == 0">
                                            Save changes</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="button" class="btn btn-outline-success"
                                    data-dismiss="modal">Close</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- Main core JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- DataTables core JavaScript -->
    <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script> --}}

</body>

</html>
