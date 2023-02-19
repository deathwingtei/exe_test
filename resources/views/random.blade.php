@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-info" id="randomitem">Random</button>
        </div>
    </div>
    <div class="row mt-5"  id="show_stock">

    </div>
    <div class="row mt-5">
        <div class="col-4"  id="show_random">

        </div>
        <div class="col-4"  id="show_random_summary">

        </div>
        <div class="col-4"  id="show_random_remaining">

        </div>
    </div>
</div>
<script>


    let items = [];
    let showitem = [];
    let sumitem = [];
    let randomnum = 100;
    let posrandom = [];

    document.addEventListener("DOMContentLoaded", () => {
        // resetitem();

    });


    function resetitem()
    {
        let show_stock_div = document.querySelector("#show_stock");
        //get item from controller and refresh DB
        let url = 'api/items';
        fetch(url, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {
            if(data.status==201)
            {
                //fetch item from api
                show_stock_div.innerHTML = "<h2>Percent Item</h2>";
                data.return.forEach(function(item){
                    show_stock_div.innerHTML += "<div class='col-12'>"+item.name+" || Chance : "+(item.chance*100)+"% || Stock : "+(item.stock)+"</div>";
                });
            }
            else
            {
                alert(data.message);
            }
        });
    }

    function getrandomitem()
    {
        // get data random item from controller and show
        let url = 'api/random100timesitems';
        fetch(url, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {
            if(data.status==200)
            {
                //fetch item from api

                const recieve = data.return.recieve;
                const remaining = data.return.remaining;
                const summary = data.return.summary;

                let randomdiv = document.querySelector("#show_random");
                randomdiv.innerHTML = "<h2>Item Recieved</h2>";
                let c = 1;
                recieve.forEach(function(item){
                    randomdiv.innerHTML += "<div>"+c+". "+item+"</div>";
                    c++;
                });


                let randomremaindiv = document.querySelector("#show_random_remaining");
                randomremaindiv.innerHTML = "<h2>Stock Remaining</h2>";
                Object.entries(remaining).forEach(([key, value]) => {
                    randomremaindiv.innerHTML += "<div>"+value.name+" : "+value.stock+" EA</div>";
                });

                let randomsumdiv = document.querySelector("#show_random_summary");
                randomsumdiv.innerHTML = "<h2>Item Recieved Summary</h2>";
                Object.entries(summary).forEach(([key, value]) => {
                    randomsumdiv.innerHTML += "<div>"+remaining[key].name+" : "+value+" EA</div>";
                });
 
            }
            else
            {
                alert(data.message);
            }
        });
    }

    document.querySelector("#randomitem").addEventListener('click', e => {
        resetitem();
        getrandomitem();
    });
</script>
@endsection