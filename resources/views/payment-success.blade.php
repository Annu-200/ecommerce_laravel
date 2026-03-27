@extends('pages.main')



@section('contend')
    <div class="container">
          <div class="card" style="width: 18rem;">
      <i class="fa fa-check text-success" aria-hidden="true"></i>
        <div class="card-body">
          <p class="card-text">Your payment was successful! </p>
          <button type="submit" class="btn btn-primary" id="successPay">Continue</button>
        </div>
      </div>
        </div> 

    <script>
       document.getElementById('successPay').addEventListener('click', function() {
            window.location.href = "{{ route('order.success') }}";
        });
    </script>
    @endsection