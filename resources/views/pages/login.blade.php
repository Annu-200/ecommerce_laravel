@extends('pages.main')

@section('contend')
<section class="contact spad">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 pb-0">
                <div class="contact__content mt-5 pt-5">
                    <div class="contact__address">
                        <h5 class="text-center">User Login</h5>
                       
                    </div>
                    <div class="contact__form">
                       <div class="alert alert-danger" @style('display:none') id="form-error"></div>
                       <div class="alert alert-success" @style('display:none') id="form-success"></div>
                        <form action="" id="loginCheck">
                            @csrf
                            <div class="pb-3">
                                <label for="name">Email</label>
                                <input type="email" id="email" name="email" placeholder="Email" >
                            </div>
                            <div class="pb-3">
                                <label for="password">Password</label>
                                <input type="password" id="pass" name="password" placeholder="Password" >
                            </div>
                            <button type="submit" class="site-btn">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__map">
                <img src="" height="100%" width="100%" alt="">
            </div>
        </div>
    </div>
</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('#loginCheck').on('submit', function(e){
          e.preventDefault();
            const email = $('#email').val();
            const password = $('#pass').val();
          $.ajax({
            type:'POST',
            url: 'api/login',
            contentType: 'application/json',
            data: JSON.stringify({
                email:email,
                password:password,
            }),

            success: function(response){  
                const token = localStorage.setItem('api_token', response.token);
                
                $('#form-success').show().text(response.message);
                window.location.href = "{{ route('dashboard')  }}" ;
                $('#loginCheck').trigger("reset");
            },
            error: function(response){
            if(Array.isArray(response.responseJSON.error)){
                $('#form-error').show().text(response.responseJSON.error).join(', ');
            }else{
                $('#form-error').show().text(response.responseJSON.error);
            }
             $('#loginCheck').trigger("reset");
            }

          })
        });
    })


// dashboard redirect 
$(document).ready(function(){
            const Token = localStorage.getItem('api_token');
            

            $.ajax({
                type: "GET",
                url: "/api/dashboard",
               headers: {
                    'Authorization': `Bearer ${Token}`,
                    'Accept': 'application/json'
                },
                success: function (response) {
                    //Do anything
                    console.log('token',response);
                    const userDetails = localStorage.setItem('user_details', JSON.stringify(response.user))
                    window.location.href=response.redirect

                },
                error: function (response) {
                    console.log('error', response);
                }
            });
        });
</script>


    @endsection