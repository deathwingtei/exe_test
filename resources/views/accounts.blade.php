@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Input Data <span style="float:right;" ><button class="btn btn-info" id="resetdata">Resetdata</button></span></div>
                <div class="card-body">
                    <form id="add_edit_account">
                        @csrf
                        @if(session("success"))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        <input type="hidden" name="id" id="id" value="">
                        
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="name" class="form-label ">Name</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('name')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="phone" class="form-label ">Phone</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{old('phone')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('phone')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="email" class="form-label">Email</label>
                                </div>
                                <div class="col-6">
                                    <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('email')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="password" class="form-label ">Password</label>
                                </div>
                                <div class="col-6">
                                    <input type="password" class="form-control" name="password" id="password" value="" autocomplete="off">
                                </div>
                                <div class="col-3 text-end">
                                    @error('password')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="confirm_password" class="form-label ">Confirm Password</label>
                                </div>
                                <div class="col-6">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" autocomplete="off">
                                </div>
                                <div class="col-3 text-end">
                                    @error('confirm_password')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="username" class="form-label ">Username</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="username" id="username" value="{{old('username')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('username')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="company" class="form-label ">Campany</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="company" id="company" value="{{old('company')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('company')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="nationality" class="form-label ">Nationality</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="nationality" id="nationality" value="{{old('nationality')}}" required>
                                </div>
                                <div class="col-3 text-end">
                                    @error('nationality')
                                        <div class=" text-center">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary ">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Result<input type="hidden" id="searchpage" value="0"><br><span id="setpage">Page : </span>
                        <span style="position: absolute;right: 20px;top:0;" ><label>Filter (Enter For Result) : </label><input type="text" class="form-control" value="" id="filter"></span></div>
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Create At</th>
                                    <th scope="col">Update At</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="showdata">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    fetchdata();

    var selection = document.querySelector('.alert') !== null;
    if (selection) {
        var alertList = document.querySelectorAll('.alert')
        var alerts =  [].slice.call(alertList).map(function (element) {
            return new bootstrap.Alert(element)
        })
        setTimeout(function() {  
            var alertNode = document.querySelector('.alert')
            var alert = bootstrap.Alert.getInstance(alertNode)
            alert.close()
        }, 1000);
    }

    document.querySelector('#filter').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            document.querySelector("#searchpage").value = 0;
            fetchdata();
            return false;
        }
    });

    function fetchdata()
    {
        document.querySelector("#showdata").innerHTML = "";
        let filter = document.querySelector("#filter").value;
        let page = document.querySelector("#searchpage").value;
        let url = 'api/accounts?filter='+filter+"&page="+page;
        fetch(url, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {
            console.log(data);
            let c = (parseInt(data.current_page)*10)+1;
            let txt = "";
            data.accounts.forEach(function(account){
                txt = "<tr><td>"+c+"</td><td>"+account.name+"</td><td>"+account.phone+"</td><td>"+account.email+"</td><td>"+account.username+"</td>";
                txt += "<td>"+account.company+"</td><td>"+account.nationality+"</td><td>"+account.created_at+"</td><td>"+account.updated_at+"</td>";
                txt += '<td><a style="cursor:pointer;" class="text-primary edit_account" data-id="'+account.enc_id+'">Edit</a></td>';
                txt += '<td><a style="cursor:pointer;" data-id="'+account.enc_id+'" class="text-danger delete_user">Delete</a></td>';
                txt += "</tr>";
                document.querySelector("#showdata").innerHTML += txt;
                c++;
            });
            document.getElementById("id").value = '';
            document.getElementById("name").value = '';
            document.getElementById("email").value = '';
            document.getElementById("password").value = '';
            document.getElementById("confirm_password").value = '';
            document.getElementById("username").value = '';
            document.getElementById("phone").value = '';
            document.getElementById("nationality").value = '';
            document.getElementById("company").value = '';
            editbtn();
            deletebtn();
            pagebtn(data.current_page,data.max_page);
        });
    }

    document.querySelector('#resetdata').addEventListener('click', (event) => {
        document.querySelector("#showdata").innerHTML = "<tr><td colspan='11' align='center'><h2>Loading...</h2></td></tr>";
        let url = 'api/accounts/reset';
        fetch(url, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {
            
            console.log(data.message);
            console.log("reset complete");
            fetchdata();
        });
        
    });

    document.querySelector('#add_edit_account').addEventListener('submit', (event) => {
        event.preventDefault();
        const id =  document.getElementById("id").value;
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const confirm_password = document.getElementById("confirm_password").value;
        const nationality = document.getElementById("nationality").value;
        const company = document.getElementById("company").value;
        const phone = document.getElementById("phone").value;

        let formdata = new FormData();
        formdata.append('id', id);
        formdata.append('name', name);
        formdata.append('email', email);
        formdata.append('username', username);
        formdata.append('phone', phone);
        formdata.append('nationality', nationality);
        formdata.append('company', company);

        if(name=="")
        {
            alert("Name Must Be Fill");
            return false;
        }
        if(email=="")
        {
            alert("Email Must Be Fill");
            return false;
        }
        if(username=="")
        {
            alert("Username Must Be Fill");
            return false;
        }
        if(phone=="")
        {
            alert("Phone Must Be Fill");
            return false;
        }
        if(nationality=="")
        {
            alert("Nationality Must Be Fill");
            return false;
        }
        if(company=="")
        {
            alert("Company Must Be Fill");
            return false;
        }

        //insert data
        if(id=="")
        {
            if(password=="")
            {
                alert("Password Must Be Fill");
                return false;
            }

            if(confirm_password=="")
            {
                alert("Confirm Password Must Be Fill");
                return false;
            }

            if(password!=confirm_password)
            {
                alert("Please Check Password And Confirm Password");
                return false;
            }
            
            formdata.append('password', password);

            let url = 'api/account';
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
                if(data.status==201)
                {
                    alert(data.message);
                    fetchdata();
                }
                else
                {
                    alert(data.message);
                }
            });
        }
        else
        {
            //update data
            if(password!=confirm_password)
            {
                alert("Please Check Password And Confirm Password");
                return false;
            }

            if(password!="")
            {
                formdata.append('password', password);
            }

            let url = 'api/account/'+id;
            fetch(url, {
                method: "post",
                body: formdata,
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
                    fetchdata();
                }
                else
                {
                    alert(data.message);
                }
            });
        }



        return false;
    });

    function editbtn()
    {
        document.querySelectorAll('.edit_account').forEach((li) => { 
            li.addEventListener('click', (event) => {
                event.preventDefault();
                const thisid = li.getAttribute("data-id");
               
                let url = 'api/account/'+thisid;
                fetch(url, {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                })
                .then(response => response.json()) 
                .then(data => {
                    if(data.status==200)
                    {
                        document.getElementById("id").value = data.account.enc_id;
                        document.getElementById("name").value = data.account.name;
                        document.getElementById("email").value = data.account.email;
                        document.getElementById("username").value = data.account.username;
                        document.getElementById("phone").value = data.account.phone;
                        document.getElementById("company").value = data.account.company;
                        document.getElementById("nationality").value = data.account.nationality;
                    }
                    else
                    {
                        alert(data.message);
                    }
                });
            });
        });
    }

    function deletebtn()
    {
        document.querySelectorAll('.delete_user').forEach((li) => { 
            li.addEventListener('click', (event) => {
                event.preventDefault();
                if (confirm("Are you sure?")) {
                    const thisid = li.getAttribute("data-id");
                
                    let url = 'api/account/'+thisid;
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                    })
                    .then(response => response.json()) 
                    .then(data => {
                        if(data.status==200)
                        {
                            alert(data.message);
                            fetchdata();
                        }
                        else
                        {
                            alert(data.message);
                        }
                    
                    });
                }

            });
        });
    }

    function pagebtn(current_page,maxpage){
        let pagesetup = "Page : ";
        for (let index = 0; index < maxpage; index++) {
            if(index==current_page)
            {
                pagesetup += parseInt(index)+1+" ";
            }
            else
            {
                pagesetup += "<a style='cursor:pointer;' class='changepage' data-page="+index+">"+(parseInt(index)+1)+"</a> ";
            }
        }
        document.querySelector("#setpage").innerHTML = pagesetup;

        document.querySelectorAll('.changepage').forEach((li) => { 
            li.addEventListener('click', (event) => {
                event.preventDefault();
                const thispage = li.getAttribute("data-page");
                document.querySelector("#searchpage").value = thispage;
                fetchdata();
            });
        });
    }

</script>
@endsection