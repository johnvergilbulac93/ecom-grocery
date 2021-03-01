<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="name" content="{{ Auth::user()->name }}">
  <meta name="server-datetime" content="{{ now() }}" >
  <title>Alturush | GROCERY-ADMIN</title>

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
      <router-link to="/" class="navbar-brand home" >
        {{-- <img src="AlturushDeliveryTextColored.png" width="30" height="30" class="d-inline-block align-top" alt=""> --}}
        {{-- GROCERY-ADMIN --}}
        <h3 >GROCERY-ADMIN</h3>
      </router-link>  
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
  <div class="container-fluid mt-5">

    <div class="row mt-4">

      @can('isSuperAdmin')
          <div class="col-lg-3 mt-3">
            <div class="sidebar">
              <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                    <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="far fas fa-home nav-icon"></i>
                      <p>Dashboard</p>
                    </router-link>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-cog "></i>
                      <p >
                        Masterfile
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <router-link :to="{ name: 'business_rule', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Business Rules</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'bu_time', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                         <p>Store Time</p>
                        </router-link>
                      </li>
                      <li class="nav-item has-treeview  ">
                        <a href="#" class="nav-link active">
                          <i class="nav-icon fas fa-shopping-basket "></i>
                          <p >
                            Item
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <router-link :to="{ name: 'central_item', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                            <p>Item Masterfile</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link :to="{ name: 'disable_uom', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                            <p>Disabled Item per UOM</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link :to="{ name: 'enable_uom', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                            <p>Enabled Item per UOM</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link :to="{ name: 'count', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Item count per store(available)</p>
                            </router-link>
                          </li>
                          {{-- <li class="nav-item">
                            <a href="./index.html" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Tag as Unavailable/Available</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                             <p>Import Unavailable/Available per batch</p>
                            </a>
                          </li> --}}
                          <hr>
                        </ul>   
                      </li>
                     
                      {{-- <li class="nav-item">
                        <router-link :to="{ name: 'business_rule', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Business Unit</p>
                        </router-link>
                      </li> --}}
                      <li class="nav-item">
                        <router-link :to="{ name: 'tenant', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Tenants</p>
                        </router-link>
                      </li>

                      <li class="nav-item">
                        <router-link :to="{ name: 'minimum_delivery', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Minimum Order (Delivery)</p>
                        </router-link>
                      </li>

                      <li class="nav-item">
                        <router-link :to="{ name: 'delivery_charges', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Delivery Charges</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'users', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Manage Users</p>
                        </router-link>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-upload "></i>
                      <p >
                        Uploading
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <router-link :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ITEM, PRICE</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Image filename and Category</p>
                        </router-link>
                      </li>
                      {{-- <li class="nav-item">
                        <a href="./index3.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Upload images</p>
                        </a>
                      </li> --}}
                    </ul>
                  </li>
                  {{-- <li class="nav-item">
                    <router-link :to="{ name: 'export', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="nav-icon fas fa-download"></i>
                      <p>
                        Export files
                      </p>
                    </router-link>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-clipboard-list "></i>
                      <p >
                        Transactions
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pick-up</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./index2.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Delivery</p>
                        </a>
                      </li>

                    </ul>
                  </li> --}}
                  <li class="nav-item">
                    {{-- <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="far fas fa-home nav-icon"></i>
                      <p>Repors</p>
                    </router-link> --}}
                    <a href="{{ route('reports') }}" class="nav-link active">
                      <i class="far fas fa-home nav-icon"></i>
                      <p>Reports</p>   
                    </a>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-cog "></i>
                      <p >
                        Reports
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      {{-- <li class="nav-item">
                        <router-link :to="{ name: 'accountability', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Cashier's Accountability
                          </p>
                        </router-link>
                      </li> --}}
                      <li class="nav-item">
                        <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Liquidation Report</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'report_item', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Items Report</p>
                        </router-link>
                      </li>

                    </ul>
                  </li>
                  
            
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
          </div>
      @endcan
      {{-- @can('isAdmin')
          <div class="col-lg-3 mt-4 ">
            <div class="sidebar">
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">

                    <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="far fas fa-home nav-icon"></i>
                      <p>Dashboard</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link :to="{ name: 'item', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="nav-icon fas fa-shopping-basket"></i>
                      <p>Item Masterfile</p>
                    </router-link>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-cog "></i>
                      <p >
                        Setup
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <router-link :to="{ name: 'picker_time', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Picker Allowed Time</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'pickup', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pick-up Time Cut-off</p>
                        </router-link>
                      </li>

                    </ul>
                  </li>
                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-clipboard-list"></i>
                      <p >
                        Reports
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <router-link :to="{ name: 'reports_store', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Items Report</p>
                        </router-link>
                      </li>

                    </ul>
                  </li>
                  

                
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
          </div>
      @endcan --}}
      @can('isGGM')
          <div class="col-lg-3 mt-3 ">
            <div class="sidebar">
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-upload "></i>
                      <p >
                        Uploading
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <router-link :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ITEM, PRICE</p>
                        </router-link>
                      </li>
                      <li class="nav-item">
                        <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Image filename and Category</p>
                        </router-link>
                      </li>
                    </ul>
                  </li>     
                </ul>
              </nav>
            </div>
          </div>
      @endcan
      
      @can('isIAD')
        <div class="col-lg-3 mt-3 ">
          <div class="sidebar">
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview  ">
                  <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-cog "></i>
                    <p >
                      Reports
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <router-link :to="{ name: 'accountability', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cashier's Accountability
                        </p>
                      </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Liquidation Report</p>
                      </router-link>
                    </li>

                  </ul>
                </li>    
              </ul>
            </nav>
          </div>
        </div>
      @endcan

      @can('isPurchasing')
          <div class="col-lg-3 mt-3">
            <div class="sidebar">
              <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                    <router-link :to="{ name: 'item', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="nav-icon fas fa-shopping-basket"></i>
                      <p>Item Masterfile</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link :to="{ name: 'disabled_item', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link active">
                      <i class="nav-icon fas fa-upload "></i>
                      <p>Upload Item code to disable</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link :to="{ name: 'reports_store', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link active">
                      <i class="nav-icon fas fa-clipboard-list"></i>
                      <p>Items Report</p>
                    </router-link>
                  </li>
            
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
          </div>
      @endcan

      @can('isAccounting')
          <div class="col-lg-3 mt-3">
            <div class="sidebar">
              <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                    <router-link :to="{ name: 'export', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link active">
                      <i class="nav-icon fas fa-download orange"></i> &nbsp;<span class="h6">EXPORT FILES</span> 
                    </router-link>
                  </li>    
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
          </div>
      @endcan

      @can('isSupervisor')
        <div class="col-lg-3 mt-3">
          <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                  <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link active">
                    <i class="nav-icon fas fa-clipboard-list orange"></i> &nbsp;<span class="h6"> Liquidation Report</span> 
                  </router-link>
                </li>    
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
        </div>
      @endcan

      <div class="col-lg-9 px-1 mt-3" >

        <div class=" mt-4">
        {{-- <div class="container mt-4" > --}}

          <router-view></router-view>

        </div>

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="custom-footer text-gray py-2">
    <div class="container">
      <p class="m-0 text-center">Copyright &copy; 2019-2020 <strong>GROCERY-ADMIN</strong>. All rights reserved.</p>
    </div>  
    <!-- /.container -->
  </footer>

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

@auth
<script>
    window.user = @json(auth()->user()->usertype_id)
</script>
@endauth
  <!-- Main core JavaScript -->
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- DataTables core JavaScript -->
  <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>

</body>

</html>

