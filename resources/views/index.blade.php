@extends('layouts.app')

@section('content')

    @if (session('status'))

    <div class="alert alert-warning alert-dismissible fade show w-50 offset-3" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

<div class="container" id="card">
        <div class="row pl-5">
            {{-- <div class="row no-gutters"> --}}
                @foreach ($items as $item)
                <div id="cardContainer" class="col-md-4 mx-2">
                    <div class="card shadow" style="width: 15rem;">
                        <a href="/items/{{ $item->id }}">
                            <img src="{{url('/images/'.$item->image)}}" class="card-img-top" alt="dumbbell" style="height: 230px;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title text-center p-2">{{ $item->name }}</h5>
                            <h5 class="text-center font-weight-bold p-2">${{ $item->price }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <a href="/items/{{ $item->id }}" class="btn btn-secondary btn-block">@lang('lang.cart')</a>
                        </div>
                    </div>
                </div>
                @endforeach
            {{-- </div> --}}
        </div>
</div>
@endsection

@extends('layouts.footer')