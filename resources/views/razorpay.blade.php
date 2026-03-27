         
         @extends('pages.main')
         @section("contend")
            <div class="container">
                <h2 class="text-center">Processing Payment...</h2>
            <button id="pay-btn" class="btn btn-success">Pay Now</button>   
            </div>
         <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


            <script>
            var options = {
                "key": "{{ $key }}",
                "amount": "{{ $amount  }}",
                "currency": "INR",
                "name": "Henry",
                "order_id": "{{ $order }}",
                "handler": function (response){
                    window.location.href="/order/{{ $orderId }}" + 
                   + "payment_id=" + response.razorpay_payment_id
                  +  "&order_id=" + response.razorpay_order_id
                   + "&signature=" + response.razorpay_signature;    
                }
            };

            var rzp = new Razorpay(options);

            document.getElementById('pay-btn').onclick = function(e){
                rzp.open();
                e.preventDefault();
            }
            window.onload = function (){
                rzp.open()          
            }
            </script>
            @endsection