<?php

namespace App\Http\Controllers;

use App\Models\ItemData;
use App\Models\LogData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RandomController extends Controller
{
    //reset item
    public function create()
    {
        // get all current item and add to log
        $items = ItemData::all();
        print_r(json_encode($items));

        //truncate table
        // DB::table('item_data')->truncate();

        // get resource from json starter data and add to DB
        $path = base_path().'/resources/data/item.json';
        $jsondata = file_get_contents($path);
        // print_r(json_decode($jsondata,true));

        //return json result to view with api
    }

    //random item
    public function randomht()
    {
        // random item from current DB

        // set item to array 0 -99

        //random item 100 times from 0-99

        //if have item in stock -1

        //if not have this item random again

        //return json result to view with api

    }
}
