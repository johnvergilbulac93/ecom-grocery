@extends("layouts.app")
@section('menu')
<div class="row">
  @can('isSuperAdmin')
      <div class="col-lg-3 mt-3">
        <div class="sidenav">
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
                  {{-- <li class="nav-item">
                    <router-link :to="{ name: 'manage-users', params: { id: {{ Auth::user()->usertype_id}}  } }"  class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Users</p>
                    </router-link>
                  </li> --}}
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
                    <li class="nav-item">
                      <router-link :to="{ name: 'multiple', params: { id: {{ Auth::user()->usertype_id}}  } }" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Multiple Images</p>
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
                <a href="{{ route('report-menu') }}" class="nav-link active">
                  <i class="far fas fa-clipboard-list nav-icon"></i>
                  <p>Reports</p>   
                </a>
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

  <div class="col-lg-9 mt-3 pr-4" >

    <div class="mt-2">
    {{-- <div class="container mt-4" > --}}

      <router-view></router-view>

    </div>

  </div>
  <!-- /.col-lg-9 -->

</div>
@endsection