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
    
        <div class="alert alert-success" id="success-msg" style="display: none;">
            <!-- Success message will be displayed here -->
           
        </div>
    
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success text-center" id="success-msg">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                              
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    {{--  @php
                                        dd($cart , $productVarient);
                                    @endphp  --}}
     @forelse($cart ?? [] as $key => $item)
     @php
  
        $variant = $productVarient[$item['varient_id']] ?? null;
    @endphp

    @if($variant)
    <tr>
        <td class="cart__product__item">
            <img src="{{ asset('uploads/product/thumbnails/'.$variant->thumbnail) }}" width="100">
            <div class="cart__product__item__title">
                <h6 data-varient="{{ $variant->id }}">{{ $variant->product->product_name }}</h6>
            </div>
        </td>

        <td class="cart__price"> ₹ {{ number_format($item['price']) }} </td>

        <td class="cart__quantity">
           <div class="pro-qty">
             {{--  <span class="dec qtybtn"> - </span>  --}}
            <input type="text" value="{{ $item['quantity'] }}" data-qty="{{ $item['quantity'] }}" data-id="{{ $item['product_id'] }}">
            {{--  <span class="inc qtybtn"> + </span>  --}}
           </div>
        </td>

        <td class="cart__total" data-pid="{{ $item['product_id'] }}"> ₹ {{ number_format($item['subtotal']) }}</td>

        <td class="cart__close"> <span class="icon_close" data-key="{{ $key }}"></span></td>
    </tr>
    @endif

@empty
    <tr>
        <td colspan="5" class="text-center">
            <img src="{{ asset('images/empty-cart.png') }}" alt="empty cart" width="200px">
        </td>
    </tr>
@endforelse

                               
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="#"><span class="icon_loading" id="update-icon"></span> Update cart</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        
                        <ul>
                          @php
                        $subtotal = 0;
                    @endphp

                    @forelse($cart ?? [] as $item)
                        @php
                            $subtotal += $item['subtotal'];
                        @endphp
                    @empty
                        {{-- cart empty --}}
                    @endforelse

                    @php
                        $cgst = $subtotal * 0.09;
                        $sgst = $subtotal * 0.09;
                        $totalgst = $cgst + $sgst;
                    @endphp

                    <li class="subtotal-amount">Subtotal <span  data-total="{{ $subtotal }}">{{ $subtotal }}</span></li>
                    <li class="total-gst">Total GST (18%) <span data-gst="{{ $totalgst }}">{{ $totalgst }}</span></li>
                    <li class="grand-total">Grand Total <span data-grand="{{ $totalgst }}">{{ $subtotal + $totalgst }}</span></li>

        
                        </ul>
                        <a href="{{ route('checkout') }}" class="primary-btn">Proceed to checkout</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->
    <script>
        let proQty =  $('.pro-qty');
        proQty.off('click', '.qtybtn');
        proQty.on('click', '.qtybtn', function(){
            console.log('clicked')
          let btn  = $(this);
          let parent  = btn.closest('.pro-qty');
          let input = parent.find('input');
          let id = input.data('id');
          let qty =  parseInt(input.val()) || 1;
          let formData = new FormData();
     

          // cart DAta collect
          let row = btn.closest('tr');
          let cartInput = row.find('.cart__product__item__title h6');
          let cartTotal = row.find('.cart__total');

          let varient_id = cartInput.data('varient');
          let pId = cartTotal.data('pid');

          formData.append('varient_id', varient_id);
          formData.append('product_id', pId);

           if(btn.hasClass('inc')){
            qty++;
           }else{
             if(qty > 1){
                qty--;
                
            }

           }
          
           formData.append('quantity', qty);

           $.ajax({
            url : '/update-cart',
            type: 'POST',
            data: formData,
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function(response){
                console.log(response);
               
        //Grand total update
          //GST update
          const gst = response.total * 0.18 ;
          const grandTotalAmount = response.total + gst;
          let cartTotalgrand = $('.grand-total span').text(grandTotalAmount);
      
          // single row subtotal update
          let cartTotal = row.find('.cart__total');
          cartTotal.text('₹ ' + response.item_subtotal)
          
          //cart Grand total update
        $('.subtotal-amount span').text('₹ ' + response.total);
          $('.total-gst span').text(gst.toFixed(2));
          
        
               

            }
           });

          let icon =  $("#update-icon")
          icon.addClass('rotate');

          if(icon.hasClass('rotate')){
            console.log('rotate ✅')
            }else{
                console.log('rotate ❌')
            }
           setTimeout(() => {
            icon.removeClass('rotate');
            console.log('rotate removed')
           }, 800);
          
        });



        // Remove from cart
        $('.cart__close span').on('click', async function(e){
            e.preventDefault();
            const id = $(this).data('key');
            confirm('Are you sure you want to remove this item from the cart?');
         try{
            const response = await fetch(`/remove-from-cart/${id}`);
            const data = await response.json();
            console.log(data)
            if(data.status === 'success'){
              console.log(data)

              const msg = data.message 
              const successMsg = $('#success-msg');

            successMsg.show();
            successMsg.html(msg);
            const row = $(this).closest('tr');
            row.remove();
         
            const gst = data.total * 0.18 ;
            $('.subtotal-amount span').text('₹ ' + data.total);
          $('.total-gst span').text(gst.toFixed(2));

          const grandTotalAmount = data.total + gst;
          let cartTotalgrand = $('.grand-total span').text(grandTotalAmount);
           
            }
         }
            catch(error){
                console.error('Error:', error);
            }

           
        })

    </script>
@endsection