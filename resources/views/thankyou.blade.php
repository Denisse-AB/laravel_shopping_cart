@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="alert alert-success show w-50 offset-3 text-center" role="alert">
                ThankYou for your purchase!
            </div>
            <div class="table-responsive-md">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Sku</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Size</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($db as $item)
                    <tr>
                        <th scope="row">{{ $item->sku }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
