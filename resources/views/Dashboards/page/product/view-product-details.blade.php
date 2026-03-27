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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>Delete</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="productBody">

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
                                <h1 class="modal-title fs-2" id="exampleModalLabel">update category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm" class="forms-sample" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Size:</label>
                                        <select class="form-control" id="size">

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword4">status</label>
                                        <select class="form-control" id="status">

                                        </select>
                                        <div class="mb-3">
                                            <label for="price" class="col-form-label"> Price </label>
                                            <input type="text" class="form-control" id="price">
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="col-form-label"> Stock </label>
                                            <input type="text" class="form-control" id="stock">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ragular_price" class="col-form-label">Ragular Price:</label>
                                            <input type="text" id="ragular_price" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">Images:</label>
                                            <input type="file" class="form-control" id="gallery">
                                            <input type="hidden" class="form-control" id="pro_id">

                                            <div id="img-gallery" width="200px">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Thambnail:</label>
                                     

                                                <img id="thambnail-img" width="50px" style="margin-top: 20px">
                                                <i class="fa fa-edit text-success" id="thumbnailChange" style="cursor: pointer"></i> 
                                                <i class="fa fa-trash text-danger" style="cursor: pointer" onclick="DeleteProductDetails()"></i> 
                                            </div>

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
                    function loadProduct(url = 'api/product-varient') {

                        const token = localStorage.getItem('api_token')
                        let productBody = document.querySelector('#productBody')
                        let paginate = document.querySelector("#paginate");
                        productBody.innerHTML = '';
                        paginate.innerHTML = '';


                        fetch(url, {
                                method: 'GET',
                                headers: {
                                    'Authorization': ` Bearer ${token}`,
                                },

                            }).then((response) => response.json())
                            .then((data) => {
                                const proData = data.product.pro.data;

                                proData.forEach((pro) => {
                                    const products = `
                        <tr>
                          <td> 
                            <img src="/uploads/product/thumbnails/${pro.thumbnail}" />
                          </td>
                          <td> 
                            ${pro.product_title}
                          </td>
                          <td> 
                            ${pro.price}
                          </td>
                          <td> 
                            ${pro.stock_quantity}
                          </td>
                          <td> 
                            ${
                             pro.size
                            }
                          </td>
                          <td>
                          ${pro.status === 1 ? '<label class="badge badge-gradient-success">Active</label>'
                           : '<label class="badge badge-danger">Inactive</label>'}
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-bs-catid="${pro.id}" onclick="DeleteCategory(${pro.id})">
                          <i class="fa fa-trash-o text-light fs-5"></i>                  
                              Delete
                            </button>
                          </td>        
                        <td> 
                        <button type="button" class="btn btn-success text-light"  data-toggle="modal" data-bs-catid="${pro.id}" data-target="#editForm">
                          <i class="fa fa-edit text-light  fs-5"></i>
                          Edit
                        </button>
                      </td>  
                   </tr>`;
                                    productBody.innerHTML += products
                                });
                                //render pagination
                                const links = data.product.pro.links
                                links.forEach(link => {
                                    const btn = document.createElement("button")
                                    btn.innerHTML = link.label
                                    btn.disabled = !link.url
                                    btn.className =
                                        `btn btn-sm mx-1 ${link.active ? 'btn-primary' : 'btn-outline-secondary'}  `;
                                    btn.onclick = () => {
                                        if (link.url) {
                                            const relativeUrl = link.url.replace(/^.*\/\/[^/]+/, '');
                                            loadProduct(relativeUrl)

                                        }

                                    };
                                    paginate.appendChild(btn);
                                });
                            });
                    }
                    //call product function show products
                    loadProduct()

                    // edit model 
                    $('#editForm').on('show.bs.modal', function(event) {
                        let button = event.relatedTarget // Button that triggered the modal
                        // GET SINGLE DATA VALUE AND SET
                        const Token = localStorage.getItem('api_token');
                        const pro_id = button.getAttribute('data-bs-catid');


                        fetch(`api/product-varient/${pro_id}`, {
                                method: 'GET',
                                headers: {
                                    'Authorization': `Bearer ${Token}`,
                                    'Content-Type': 'application/json',
                                }
                            }).then((response) => response.json())
                            .then((data) => {
                                const product = data.product.pro[0]


                                //append data in form  to display
                                document.querySelector("#pro_id").value = product.id
                                document.querySelector("#price").value = product.price
                                document.querySelector("#ragular_price").value = product.regular_price
                                document.querySelector("#stock").value = product.stock_quantity

                                let sizeTy = document.querySelector("#size")

                                // thumbnail Img display

                                const thumbImg = document.querySelector("#thambnail-img");
                               
                                thumbImg.src = `/uploads/product/thumbnails/${product.thumbnail}`;
                             
                                //Gallery
                                const imgGry = document.querySelector("#img-gallery");
                                const fileInput = document.createElement('input')
                                fileInput.type = "file"
                                fileInput.style.display = "none"
                                document.body.append(fileInput)
                                // separate hidden input for thumbnail updates
                                const thumbFileInput = document.createElement('input')
                                thumbFileInput.type = "file"
                                thumbFileInput.style.display = "none"
                                document.body.append(thumbFileInput)
                                let selectedIndex = null
                                imgGry.innerHTML = '';

                                //display gallary Img
                                const galleryArray = JSON.parse(product.gallery)
                                galleryArray.forEach((img, index) => {
                                    const imgSrc = `/uploads/product/gallery/${img}`;
                                    const imgElement = document.createElement('img');
                                    imgElement.src = imgSrc;
                                    imgElement.style.width = "50px"
                                    imgElement.alt = "product_img";
                                    imgElement.setAttribute('data-index', index)
                                    // update button
                                    const updateBtn = document.createElement('i')
                                    updateBtn.style.cursor = "pointer"
                                    updateBtn.style.margin = ' 10px'
                                    updateBtn.setAttribute('class', 'fa fa-edit text-success')

                                    updateBtn.addEventListener('click', () => {
                                        selectedIndex = index
                                        fileInput.click()
                                    })

                                    // delete button
                                    const DeleteBtn = document.createElement('i')
                                    DeleteBtn.style.cursor = 'pointer'
                                    DeleteBtn.setAttribute('class', 'fa fa-trash text-danger grydelete')
                                    DeleteBtn.setAttribute('data-index', `${index}`)

                                    


                                    imgGry.appendChild(imgElement);
                                    imgGry.appendChild(updateBtn);
                                    imgGry.appendChild(DeleteBtn);
                                });
                                
                              
                                // thumbnail
                                thumbnailChange.addEventListener('click' , () => {
                                    thumbFileInput.click()
                                })
// update img
                                fileInput.addEventListener('change', (e) => {
                                    const file = e.target.files[0]

                                    const pro_id = document.querySelector('#pro_id').value;
                                    const token = localStorage.getItem('api_token')
                                    if (!file || selectedIndex === null) return

                                    let formData = new FormData();
                                    formData.append('gallery', file)
                                    formData.append('_method', 'PUT')
                                    formData.append('image_index', selectedIndex)

                                    fetch(`/api/product-varient/${pro_id}`, {
                                            'method': 'POST',
                                            'body': formData,
                                            'headers': {
                                                'Authorization': `Bearer ${token}`,
                                                'Accept': 'Application/json'
                                            }
                                        }).then(response => response.json())
                                        .then(data => {
                                            console.log(data);

                                            if (data?.status) {
                                                const successData = document.createElement('div')
                                                successData.setAttribute('class', 'alert alert-success')
                                                successData.innerText = data.message

                                                const allImg = imgGry.querySelectorAll('img');
                                                allImg[selectedIndex].src = URL.createObjectURL(file)

                                                selectedIndex = null
                                                fileInput.value = ''

                                            } else {
                                                if(Array.isArray(data.error)){
                                                    data.error.forEach(err => {
                                                        const errorMsg = document.createElement('div')
                                                        errorMsg.setAttribute('class', 'alert alert-danger')
                                                        errorMsg.innerText = err  
                                                        imgGry.append(errorMsg) 
                                                    })
                                                }
                                                
                                            }

                                        })


                                })
                                // handle thumbnail file change (no image_index, no gallery field)
                                thumbFileInput.addEventListener('change', (e) => {
                                    const file = e.target.files[0]
                                    const pro_id = document.querySelector('#pro_id').value;
                                    const token = localStorage.getItem('api_token')
                                    if (!file) return

                                    let formData = new FormData();
                                    formData.append('_method', 'PUT')
                                    formData.append('thumbnail', file)

                                    fetch(`/api/product-varient/${pro_id}`, {
                                            'method': 'POST',
                                            'body': formData,
                                            'headers': {
                                                'Authorization': `Bearer ${token}`,
                                                'Accept': 'Application/json'
                                            }
                                        }).then(response => response.json())
                                        .then(data => {
                                            if (data?.status) {
                                                // update thumbnail preview
                                                const thumbImg = document.querySelector("#thambnail-img");
                                                thumbImg.src = URL.createObjectURL(file)
                                                thumbFileInput.value = ''
                                            } else {
                                                // optionally render errors
                                                console.log(data)
                                            }
                                        })
                                })
                                
                                //sizes
                                sizeTy.innerHTML = `<option value="${product.size_id}">${product.size_name}</option>`

                                //status
                                const statusElement = document.querySelector("#status");
                                statusElement.innerHTML =
                                    `<option value="1" ${product.status === 1 ? 'selected': ""}> Active </option>
                          <option value="0" ${product.status === 0 ? 'selected': ""}> Inactive </option>`

                            }).catch(error => {
                                console.log(error);
                            });
                        var modal = $(this)
                        modal.find('.modal-title').text('Update Category')
                    });
                    $('#editForm').modal('hide')



                    // update data with api request
                    const UpdateForm = document.querySelector("#updateForm");

                    updateForm.addEventListener('submit', async function(e) {
                        e.preventDefault();


                        const errorMsg = document.querySelector('#error-msg')
                        const successMsg = document.querySelector('#successMsg')
                        const token = localStorage.getItem('api_token');

                        //get data from form
                        const pro_id = document.querySelector('#pro_id').value;
                        const size = document.querySelector('#size').value;
                        const status = document.querySelector('#status').value;
                        const price = document.querySelector('#price').value;
                        const ragular_price = document.querySelector('#ragular_price').value;
                        const stock = document.querySelector('#stock').value;
                        

                      let formData = new FormData()
                        //append data in class object formdata
                        formData.append('id', pro_id);
                        formData.append('size', size);
                        formData.append('price', price);
                        formData.append('status', status);
                        formData.append('ragular_price', ragular_price);
                        formData.append('stock', stock);
                        formData.append('status', status);
                    //console.log(formData)


                        // insert by fetch
                        try {
                            let response = await fetch(`/api/product-varient/${pro_id}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'X-HTTP-Method-Override': 'PUT'

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
                                if (Array.isArray(data.error)) {
                                    errorMsg.innerText = data.error.join(', ');

                                    //window.location.reload();

                                } else {
                                    errorMsg.innerText = data.error;
                                    console.log(error);
                                    //window.location.reload();

                                }
                            }

                        } catch (error) {
                            alert('An error occurred while creating the category');
                            console.log(error);

                        }
                    })
                    // Delete single category
                        const DeleteProductDetails = async (index) => {
                            confirm('Are you Want to delete Product Varient..?')
                        const id =   document.querySelector("#pro_id").value

                            const Token = localStorage.getItem('api_token');
                            fetch(`/api/product-varient/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Authorization': `Bearer ${Token}`,
                                    },
                                    'body': JSON.stringify({
                                        image_index : index
                                    })

                                }).then((response) => response.json())
                                .then((data) => {
                                    const msg = document.createElement('div')

                                    console.log(data)
                                if(data.status){
                                    msg.setAttribute('class', 'alert alert-success')
                                    msg.innerText = data.message
                                }else{
                                    
                                    msg.setAttribute('class', 'alert alert-danger')
                                    msg.innerText = data.message
                                }
                                })
                        };
                </script>
            @endsection
