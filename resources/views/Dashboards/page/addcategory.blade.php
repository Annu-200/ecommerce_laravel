@extends('Dashboards.page.master-layout')


@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Add Categories </h3>

            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <form class="forms-sample" id='submitCat' method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1" class="mt-3">Category Title</label>
                                    <input type="text" id="cat_title" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword4">status</label>
                                    <select class="form-control" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>File upload</label>

                                    <div class="input-group col-xs-12">
                                        <input type="file" id="cat_image" class="form-control file-upload-info"
                                            placeholder="Upload Image">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="description" rows="4"></textarea>
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
                const token = localStorage.getItem('api_token');
                let formData = new FormData();

                //get data from form
                const title = document.querySelector('#cat_title').value;
                const status = document.querySelector('#status').value;
                const description = document.querySelector('#description').value;
                const cat_image = document.querySelector("#cat_image").files[0];

                //append data in class object formdata
                formData.append('cat_title', title);
                formData.append('cat_description', description);
                formData.append('status', status);
                formData.append('cat_images', cat_image);
console.log(formData)

                // insert by fetch
                try {
                    let response = await fetch('/api/category', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            // Remove content-type header when sending FormData
                        },
                    });
                    let data = await response.json();
                    console.log(data);
                    if (data.status) {
                        alert('Category created successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error creating category');
                    }
                } catch (error) {
                    console.log(error);
                    alert('An error occurred while creating the category');
                }
            });
        </script>
    @endsection
