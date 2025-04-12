@extends('Dashboards.page.master-layout')



@section('admin-content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Users Tables </h3>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All User</h4>
           
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email ID</th>
             
                  <th>Role</th>
                </tr>
              </thead>
              <tbody id="userTbody">
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
     
      
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
     function loadUsers() {
      const token = localStorage.getItem('api_token')
      fetch('api/user',{
        method:'GET',
        headers: {
          'Authorization': ` bearer ${token}`,
        },
      }).then((response) => response.json())
      .then((data) => {
        const users = data.user.user
        console.log(users);
        let tbody = document.querySelector('#userTbody')
        tbody.innerHTML = ''
                users.forEach(user => {
                  const userbody =`<tr>
                            <td>
                               ${user.name}
                            </td>
                            <td>
                               ${user.role === 'admin'  ? '<label class="badge badge-gradient-success">Admin</label>'  
                                   : '<label class="badge badge-gradient-info">Customer</label>'
                            }
                            </td>
                            <td> ${user.email} </td>
                          </tr>` 
                          

                          return tbody.innerHTML += userbody
                });
      });
    }
    
    loadUsers()
  </script>
@endsection