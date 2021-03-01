@extends("layouts.app")
@section('menu')
    <div class="mt-4">
        <a href="{{ route('main-menu') }}" class="btn btn-primary mt-3">
          <i class="fas fa-long-arrow-alt-left"></i>
            <p>GO TO MENU</p>
        </a>
    </div>
    <hr  class="mt-1">
    <Liquidition></Liquidition>
    <router-view></router-view>

@endsection
