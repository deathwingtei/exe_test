<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use App\Models\Account;
use App\Models\LogData;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function __construct()
    {

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check login
        // if(!$this->checkauthen()) {
        //     $data['status'] = 203;
        //     $data['message'] = "No Login Information";
    
        //     return response()->json($data);
        //     exit;
        // }

        //reset data Account table
         // get all current item and add to log
         $accounts = Account::all();

         //log access
         $log = new LogData;
         $log->log = json_encode($accounts,JSON_UNESCAPED_UNICODE);
         $log->table = "accounts";
         $log->commend = "Log Before truncate";
         $log->save();
 
         //truncate table
         DB::table('accounts')->truncate();
 
         // get resource from json starter data and add to DB
         $savecount = 0;
         $path = base_path().'/resources/data/data.json';
         $jsondata = file_get_contents($path);
         $jsondata = json_decode($jsondata,true);
         foreach ($jsondata as $key => $value) {
            $data = array(
                'name' => $value['name'],
                'phone' => $value['phone'],
                'email' => $value['email'],
                'username' => $value['username'],
                'password' => Hash::make($value['password']),
                'company'=>$value['company'],
                'nationality'=>$value['nationality']
            );
            DB::table('accounts')->insert($data);
         }

        $data['status'] = 201;
        $data['message'] = "Data Reset";
        $data['return'] = $jsondata;

         return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check login
        if(!$this->checkauthen()) {
            $data['status'] = 203;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
            exit;
        }

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

        $account = new Account;
        $account->name = $request->name;
        $account->phone = $request->phone;
        $account->email = $request->email;
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->company = $request->company;
        $account->nationality = $request->nationality;

        if($account->save())
        {
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['account'] = $account;
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
        //check login
        if(!$this->checkauthen()) {
            $data['status'] = 203;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
            exit;
        }

        $filter = request('filter', '');
        $page = request('page', 0);
        $skip = $page*10;
        //
        if($filter=='') {
            $allrows = DB::table('accounts')->whereNull('deleted_at')->count();
            $maxpage = ceil(($allrows)/10);
            $accounts = Account::select('id','username','name','phone','email','company','nationality','created_at','updated_at')
            ->whereNull('deleted_at')->skip($skip)->take(10)->orderBy('id', 'desc')->get();
        }
        else {
            $allrows = DB::table('accounts')->whereNull('deleted_at')->whereRaw('username = ? or phone like ? or email like ? or company like ? or nationality like ?', 
            ["%{$filter}%","%{$filter}%","%{$filter}%","%{$filter}%","%{$filter}%"])
            ->count();
            $maxpage = ceil(($allrows)/10);

            $accounts = Account::select('id','username','name','phone','email','company','nationality','created_at','updated_at')
            ->whereNull('deleted_at')->whereRaw('username = ? or phone like ? or email like ? or company like ? or nationality like ?', 
            ["%{$filter}%","%{$filter}%","%{$filter}%","%{$filter}%","%{$filter}%"])
            ->skip($skip)->take(10)->orderBy('id', 'desc')->get();
        }

        foreach ($accounts as $key => $value) {
            $accounts[$key]->enc_id = base64_encode($value->id."dgtei");
        }

        $max_page = (sizeof($accounts));

        $data['status'] = 200;
        $data['message'] = "Get Accounts Complete";
        $data['accounts'] = $accounts;
        $data['current_page'] = $page;
        $data['max_page'] = $maxpage;
        $data['all_rows'] = $allrows;
        $data['filter'] = $filter;
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
        //check login
        if(!$this->checkauthen()) {
            $data['status'] = 203;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
            exit;
        }

        //get data from id for edit page
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
        //check login
        if(!$this->checkauthen()) {
            $data['status'] = 203;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
            exit;
        }

        //check dupplicate unique data
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

        //check id from request
        if($request->id!=""&&$request->id!=null&&$request->id!="0")
        {
            //set update if has id request
            $updatedata = [
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'username'=>$request->username,
                'nationality' =>$request->nationality,
                'company'=>$request->company,
                'updated_at'=>date("Y-m-d H:i:s"),
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
            //return error if not has id
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
        //check login
        if(!$this->checkauthen()) {
            $data['status'] = 203;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
            exit;
        }

        //decode id from view
        $decode_id = str_replace("dgtei","",base64_decode($id));

        // permanently delete
        // $delete =  DB::table('accounts')->where('id', $decode_id)->delete();

        // soft delete by  Eloquent
        $delete = Account::find($decode_id)->delete();
        $data['status'] = 200;
        $data['message'] = "Account Delete";
        $data['account'] = $delete;

        return response()->json($data);
    }

    public function login_page(Request $request){
        // print_r(Session::all());

        $path = base_path().'/resources/data/data.json';
        $jsondata = file_get_contents($path);
        $jsondata = json_decode($jsondata,true);

        return view('login')->with("datas",$jsondata);
    }

    public function accounts_page(){
        if(!$this->checkauthen()) {
            return redirect('/login');
        }
        else {
            return view('accounts');
        }
        
    }

    public function login(Request $request)
    {
        //set login authen
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $credentials = request(['username', 'password']);
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            $data['status'] = 401;
            $data['message'] = "Unauthorized / Username Or Password Incorect";
            return response()->json($data);
        }
        Session::put('bearer', $token);
        Session::save();
        return $this->respondWithToken($token);
    }

      /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //check login authen
        return response()->json(auth()->user());
    }

    public function logout()
    {
        //set loout authen
        if($this->checkauthen()){
            auth()->logout();

            $data['status'] = 200;
            $data['message'] = "Successfully logged out";
    
            return response()->json($data);
        }
        else{
            $data['status'] = 200;
            $data['message'] = "No Login Information";
    
            return response()->json($data);
        }
    }

    public function checkauthen()
    {
        //check authen
        if(Session::has('bearer'))
        {
            return true;
        }
        else
        {
            if(!auth()->user())
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }

    protected function respondWithToken($token)
    {
        //return token

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'message' => "Login Complete",
            'status' => 200
        ]);
    }
    

}
