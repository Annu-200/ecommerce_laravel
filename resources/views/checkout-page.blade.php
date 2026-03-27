@extends('pages.main')

@section('contend')

<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <span>Shopping cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="#">Have a coupon?</a> Click
                here to enter your code.</h6>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('checkout.store') }}" method="POST" class="checkout__form">
            <div class="row">
                <div class="col-lg-8">
                    <h5>Billing detail</h5>
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>First Name <span>*</span></p>
                                <input type="text" name="first_name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Last Name <span>*</span></p>
                                <input type="text" name="last_name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Country <span>*</span></p>
                                <input type="text" readonly name="country" value="India">
                            </div>
                            <div class="checkout__form__input">
                                <p>Address <span>*</span></p>
                                <input type="text" placeholder="Street Address" name="address">
                                <input type="text" placeholder="Apartment. suite, unite ect ( optinal )" name="apartment">
                            </div>
                            <div class="checkout__form__input">
                                <p>Town/City <span>*</span></p>
                                <input type="text" name="city">
                            </div>
                            <div class="checkout__form__input">
                                <p>Country/State <span>*</span></p>
                                <input type="text" name="state">
                            </div>
                            <div class="checkout__form__input">
                                <p>Postcode/Zip <span>*</span></p>
                                <input type="text" name="pin">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Phone <span>*</span></p>
                                <input type="number" name="phone">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="text" name="email">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__checkbox">
                               
                                </div>
                                
                            
                                <div class="checkout__form__input">
                                    <p>Oder notes</p>
                                    <input type="text"
                                    placeholder="Note about your order, e.g, special noe for delivery (optional)" name="order_note">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    {{--  @php
                                    dd($cart, $productVarient)
                                    @endphp  --}}
                                    
                                    @if ($cart)
                                        @foreach ($cart as $item)
                                        @php
                                            $varient = $productVarient[$item['varient_id']] ?? null;
                                        @endphp

                                            <li>{{ $varient->product->product_name }} <span>₹{{ number_format($item['price']) }}</span></li>
                                        @endforeach
                                    @endif
                                    {{--  <li>01. Chain buck bag <span>$ 300.0</span></li>
                                    <li>02. Zip-pockets pebbled<br /> tote briefcase <span>$ 170.0</span></li>
                                    <li>03. Black jean <span>$ 170.0</span></li>
                                    <li>04. Cotton shirt <span>$ 110.0</span></li>  --}}
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Subtotal <span>₹ {{  number_format($subtotal)}}</span></li>
                                    <li>GST <span>₹ {{  number_format($subtotal * 0.18)}}</span></li>
                                    <li>Total <span>₹ {{  number_format($total + ($subtotal * 0.18))}}</span></li>
                                </ul>
                            </div>
                            <div class="checkout__order__widget">
                                <label for="o-acc">
                                    Cash on Delivery?
                                    <input type="radio" id="o-acc" name="payment_method" value="cod" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                    PayPal
                                    <input type="radio" id="paypal" name="payment_method" value="online">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">Place oder</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->








@endsection