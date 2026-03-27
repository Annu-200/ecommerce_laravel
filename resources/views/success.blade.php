@extends('pages.main')


@section('contend')

  <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Order Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <h5 class="text-center  text-success mb-3">
             🎉Thank you for your order! 
             @if(session('success'))
                <span class="text-success">{{ session('success') }}</span>
            @endif
            
        </h5>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">


                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order Number (or ID)</th>
                                    <th> Method</th>
                                    <th> Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  @php
                                dd($orderItem);
                                @endphp  --}}
                                 <tr>
                                    <td class="cart__product__item">
                                        @foreach ($orderItem->orderItem as $item)
                                        <img src="{{ asset('uploads/product/thumbnails/'.$item->varient->thumbnail) }}" alt="" width="100px">
                                     @endforeach
                                        {{$order->order_num}}
                                        <div class="cart__product__item__title">
                                            <h6>{{$order->first_name}} {{$order->last_name}}</h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">{{$order->payment_mode}}</td>
                                    <td class="cart__quantity ">
                                       {{ $order->payment_status }}
                                    </td>
                                    {{--  <td class="cart__total">{{ $order->delivery_date }}</td>  --}}
                                    <td class="cart__total">{{ number_format($order->total) }}</td>
                                    @if($order->payment_status === 'paid' || $order->payment_status === 'processing' || $order->payment_status === 'pending')
                                        
                                    <form action="{{ route('order.destroy', $order->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <td class="cart__close"><button class="btn btn-secondary ">Cancel</button></td>
                                    </form>
                                    @endif
                                </tr>
                           
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('order.track') }}">My Order History</a>
                    </div>
                </div>
                
            </div>
            <div class="row">
              
                <div class="col-lg-12 ">
                    <div class="cart__total__procced">
                        <h6>Order Summary</h6>
                        <ul>
                            <li>Product <span>Total</span></li>
                            @foreach ($orderItem->orderItem as $item)
                            <li> {{$item->product->product_name}} <span> {{ number_format($item->price)}}</span></li>
                            {{--  <li>Total <span>$ {{ $item->orderPlace->address }}</span></li>  --}}
                            @endforeach
                              <li> Subtotal <span> {{ number_format($order->total)}}</span></li>
                            <li> Tax <span> {{ number_format($order->taxt)}}</span></li>
                            <li> Delivery Address <span> {{ ($order->address)}}</span></li>
                          <li>Delivery Date <span>{{ $order->deliverd_at ?? now()->addDays(5)->format('d-m-Y') }}</span></li>

                    
                        </ul>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop order details Section End -->


@endsection