<?php

namespace App\Http\Controllers;

use App\Models\ItemData;
use App\Models\LogData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RandomController extends Controller
{

    public function show()
    {
        // get all current item and add to log
        $items = ItemData::all();

        //log access
        $log = new LogData;
        $log->log = "";
        $log->table = "";
        $log->commend = "Access Log Page";
        $log->save();

        $path = base_path().'/resources/data/item.json';
        if($jsondata = file_get_contents($path))
        {
            $jsondata = json_decode($jsondata,true);
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['return'] = $jsondata;
            
        }
        else{
            $data['status'] = 500;
            $data['message'] = "Internal Error";
            $data['return'] = "";
        }
        return response()->json($data);
    }
    
    //reset item
    public function create()
    {
        // get all current item and add to log
        $items = ItemData::all();

        //log access
        $log = new LogData;
        $log->log = json_encode($items,JSON_UNESCAPED_UNICODE);
        $log->table = "item_data";
        $log->commend = "Log Before truncate";
        $log->save();

        //truncate table
        DB::table('item_data')->truncate();

        // get resource from json starter data and add to DB
        $savecount = 0;
        $path = base_path().'/resources/data/item.json';
        $jsondata = file_get_contents($path);
        $jsondata = json_decode($jsondata,true);
        foreach ($jsondata as $key => $value) {
            $item = new ItemData;
            $item->game_item_id  = $value['game_item_id'];
            $item->name =  $value['name'];
            $item->chance = $value['chance'];
            $item->stock = $value['stock'];
            $item->save();
            if($item->save())
            {
                $savecount++;
            }
        }

        //return json result to view with api
        if($savecount==sizeof($jsondata))
        {
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['return'] = $jsondata;
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "Insert Incomplete";
            $data['return'] = "";
        }
        return response()->json($data);
    }

    //random item
    public function randomht()
    {
        // random item from current DB
        $items = ItemData::select('game_item_id','name','chance','stock')->get();
        $items = json_decode(json_encode($items,JSON_UNESCAPED_UNICODE),true);

        //set key item to game id (unnecessary)
        $items_key_game = array();
        foreach ($items as $key => $value) {
            $items_key_game[$value['game_item_id']] = $value;
        }

        // set item to array 0 -99
        $itemforrandom = array();
        $random_position = 0;
        foreach ($items as $key => $value) {
            for ($i=0; $i < ($value['chance']*100); $i++) { 
                $itemforrandom[$random_position] = $value['game_item_id'];
                $random_position++;
            }
        }

        //random item 100 times from 0-99
        $itemreturn = array();
        $itemsummary = array();
        for ($i=0; $i < 100; $i++) { 
            $returndata =  $this->randomitem($i,$itemforrandom,$items_key_game,$itemsummary,$itemreturn);
            $items_key_game = $returndata[0];
            $itemsummary = $returndata[1];
            $itemreturn = $returndata[2];
        }

        //update log item recieved
        $log = new LogData;
        $log->log = json_encode($itemsummary,JSON_UNESCAPED_UNICODE);
        $log->table = "-";
        $log->commend = "Log Item has beed recieve";
        $log->save();

        //return json result to view with api
        if($log->save())
        {
            $return_data = array("summary" => $itemsummary,"recieve" => $itemreturn,"remaining" => $items_key_game);
            $data['status'] = 200;
            $data['message'] = "Get Data Complete";
            $data['return'] = $return_data;
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "Incomplete Data";
            $data['return'] = "";
        }

        return response()->json($data);
    }

    private function randomitem($index,$itemforrandom,$items_key_game,$itemsummary,$itemreturn)
    {
        //random with 0-99 index for get item
        $itemcode = $itemforrandom[rand(0,99)];
        if($items_key_game[$itemcode]['stock']>=1)
        {
            //if have item in stock -1
            $items_key_game[$itemcode]['stock']-=1;
            if(isset($itemsummary[$itemcode]))
            {
                //if has item index add summary item recieve
                $itemsummary[$itemcode]+=1;
            }
            else
            {
                //if not has item index add summary item recieve
                $itemsummary[$itemcode]=1;
            }
        }
        else
        {
            //if not have this item random again
            $this->randomitem($index,$itemforrandom,$items_key_game,$itemsummary,$itemreturn);
        }

        $itemreturn[$index] = $items_key_game[$itemcode]['name'];
        return array($items_key_game,$itemsummary,$itemreturn);
    }

    //other logic random 0-99 and divide 100 and switch case forcheck/ item 0-12 = item 1050,13-20 = item 3315 ....
}
