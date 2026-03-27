@extends('Dashboards.page.master-layout')


@section('admin-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Add Products-Details </h3>

            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card ">
                        <div class="card-body">
                                <div class="text-danger" @style('display:none') id="error-msg"></div>
                                <div class="text-success" @style('display:none') id="successMsg"></div>
                            <form class="forms-sample" id='submitCat' method="POST" enctype="multipart/form-data">
                               <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1" class="mt-3">Product Title</label>
                                        <select  id="product_id" class="form-control">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Status</label>
                                       <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                       </select>
                                    </div>
                                </div>
                                 
                               </div>

                             
                               <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Price</label>
                                    <input type="number" id="price" class="form-control" placeholder="price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="exampleInputPassword4">Orignal Price</label>
                                    <input type="number" id="regular_price" class="form-control" placeholder="Orignal Price">
                                </div>
                            </div>
                              
                               
                               <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="exampleInputPassword4">Stock Quantity </label>
                                    <input type="number" id="stock_quantity" class="form-control" placeholder="Stock">              
                                    </div>
                                </div>
                                <div class="col-md-4">
                                     <div class="form-group">
                                    <label for="exampleTextarea1">Sizes</label>
                                    <select name="size" id="size" class="form-control">
                                        
                                    </select>
                                   </div>
                             </div>
                             <div class="col-md-4">
                                     <div class="form-group">
                                    <label for="exampleTextarea1">Color</label>
                                    <select name="color" id="color" class="form-control">
                                        
                                    </select>
                                   </div>
                             </div>
                                
                             </div>
                                
                                

                               <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="exampleTextarea1">Thumbnail</label>
                                        <input type="file" class="form-control" id="thumbnail">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleTextarea1">Gallary</label>
                                            <input type="file" name="gallery[]" multiple="multiple" class="form-control" id="gallery">
                                        </div>
                                    </div>
                                </div>
                               
                           
                           <div class="row">
                           <div class="col-md-6">
                                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                              
                           </div> 
                           <div class="col-md-6">
                      <button class="btn btn-light">Cancel</button>                              
                           </div> 
                           </div>
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

        // Get  sizes
        function loadsize(){
        const token = localStorage.getItem('api_token')
        let productBody = document.querySelector('#product_id')
        productBody.innerHTML = ` ` 
        fetch('api/product/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },

        }).then((response) =>  response.json())
        .then((data) => { 
            const productData = data.product_list;
            productData.forEach((product) => {
              
              const  productHtml =  `<option value="${product.product_id}">${product.product_name}</option>
                                 `
                productBody.innerHTML += productHtml 
                
            });
        })
    }

    loadsize()


    // GET Product Size 
     function loadColor(){
        const token = localStorage.getItem('api_token')
        let colorBody = document.querySelector('#color')
        colorBody.innerHTML = ` ` 
        fetch('api/product-color/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },

        }).then((response) =>  response.json())
        .then((data) => { 
            const productData = data.data;
          
            productData.forEach((color) => {
              
              const  productHtml =  `<option value="${color.id}">${color.name}</option>
                                 `
                colorBody.innerHTML += productHtml 
                
            });
        })
    }

    loadColor()
    // GET Product 
        function loadproduct(){
        const token = localStorage.getItem('api_token')
        let SizeBody = document.querySelector('#size')
        SizeBody.innerHTML = ` ` 
        fetch('api/product-size/',{
           method:'GET',
           headers: {
            'Authorization': ` Bearer ${token}`,            
           },

        }).then((response) =>  response.json())
        .then((data) => { 
            const sizeData = data.size;
            sizeData.forEach((size) => {
              
              const  sizeHtml =  `<option value="${size.id}">${size.size}</option>
                                 `
                SizeBody.innerHTML += sizeHtml 
                
            });
        })
    }

    loadproduct()


   
   
        // add Product Details
            const submitCat = document.querySelector('#submitCat');
            submitCat.addEventListener('submit', async function(e) {
                e.preventDefault();
                const errorMsg = document.querySelector('#error-msg')
               const successMsg = document.querySelector('#successMsg')
                const token = localStorage.getItem('api_token');
                let formData = new FormData();

                //Get data from form
                const title = document.querySelector('#product_id').value;
                const pro_status = document.querySelector('#status').value;
                const price = document.querySelector('#price').value;
                const regular_price = document.querySelector("#regular_price").value
                const stock_quantity = document.querySelector("#stock_quantity").value
                const size = document.querySelector("#size").value
                const thumbnail = document.querySelector("#thumbnail").files[0]
                const gallery = document.querySelector("#gallery").files
                const color = document.querySelector("#color").value
 
                //append data in class object formdata
                formData.append('product_id', title);
                formData.append('color', color);
                formData.append('status', pro_status);
                formData.append('price', price);
                formData.append('regular_price', regular_price);
                formData.append('size', size);
                formData.append('stock_quantity', stock_quantity);
                formData.append('thumbnail', thumbnail);
                
                for (let i = 0; i < gallery.length; i++) {
                    formData.append('gallery[]', gallery[i]); 
                }

                
                // insert by fetch
                try {
                    let response = await fetch('/api/product-varient', {
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
                        successMsg.innerText = data.massage;
                       window.location.href = "{{ route('view-product-details') }}";
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
                   
                    alert('An error occurred while creating the product Details.');
                }
            });
        </script>
    @endsection
