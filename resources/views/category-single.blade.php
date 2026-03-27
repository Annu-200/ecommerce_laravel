@extends('pages.main')

@section('contend')

 <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
              
                <div class="col-lg-12 col-md-4">
                    <div class="row">
         
                    @foreach($subcategories->SubCategory as $data)

   

        <div class="col-lg-4 col-md-6">
            <div class="product__item">
                <div class="product__item__pic set-bg"
                     data-setbg="{{ asset('uploads/subcategory/' . $data->subcat_images) }}">

                    @if($loop->last)
                        <div class="label new">New</div>
                    @endif 

                    <ul class="product__hover">
                        <li>
                            <a href="#"><span class="icon_heart_alt"></span></a>
                        </li>
                        <li>
                            <a href="{{ route('shop') }}?subcat={{ $data->subcat_id }}">
                                <span class="arrow_right_alt"></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="product__item__text">
                    <h6>
                        <a href="#">{{ $data->subcat_title }}</a>
                    </h6>
                </div>
            </div>
        </div>

    @endforeach


 

               
       
                     
                      
                       
                        
                        {{--  <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

{{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}
<script>

   {{--  function SubcategoryFilter(id = null){
    
    $.ajax({
        type: "GET",
        url: "filter-category",
        data:{
            subcat: [id]
        },
        success: function(response){
            console.log(response);
        }
    })
   }  --}}
</script>


@endsection