<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use JWTAuth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\LogData;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function __construct()
    {

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
    
            $this->no_login_log("show()");

            return response()->json($data);
            exit;
        }

        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
        }else{
            $data['status'] = 500;
            $data['message'] = "Token Expire";
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

        //update log
        $this->update_log(json_encode($accounts,JSON_UNESCAPED_UNICODE),"accounts","Get all account from id ".$thisiuser['id']." By Query Filter ".$filter." And Page ".$page);
        
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
        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
                  //log access
            $this->update_log(json_encode($accounts,JSON_UNESCAPED_UNICODE),"accounts","Log Before truncate in function create BY ID ".$thisiuser->id);
        }else{
            //log access
            $this->update_log(json_encode($accounts,JSON_UNESCAPED_UNICODE),"accounts","Log Before truncate in function create");
        }
   

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

        Session::flush();

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

            $this->no_login_log("store()");
    
            return response()->json($data);
            exit;
        }

        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
        }else{
            $data['status'] = 500;
            $data['message'] = "Token Expire";
            return response()->json($data);
            exit;
        }

        $dup_email = DB::table('accounts')->where('email', '=', $request->email)->count();
        $dup_username = DB::table('accounts')->where('username','=', $request->username)->count();


        $account = new Account;
        $account->name = $request->name;
        $account->phone = $request->phone;
        $account->email = $request->email;
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->company = $request->company;
        $account->nationality = $request->nationality;

        if($dup_email)
        {

            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Insert New Account But Dupplicate Email By ID ".$thisiuser['id']);

            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Insert New Account But Dupplicate Username By ID ".$thisiuser['id']);
           

            $data['status'] = 500;
            $data['message'] = "Username Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($account->save())
        {
            $data['status'] = 201;
            $data['message'] = "Insert Complete";
            $data['account'] = $account;

            //update log
            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Insert New Account By ID ".$thisiuser['id']);
        }
        else
        {
            $data['status'] = 500;
            $data['message'] = "Insert Incomplete";
            $data['account'] = "";

            $this->update_log("","accounts","Insert New Account By ID ".$thisiuser['id']." Incomplete");
            
        }
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

            $this->no_login_log("edit()");
    
            return response()->json($data);
            exit;
        }

        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
        }else{
            $data['status'] = 500;
            $data['message'] = "Token Expire";
            return response()->json($data);
            exit;
        }

        //get data from id for edit page
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $account = Account::find($decode_id);
        $account->enc_id = base64_encode($account->id."dgtei");

        //update log
        $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Get Account By ID ".$thisiuser['id']);
        

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

            $this->no_login_log("update()");
    
            return response()->json($data);
            exit;
        }

        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
        }else{
            $data['status'] = 500;
            $data['message'] = "Token Expire";
            return response()->json($data);
            exit;
        }

  
        //check dupplicate unique data
        $decode_id = str_replace("dgtei","",base64_decode($id));
        $dup_email = DB::table('accounts')->where('email', '=', $request->email)->where('id','!=',$decode_id)->count();
        $dup_username = DB::table('accounts')->where('username','=', $request->username)->where('id','!=',$decode_id)->count();

        
        $account = Account::find($decode_id);

        if($dup_email)
        {
            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Update But Dupplicate Email By ID ".$thisiuser['id']);

            $data['status'] = 500;
            $data['message'] = "Email Dupplicate";
            $data['account'] = "";
            return response()->json($data);
            exit;
        }

        if($dup_username)
        {
            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Update Account But Dupplicate Username By ID ".$thisiuser['id']);

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

                //update log
                $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Data Before Update Account By ID ".$thisiuser['id']);
               
            }
            else
            {
                $data['status'] = 500;
                $data['message'] = "Updated Incomplete";
                $data['account'] = "";

                //update log
                $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Data Updated Incomplete By ID ".$thisiuser['id']);
                
            }

            return response()->json($data);
        }
        else
        {
            //return error if not has id
            $data['status'] = 500;
            $data['message'] = "No Account Data";
            $data['account'] = "";

            //update log
            $this->update_log("","accounts","NO ACCOUNT For Update By ID ".$thisiuser['id']);
            
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
    
            $this->no_login_log("destroy()");

            return response()->json($data);
            exit;
        }

        if($this->getuser()!=null){
            $thisiuser = $this->getuser();
        }else{
            $data['status'] = 500;
            $data['message'] = "Token Expire";
            return response()->json($data);
            exit;
        }

        //decode id from view
        $decode_id = str_replace("dgtei","",base64_decode($id));

        // permanently delete
        // $delete =  DB::table('accounts')->where('id', $decode_id)->delete();

        // soft delete by  Eloquent
        if($account = Account::find($decode_id)){
            $delete = Account::find($decode_id)->delete();
            $data['status'] = 200;
            $data['message'] = "Account Delete";
            $data['account'] = $delete;
            //update log
            $this->update_log(json_encode($account,JSON_UNESCAPED_UNICODE),"accounts","Delete ACCOUNT By ID ".$thisiuser['id']);
        }else{
            //return error if not has id
            $data['status'] = 500;
            $data['message'] = "No Account Data";
            $data['account'] = "";

            //update log
            $this->update_log("","accounts","NO ACCOUNT For Delete By ID ".$thisiuser['id']);
        }

        return response()->json($data);
    }

    //page section

    public function login_page(Request $request){
        if($this->checkauthen()){
            if($this->getuser()!=null){
                $thisiuser = $this->getuser();
                //update log
                $this->update_log("","","ID ".$thisiuser['id']." Access LOGIN Page and has token redirect to account page");

                return redirect('/accounts');
            }else{
                
                //update log
                $this->update_log("","",request()->ip()." Access Login Page with Token Expire");
                
                $path = base_path().'/resources/data/data.json';
                $jsondata = file_get_contents($path);
                $jsondata = json_decode($jsondata,true);
    
                return view('login')->with("datas",$jsondata);
            }
        }
        else
        {
            // print_r(Session::all());
            
            //update log
            $this->update_log("","",request()->ip()." Access Login Page");

            $path = base_path().'/resources/data/data.json';
            $jsondata = file_get_contents($path);
            $jsondata = json_decode($jsondata,true);

            return view('login')->with("datas",$jsondata);
        }

    }

    public function accounts_page(){
        if(!$this->checkauthen()) {
            //update log
            $this->update_log("","",request()->ip()." No Authen Access Account Page");

            return redirect('/login');
        }
        else {
            if($this->getuser()!=null){
                $thisiuser = $this->getuser();

                //update log
                $this->update_log("","","ID ".$thisiuser['id']." Access Account Page");

            }else{
                $data['status'] = 500;
                $data['message'] = "Token Expire";

                //update log
                $this->update_log("","",request()->ip()." Access Account Page Token Expire");

                return redirect('/login');
                exit;
            }
            return view('accounts');
        }
    }

    public function log_page(){
        if(!$this->checkauthen()) {
            //update log
            $this->update_log("","",request()->ip()." No Authen Access Log Page");

            return redirect('/login');
        }
        else {
            if($this->getuser()!=null){
                $thisiuser = $this->getuser();

                //update log
                $this->update_log("","","ID ".$thisiuser['id']." Access Log Page");

            }else{
                $data['status'] = 500;
                $data['message'] = "Token Expire";

                //update log
                $this->update_log("","",request()->ip()." Access Log Page Token Expire");

                return redirect('/login');
                exit;
            }
            $logs = LogData::orderBy('id', 'desc')->paginate(10);
            return view('logs')->with("logs",$logs);
        }
    }
    

    //auth section

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
            //update log
            $this->update_log("","",request()->ip()." Login Failed");
            $data['status'] = 400;
            $data['message'] = $validator->errors();
            return response()->json($data);
        }
        $credentials = request(['username', 'password']);
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            $data['status'] = 401;
            $data['message'] = "Unauthorized / Username Or Password Incorect";
            //update log
            $this->update_log("","",request()->ip()." Unauthorized / Username Or Password Incorect");
            return response()->json($data);
        }
        //update log
        $this->update_log("","",request()->ip()." Login Complete With Username".$request->username);
        
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
        if($this->checkauthen()){
            if(auth()->user()) {
                $data['status'] = 200;
                $data['message'] = auth()->user();
                $this->update_log("","",request()->ip()." Check Login ".json_encode(auth()->user()->id));
                return response()->json($data);
            }else{
                $token = Session::get('bearer');
                $user = JWTAuth::setToken($token)->toUser();
                $data['status'] = 200;
                $data['message'] =  $user;
                $this->update_log("","",request()->ip()." Check Login ".json_encode($user->id));
                return response()->json($data);
            } 
        }else{
            $data['status'] = 200;
            $data['message'] = "No Login Information";
            $this->update_log("","",request()->ip()." Try to Check me() But no Information");
            return response()->json($data);
        }

    }

    public function logout()
    {
        //set lout authen
        if($this->checkauthen()){
            if($this->getuser()!=null){
                $thisiuser = $this->getuser();
            }else{
                $data['status'] = 500;
                $data['message'] = "Token Expire";
                $this->update_log("","",request()->ip()." Try to Logout But Token Expire");
                return response()->json($data);
                exit;
            }
            
            if(Session::has('bearer'))
            {
                $token = Session::get('bearer');
                JWTAuth::setToken($token)->toUser();
                JWTAuth::invalidate(true);
                Session::flush();
            }
            else
            {
                auth()->logout();
            }

            $this->update_log("","",$thisiuser->username." Logout");

            $data['status'] = 200;
            $data['message'] = "Successfully logged out";
    
            return response()->json($data);
        }
        else{
            $data['status'] = 200;
            $data['message'] = "No Login Information";
             $this->update_log("","",request()->ip()." Try to Logout But no Information");
            return response()->json($data);
        }
    }

 
    private function checkauthen(){
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

    private function getuser(){
        if(auth()->user()){
            $user = auth()->user();
        }
        else {
            if($token = Session::get('bearer')) {

                if(!JWTAuth::setToken($token)->toUser())
                {
                    //token expire
                    $user = null;
                    Session::flush();
                }
                else
                {
                    $user = JWTAuth::setToken($token)->toUser();
                }
            }else {
                $user = null;
                Session::flush();
            }

        }
        return $user;
    }

    private function no_login_log($function = ""){
        //update log
        $log = new LogData;
        $log->log = "";
        $log->table = "";
        $log->commend = "Try to use ".$function." function But no login info IP ".request()->ip();
        $log->save();
        return true;
    }

    private function update_log($log_data = "",$table_data = "",$commend = ""){
        $log = new LogData;
        $log->log = $log_data;
        $log->table = $table_data;
        $log->commend = $commend;
        $log->save();
        return true;
    }

    protected function respondWithToken($token){
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
