@component('mail::message')
# Shopping

Thank You {{ $customer->name }}, for your order!

@component('mail::panel')
<h2><strong>{{ $customer->name }}</strong></h2>
<p>{{ $customer->address }}</p>
<p>{{ $customer->city }} {{ $customer->state }}, {{ $customer->zip }}</p>
@endcomponent

@foreach ($orders as $order)
@component('mail::table')
    <tr>
       <th align="left">Items</th>
       <th align="left">Price</th> 
    </tr> 
    <tr>
        <td><h3>{{ $order->name ?? "name" }}</h3>
            <p>qty: {{ $order->qty }} size: {{ $order->size }}</p>
            <p>Item #: {{ $order->item_id }}</p>
        </td>
    <td>${{ $order->price * $order->qty }}</td>
    </tr>
@endcomponent
@endforeach

@component('mail::table')
<tr>
    <th align="right">Your Order Total:</th>
</tr>
<tr>
    <td>
        <p style="text-align: right;">Tax: ${{ number_format($order->tax, 2) }}</p>
        <p style="text-align: right;">Total:<strong> ${{ number_format($order->total, 2) }}</strong></p>
    </td>
</tr>
@endcomponent

{{-- button --}}
@component('mail::button', ['url' => '', 'color' => 'success'])
View your Order
@endcomponent

@component('mail::subcopy')

If you have any trouble regarding your order, please contact us at: yahoo@gmail.com <br>
<h4>Thanks,</h4>{{ config('app.name') }}

@endcomponent
@endcomponent