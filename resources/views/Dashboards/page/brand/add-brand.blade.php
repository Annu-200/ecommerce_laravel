@extends('Dashboards.page.master-layout')


@section('admin-content')
    <div class="main-panel">    
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Add Brands </h3>

            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                                <div class="text-danger" @style('display:none') id="error-msg"></div>
                                <div class="text-success" @style('display:none') id="successMsg"></div>
                            <form class="forms-sample" id='submitCat' method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1" class="mt-3">Brand Title</label>
                                    <input type="text" id="brand" class="form-control" placeholder="Brand Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword4">status</label>
                                    <select class="form-control" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            const submitCat = document.querySelector('#submitCat');
            submitCat.addEventListener('submit', async function(e) {
                e.preventDefault();
                const errorMsg = document.querySelector('#error-msg')
               const successMsg = document.querySelector('#successMsg')
                const token = localStorage.getItem('api_token');
                let formData = new FormData();

                //get data from form
                const brand = document.querySelector('#brand').value;
                const status = document.querySelector('#status').value;
                

                //append data in class object formdata
                formData.append('brand_name', brand);
                formData.append('status', status);


                // insert by fetch
                try {
                    let response = await fetch('/api/brand', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                        },
                    });
                    let data = await response.json();
                    console.log(data);
                    if (data.status) {
                        errorMsg.style.display = 'none';
                        successMsg.style.display = 'Block';
                        successMsg.innerText = data.message;
                        window.location.href = '{{ route('allbrands') }}' 
                        //window.location.reload();
                    } else {
                        errorMsg.style.display = 'Block';
                        successMsg.style.display = 'none';
                        if(Array.isArray(data.errors)){
                            errorMsg.innerText = data.errors.join(', ');
                        window.location.reload();
                        }else{
                            errorMsg.innerText = data.errors;

                        }       
                    }
                  
                    


                } catch (error) {
                   
                    alert('An error occurred while creating the category');
                }
            });
        </script>
    @endsection
