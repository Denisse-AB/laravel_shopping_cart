@extends('layouts.app')

@section('content')

<div id='checkoutCard' class="container">
    <div class="row">
        <div class="col-md-8">

            @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show w-50 offset-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            @if (session('status'))

            <div class="alert alert-warning alert-dismissible fade show w-50 offset-3" role="alert">
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
                                        <p class="card-text"><small class="text-muted offset-2"><span>Qty:
                                            {{ $qty }}
                                        </span></small>
                                        <small class="text-muted offset-2"><span>Total:
                                            {{ number_format($itemTotal, 2) }}
                                        </span></small></p>
                                        {{-- Vue --}}
                                            <delete-item item-id="{{ $item->id }}"></delete-item>
                                        @auth
                                            {{-- vue --}}
                                            <save-item item-id="{{ $item->id }}" checkdb="{{ $checkdb }}"></save-item>
                                        @else
                                            <button class="btn btn-secondary btn-sm float-right m-2" data-toggle="modal" data-target="#login">save for later</button>
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
                <h5 class="card-header text-center">Your Items!</h5>
                <div class="card-body">
                    <h5 class="card-text"><small class="font-weight-bold">Subtotal: </small>
                    <small class="float-right"><span>

                        @if (session('cart'))

                            ${{ number_format($subtotal, 2)  }}

                            @else
                               {{ (0) }}
                        @endif

                    </span></small></h5>
                    <p class="card-text text-muted">Shipping will be determing in next page.</p>

                    @guest
                        <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#login">Proceed to checkout</button>
                    @else
                        <a href="/checkout" type="button" class="btn btn-outline-secondary btn-block" role="button">Proceed to checkout</a>
                    @endguest

                    <!-- Modal -->
                    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="loginLabel">Log In</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer float-left">
                                            <div class="form-group row mb-0">
                                                <div class="">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Login') }}
                                                    </button>

                                                    @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                    @endif
                                                </div>

                                                <div class="row ml-5 pt-2">
                                                    <a href="{{ route('register') }}">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
