@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Login First</b> (If your can't login click reset data) <span style="float:right;" ><button class="btn btn-info" id="resetdata">Resetdata</button></span></div>
                    <div class="card-body">
                        <form id="login_form">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="username" id="username" class="form-control" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                        </form>
                        <div >
                            <h2>Login Info From data.json</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                    </tr>
                                </thead>
                                <tbody id="example_information_login">
                                @php($i=1)
                                @foreach ($datas as $data)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$data['username']}}</td>
                                    <td>{{$data['password']}}</td>
                                </tr>
                                @php($i++)
                                @endforeach
                                </tbody>
                            </table>
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
            const arrayshow = data.return;
            let c = 1;
            if(data.status==201)
            {
                document.querySelector("#example_information_login").innerHTML = "";
                arrayshow.forEach(function(val){
                    txt = '<tr><th scope="row">'+c+'</th>';
                    txt += '<td>'+val.username+'</td>';
                    txt += '<td>'+val.password+'</td>';
                    txt += "</tr>";
                    document.querySelector("#example_information_login").innerHTML += txt;
                    c++;
                });
            }

        });
    });

    document.querySelector('#login_form').addEventListener('submit', (event) => {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        let formdata = new FormData();
        formdata.append('username', username);
        formdata.append('password', password);

        if(username=="")
        {
            alert("Username Must Be Fill");
            return false;
        }

        if(password=="")
        {
            alert("Password Must Be Fill");
            return false;
        }

        let url = 'api/auth/login';
        fetch(url, {
            method: "POST",
            body: formdata,
            mode: 'no-cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        })
        .then(response => response.json()) 
        .then(data => {
            if(data.status==200)
            {
                alert(data.message);
                console.log(data.access_token);
                window.location.href = "accounts";
            }
            else
            {
                alert(data.message);
            }
        });

        return false;
    });
</script>
@endsection