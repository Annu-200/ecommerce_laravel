@extends('Dashboards.page.master-layout')


@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Add Sub Categories </h3>

            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                                <div class="text-danger" @style('display:none') id="error-msg"></div>
                                <div class="text-success" @style('display:none') id="successMsg"></div>
                            <form class="forms-sample" id='submitCat' method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1" class="mt-3">Sub Category Title</label>
                                    <input type="text" id="sucat_title" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword4">status</label>
                                    <select class="form-control" id="substatus">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Category</label>
                                    <select class="form-control" id="category">
                                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>File upload</label>

                                    <div class="input-group col-xs-12">
                                        <input type="file" id="subcat_image" class="form-control file-upload-info"
                                            placeholder="Upload Image">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleTextarea1">Subcategory Description</label>
                                    <textarea class="form-control" id="subdescription" rows="4"></textarea>
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

        // get parent Category
        function loadCategory(){

        const token = localStorage.getItem('api_token')
        let catBody = document.querySelector('#category')
        catBody.innerHTML = ` ` 
        fetch('api/AllCategory/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },

        }).then((response) =>  response.json())
        .then((data) => { 
            
            const Catdata = data.data.cat;
          Catdata.forEach((cat) => {
                
              const  catInner =  `<option value="${cat.id}">${cat.cat_title}</option>
                                 `
                catBody.innerHTML += catInner 
            });
        })
    }

    loadCategory()
        // add sub category
            const submitCat = document.querySelector('#submitCat');
            submitCat.addEventListener('submit', async function(e) {
                e.preventDefault();
                const errorMsg = document.querySelector('#error-msg')
               const successMsg = document.querySelector('#successMsg')
                const token = localStorage.getItem('api_token');
                let formData = new FormData();

                //get data from form
                const title = document.querySelector('#sucat_title').value;
                const status = document.querySelector('#substatus').value;
                const description = document.querySelector('#subdescription').value;
                const cat_image = document.querySelector("#subcat_image").files[0];
                const category = document.querySelector("#category").value

                //append data in class object formdata
                formData.append('subcat_title', title);
                formData.append('subcat_description', description);
                formData.append('subcat_status', status);
                formData.append('subcat_images', cat_image);
                formData.append('cat_id', category);
                
                if (cat_image && cat_image.size > 2 * 1024 * 1024) { // 2 MB
                    console.error("File size exceeds 2 MB.");
                    errorMsg.innerText = "File size exceeds 2 MB. Please upload a smaller image.";
                    errorMsg.style.display = 'Block';
                    return; // Prevent form submission
                }

                
                // insert by fetch
                try {
                    let response = await fetch('/api/subcategory', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                           
                        },
                })
                    let data = await response.json();
                    console.log(data);
                    
                    if (data.status) {
                        errorMsg.style.display = 'none';
                        successMsg.style.display = 'Block';
                        successMsg.innerText = data.message;
                       window.location.href = "{{ route('viewSubCategory') }}";
                    } else {
                        errorMsg.style.display = 'Block';
                        successMsg.style.display = 'none';
                        if(Array.isArray(data.error)){
                            errorMsg.innerText = data.error.join(', ');               
                       // window.location.reload();
                        }else{
                            errorMsg.innerText = data.error;
                       // window.location.reload();
                        }       
                    }

                } catch (error) {
                   
                    alert('An error occurred while creating the category');
                }
            });
        </script>
    @endsection
