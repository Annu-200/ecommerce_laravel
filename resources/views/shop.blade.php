

@extends('pages.main')


@section('contend')

  <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
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
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @foreach($category as $key => $cat_data)
                                    <div class="card">
                                        <div class="card-heading @if($loop->first) active @endif">
                                            <a data-toggle="collapse"  data-target="#collapse{{$key}}">{{ $cat_data->cat_title }}</a>
                                        </div>
                                        <div id="collapse{{$key}}" class="collapse @if($loop->first) show @endif" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul>
                                                    @foreach ($cat_data->SubCategory as $sub)
                                                        
                                                    <li><a href="#" class="subcat__list" data-subcat-id="{{ $sub->subcat_id }}">{{ $sub->subcat_title }}</a></li>
                                                    @endforeach
                                                    {{--  <li><a href="#">Jackets</a></li>
                                                    <li><a href="#">Dresses</a></li>
                                                    <li><a href="#">Shirts</a></li>
                                                    <li><a href="#">T-shirts</a></li>
                                                    <li><a href="#">Jeans</a></li>  --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Shop by price</h4>
                            </div>
                            <div class="filter-range-wrap">
                            
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                              data-min="{{ number_format($min_price) }}" data-max="{{ ($max_price) }}">
                               
                            </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <p>Price:</p>
                                        
                                        <input type="text" id="minamount" value="{{ number_format($min_price) }}">
                                         <input type="text" id="maxamount" value="{{ number_format($max_price) }}">
                                    </div>
                                </div>
                            </div>
                           {{--  // <a href="#">Filter</a>  --}}
                        </div>
                        <div class="sidebar__sizes" id="size">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                @foreach($sizes as $sz)
                                <label for="{{ $sz->size }}">
                                    {{ $sz->size }}
                                    <input type="checkbox" class="size-checkbox" name="size_list" id="{{ $sz->size }}" value="{{ $sz->size }}">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                               
                            </div>
                        </div>
                        <div class="sidebar__color">
                            <div class="section-title">
                                <h4>Shop by Color</h4>
                            </div>
                            <div class="size__list color__list">
                                @foreach($color as $col)
                                <label for="{{ $col->id }}">
                                    {{ $col->name }}
                                    <input type="checkbox" id="{{ $col->id }}" class="color-checkbox"  value="{{ $col->name }}">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="subcat_id" value="{{ (request('subcat')) }}">
                <div class="col-lg-9 col-md-9">
                    <div class="row" id="product__filter">
                                   @foreach($product_all as $product)                                  
                        <div class="col-lg-4 col-md-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/product/thumbnails/'.$product->varient->thumbnail) }}">
                                   @if($product->created_at >= now()->subDays(7))
                                    <div class="label new">New</div>
                                    @endif
                                   @if($product->stock_quantity >= 1) 
                                    <div class="label stockout stockoutblue">Out of stock</div>
                                    @endif
                                    <ul class="product__hover">
                                        <li><a href="{{ asset('uploads/product/thumbnails/'.$product->varient->thumbnail) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="{{ route('productdetails', $product->varient->id) }}"><span class="icon_bag_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('productdetails', $product->varient->id) }}">{{ $product->product_name}}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <div class="product__price"> ₹ {{ number_format($product->varient->regular_price) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                       {{--  pagination  --}}
                        <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                              {{--  @if($product_all->onFirstPage())

                                <a href=""><i class="fa fa-angle-left"></i></a>
                           @else

                                <a href="{{$product_all->previousPageUrl()}}"><i class="fa fa-angle-left"></i></a>
                            @endif
                            @foreach($product_all->links()->elements[0] ?? [] as $page =>$url)
                              <a href="{{ $url }}" class="{{ $page == $product_all->currentPage() ?'active': '' }}"> {{ $page}}</a>
                            @endforeach  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->


<script>
   let activeFilter =  'size';
 const min = $('.price-range').data('min') ?? 0;
 const max = $('.price-range').data('max') ?? 100000;
 let v1 = 100;
 let v2 = 48000;
 $(document).ready(function(){
   $('.price-range').slider({
      range: true,
      min: min,
      max: max,
      values: [v1, v2],
      slide: function( event, ui ) {
        $("#minamount").val(ui.values[ 0 ]);
        $("#maxamount").val(ui.values[ 1 ]);
      },
       stop: function( event, ui ) {
        //v1 = ui.values[0]
       // v2 = ui.values[1]
        FilterbyPrice(ui.values[0] , ui.values[1]);
      }
    });
   
 });


// filter data by Price
  function FilterbyPrice(range1 , range2){
    activeFilter = 'price';
    $.ajax({
        type: "GET",
        url: "filterproduct",
        data: {
            minprice: range1,
            maxprice: range2,
            sizes: getbySelectedSize()
        },
        success: function(response){
           
    
    let productFilter = $("#product__filter");
    productFilter.html('');
 const productUrl = '/productdetails';
 if(response && response.price && response.price.data && response.price.data.length > 0){
     response.price.data.forEach(product => {
         
    if(product){
 const createAt = new Date(product.created_at)
 const sevenDayAgo = new Date();
sevenDayAgo.setDate(sevenDayAgo.getDate() - 7);
    let filterData = `
                <div class="col-lg-4 col-md-6" >
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="/uploads/product/thumbnails/${product.thumbnail}">
                        
                        ${createAt >= sevenDayAgo ? '<div class="label new">New</div> ' : " "}
                        ${product.stock_quantity < 1 ? '<div class="label stockout stockoutblue">Out of stock</div> ': " "}
                        
                        
                            <ul class="product__hover">
                            <li><a href="/uploads/product/thumbnails/${product.thumbnail}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="${productUrl}/${product.id}"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                                <div class="product__item__text">
                                    <h6><a href="">${product.product.product_name}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <div class="product__price"> ₹ ${product.regular_price }</div>
                                    </div>
                                </div>
                                </div>
                            </div>`;
            productFilter.append(filterData);
        }else{
            filterData = `<div class="col-12"> <h2> NO Poduct Found</h2> </div>`;
            productFilter.append(filterData);
            
        }
    });
        setImgBg();
        //pagination code 
        setPaginate(response);
       
    } else {
        let filterData = `<div class="col-12"> <h2> NO Product Found</h2> </div>`;
        productFilter.append(filterData);
    }
}
    });
 
 
  }

//Background Image Set
   function setImgBg(){
    $('.set-bg').each(function() {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });
 }
// filter by size
function getbySelectedSize(){
    let sizes = [];
    $('.size-checkbox:checked').each(function() {
        sizes.push($(this).val());
    });
    return sizes;
}
// Filter Color 
function getbySelectedColor(){
    let color = [];
    $('.color-checkbox:checked').each(function(){
        color.push($(this).val());
    });

    return color;
}

// Set up event listener for size & Color checkboxes
$(document).ready(function(){
    $('.size-checkbox').on('change', function () {
        SizeofProduct();
    });
    $('.color-checkbox').on('change', function(){
        colorofProduct();
    })
    $('.subcat__list').on('click', function(e){
        e.preventDefault();
        $(this).toggleClass('active');
        SubcategoryFilter();
    });
    let subcategoryformCategory = $('#subcat_id').val();
    if(subcategoryformCategory){
        SubcategoryFilter(url = 'filter-category' + '?subcat=' + subcategoryformCategory);
    }
});
function setPaginate(response) {
    
    let pagination = document.createElement('div');
    let paginationWrapper = document.createElement('div');
    let productFilterRow  = document.querySelector('#product__filter');
    paginationWrapper.classList.add('col-lg-12', 'text-center');
    pagination.classList.add('pagination__option');
     paginationWrapper.append(pagination);
    productFilterRow.append(paginationWrapper);
    if (!response?.price?.links?.length) return;

    response.price.links.forEach(link => {

        let button = document.createElement('a');
        button.href = '#';

        // ----- LABEL / ICON -----
        if (link.label.includes('Previous')) {
            button.innerHTML = `<i class="fa fa-angle-left"></i>`;
        } 
        else if (link.label.includes('Next')) {
            button.innerHTML = `<i class="fa fa-angle-right"></i>`;
        } 
        else {
            button.textContent = link.label;
        }

        // ----- ACTIVE PAGE -----
        if (link.active === true) {
            button.classList.add('active');
        }

        // ----- DISABLE EMPTY LINKS -----
        if (!link.url) {
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.5';
        }

        // ----- PAGINATION CLICK -----
        button.addEventListener('click', function (e) {
            e.preventDefault();

            if (!link.url) return;

            let relativeUrl = link.url.replace(/^.*\/\/[^/]+/, '');

            if (activeFilter === 'size') {
                SizeofProduct(relativeUrl);
            } 
            else if (activeFilter === 'color') {
                colorofProduct(relativeUrl);
            } 
            else if (activeFilter === 'subcategory') {
                SubcategoryFilter(relativeUrl);
            } 
            else if (activeFilter === 'price') {
                FilterbyPrice(v1, v2);
            }
        });

        pagination.append(button);
    });
}

// category  Got the Array 
function getSelectedCategory(){
    let subCategory = [];
    $('.subcat__list.active').each(function(){
        let subcatId = $(this).data('subcat-id');
        if(subcatId){
            subCategory.push(subcatId);
        }
    });
    return subCategory;
}
// Color Ajax Call
function colorofProduct(url = 'filter-color'){
   let color = getbySelectedColor();
    activeFilter  = 'color'
   $.ajax({
    type:'GET',
    url: url,
    data: {
        color: color
    },
    success : function(response){

        let productFilter = $("#product__filter");
        productFilter.html('');
 const productUrl = '/productdetails';

      if(response && response.price && response.price.data && response.price.data.length > 0){
      response.price.data.forEach(product => {
         const createAt = new Date(product.created_at)
            const sevenDayAgo = new Date();
            sevenDayAgo.setDate(sevenDayAgo.getDate() - 7);
           let filterData = `
                    <div class="col-lg-4 col-md-6" >
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="/uploads/product/thumbnails/${product.thumbnail}">
                           
                            ${createAt >= sevenDayAgo ? '<div class="label new">New</div> ' : " "}
                                ${product.stock_quantity < 1 ? '<div class="label stockout stockoutblue">Out of stock</div> ': " "}
                            
                            
                                <ul class="product__hover">
                                <li><a href="" class="image-popup"><span class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="${productUrl}/${product.id}"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                                    <div class="product__item__text">
                                        <h6><a href="">${product.product.product_name}</a></h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <div class="product__price"> ₹ ${product.regular_price }</div>
                                        </div>
                                    </div>
                                    </div>
                                </div>`;
                                productFilter.append(filterData);
                
        });
        setImgBg();
        //pagination code 
        setPaginate(response);
       
    }else{
         producthtml = `<div class="col-12"> <h2> NO PRODUCT FOUND</h2>  </div>`;
         productFilter.append(producthtml);
    }
   }
   })
}

// Size Ajax Call
function SizeofProduct(url = 'filter-data'){
   let sizes = getbySelectedSize();
   activeFilter  = 'size'
   $.ajax({
       type: "GET",
       url: url,
       data: {
           sizes: sizes
       },
       success: function(response){

        let productFilter = $("#product__filter");
        productFilter.html('');
       const productUrl = '/productdetails';
    // response exitst or not
       if(response && response.price && response.price.data && response.price.data.length > 0){
       response.price.data.forEach(product => {
    
        if(product){
             const createAt = new Date(product.created_at)
            const sevenDayAgo = new Date();
            sevenDayAgo.setDate(sevenDayAgo.getDate() - 15);
        let filterData = `
                    <div class="col-lg-4 col-md-6" >
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="/uploads/product/thumbnails/${product.thumbnail}">
                            ${createAt >= sevenDayAgo ? '<div class="label new">New</div> ' : " "}
                            
                            ${product.stock_quantity < 1 ? '<div class="label stockout stockoutblue">Out of stock</div> ': " "}
                            
                            
                                <ul class="product__hover">
                                <li><a href="" class="image-popup"><span class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="${productUrl}/${product.id}"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                                    <div class="product__item__text">
                                        <h6><a href="">${product.product.product_name}</a></h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <div class="product__price"> ₹ ${product.regular_price }</div>
                                        </div>
                                    </div>
                                    </div>
                                </div>`;
                productFilter.append(filterData);
            }else{
                filterData = `<div class="col-12"> <h2> NO Poduct Found</h2> </div>`;
                productFilter.append(filterData);
                
            }
        }); //foreach loop close

        setImgBg();
        //pagination code
         setPaginate(response);
       }
    }
   });
}

//  SubCategory Call
function SubcategoryFilter(url = 'filter-category'){
    let subcat = getSelectedCategory();
   activeFilter  = 'subcategory'
    $.ajax({
        type: "GET",
        url:url,
        data:{
            subcat : subcat
        },
        success: function(response){
        
             let productFilter = $("#product__filter");
             productFilter.html('');

        const productUrl = '/productdetails';
            if(response && response.price && response.price.data && response.price.data.length > 0){
            response.price.data.forEach(product => {
         
             if(product){
                 const createAt = new Date(product.created_at)
            const sevenDayAgo = new Date();
            sevenDayAgo.setDate(sevenDayAgo.getDate() - 7);
             let filterData = `
                         <div class="col-lg-4 col-md-6" >
                             <div class="product__item">
                                 <div class="product__item__pic set-bg" data-setbg="/uploads/product/thumbnails/${product.thumbnail}">
                                 ${createAt >= sevenDayAgo ? '<div class="label new">New</div> ' : " "}
                                 
                                 ${product.stock_quantity < 1 ? '<div class="label stockout stockoutblue">Out of stock</div> ': " "}
                                 
                                 
                                     <ul class="product__hover">
                                     <li><a href="" class="image-popup"><span class="arrow_expand"></span></a></li>
                                         <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                         <li><a href="${productUrl}/${product.id}"><span class="icon_bag_alt"></span></a></li>
                                     </ul>
                                 </div>
                                         <div class="product__item__text">
                                             <h6><a href="">${product.product.product_name}</a></h6>
                                             <div class="rating">
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                                 <i class="fa fa-star"></i>
                                                 <div class="product__price"> ₹ ${product.regular_price}</div>
                                             </div>
                                         </div>
                                    </div>
                                 </div>`;
                                        productFilter.append(filterData);
                              }
             });
                 setImgBg();
                  setPaginate(response);
                 
            } else {
                let filterData = `<div class="col-12"> <h2> NO Product Found</h2> </div>`;
                productFilter.append(filterData);
            }
        }
    });
}


  FilterbyPrice(v1 , v2);

  SizeofProduct();
</script>

@endsection