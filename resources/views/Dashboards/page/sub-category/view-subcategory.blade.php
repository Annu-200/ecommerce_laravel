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
                                            <th>Img</th>
                                            <th>Title</th>
                                            <th>Belongs category</th>
                                            <th>status</th>
                                            <th>Delete</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoryTbody">

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
                            <h1 class="modal-title fs-2" id="exampleModalLabel">update category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form id="updateForm" class="forms-sample"  method="post" enctype="multipart/form-data">
                            @csrf

                          
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="catTitle">
                                <input type="hidden" class="form-control" id="cat_id">
                              </div>
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Category:</label>
                                <select class="form-control" id="category">
                                  
                                   </select>
                              </div>
                              <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">cat Image:</label>
                                <input type="file" class="form-control" id="catImage">
                                <img src="" alt="" id="showImg" width="200px" max-height="100px">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputPassword4">status</label>
                                <select class="form-control" id="status">
                               <option value="0">Inactive</option>
                               <option value="1">Active</option>
                                </select>
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
                        function loadCategory(url = 'api/subcategory') {

                            const token = localStorage.getItem('api_token')
                            let catBody = document.querySelector('#categoryTbody')
                            let paginate = document.querySelector("#paginate");
                            catBody.innerHTML = '';
                            paginate.innerHTML = '';


                            fetch(url, {
                                    method: 'GET',
                                    headers: {
                                        'Authorization': ` Bearer ${token}`,
                                    },

                                }).then((response) => response.json())
                                .then((data) => {
                                    const Catdata = data.data.subcat.data;
                                  
                                   // console.log(Catdata)
                              Catdata.forEach((cat) => {          
                              const catInner = `
                        <tr>
                          <td> 
                          <img src='/uploads/subcategory/${cat.subcat_images}' /> 
                        </td>
                          <td> 
                            ${cat.subcat_title}
                          </td>
                          <td> 
                            ${cat.category.cat_title}
                          </td>
                          <td>
                          ${cat.subcat_status === 1 ? '<label class="badge badge-gradient-success">Active</label>'
                           : '<label class="badge badge-danger">Inactive</label>'}
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-bs-catid="${cat.subcat_id}" onclick="DeleteCategory(${cat.subcat_id})">
                          <i class="fa fa-trash-o text-light fs-5"></i>                  
                              Delete
                            </button>
                          </td>        
                        <td> 
                        <button type="button" class="btn btn-success text-light"  data-toggle="modal" data-bs-catid="${cat.subcat_id}" data-target="#editForm">
                          <i class="fa fa-edit text-light  fs-5"></i>
                          Edit
                        </button>
                      </td>  
                   </tr>`;
                                catBody.innerHTML += catInner
                         });
                         //render pagination
                         const links = data.data.subcat.links
                         links.forEach(link => {
                          const btn = document.createElement("button")
                          btn.innerHTML = link.label
                          btn.disabled = !link.url
                          btn.className = `btn btn-sm mx-1 ${link.active ? 'btn-primary' : 'btn-outline-secondary'}  `;
                          btn.onclick = () => {
                              if(link.url){
                                const relativeUrl = link.url.replace(/^.*\/\/[^/]+/, '');
                                loadCategory(relativeUrl)
                              
                              }
                              
                            };
                            paginate.appendChild(btn);
                          });         
                      });
              }

  loadCategory()

// edit model 
   $('#editForm').on('show.bs.modal', function(event) {
    let button = event.relatedTarget; // Button that triggered the modal
    const Token = localStorage.getItem('api_token');
    const cat_id = button.getAttribute('data-bs-catid');
    const category = document.querySelector("#category");

    // Fetch subcategory
    fetch(`api/subcategory/${cat_id}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${Token}`,
            'Content-Type': 'application/json',
        }
    }).then((response) => response.json())
      .then((data) => {
          let cat_data = data.data.subcat[0];
          console.log(cat_data);

          // Clear previous options
          category.innerHTML = '';

          // Add selected option first
          const selectedOption = `<option value="${cat_data.category.id}" selected>
                                    ${cat_data.category.cat_title}
                                  </option>`;
          category.innerHTML = selectedOption;

          // Fill other fields
          document.querySelector("#catTitle").value = cat_data.subcat_title;
          document.querySelector("#cat_id").value = cat_data.subcat_id;
          document.querySelector("#description").value = cat_data.subcat_description;
          document.querySelector("#showImg").src = `/uploads/subcategory/${cat_data.subcat_images}`;
          document.querySelector("#status").value = cat_data.subcat_status === 1 ? "1" : "0";

          // Fetch all categories
          fetch('api/AllCategory/', {
              method: 'GET',
              headers: {
                  'Authorization': `Bearer ${Token}`,
              },
          }).then((response) => response.json())
            .then((data) => {
                const Catdata = data.data.cat;

                Catdata.forEach((cat) => {
                    // Avoid duplicating the already selected option
                    if (cat.id !== cat_data.category.cat_id) {
                        const option = `<option value="${cat.id}">${cat.cat_title}</option>`;
                        category.innerHTML += option;
                    }
                });
            })
            .catch(error => console.log(error));
      })
      .catch(error => console.log(error));
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
               const subcat_id  = document.querySelector('#cat_id').value;
               const category  = document.querySelector('#category').value;
                const title = document.querySelector('#catTitle').value;
                const status = document.querySelector('#status').value;
                const description = document.querySelector('#description').value;

                const fileInput = document.querySelector("#catImage");

              if(!document.querySelector("#catImage").files[0] == ""){
                    const subcat_image = document.querySelector("#catImage").files[0];
                    formData.append('subcat_images', subcat_image);

                }


                //append data in class object formdata
                formData.append('subcat_id', subcat_id);
                formData.append('cat_id', category);
                formData.append('subcat_title', title);
                formData.append('subcat_description', description);
                formData.append('subcat_status', status);
                console.log(formData)


                // insert by fetch
                try {
                    let response = await fetch(`/api/subcategory/${subcat_id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'X-HTTP-Method-Override':'PUT'
                            // Remove content-type header when sending FormData
                        },
                 
                    });
                    let data = await response.json();
                    console.log(data);
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
                            //window.location.reload();

                        }       
                    }
                
                } catch (error) {   
                    alert('An error occurred while creating the category');
                }
           })
               // Delete single category
                const DeleteCategory =   async (id) => { 
                  confirm('Are you Want to delete Category..?')
                 const Token = localStorage.getItem('api_token');
                  fetch(`api/subcategory/${id}`, {
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
