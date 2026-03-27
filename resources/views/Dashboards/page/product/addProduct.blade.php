@extends('Dashboards.page.master-layout')


@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Add Products </h3>

            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card ">
                        <div class="card-body">
                                <div class="text-danger" @style('display:none') id="error-msg"></div>
                                <div class="text-success" @style('display:none') id="successMsg"></div>
                            <form class="forms-sample" id='submitCat' method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1" class="mt-3">Product Title</label>
                                    <input type="text" id="pro_title" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword4">status</label>
                                    <select class="form-control" id="pro_status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                   
                                    <label for="hot-trend">
                                        <input type="checkbox" id="hot-trend" name="hot_trend" value="1">
                                     hot Trend
                                    </label>
                                    <label for="bestseller">
                                        <input type="checkbox" id="bestseller" name="bestseller" value="1">
                                        Bestseller
                                    </label>
                                    <label for="featured">
                                        <input type="checkbox" id="featured" name="featured" value="1">
                                    featured
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Category</label>
                                    <select class="form-control" id="category">
                                    
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Brand</label>
                                    <select class="form-control" id="brand">
                                    
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleTextarea1">Product Short Description</label>
                                    <textarea class="form-control" id="short_prodesc" rows="2"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Product  Description</label>
                                    <textarea class="form-control" id="long_prodesc" rows="4"></textarea>
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

        // Get  Category
        function loadCategory(){
        const token = localStorage.getItem('api_token')
        let catBody = document.querySelector('#category')
        catBody.innerHTML = ` ` 
        fetch('api/product-category/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },

        }).then((response) =>  response.json())
        .then((data) => { 
            const Catdata = data.cat;
        
            Catdata.forEach((product) => {
              
              const  catInner =  `<option value="${product.subcat_id}">${product.subcat_title}</option>
                                 `
                catBody.innerHTML += catInner 
                
            });
        })
    }

    loadCategory()


    // Get BRAND
     function loadBrand(){
        const token = localStorage.getItem('api_token')
        let brandBody = document.querySelector('#brand')
        brandBody.innerHTML = ` ` 
        fetch('api/showBrand/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },
        }).then((response) =>  response.json())
        .then((data) => { 
            const BrdData = data.brand;
            BrdData.forEach((brd) => {
              const  BranndData =  `<option value="${brd.id}">${brd.brand_name}</option>
                                 `
                brandBody.innerHTML += BranndData 
            });
        })
    }

    loadBrand()
        // add sub category
            const submitCat = document.querySelector('#submitCat');
            submitCat.addEventListener('submit', async function(e) {
                e.preventDefault();
                const errorMsg = document.querySelector('#error-msg')
               const successMsg = document.querySelector('#successMsg')
                const token = localStorage.getItem('api_token');
                let formData = new FormData();

                //Get data from form
                const title = document.querySelector('#pro_title').value;
                const pro_status = document.querySelector('#pro_status').value;
                const description = document.querySelector('#long_prodesc').value;
                const short_desc = document.querySelector('#short_prodesc').value;
                const category = document.querySelector("#category").value
                const brand = document.querySelector("#brand").value
                const hotTrend = document.querySelector("#hot-trend").checked ? 1: 0
                const featured = document.querySelector("#featured").checked ? 1: 0
                const bestseller = document.querySelector("#bestseller").checked ? 1: 0

                //append data in class object formdata
                formData.append('product_name', title);
                formData.append('pro_description', description);
                formData.append('status', pro_status);
                formData.append('short_description', short_desc);
                formData.append('subcat_id', category);
                formData.append('brand_id', brand);
                formData.append('hot_trend', hotTrend);
                formData.append('best_seller', bestseller);
                formData.append('feature', featured);
                
               

                
                // insert by fetch
                try {
                    let response = await fetch('/api/product', {
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
                       window.location.href = "{{ route('view-product') }}";
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
