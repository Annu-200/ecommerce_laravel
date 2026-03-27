@extends('Dashboards.page.master-layout')

@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Color Tables </h3>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All colour</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                       
                                        <th>Color</th>
                                        <th>Code</th>
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
                                <h1 class="modal-title fs-2" id="exampleModalLabel">update Color</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm" class="forms-sample" method="post" enctype="multipart/form-data">
                                    @csrf


                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Color Name:</label>
                                        <input type="text" class="form-control" id="color_name">
                                        <input type="hidden" class="form-control" id="color_id">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword4">Color Code</label>
                                        <input type="color" name="color_code" id="color_code">
                                    </div>
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
                  
                  function loadCategory(url = '/api/colors') {
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
                        const colors = data.data;
                        console.log(colors);
               
                        colors.forEach(color => {
                            const brandInner = `
                                <tr>
                                    
                                    <td>${color.name}</td>
                                    <td>
                                        ${color.code }
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-bs-catid="${color.id}" onclick="DeleteColor(${color.id})">
                                            <i class="fa fa-trash-o text-light fs-5"></i> Delete
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success text-light" data-toggle="modal" data-bs-colorid="${color.id}" data-target="#editForm">
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
                        const color_id = button.getAttribute('data-bs-colorid');
                        fetch(`api/colors/${color_id}`, {
                                method: 'GET',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                    'Content-Type': 'application/json',

                                }
                            }).then((response) => response.json())
                            .then((data) => {
                                let color = data.color

                                document.querySelector("#color_name").value = color.name
                                document.querySelector("#color_id").value = color.id
                                document.querySelector("#color_code").value = color.code
                                // Set the value
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
                        const color_id = document.querySelector('#color_id').value;
                        const name = document.querySelector('#color_name').value;
                        const code = document.querySelector('#color_code').value;


                        //append data in class object formdata
                        formData.append('id', color_id);
                        formData.append('name', name);
                        formData.append('code', code);


                        // insert by fetch
                        try {
                            let response = await fetch(`/api/colors/${color_id}`, {
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
                            } else {
                                errorMsg.style.display = 'Block';
                                successMsg.style.display = 'none';
                                if (Array.isArray(data.errors)) {
                                    errorMsg.innerText = data.errors.join(', ');


                                } else {
                                    errorMsg.innerText = data.errors;

                                }
                            }
                        } catch (error) {

                            alert('An error occurred while creating the color');
                        }

                    })
                    // Delete single category
                    const DeleteColor = async (id) => {
                        confirm('Are you Want to delete Color..?')
                   
                        const Token = localStorage.getItem('api_token');
                        fetch(`api/colors/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                },

                            }).then((response) => response.json())
                        const errorMsg = document.querySelector('#error-msg')
                        const successMsg = document.querySelector('#successMsg')
                            .then((data) => {
                                
                                  if (data.status) {
                                successMsg.style.display = 'block';
                                errorMsg.style.display = 'none';
                                successMsg.innerText = data.message;
                            window.location.href = '{{ route('allcolor') }}' 

                            } else {
                                errorMsg.style.display = 'block';
                                successMsg.style.display = 'none';
                                errorMsg.innerText = Array.isArray(data.errors)
                                    ? data.errors.join(', ')
                                    : data.errors;
                            }

                           })
                    };
                </script>
            @endsection
