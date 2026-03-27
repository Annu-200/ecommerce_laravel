@extends('Dashboards.page.master-layout')

@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Products Tables </h3>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All Products</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Order Number</th>
                                        <th>Email</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Delete</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="productBody">
                                     @foreach ($order as $item)
                                    <tr>
                                       
                                            <td>{{ $item->id }}</td>
                                            <td>{{ substr($item->order_num, 3, 5) }}</td>  
                                            <td>{{ substr($item->email,0,3) }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td> 
                                            @if($item->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else

                                                <span class="badge bg-info">Unpaid</span>
                                            @endif
                                            </td>
                                            <td>@if($item->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($item->status == 'shipped')
                                                <span class="badge bg-info">shipped</span>
                                            @elseif($item->status == 'delivered')
                                                <span class="badge bg-success">delivered</span>
                                            @endif
                                            </td>
                                            <td>{{ date_format($item->created_at, 'd-m-Y') }}</td>
                                            <td><button class="btn btn-danger" onclick="DeleteOrder({{ $item->id }})">Delete</button></td>
                                            <td><button class="btn btn-primary" onclick="editProduct({{ $item->id }})" data-toggle="modal" data-bs-orderid="{{ $item->id }}" data-target="#editForm" data-toggle="modal">Update</button></td>
                                    </tr>
                                        @endforeach

                                </tbody>
                            </table>
                            <div id="paginate" class="mt-5"></div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editForm" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-2" id="exampleModalLabel"> Order Status Shipped</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm" class="forms-sample" method="post" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <input type="text" id="order_id"  hidden>
                                    <div class="form-group">
                                        <label for="exampleInputPassword4">status</label>
                                        <select class="form-control" id="status">
                                            <option value="pending">Pending</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                       
                                            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                </form>


                            </div>
                            <div class="modal-footer">
                                <div class="text-danger" id="error-msg"></div>
                                <div class="text-success" id="successMsg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
                    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
                </script>

                <script>
                    // Your JavaScript code here
                  
                    // edit model 
                    $('#editForm').on('show.bs.modal', function(event) {
                        let button = event.relatedTarget // Button that triggered the modal
                        // get single data 
                        const Token = localStorage.getItem('api_token');
                        const order_id = button.getAttribute('data-bs-orderid');
                        fetch(`api/update-order-status/${order_id}`, {
                                method: 'GET',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                    'Content-Type': 'application/json',

                                }
                            }).then((response) => response.json())
                            .then((data) => {
                                let order = data.order
                            
                                document.querySelector('#order_id').value = order.id;
                                document.querySelector('#status').value = order.status;

                            
                            }).catch(error => {
                                console.log(error);
                            })

                        var modal = $(this)
                        modal.find('.modal-title').text('Update order status ')
                    });
                    $('#editForm').modal('hide')



                    // update data with api request
                    const UpdateForm = document.querySelector("#updateForm");

                    updateForm.addEventListener('submit', async function(e) {
                        e.preventDefault();


                        const errorMsg = document.querySelector('#error-msg')
                        const successMsg = document.querySelector('#successMsg')
                        const token = localStorage.getItem('api_token');


                        let formData = new FormData();

                        //get data from form
                        const order_id = document.querySelector('#order_id').value;
                     
                        const status = document.querySelector('#status').value;
            
                        //append data in class object formdata
                        formData.append('id', order_id);
                        formData.append('status', status);


                        // insert by fetch
                        try {
                            let response = await fetch(`/api/update-order/${order_id}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Authorization': `Bearer ${token}`
                                    
                                    // Remove content-type header when sending FormData
                                },
                            });
                            let data = await response.json();
                             let  order = data.order
                            if (data.status == true) {
                                errorMsg.style.display = 'none';
                                successMsg.style.display = 'Block';
                                successMsg.innerText = data.message;
                                //window.location.reload();
                            } else {
                                errorMsg.style.display = 'Block';
                                successMsg.style.display = 'none';
                                if (Array.isArray(data.errors)) {
                                    errorMsg.innerText = data.errors.join(', ');

                                    window.location.reload();

                                } else {
                                    errorMsg.innerText = data.message;
                                    window.location.reload();

                                }
                            }




                        } catch (error) {

                            alert('An error occurred while creating the category');
                        }

                    })


                    const DeleteOrder = async (id) => {
                        confirm('Are you Want to delete Order..?')
                        const Token = localStorage.getItem('api_token');
                        fetch(`/api/orderDelete/${id}`, {
                                method: 'GET',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                },

                            }).then((response) => response.json())
                            .then((data) => {
                                console.log(data)
                            })
                    };
                </script>
            @endsection
