@extends('layouts.app')

@section('content')

<div id='checkoutCard' class="container">
    <div class="row">
        <div class="col-md-8">

            @if (session('status'))

            <div class="alert alert-info alert-dismissible fade show w-50 offset-3" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif

            @if(session('cart'))

                @foreach ($items as $item)
                    @foreach (session('cart') as $key => $value)
                        @if ($value['itemId'] == $item->id)

                            @php
                                $qty = session('cart')[$key]["quantity"];
                                $price = session('cart')[$key]["price"];
                                $itemTotal = session('cart')[$key]["subtotal"];
                                $checkdb = session('cart')[$key]["checkdb"] ?? '';
                            @endphp

                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <a href="/items/{{ $item->id }}">
                                        <img src="{{url('/images/'.$item->image)}}" class="card-img" alt="...">
                                    </a>
                                    </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text">{{ $item->description }}</p>
                                        <p class="card-text">
                                            <small class="text-muted offset-2">
                                                <span>Qty:
                                                    {{ $qty }}
                                                </span>
                                             </small>
                                        <small class="text-muted offset-2">
                                            <span>Total:
                                                {{ number_format($itemTotal, 2) }}
                                            </span>
                                        </small>
                                    </p>
                                        {{-- Vue --}}
                                        <delete-item item-id="{{ $item->id }}" lang="{{ __('lang.en')}}"></delete-item>
                                    @auth
                                        {{-- vue --}}
                                        <save-item item-id="{{ $item->id }}" checkdb="{{ $checkdb }}" lang="{{ __('lang.en')}}"></save-item>
                                    @else
                                        <button class="btn btn-secondary btn-sm float-right m-2" data-toggle="modal" data-target="#login">{{ __('save for later')}}</button>
                                    @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            @else
                <h3>Cart is Empty</h3>
            @endif
        </div>
        {{-- subTotal --}}
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header text-center">{{ __('Your Items')}}!</h5>
                <div class="card-body">
                    <h5 class="card-text"><small class="font-weight-bold">Subtotal: </small>
                    <small class="float-right"><span>

                        @if (session('cart'))

                            ${{ number_format($subtotal, 2)  }}

                            @else
                               {{ (0) }}
                        @endif

                    </span></small></h5>
                    <p class="card-text text-muted">{{ __('Shipping will be determing in next page')}}.</p>

                    @guest
                        <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#login">{{ __('Proceed to checkout')}}</button>
                    @else

                        <a href="/checkout" type="button" class="btn btn-outline-secondary btn-block" role="button">{{ __('Proceed to checkout')}}</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.loginModal')