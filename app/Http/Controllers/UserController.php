<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

use Auth;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userList(Request $request){

       if(!$request->get('user_type_id') ){
            return redirect('/');
        }

        $data = array();

        $user_type = Usertype::where('id',$request->get('user_type_id'))->first();

        $data['user_type'] = $user_type['name'];

        $users =  User::orderBy('id');
        
        $users->where('user_type_id',$request->get('user_type_id'));
    
      
        if($request->get('filter_name')){
            $users->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }

        if($request->get('filter_telephone')){
            $users->where('telephone', 'LIKE','%' . $request->get('filter_telephone') . '%');
        }

        if($request->get('filter_email')){
            $users->where('email', $request->get('filter_email'));
        }


        if($request->get('filter_status') || $request->get('filter_status') == "0"){
            $users->where('status', $request->get('filter_status'));
        }
        
        if($request->get('user_type_id') == 2 ){
            $data['is_private_user'] = true;
        }else{
            $data['is_private_user'] = false;
        }

        $data['users'] = $users->paginate(15);

        return view("user.userlist",$data);
    }

    public function userForm(Request $request){
       if(!$request->get('user_type_id') ){
            return redirect('/');
        }

        $data = array();

        if($request->path() == 'users/add'){
            $data['action'] = route('addUser',['user_type_id'=>$request->get('user_type_id')]);
        }else if($request->path() == 'users/edit'){
            $data['action'] = route('editUser',['id'=>$request->get('id'),'user_type_id'=>$request->get('user_type_id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

                // validation data if add or edit and not empty
                if($request->path() == 'users/add' || ($request->path() == 'users/edit' && !empty($request->input('password')))){
                    $validation_data['password'] = 'required|min:8';
                    
                }

                if($request->path() == 'users/add'){ // validation if add
                    $validation_data['name'] = 'required|unique:users|min:3';
                    $validation_data['email'] = 'required|unique:users|email';
                    $validation_data['telephone'] = 'required|unique:users|min:6';
                }else{ // validation if edit
                    $validation_data['name'] = 'required|min:3';
                    $validation_data['email'] = 'required|email';
                    $validation_data['telephone'] = 'required|min:6';
                }

                if($request->get('user_type_id') == 2){
                    $validation_data['balance'] = 'required|min:1';
                }

                $validated = $request->validate($validation_data);

                // inser/edit data
                $user_data = [
                    'name'          =>  $request->input('name'),
                    'telephone'     =>  $request->input('telephone'),
                    'email'         =>  $request->input('email'),
                    'user_type_id'  =>  $request->get('user_type_id'),
                    'status'        =>  $request->input('status'),
                    'updated_at'    =>   now()
                ];

                if($request->get('user_type_id') == 2){
                    $user_data['balance'] = $request->input('balance');
                }

                if(!empty($request->input('password'))){
                    $user_data['password']  = Hash::make($request->input('password'));
                }
                
               
                try { 
                    if($request->path() == 'users/add'){
                        User::insert($user_data);
                    }else if($request->path() == 'users/edit'){
                        User::where('id', $request->get('id'))
                        ->update($user_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }

                if($request->path() == 'users/add'){
                    return redirect(route('users',['user_type_id'=>$request->get('user_type_id')]))->with('status', '<strong>Success:</strong> New user added!');
                }else{
                    return redirect(route('users',['user_type_id'=>$request->get('user_type_id')]))->with('status', '<strong>Success:</strong> User Info Updated!');
                }
                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $user = User::where('id',$request->id)->first();
                    unset($user->password);
                    $data['user'] = $user;
                }

                if($request->get('user_type_id') == 2 ){
                    $data['is_private_user'] = true;
                }else{
                    $data['is_private_user'] = false;
                }

                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }

        return view('user.userfrom',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                User::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('users')->with('status', '<strong>Success:</strong> ' . $i . 'Users Removed!');

    }

    public function balanceList(Request $request){
        $data = array();
        $balance = DB::table('user_balance')
          
            ->where('user_id',$request->get('user_id'));
    

        $data['balances'] = $balance->paginate(15);
        return view('user.balanceList',$data);
    }

    public function balanceForm(Request $request){
        $data = array();
        $data['action'] = route('addUserBalance');
        $data['user_id'] = $request->get('user_id');

        if($request->method() == 'POST'){
            $validation_data =  array();
            $validation_data['balance'] = 'required';

            $validated = $request->validate($validation_data);

            $note = !empty($request->input('note')) ?  ', ' . $request->input('note') : '';

            DB::table('user_balance')->insert(
                [
                    'user_id'       =>  $request->input('user_id'),
                    'balance'       =>  $request->input('balance'),
                    'description'   =>  'New Balance Added' . $note,
                    'action'        =>  '+'
                ]
            );

            $user = User::where('id',$request->input('user_id'))->first();
            $balance = $user->balance;
            $new_balance = (double)$balance + (double)$request->input('balance');

            User::where('id',$request->input('user_id'))->update(['balance'=>$new_balance]);


            return redirect()->route('userBalance',  ['user_id'=>$request->input('user_id')])->with('status', '<strong>Success:</strong> New balance added for user!');

        }


        return view('user.balanceForm',$data);
    }
}
