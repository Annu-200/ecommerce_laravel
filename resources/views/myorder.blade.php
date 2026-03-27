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

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <h5 class="text-center  text-success mb-3">
           
             @if(session('success'))
                <span class="text-success">{{ session('success') }}</span>
            @endif
            
        </h5>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">


                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th> ID</th>
                                    <th>Date</th>
                                    <th> Email</th>
                                    <th> Order Number</th>
                                    <th>Total</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                               
                              @foreach ($order as $item)
                                  <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->order_num }}</td>
                                    <td>{{ number_format($item->total) }}</td>
                                    <td> @if($item->status == 'paid')
                                         <span class="badge badge-success">Paid</span>
                                         @elseif($item->status == 'pending')
                                         <span class="badge badge-warning">Pending</span>
                                         @elseif($item->status == 'cancelled')
                                         <span class="badge badge-danger">Cancelled</span>
                                         @elseif($item->status == 'shipped')
                                         <span class="badge badge-info">Shipped</span>
                                         @endif 
                                     </td>
                                </tr>
                              @endforeach
                                 
                              
                           
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('order.track') }}">Continue Shopping</a>
                    </div>
                </div>
                
            </div>
            <div class="row">
              
                <div class="col-lg-12 ">
                    <div class="cart__total__procced">
                        <h6>Order Summary</h6>

                        <ul>
                            <li>Product <span>Details</span></li>
                        
                               <li>Name <span>{{ $item->first_name }} - {{ $item->last_name}}</span></li>
                                    <li>Address <span>{{ $item->address}}</span></li>
                                    <li>Phone <span>{{ $item->phone}}</span></li>
                         
                                   

                          
                    
                        </ul>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop order details Section End -->


@endsection