@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div id='checkoutCard' class="col-md-12">

        @if (session('status'))

            <div class="alert alert-success text-center" role="alert">
                {{ session('status') }}
            </div>

        @elseif ($noItems === false)

            <div class="alert alert-success" role="alert">
                No items.
            </div>

        @endif

        @foreach ($items as $item)
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="/items/{{ $item->id }}" role="button">
                            <img src="{{url('/images/'.$item->image)}}" class="card-img" alt="...">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            {{-- button --}}
                            <delete-wishlist item-id="{{ $item->id }}"></delete-wishlist>
                            <a href="/items/{{ $item->id }}" class="btn btn-secondary btn-sm float-right m-2" role="button">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

@endsection