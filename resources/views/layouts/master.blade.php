@extends("layouts.app")
@section('menu')

    @can('isSuperAdmin')
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

                            <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item dropdown ">

                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link   dropdown-toggle">
                                <i class="fas fa-cog text-orange fa-lg"></i>
                                <span>MASTERFILE</span>
                            </a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu dropdown-menu-lg border-0 shadow"
                                style="font-size: 12px;">
                                <li>
                                    <router-link
                                        :to="{ name: 'business_rule', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>BUSINESS RULES</p>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'bu_time', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>STORE TIME</p>
                                    </router-link>
                                </li>
                                <li class="dropdown-divider"></li>

                                <li class="dropdown-submenu dropdown-hover">
                                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" class="dropdown-item dropdown-toggle">ITEM</a>
                                    <ul aria-labelledby="dropdownSubMenu2"
                                        class="dropdown-menu dropdown-menu-lg border-0 shadow" style="font-size: 12px;">
                                        <li>
                                            <router-link
                                                :to="{ name: 'central_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                                class="dropdown-item">
                                                <p>ITEM MASTERFILE</p>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link
                                                :to="{ name: 'disable_uom', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                                class="dropdown-item">
                                                <p>DISABLED ITEM PER UOM</p>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link
                                                :to="{ name: 'enable_uom', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                                class="dropdown-item">
                                                <p>ENABLED ITEM PER UOM</p>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link
                                                :to="{ name: 'count', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                                class="dropdown-item">
                                                <p>ITEM COUNT PER STORE(AVAILABLE)</p>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-divider"></li>

                                <li>
                                    <router-link :to="{ name: 'tenant', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>TENANTS</p>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        :to="{ name: 'minimum_delivery', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>MINIMUM ORDER DELIVERY</p>
                                    </router-link>
                                </li>

                                <li>
                                    <router-link
                                        :to="{ name: 'delivery_charges', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>DELIVERY CHARGES</p>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'users', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>MANAGE USERS</p>
                                    </router-link>
                                </li>
                                {{-- <li class="dropdown-submenu dropdown-hover">
                                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" class="dropdown-item dropdown-toggle">ITEM</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            class="dropdown-item dropdown-toggle">level 2</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                </ul>
                            </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item dropdown ">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link   dropdown-toggle">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>UPLOADING</span>
                            </a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu dropdown-menu-lg border-0 shadow"
                                style="font-size: 12px;">
                                <li>
                                    <router-link
                                        :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>ITEM, PRICE</p>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>IMAGE FILENAME AND CATEGORY</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'multiple', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>UPLOAD MULTIPLE IMAGES</p>
                                    </router-link>
                                </li>
                                {{-- <li class="dropdown-submenu dropdown-hover">
                                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" class="dropdown-item dropdown-toggle">UPLOADING</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            class="dropdown-item dropdown-toggle">level 2</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                                            <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                </ul>
                            </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item dropdown ">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link   dropdown-toggle">
                                <i class="fas fa-list-alt text-orange fa-lg"></i>
                                <span>REPORTS</span>
                            </a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu dropdown-menu-lg border-0 shadow"
                                style="font-size: 12px;">
                                <li>
                                    <router-link
                                        :to="{ name: 'report_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>ITEMS REPORT</p>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                        class="dropdown-item">
                                        <p>LIQUIDITION REPORT</p>
                                    </router-link>
                                </li>
                                <router-link
                                    :to="{ name: 'accountability', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="dropdown-item">
                                    <p>ACCOUNTABILITY REPORT</p>
                                </router-link>
                            </ul>
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
                            <router-link
                                :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
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
                            <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <p>LIQUIDITION REPORT</p>
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
