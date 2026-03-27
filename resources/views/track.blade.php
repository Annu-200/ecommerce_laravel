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

  <!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 class="coupon__link"> Track Order </h6>
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
        <form action="{{ route('order.status') }}" method="POST" class="checkout__form">
            <div class="row">
          
                @csrf
                    <div class="col-lg-12">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                               <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="checkout__form__input">
                                <p>User Email <span>*</span></p>
                                <input type="email" name="email">
                            </div>
                        </div>
                        
                            </div>
                            
                            </div>
                           <div class="d-flex justify-content-center">
                            <button type="submit" class="site-btn btn btn-success">Track Order</button>
                        </div>  
              

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Shop order details Section End -->    
@endsection