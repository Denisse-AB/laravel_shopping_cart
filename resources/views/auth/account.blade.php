@extends('layouts.app')

@foreach ($user as $customer)
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <edit-user
                customer-id='{{ $customer->id }}'
                customer-name='{{ $customer->name }}'
                customer-address='{{ $customer->address }}'
                customer-city='{{ $customer->city }}'
                customer-state='{{ $customer->state }}'
                customer-zip='{{ $customer->zip }}'
                customer-tel='{{ $customer->tel }}'
                lang='{{ __('lang.en')}}'
                ></edit-user>
                <br><br>
            </div>
        </div>
    @endsection
@endforeach
