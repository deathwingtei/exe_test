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
        resetitem();

    });


    function resetitem()
    {
        //get item from controller and refresh DB

        let show_stock_div = document.querySelector("#show_stock");
        show_stock_div.innerHTML = "<h2>Percent Item</h2>";
        items.forEach(function(item,index){
            show_stock_div.innerHTML += "<div class='col-12'>"+items[index]['name']+" || Chance : "+(items[index]['chance']*100)+"% || Stock : "+items[index]['stock']+"</div>";
        });
    }

    function getrandomitem()
    {
        // get data random item from controller and show
    }

    document.querySelector("#randomitem").addEventListener('click', e => {
        resetitem();
        getrandomitem();
    });
</script>
@endsection