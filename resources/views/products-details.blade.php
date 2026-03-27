<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('pages.main')

    @section('contend')
            
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{--  @php 
                    dd($product);
                    @endphp  --}}
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="#" data-product="{{ $product->product->product_id}}" id="product">{{ $product->product->subCategory->category->cat_title }} </a>
                            <a href="#">{{ $product->product->subCategory->subcat_title}} </a>
                        <span>{{ $product->product->product_name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-success d-none text-center" id="alert"></div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                          @foreach($product->gallery as $key => $img)
                            <a class="pt active" href="#" data-image="{{ asset('uploads/product/gallery/'.$img )}}">
                                <img src="{{ asset('uploads/product/gallery/'.$img )}}" alt="">
                            </a>
                            @endforeach
                           
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                
                                @foreach ($product->gallery as $item => $value)
                                <img data-hash="{{$product->$item}}" class="product__big__img" src="{{ asset('uploads/product/gallery/'. $value)}}" alt="">
                                    
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3 id="product_id" data-product-id="{{ $product->id }}">{{$product->product->product_name}} <span data-brand="{{ $product->product->brandShow->brand_name }}">Brand: {{ $product->product->brandShow->brand_name }}</span></h3>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>  
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>    
                        </div>
                        <div class="product__details__price" data-price="{{  number_format($product->regular_price) }}">₹ {{ number_format($product->regular_price) }} <span> ₹ {{ number_format($product->price) }}</span></div>    
                        <p>{{ $product->product->short_description }}</p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity: </span>
                                <div class="pro-qty">
                                    <input type="text" value="1" id="quantity-input">
                                </div>
                            </div>
                            <button href="#" class="cart-btn {{ $product->stock_quantity <= 0 ? ' d-none' : '' }}" {{ $product->stock_quantity < 0 ? 'disabled' : '' }}><span class="icon_bag_alt"></span> Add to cart</button>
                            <ul>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            In Stock
                                            <input type="checkbox" data-stock="{{ $product->stock_quantity }}" id="stockin" {{ $product->stock_quantity > 0 ? 'checked' : '' }} hidden>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        @foreach($color as $item)
                                        @if($item->id == $product->color)
                                       @php
                                           $bgClass = $item->name . '-bg';
                                       @endphp
                                        <label for="{{ $item->name }}">
                                            <input type="radio" name="color__radio" data-color="{{ $item->id }}" id="{{ $item->name }}"   {{ $product->color == $item->id ? 'checked' : '' }} hidden>
                                            <span class=" checkmark {{ $bgClass }} "
                                                 style="background :{{ $item->code }};">
                                            </span>
                                        </label>
                                        @endif
                                        @endforeach
                                    </div>
                                </li>
                                <li>
                                    <span> size:</span> 
                                    <div class="size__btn">
                                       

                                        @foreach($size as $sz)
                                          @if($sz->id == $product->size)
                                        <label for="{{$sz->size}}-btn" class="active">
                                         
                                            <input type="radio" id="{{$sz->size}}-btn" checked data-size={{$sz->size}}>
                                           {{ $sz->size }}
                                        </label>
                                        @endif
                                        @endforeach

                                       
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p> {{ $product->product->pro_description }} </p>
                            </div>
                               
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                quis, sem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>       
                @foreach($product_data as $value)
               {{--  @php
                   dd($value)
               @endphp  --}}
             @if($product->product->subCategory->subcat_id == $value->product->subCategory->subcat_id)
              
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/product/thumbnails/'.$value->thumbnail) }}">
                            {{--  <div class="label new">New</div>  --}}
                            <ul class="product__hover">
                                <li><a href="{{ asset('uploads/product/thumbnails/'.$value->thumbnail) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="{{ route('productdetails', $value->id) }}"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">{{ $value->product->product_name }}</a></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price">  {{ $value->ragular_price }} </div>
                        </div>
                    </div>
                </div>
               @endif
@endforeach


            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
{{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}


    <script>
        $('.pt').on('click',function(e){
            e.preventDefault();
            let img = $(this).data('image');
            $('.product__big__img').attr('src' , img)

            
        });
      
        $(document).on('change','.size__btn',  function(){
            $('.size__btn').on('click' , function(){
                $('.size__btn label').removeClass('active');
                $(this).closest('.size__btn').addClass('active');
            });
        });

       const cartBtn = document.querySelector('.cart-btn');
       cartBtn.addEventListener('click', function(e){
        e.preventDefault();
        let formData = new FormData();
          let size =  $('.size__btn .active input').data('size');
          let color = $('input[name="color__radio"]:checked').data('color');
            let quantity =  $('#quantity-input').val();
           // let brand =  $('#product_id span').data('brand');
            let varient_id =  $('#product_id').data('product-id');
            let product_id =  $('#product').data('product');
            let price = $('.product__details__price').data('price');
            //const tokenUser = localStorage.getItem('user_details');
          $('#alert').removeClass('d-none');
           
            formData.append('size' , size);
            formData.append('varient_id' , varient_id);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('color' , color);
            formData.append('quantity' , quantity);
            formData.append('product_id' , product_id);
            formData.append('price' , price);
        //    console.log(`size ${size} color ${color} quantity ${quantity} varient_id ${varient_id} product_id ${product_id} price ${price}`);
         $.ajax({
            url: '/add-to-cart',
            type:'POST',
            data: formData,
                   processData: false,
                   contentType:false, 
          
                   success: function(response){
                       console.log(response);

                       alert(response.message);
                       $('#alert').removeClass('d-none');
                       $('#alert').html(response.message);
                       $('.cart-count').text(response.cart_count);
                   },
                   error:function(err){
                          console.log(err);
                   },
               });  

       })

    </script>
    @endsection
