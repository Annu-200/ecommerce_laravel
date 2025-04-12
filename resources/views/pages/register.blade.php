
@extends('pages.main')

@section('contend')
<section class="contact spad">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 pb-0">
                <div class="contact__content mt-3 pt-3">
                <div class="alert alert-success" @style('display:none') id="successMsg"></div>
                    <div class="contact__form">
                        <h5 class="text-center">User Register</h5>
                        <form action="" id="registerContainer">
                            <div class="alert alert-danger" @style('display:none') id="errorMsg"></div>
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name"  name="name" placeholder="Name" >
                            </div>
                            <div class="mb-3">
                                <label for="name">Email</label>
                                <input type="email" id="email" name="email" placeholder="Email" >
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password" >
                            </div>
                           
                            <button type="submit" id="submitForm" class="site-btn">submit</button>
                        </form>

                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__map">
                <img  height="100%" width="100%" alt="">
            </div>
        </div>
    </div>
</div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
 $(document).ready(function(){
    $("#registerContainer").on('submit', function(e){
        e.preventDefault();
        const name = $("#name").val();
        const email = $("#email").val();
        const password = $("#password").val();
        let formData = new FormData(this);
        formData.append('name', name), 
        formData.append('email', email), 
        formData.append('password', password), 
        $.ajax({
            type: "POST",
            url: "api/registerUser",
            data: formData,
            contentType:false,
            processData:false,
            success: function (response) {
                if(response.responseJSON.success){
                    $("#successMsg").show();
                    $("#successMsg").text(response.responseJSON.message);
                    $("#errorMsg").hide();
                    window.location.href="http://127.0.0.1:8000/login";
                }else{
                    $("#errorMsg").show();
                    $("#errorMsg").text(response.responseJSON.error);
                    $("#successMsg").hide();

                }
            },
            error: function (response) {
                if(response.responseJSON.error){  
                    $("#errorMsg").show();
                    $("#errorMsg").text(response.responseJSON.error.join((', '))); 
        
                }

            }
        }); 
    })
 })
</script>
    @endsection



