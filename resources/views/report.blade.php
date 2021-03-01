@extends("layouts.app")
@section('menu')
    <div class="mt-4">
        <div class="row">
            <div class="col-10 mt-3 float-left">
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle btn-sm float-left" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Report
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id }}  } }"
                            class="dropdown-item">
                            <p>Liquidation Report</p>
                        </router-link>
                        <router-link :to="{ name: 'report_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                            class="dropdown-item">
                            <p>Items Report</p>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <a href="{{ route('home') }}" class="btn btn-danger mt-3 btn-sm float-right ">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    BACK TO MENU
                </a>
            </div>
        </div>

    </div>
    <hr class="mt-1">
    {{-- <Liquidition></Liquidition> --}}
    <router-view></router-view>

@endsection
