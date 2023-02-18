@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Login First <span style="float:right;" ><button class="btn btn-info" id="resetdata">Resetdata</button></span></div>
                    <div class="card-body">
                        <form id="login_form">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="form2Example1" class="form-control" />
                                <label class="form-label" for="form2Example1">Username</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example2" class="form-control" />
                                <label class="form-label" for="form2Example2">Password</label>
                            </div>

                            <!-- Submit button -->
                            <button type="button" class="btn btn-primary btn-block mb-4">Sign in</button>
                        </form>
                        <div id="example_information_login">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('#resetdata').addEventListener('click', (event) => {
        document.querySelector("#example_information_login").innerHTML = "<tr><td colspan='11' align='center'><h2>Loading...</h2></td></tr>";
        let url = 'api/accounts/reset';
        fetch(url, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {
            
            console.log(data.message);
            console.log("reset complete");
            
        });
        
    });
</script>
@endsection