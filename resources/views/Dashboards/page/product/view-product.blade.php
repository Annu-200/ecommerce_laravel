@extends('Dashboards.page.master-layout')

@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">  Products Tables </h3>
            </div>
           
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All Products</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                          
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
                    <div class="modal fade" id="editForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-2" id="exampleModalLabel">update Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form id="updateForm" class="forms-sample"  method="post" enctype="multipart/form-data">
                            @csrf

                          
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Product Title:</label>
                                <input type="text" class="form-control" id="pro_title">
                                <input type="hidden" class="form-control" id="pro_id">
                              </div>
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Category:</label>
                                <select class="form-control" id="category">
                                
                                   </select>
                              </div>
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Brand:</label>
                                <select class="form-control" id="brand">
                                
                                   </select>
                              </div>
                             
                              <div class="form-group">
                                <label for="exampleInputPassword4">status</label>
                                <select class="form-control" id="status">
                               <option value="0">Inactive</option>
                               <option value="1">Active</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="hot-trend">
                                  Hot trend 
                               <input type="checkbox" id="hot-trend" name="hot_trend" value="1">
                                </label>
                                <label for="bestseller">
                                 Bestseller
                               <input type="checkbox" id="bestseller" name="bestseller" value="1">
                                </label>
                                <label for="featured">
                                featured 
                               <input type="checkbox" id="featured" name="featured" value="1">
                                </label>
                                
                              </div>
                              <div class="mb-3">
                                <label for="short-description" class="col-form-label">short Description:</label>
                                <textarea class="form-control" id="short_description"></textarea>
                              </div>
                              <div class="mb-3">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="description"></textarea>
                              </div>
                             <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                               </form>

                           
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="text-danger"  id="error-msg"></div>
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
                        function loadProduct(url = 'api/product') {

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
                                    const proData = data.data.data;
                                    console.log(proData);
                                    proData.forEach(pro => {          
                              const products = `
                        <tr>
                          
                          <td> 
                            ${pro.product_name}
                          </td>
                          <td> 
                            ${pro.subcategory.subcat_title}
                          </td>
                          <td> 
                            ${pro.brand_show.brand_name}
                          </td>
                          
                          <td>
                          ${pro.status === 1 ? '<label class="badge badge-gradient-success">Active</label>'
                           : '<label class="badge badge-danger">Inactive</label>'}
                          </td>
                          
                          <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-bs-catid="${pro.product_id}" onclick="DeleteCategory(${pro.product_id})">
                          <i class="fa fa-trash-o text-light fs-5"></i>                  
                              Delete
                            </button>
                          </td>        
                        <td> 
                        <button type="button" class="btn btn-success text-light"  data-toggle="modal" data-bs-catid="${pro.product_id}" data-target="#editForm">
                          <i class="fa fa-edit text-light  fs-5"></i>
                          Edit
                        </button>
                      </td>  
                   </tr>`;
                             productBody.innerHTML += products
                         });
                         //render pagination
                         const links = data.data.links
                         links.forEach(link => {
                          const btn = document.createElement("button")
                          btn.innerHTML = link.label
                          btn.disabled = !link.url
                          btn.className = `btn btn-sm mx-1 ${link.active ? 'btn-primary' : 'btn-outline-secondary'}  `;
                          btn.onclick = () => {
                              if(link.url){
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
                             const pro_id  = button.getAttribute('data-bs-catid');
                          let category = document.querySelector("#category")
                          let brand = document.querySelector("#brand")

                           category.innerHTML = ''
                           brand.innerHTML = ''

                             fetch(`api/product/${pro_id}`,{
                              method : 'GET',
                              headers: {
                                'Authorization': `Bearer ${Token}`,
                                'Content-Type':'application/json',
                              }
                             }).then((response) => response.json())
                             .then((data) => {
                               let product = data.data[0]
                               console.log(product.product_name);
                              
                          document.querySelector("#pro_title").value = product.product_name
                          document.querySelector("#pro_id").value = product.product_id
                          document.querySelector("#description").value = product.pro_description
                          document.querySelector("#short_description").value = product.short_description
                          //display parent category
                          data.subcat.forEach(subcat => {
                            const selected = subcat.subcat_id === product.subcat_id ? "selected" : "";
                              const viewCategory = `<option value="${subcat.subcat_id}" ${selected}>${subcat.subcat_title}</option>` 
                              category.innerHTML += viewCategory 
                          })
                          data.brand.forEach(brd => {
                            const selected =  brd.id === product.brand_id ? "selected" : "";
                            const viewBrand = `<option value="${brd.id}" ${selected}>${brd.brand_name}</option>` 
                            brand.innerHTML += viewBrand 
                          })
                         const statusElement = document.querySelector("#status");
                         const hotTrend = document.querySelector("#hot-trend");
                         const bestseller = document.querySelector("#bestseller");
                         const featured = document.querySelector("#featured");
                          // Set the value
                          statusElement.value = product.status === 1 ? "1" : "0";
                          // deals
                         hotTrend.checked = product.hot_trend == 1
                         bestseller.checked = product.best_seller == 1
                         featured.checked = product.feature == 1
                             }).catch(error => {
                              console.log(error);
                             });                                       
                            var modal = $(this)
                            modal.find('.modal-title').text('Update Product')  
                        });
                       $('#editForm').modal('hide')



                        // update data with api request
                 const UpdateForm = document.querySelector("#updateForm");

                 updateForm.addEventListener('submit', async function(e){
                  e.preventDefault();
                 
             
                const errorMsg = document.querySelector('#error-msg')
               const successMsg = document.querySelector('#successMsg')
                const token = localStorage.getItem('api_token');
              

                let formData = new FormData();

                //get data from form
               const pro_id  = document.querySelector('#pro_id').value;
               const category  = document.querySelector('#category').value;
                const pro_title = document.querySelector('#pro_title').value;
                const status = document.querySelector('#status').value;
                const brand = document.querySelector('#brand').value;
                const hotTrend = document.querySelector('#hot-trend').checked ? 1: 0;
                const bestSeller = document.querySelector('#bestseller').checked ? 1: 0;
                const featured = document.querySelector('#featured').checked ? 1: 0;
                const description = document.querySelector('#description').value;
                const short_description = document.querySelector('#short_description').value;

                //append data in class object formdata
                formData.append('product_id', pro_id);
                formData.append('subcat_id', category);
                formData.append('product_name', pro_title);
                formData.append('pro_description', description);
                formData.append('short_description', short_description);
                formData.append('status', status);
                formData.append('brand_id', brand);
                formData.append('feature', featured);
                formData.append('hot_trend', hotTrend);
                formData.append('best_seller', bestSeller);
                //console.log(formData)


                // insert by fetch
                try {
                    let response = await fetch(`api/product/${pro_id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'X-HTTP-Method-Override':'PUT'
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
                        if(Array.isArray(data.error)){
                            errorMsg.innerText = data.error.join(', ');

                        //window.location.reload();

                        }else{
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
                const DeleteCategory =   async (id) => { 
                  confirm('Are you Want to delete Category..?')
                 const Token = localStorage.getItem('api_token');
                  fetch(`api/product/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'Authorization': `Bearer ${Token}`,
                    },

                  }).then((response) => response.json())
                    .then((data) => {
                    console.log(data)
                    window.location.reload()
                  })
                };        
                    </script>
                @endsection
