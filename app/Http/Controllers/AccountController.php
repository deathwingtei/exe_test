<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $accounts = Account::all();
        return view('accounts',compact('accounts'));
    }

    //laravel Set not use
    public function account_update(Request $request)
    {
        // validate value
        if($request->id!=""&&$request->id!=null&&$request->id!="0")
        {
            // validate value
            $request->validate(
                ['name' =>'required','email' =>'required','username' =>'required','phone' =>'required','company' =>'required','nationality' =>'required']
                ,['name.required' => 'Please Insert Name','email.required' => 'Please Insert Email'
                ,'username.required' => 'Please Insert Username','phone.required' => 'Please Insert Phone'
                ,'company.required' => 'Please Insert Company','nationality.required' => 'Please Insert Nationality']
            );

            $decode_id = str_replace("dgtei","",base64_decode($request->id));

            //Query Builder
            $updatedata = [
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'username'=>$request->username,
                'company'=>$request->company,
                'nationality'=>$request->nationality,
                'update_date'=>date("Y-m-d H:i:s"),
            ];

            if($request->password!="")
            {
                $updatedata['password'] = Hash::make($request->password);
            }

            $update = DB::table('accounts')->where('id', $decode_id)->update($updatedata);


            return redirect()->route('accounts')->with('success','Form Edited');
        }
        else
        {
            // validate value
            $request->validate(
                ['name' =>'required','email' =>'required','username' =>'required','phone' =>'required','company' =>'required','nationality' =>'required','password' =>'required']
                ,['name.required' => 'Please Insert Name','email.required' => 'Please Insert Email'
                ,'username.required' => 'Please Insert Username','phone.required' => 'Please Insert Phone','password.required' => 'Please Insert Password'
                ,'company.required' => 'Please Insert Company','nationality.required' => 'Please Insert Nationality']
            );

            // store to account DB

            // $data = array(
            //     'name' => $request->name,
            //     'phone' => $request->phone,
            //     'email' => $request->email,
            //     'username' => $request->username,
            //     'password' => Hash::make($request->password),
            //     'company'=>$request->company,
            //     'nationality'=>$request->nationality,
            //     'created_date' => date("Y-m-d H:i:s"),
            //     'update_date' => date("Y-m-d H:i:s")
            // );
            // DB::table('accounts')->insert($data);

            // Eloquent
            $account = new Account;
            $account->name = $request->name;
            $account->phone = $request->phone;
            $account->email = $request->email;
            $account->username = $request->username;
            $account->password = $request->password;
            $account->company = $request->company;
            $account->nationality = $request->nationality;

            $account->save();
        }
        return redirect()->back()->with('success','Form Added');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dup_email = DB::table('accounts')->where('email', '=', $request->email)->count();
        $dup_username = DB::table('accounts')->where('username','=', $request->username)->count();

        if($dup_email)
        {
            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $data['status'] = 500;
            $data['message'] = "Username Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        $instdata = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'company'=>$request->company,
            'nationality'=>$request->nationality,
            'created_date' => date("Y-m-d H:i:s"),
            'update_date' => date("Y-m-d H:i:s")
        );
        $save = DB::table('accounts')->insert($instdata);

        if($save)
        {
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['account'] = $instdata;
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "Insert Incomplete";
            $data['account'] = "";
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
        $account = DB::table('accounts')->select('id','username','name','phone','email','company','nationality','created_date','update_date')->get();
        foreach ($accounts as $key => $value) {
            $accounts[$key]->enc_id = base64_encode($value->id."dgtei");
        }

        $data['status'] = 200;
        $data['message'] = "Get Accounts Complete";
        $data['accounts'] = $accounts;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $account = Account::find($decode_id);
        $account->enc_id = base64_encode($account->id."dgtei");
        $data['status'] = 200;
        $data['message'] = "Get Account Complete";
        $data['account'] = $account;
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $dup_email = DB::table('accounts')->where('email', '=', $request->email)->where('id','!=',$decode_id)->count();
        $dup_username = DB::table('accounts')->where('username','=', $request->username)->where('id','!=',$decode_id)->count();

        if($dup_email)
        {
            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $data['status'] = 500;
            $data['message'] = "Username Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($request->id!=""&&$request->id!=null&&$request->id!="0")
        {
            $updatedata = [
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'username'=>$request->username,
                'nationality' =>$request->nationality,
                'company'=>$request->company,
                'update_date'=>date("Y-m-d H:i:s"),
            ];
            if($request->password!="")
            {
                $updatedata['password'] = Hash::make($request->password);
            }

            $update = DB::table('accounts')->where('id', $decode_id)->update($updatedata);

            if($update)
            {
                $data['status'] = 200;
                $data['message'] = "User Updated";
                $data['account'] = $updatedata;
            }
            else
            {
                $data['status'] = 500;
                $data['message'] = "Updated Incomplete";
                $data['account'] = "";
            }

            return response()->json($data);
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "No Account Data";
            $data['account'] = "";
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $delete =  DB::table('accounts')->where('id', $decode_id)->delete();

        $data['status'] = 200;
        $data['message'] = "Sccount Delete";
        $data['account'] = $delete;

        return response()->json($data);
    }
}
