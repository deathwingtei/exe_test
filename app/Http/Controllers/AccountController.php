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
        $users = User::all();
        return view('user',compact('users'));
    }

    public function user_update(Request $request)
    {
        // validate value
        if($request->id!=""&&$request->id!=null&&$request->id!="0")
        {
            // validate value
            $request->validate(
                ['name' =>'required','email' =>'required','username' =>'required','surname' =>'required']
                ,['name.required' => 'Please Insert Name','email.required' => 'Please Insert Email'
                ,'username.required' => 'Please Insert Username','surname.required' => 'Please Insert Surname']
            );

            $decode_id = str_replace("dgtei","",base64_decode($request->id));

            $updatedata = [
                'name'=>$request->name,
                'surname'=>$request->surname,
                'email'=>$request->email,
                'username'=>$request->username,
                'update_date'=>date("Y-m-d H:i:s"),
            ];
            
            if($request->password!="")
            {
                $updatedata['password'] = Hash::make($request->password);
            }

            $update = DB::table('users')->where('id', $decode_id)->update($updatedata);


            return redirect()->route('users')->with('success','Form Edited');
        }
        else
        {
            // validate value
            $request->validate(
                ['name' =>'required','email' =>'required','username' =>'required','surname' =>'required']
                ,['name.required' => 'Please Insert Name','email.required' => 'Please Insert Email'
                ,'username.required' => 'Please Insert Username','surname.required' => 'Please Insert Surname']
            );

            // store to customer DB

            $data = array(
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'created_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s")
            );
            DB::table('users')->insert($data);

            $user->save();
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
        $dup_email = DB::table('users')->where('email', '=', $request->email)->count();
        $dup_username = DB::table('users')->where('username','=', $request->username)->count();

        if($dup_email)
        {
            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['user'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $data['status'] = 500;
            $data['message'] = "Username Dupplicate";
            $data['user'] = "";
            return response()->json($data);
            exit;
        }

        $instdata = array(
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'created_date' => date("Y-m-d H:i:s"),
            'update_date' => date("Y-m-d H:i:s")
        );
        $save = DB::table('users')->insert($instdata);

        if($save)
        {
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['user'] = $instdata;
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "Insert Incomplete";
            $data['user'] = "";
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $users = DB::table('users')->select('id','username','name','surname','email','created_date','update_date')->get();
        foreach ($users as $key => $value) {
            $users[$key]->enc_id = base64_encode($value->id."dgtei");
        }

        $data['status'] = 200;
        $data['message'] = "Get Users Complete";
        $data['users'] = $users;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $user = User::find($decode_id);
        $user->enc_id = base64_encode($user->id."dgtei");
        $data['status'] = 200;
        $data['message'] = "Get User Complete";
        $data['user'] = $user;
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $dup_email = DB::table('users')->where('email', '=', $request->email)->where('id','!=',$decode_id)->count();
        $dup_username = DB::table('users')->where('username','=', $request->username)->where('id','!=',$decode_id)->count();

        if($dup_email)
        {
            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['user'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $data['status'] = 500;
            $data['message'] = "Username Dupplicate";
            $data['user'] = "";
            return response()->json($data);
            exit;
        }

        if($request->id!=""&&$request->id!=null&&$request->id!="0")
        {
            $updatedata = [
                'name'=>$request->name,
                'surname'=>$request->surname,
                'email'=>$request->email,
                'username'=>$request->username,
                'update_date'=>date("Y-m-d H:i:s"),
            ];
            if($request->password!="")
            {
                $updatedata['password'] = Hash::make($request->password);
            }

            $update = DB::table('users')->where('id', $decode_id)->update($updatedata);

            if($update)
            {
                $data['status'] = 200;
                $data['message'] = "User Updated";
                $data['user'] = $updatedata;
            }
            else
            {
                $data['status'] = 500;
                $data['message'] = "Updated Incomplete";
                $data['user'] = "";
            }

            return response()->json($data);
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "No User Data";
            $data['user'] = "";
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $delete =  DB::table('users')->where('id', $decode_id)->delete();

        $data['status'] = 200;
        $data['message'] = "User Delete";
        $data['user'] = $delete;

        return response()->json($data);
    }
}
