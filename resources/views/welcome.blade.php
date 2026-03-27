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
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">

    
 
            <div class="row">    
                <div class="col-lg-6">
                    <div class="categories__item categories__large__item set-bg"
                    data-setbg="{{ asset('uploads/category/'. $category->cat_images)}}">
                    <div class="categories__text">
                        <h1>{{ $category->cat_title }}</h1>
                        <p>{{ $category->cat_description }}.</p>
                        <a href="{{ route('CategoryOne' , $category->id)}}">Shop now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    
                    @foreach ($categoryAll as $cat_data)
                  
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="{{ asset('uploads/category/'. $cat_data->cat_images)}}">
                            <div class="categories__text">
                                <h4 class="text-secondary">{{ $cat_data->cat_title}}</h4>
                                <p>358 items</p>
                                <a href="{{ route('CategoryOne' , $cat_data->id)}}">Shop now</a>
                            </div>
                        </div>
                    </div>
      
                    @endforeach
                   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>New product</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="all">All</li>
                       
                    @foreach($category_data as $cat_data)
               
                    <li data-filter="{{$cat_data->id}}">{{$cat_data->cat_title}}</li>
                   @endforeach
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            {{--  @php
            dd($porduct)
            @endphp  --}}

            @foreach ($porduct as $pro_data)
               
            
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/product/thumbnails/'.$pro_data->thumbnail) }}">
                        {{--  <div class="label new">New</div>  --}}
                        <ul class="product__hover">
                            <li><a href="{{ asset('uploads/product/thumbnails/'.$pro_data->thumbnail) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="{{ route('productdetails', $pro_data->id) }}"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">{{ $pro_data->product_name}}</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">  ₹ {{ number_format($pro_data->regular_price) ?? 'N/A'}}</div>
                    </div>
                </div>
            </div>
            @endforeach 


        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="images/banner-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Trend Section Begin -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Hot Trend</h4>
                    </div>
                    @foreach($hot_trend as $trend)
                   
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ asset('uploads/subcategory/'. $trend->SubCategory->subcat_images)}}" alt="" width="90px">
                        </div>
                        <div class="trend__item__text">
                            <h6>{{ $trend->SubCategory->subcat_title}}</h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
        
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Best seller</h4>
                    </div>
                    @foreach($best_seller as $best)
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ asset('uploads/product/thumbnails/' . $best->varient->thumbnail) }}" alt="" width="90px">
                        </div>
                        <div class="trend__item__text">
                            <h6>{{ $best->Subcategory->subcat_title }}</h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                   
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Feature</h4>
                    </div>
                    @foreach($feature as $feature_data)
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ asset('uploads/subcategory/'. $feature_data->Subcategory->subcat_images) }}" alt="" width="90px">
                        </div>
                        <div class="trend__item__text">
                            <h6>{{ $feature_data->Subcategory->subcat_title }} </h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                           
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trend Section End -->

<!-- Discount Section Begin -->
<section class="discount">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="discount__pic">
                    <img src="images/discount.jpg" alt="discount">
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="discount__text">
                    <div class="discount__text__title">
                        <span>Discount</span>
                        <h2>Summer 2025</h2>
                        <h5><span>Sale</span> 50%</h5>
                    </div>
                    <div class="discount__countdown" id="countdown-time">
                        <div class="countdown__item">
                            <span>22</span>
                            <p>Days</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>Hour</p>
                        </div>
                        <div class="countdown__item">
                            <span>46</span>
                            <p>Min</p>
                        </div>
                        <div class="countdown__item">
                            <span>05</span>
                            <p>Sec</p>
                        </div>
                    </div>
                    <a href="#">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Discount Section End -->

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
           
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Money Back Guarantee</h6>
                    <p>If good have Problems</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Online Support 24/7</h6>
                    <p>Dedicated support</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Payment Secure</h6>
                    <p>100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function(){
            const Token = localStorage.getItem('api_token');
        

            $.ajax({
                type: "GET",
                url: "/api/dashboard",
               headers: {
                    'Authorization': `Bearer ${Token}`,
                    'Accept': 'application/json'
                },
                success: function (response) {
                    //Do anything
                    console.log('token',response);
                    window.location.href=response.redirect

                },
                error: function (response) {
                    console.log('error', response);
                }
            });
        });
        
  $('.filter__controls li').on('click' , function(){

   $('.filter__controls li').removeClass('active');
    $(this).addClass('active');

  let baseUrl = "{{ asset('uploads/product/thumbnails') }}/";
  let productUrl = "{{ route('productdetails', '') }}/";

    let cat_id = $(this).data('filter');
    let productHtml = $('.property__gallery');

       $.ajax({
        'type': "GET",
        'url': '/filter-product',
        'data': {
            cat_id : cat_id
        },
        'success': function(response){
            console.log(response);
            productHtml.html('');
        
        response.category_product.forEach(pro_data => {
            productHtml.append(`
          <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="${baseUrl}${pro_data.thumbnail}">
                        {{--  <div class="label new">New</div>  --}}
                        <ul class="product__hover">
                            <li><a href="${baseUrl}${pro_data.thumbnail}" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="${productUrl}${pro_data.id}"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">${pro_data.product_name}</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">  ₹ ${pro_data.price ?? "N/A"}</div>
                    </div>
                </div>
            </div>
         
         `);
         });
       $('.set-bg').each(function() {
            let bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
        });
    }
       });
       
  })  
</script>


</body>

@endsection