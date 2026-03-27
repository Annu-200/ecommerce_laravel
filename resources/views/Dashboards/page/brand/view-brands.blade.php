@extends('Dashboards.page.master-layout')

@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Category Tables </h3>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All Category</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                       
                                        <th>Brand</th>
                                        <th>status</th>
                                        <th>Delete</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="categoryTbody">

                                </tbody>
                            </table>

                            <div id="paginate" class="mt-5">
                            </div>
                          </div>
                    </div>
                <div class="modal fade" id="editForm" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-2" id="exampleModalLabel">update category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm" class="forms-sample" method="post" enctype="multipart/form-data">
                                    @csrf


                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Brand Name:</label>
                                        <input type="text" class="form-control" id="brand_name">
                                        <input type="hidden" class="form-control" id="brand_id">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword4">status</label>
                                        <select class="form-control" id="status">
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
                                        </select>
                                       
                                        <button type="submit" class="btn btn-gradient-primary me-2 mt-3">Submit</button>
                                </form>


                            </div>
                            <div class="modal-footer">
                                <div class="text-danger" id="error-msg"></div>
                                <div class="text-success" id="successMsg"></div>
                            </div>
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
                  
                  function loadCategory(url = 'api/brand') {
                    const token = localStorage.getItem('api_token');
                    let BrandBody = document.querySelector('#categoryTbody');
                    let paginate = document.querySelector('#paginate');
                
                    BrandBody.innerHTML = '';
                    paginate.innerHTML = '';
                
                    // Use the passed `url` here!
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        const Brand = data.data.brand.data;
               
                        Brand.forEach(brand => {
                            const brandInner = `
                                <tr>
                                    
                                    <td>${brand.brand_name}</td>
                                    <td>
                                        ${brand.status === 1 
                                            ? '<label class="badge badge-gradient-success">Active</label>' 
                                            : '<label class="badge badge-danger">Inactive</label>'}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-bs-catid="${brand.id}" onclick="DeleteCategory(${brand.id})">
                                            <i class="fa fa-trash-o text-light fs-5"></i> Delete
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success text-light" data-toggle="modal" data-bs-catid="${brand.id}" data-target="#editForm">
                                            <i class="fa fa-edit text-light fs-5"></i> Edit
                                        </button>
                                    </td>
                                </tr>`;
                                BrandBody.innerHTML += brandInner;
                        });
                
                        // Render pagination buttons
                        const links = data.data.brand.links;
                        links.forEach(link => {
                            const btn = document.createElement('button');
                            btn.innerHTML = link.label;
                            btn.disabled = !link.url;
                            btn.className = `btn btn-sm mx-1 ${link.active ? 'btn-primary' : 'btn-outline-secondary'}`;
                            btn.onclick = () => {
                                if (link.url) {
                                    const relativeUrl = link.url.replace(/^.*\/\/[^/]+/, '');
                                    loadCategory(relativeUrl);
                                }
                            };
                            paginate.appendChild(btn);
                        });
                    });
                }
                
                loadCategory();
                

                    // edit model 
                    $('#editForm').on('show.bs.modal', function(event) {
                        let button = event.relatedTarget // Button that triggered the modal
                        // get single data 
                        const Token = localStorage.getItem('api_token');
                        const brand_id = button.getAttribute('data-bs-catid');
                        fetch(`api/brand/${brand_id}`, {
                                method: 'GET',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                    'Content-Type': 'application/json',

                                }
                            }).then((response) => response.json())
                            .then((data) => {
                                let brand = data.data.brand[0]

                                document.querySelector("#brand_name").value = brand.brand_name
                                document.querySelector("#brand_id").value = brand.id
                                const statusElement = document.querySelector("#status");
                                // Set the value
                                statusElement.value = brand.status === 1 ? "1" : "0";
                            }).catch(error => {
                                console.log(error);
                            })

                        var modal = $(this)
                        modal.find('.modal-title').text('Update Brand ')
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
                        const brand_id = document.querySelector('#brand_id').value;
                        const brand = document.querySelector('#brand_name').value;
                        const status = document.querySelector('#status').value;


                        //append data in class object formdata
                        formData.append('id', brand_id);
                        formData.append('brand_name', brand);
                        formData.append('status', status);


                        // insert by fetch
                        try {
                            let response = await fetch(`/api/brand/${brand_id}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'X-HTTP-Method-Override': 'PUT'
                                    // Remove content-type header when sending FormData
                                },
                            });
                            let data = await response.json();
                            if (data.status) {
                                errorMsg.style.display = 'none';
                                successMsg.style.display = 'Block';
                                successMsg.innerText = data.message;
                                window.location.reload();
                            } else {
                                errorMsg.style.display = 'Block';
                                successMsg.style.display = 'none';
                                if (Array.isArray(data.errors)) {
                                    errorMsg.innerText = data.errors.join(', ');

                                    window.location.reload();

                                } else {
                                    errorMsg.innerText = data.errors;
                                    window.location.reload();

                                }
                            }
                        } catch (error) {

                            alert('An error occurred while creating the category');
                        }

                    })
                    // Delete single category
                    const DeleteCategory = async (id) => {
                        confirm('Are you Want to delete Category..?')
                        const Token = localStorage.getItem('api_token');
                        fetch(`api/brand/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                },

                            }).then((response) => response.json())
                            .then((data) => {
                                    window.location.reload();

                            })
                    };
                </script>
            @endsection
