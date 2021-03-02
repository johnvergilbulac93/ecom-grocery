@extends("layouts.app")
@section('menu')
    <div class="d-flex justify-content-start mt-4">
        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-danger  btn-sm float-right ">
                <i class="fas fa-long-arrow-alt-left"></i>
                GO BACK
            </a>
        </div>
        <div class="mt-3 ">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle btn-sm mx-2" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Select Report
                </button>
                <div class="dropdown-menu" style="min-width: 200px;" aria-labelledby="dropdownMenuButton">
                    <router-link :to="{ name: 'report_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                        class="dropdown-item" style="font-size: 14px;">
                        <p>Items Report</p>
                    </router-link>
                    <router-link :to="{ name: 'liquidition', params: { id: {{ Auth::user()->usertype_id }}  } }"
                        class="dropdown-item" style="font-size: 14px;">
                        <p>Liquidation Report</p>
                    </router-link>
                    <router-link :to="{ name: 'accountability', params: { id: {{ Auth::user()->usertype_id }}  } }"
                        class="dropdown-item" style="font-size: 14px;">
                        <p>Accountability Report</p>
                    </router-link>
                </div>
            </div>
        </div>

    </div>
    <hr class="mt-1">
    {{-- <Liquidition></Liquidition> --}}
    <router-view></router-view>

@endsection
