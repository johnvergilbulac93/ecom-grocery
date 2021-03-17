@extends("layouts.app")
@section('menu')

    @can('isSuperAdmin')
        <header class="main-sidenav navbar navbar-expand-sm navbar-light navbar-white layout-navbar-fixed">
            <div class="container">
                <button class="navbar-toggler order-3" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">

                            <router-link :to="{ name: 'menu', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-bars text-orange fa-lg"></i>
                                <span>MENU</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isGGM')
        <header class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-cloud-upload-alt text-orange"></i>
                                <span>ITEM, PRICE</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>IMAGE FILENAME AND CATEGORY</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'multiple', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>UPLOAD MULTIPLE IMAGES</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isIAD')
        <header class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>LIQUIDITION REPORT</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{ name: 'accountability_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>CASHIER ACCOUNTABILITY REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isPurchasing')
        <header class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-shopping-cart text-orange fa-lg"></i>
                                <span>ITEM MASTERFILE</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'disabled_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>UPLOAD ITEM CODE TO DISABLE</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'reports_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>ITEM REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isAccounting')
        <header class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link :to="{ name: 'export', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <p>EXPORT FILES</p>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isSupervisor')
        <header class="main-sidenav navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3 " id="navbarCollapse" style="font-size: 16px;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <router-link
                                :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>LIQUIDITION REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    <div class="mt-2">
        <router-view></router-view>
    </div>
@endsection
