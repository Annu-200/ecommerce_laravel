<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Henry Ecommerce">
    <meta name="keywords" content="Henry, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Henry | online Shop</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->

<link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.min.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ URL::asset('/css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('/css/elegant-icons.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('/css/jquery-ui.min.css') }}" type="text/css">

<link rel="stylesheet" href="{{ URL::asset('/css/magnific-popup.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('/css/owl.carousel.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('/css/slicknav.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('/css/style.css') }}" type="text/css">
{{--  < --- code INjected by server -- >  --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css" integrity="sha512-8PjjnSP8Bw/WNPxF6wkklW6qlQJdWJc/3w/ZQPvZ/1bjVDkrrSqLe9mfPYrMxtnzsXFPc434+u4FHLnLjXTSsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>


</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_heart_alt"></span>
                <div class="tip">2</div>
            </a></li>
            <li><a href="#"><span class="icon_bag_alt" data-bag=""></span>
                <div class="tip cart-count">{{ $cartCount }}</div>
            </a></li>
            dd($cartCount)
        </ul>
        <div class="offcanvas__logo">
            <a href="/home"><img src="{{ asset('images/logo/henry-logo.jpeg')}}" height="50px" width="98px" alt="logo"></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            @auth
                <i class="fa fa-sign-out" aria-hidden="true" id="logoutBtn"></i>        
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('images/logo/henry-logo.jpeg')}}" height="50px" width="98px" alt="logo"></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul class="d-flex justify-content-center align-items-center gap-4 mb-0">
                            <li class="active"><a href="{{ route('home') }}">Home</a></li>
                            @foreach ($subcategories as $item)
                                
                            <li><a href="{{ route('CategoryOne', $item->id)}}">{{ $item->cat_title }}</a></li> 
                            @endforeach
                          
                            <li><a href="{{ route('shop')}}">Shop</a></li>
                     
                        </ul>
                    </nav>
                </div>
                
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            @auth
                             {{ auth()->user()->name() }}
                            @endauth
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                                   
                            
                        </div>
                        <ul class="header__right__widget">
                            <li> 
                                <i class="fa fa-sign-out" aria-hidden="true"  id="logoutBtn">
                                </i> 
                               
                             </li>
                            <li id="search-product"><span class="icon_search search-switch"></span></li>
                           
                        
                            <li><a href="{{ route('cart')}}"><span class="icon_bag_alt"></span>
                                <div class="tip cart-count">{{ $cartCount }}</div>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
     @yield('contend')
     

     <!-- Instagram Begin -->
<div class="instagram">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-1.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-2.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-3.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-4.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-5.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ asset('images/instagram/insta-6.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ ashion_shop</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Instagram End -->
     <!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('images/logo/henry-logo.jpeg')}}" width="max 100px"></a>
                    </div>
                    <p>Henry is your trusted online store for fashion, accessories, and lifestyle products, providing exceptional service and hassle-free returns.</p>
                    <div class="footer__payment">
                        <a href="#"><img src="{{ asset('images/payment/payment-1.png')}}" alt="payment-1"></a>
                        <a href="#"><img src="{{ asset('images/payment/payment-2.png')}}" alt="payment-2"></a>
                        <a href="#"><img src="{{ asset('images/payment/payment-3.png')}}" alt="payment-3"></a>
                        <a href="#"><img src="{{ asset('images/payment/payment-4.png')}}" alt="payment-4"></a>
                        <a href="#"><img src="{{ asset('images/payment/payment-5.png')}}" alt="payment-5"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    <h6>Quick links</h6>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blogs</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    <h6>Account</h6>
                    <ul>
                        <li><a href="{{ route('register') }}">Register User</a></li>
                        <li><a href="#">Orders Tracking</a></li>
                        <li><a href="{{route('cart')}}">Checkout</a></li>
                        <li><a href="#">Wishlist</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6>NEWSLETTER</h6>
                    <form action="#">
                        <input type="text" placeholder="Email">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
            <div id="searchResults"></div>
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
{{--  <script src="/js/jquery-3.3.1.min.js"></script>  --}}
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.magnific-popup.min.js"></script>

<script src="/js/mixitup.min.js"></script>
<script src="/js/jquery.countdown.min.js"></script>
<script src="/js/jquery.slicknav.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/jquery.nicescroll.min.js"></script>
<script src="/js/main.js"></script>
{{-- <script src="/js/restore.js"></script> --}}
<!-- jQuery UI CSS -->


<!-- Code injected by live-server -->
 

 <script>

const logoutBtn = document.querySelector('#logoutBtn');
logoutBtn.addEventListener('click', function(){
 const Token = localStorage.getItem('api_token');

 fetch('/api/logout', {
  method: 'GET',
  headers: {
       'Authorization' : `Bearer ${Token}`,
  },
 }).then((response) => response.json())
 .then((data) => {
 if(data.status){
  console.log(data);
  
  localStorage.removeItem('api_token');
  window.location.href = '{{ route('logout') }}';
 }
 })

});



$("#search-input").on("keyup", function(){
    let query = $(this).val();
    let searchModle = $("#searchResults");
    if(query.length > 0){
        $.ajax({
          url:"live-search",
          method:"GET",
          data: {
            query:query
          },
          success: function(data){
             const product = data.data;
            searchModle.html(product);
          }
        });
    }
});
</script>
	
</body>

</html>