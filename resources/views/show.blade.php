@extends('layouts.app')

@section('content')
<div class="text-center">

    @if (session('status'))

        <div class="alert alert-info alert-dismissible fade show w-50 offset-3" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    @elseif (session('success'))

        <div class="alert alert-success alert-dismissible fade show w-50 offset-3" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    @endif

</div>
<div class="container">
    <div class="row py-4">
        {{-- image --}}
        <div class="col-md-6">
            <div class="row justify-content-center">
            <img class="img-fluid" src="{{url('/images/'.$items->image)}}" style="width: 250px;">
            </div>
        </div>
        {{-- details --}}
        <div class="col-md-6">
            <div class="row justify-content-center">
                <h4>{{ $items->name }}</h4>
            </div>
            <hr>
            <div>
                <h5 class="text-center pt-3">${{ $items->price }}</h5>
            </div>
            <div>
                <h5 class="text-center py-3">{{ $items->description }}</h5>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type='button' name="plus" class='btn bg-light border rounded-circle'><i class='fas fa-plus'></i></button>
                    <input type='text' name="quantity" id="qty" value="1" class='form-control d-inline' style="width:50px;" disabled>
                    <button type='button' name="minus" class='btn bg-light border rounded-circle minus'><i class='fas fa-minus'></i></button>
                </div>
            </div>
            <form action="/item/{{ $items->id }}" method="POST">
                @csrf
                <button type="submit" name="add" class="btn btn-outline-secondary mt-4 btn-block">@lang('lang.cart')</button>
                <input type="hidden" name="itemId" value="{{ $items->id }}" required>
                <input type="hidden" name="qty" value="1" required>
                <input type="hidden" name="price" value="{{ $items->price }}" required>
            </form>
        </div>
    </div>
</div>

@endsection

@section('comments')
    @auth
    <div class="container border rounded w-75 my-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>@lang('Leave a comment')</h5>
                <hr>
            </div>
            <!-- comments -->
            <comments-area
                user='{{ Auth::user()->name }}'
                user-id ='{{ Auth::user()->id }}'
                item-id='{{ $items->id }}'
                lang='{{ __('lang.en')}}'
            ></comments-area>
            {{-- end --}}
        </div>
    </div>
    @else
    <div class="container border rounded w-75 my-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="d-flex align-items-baseline">
                        <button class="btn btn-secondary btn-sm d-flex justify-content-start badge-pill" data-toggle="modal" data-target="#login">@lang('lang.login')</button>
                        <h4 class="offset-4">@lang('Leave a comment')</h4>
                    </div>
                    <hr>
                    @foreach ($comments as $comment)
                        <h4 class="my-4">{{ $comment->name }}</h4>
                        <hr class="w-25">
                        <p class="">{{ $comment->comment}}</p>
                        <p class="text-muted m-3">{{ $comment->created_at}}</p>
                    @endforeach
                </div>
            </div>
    </div>
    @endauth
@endsection
@extends('layouts.loginModal')
@extends('layouts.footer')