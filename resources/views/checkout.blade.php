@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @if (session('status'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                        $size = session('cart')[$key]["size"];
                        $qty = session('cart')[$key]["quantity"];
                        $price = session('cart')[$key]["price"];
                        $itemTotal = session('cart')[$key]["subtotal"];
                        $checkdb = session('cart')[$key]["checkdb"] ?? '';
                        @endphp

                        <div id="checkoutCard" class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{url('/images/'.$item->image)}}" class="card-img" alt="dumbbell">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">{{ $item->description }}</p>
                                        <p class="card-text"><small class="text-muted">Size:
                                                {{ $size }}
                                            </small><small class="text-muted offset-2"><span>Qty:
                                                    {{ $qty }}
                                                </span></small>
                                            <small class="text-muted offset-2"><span>Total:
                                                    {{ number_format($itemTotal, 2) }}
                                                </span></small></p>

                                        <form action="/item/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm float-right m-2">Remove</button>
                                        </form>
                                        {{-- vue --}}
                                            <save-item item-id="{{ $item->id }}" checkdb="{{ $checkdb }}"></save-item>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @endforeach
                @endif
            </div>
            {{-- subTotal --}}
            <div class="col-md-4">
                <div class="card">
                    <h5 class="card-header text-center">Your Items!</h5>
                    <div class="card-body">
                        <h5 class="card-text"><small class="font-weight-bold">Subtotal: </small>
                            <small class="float-right">
                                <span>$
                                    {{ number_format($subtotal, 2) }}
                                </span>
                            </small>
                        </h5>
                        {{-- tax --}}
                        <h5 class="card-text"><small class="font-weight-bold">Tax: </small>
                            <small class="float-right">
                                <span>
                                    {{ number_format($tax, 2) }}
                                </span>
                            </small>
                        </h5>
                        {{-- shipping --}}
                        <h5 class="card-text"><small class="font-weight-bold">Shipping: </small>
                            <small class="float-right">
                                <span>
                                    {{ number_format(0, 2) }}
                                </span>
                            </small>
                        </h5>
                        <hr>
                        {{-- total --}}
                        <h5 class="card-text"><small class="font-weight-bold">Total: </small>
                            <small class="float-right">
                                <span>$
                                    {{ number_format($total, 2) }}
                                </span>
                            </small>
                        </h5>
                        {{-- stripe --}}
                        <form action="/charge/{{ $user->id }}" method="post" id="payment-form">
                        @csrf

                        <div>
                            <br>
                            <label for="card-element" class="offset-3">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div class="text-center text-danger" id="card-errors" role="alert"></div>
                        </div>
                        <button id="checkout-button" data-secret="{{ $intent->client_secret }}" class="btn btn-light badge-pill btn-block my-3 button shadow" role="button" style="background-color: #5469d4; color:#ffffff;">
                            <span id="spinner" class="spinner-border spinner-border-sm invisible" role="status" aria-hidden="false"></span>
                            {{-- <div class="spinner hidden" id="spinner"></div> --}}
                            <span id="button-text">Pay with Stripe
                            <i class="fab fa-cc-stripe" style="font-size: 20px;padding-left:5px;"></i></span>
                        </button>
                            <input type="text" name="total" id="total" value="{{ $total }}" hidden>
                            <input type="text"name='tx' value="{{ $tax }}" hidden>
                            <input type="text" name="email" id="email" value="{{ $user->email }}" hidden>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" hidden>
                            <input type="text" name="address" id="address" value="{{ $user->address }}" hidden>
                            <input type="text" name="zip" id="zip" value="{{ $user->zip }}" hidden>
                            <input type="text" name="city" id="city" value="{{ $user->city }}" hidden>
                        </form>
                    </div>
                </div>
                {{-- Personal info --}}
                <div class="card mt-2">
                <h5 class="card-header text-center">Your Info <a class="float-right text-decoration-none text-body" href="/account"><span><i class="fas fa-cog"></i></a></span></h5>
                    <div class="card-body">
                        <p class="pb-2">{{ $user->name }} <span class="float-right">{{ $user->email }}</span></p>
                        <hr>
                    <div class="text-center">
                        <p>{{ $user->address }}</p>
                        <p>{{ $user->city }}</p>
                        <p>{{ $user->state }}, <span>{{ $user->zip }}</span></p>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@endsection
