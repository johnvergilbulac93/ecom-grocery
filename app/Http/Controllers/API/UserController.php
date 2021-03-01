<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\store;
use App\gc_usertype;
use App\gc_employee;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function getusers(Request $request)
    {

        $columns = ['id','name', 'username', 'usertype_id','bunit_code'];

        $length = $request->input('length');
        $column = $request->input('column'); 
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_users')
                    ->join('user_types','gc_users.usertype_id','=','user_types.id')
                    ->join('locate_business_units','gc_users.bunit_code','=','locate_business_units.bunit_code')
                    ->select('gc_users.id','gc_users.emp_id','gc_users.bunit_code','gc_users.usertype_id','user_types.usertype','gc_users.name','gc_users.username','locate_business_units.business_unit')
                    ->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        return ['data' => $projects, 'draw' => $request->input('draw')];

    }
    public function getUsersAdmin(){

        return User::where('bunit_code','=',Auth::user()->bunit_code)->where('usertype_id','!=',12)->get();
    }

    public function usertype(){
        return gc_usertype::where('type','=',2)->orwhere('type','=',0)->get();
    }
    public function usertypeAdmin(){
        return gc_usertype::where('id','!=',12)->where('type','=',2)->get();
    }
    public function getStores(){
        return store::all();
    }
    public function delete_user($id){
        $user = User::where('id', '=', $id);
        $user->delete();
    }
    public function add_user(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'string', 'max:255','unique:users,username' ],
            'usertype' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ]);      

        if
        (  $request->get('usertype') == 6  || 
           $request->get('usertype') == 12 || 
           $request->get('usertype') == 15 || 
           $request->get('usertype') == 16 || 
           $request->get('usertype') == 17 || 
           $request->get('usertype') == 8  || 
           $request->get('usertype') == 14
        )
        {
            $user_add_data = array(
                'name'      => $request->get('name'),
                'username'  => $request->get('username'),
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
                'usertype_id' => $request->get('usertype'),
                'bunit_code'   => Auth::user()->bunit_code,
                'emp_id'     => $request->get('employee'),
                'isAdmin'       => true
            );
        }else{
            $user_add_data = array(
                'name'      => $request->get('name'),
                'username'  => $request->get('username'),
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
                'usertype_id' => $request->get('usertype'),
                'bunit_code'   => Auth::user()->bunit_code,
                'emp_id'     => $request->get('employee'),
                'isAdmin'      => false
                
            );
        }
        User::insert($user_add_data);
    }
    public function edit_user(Request $request,$id){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'string', 'max:255', ],
            'usertype' => ['required'],
        ]);

        if
        (  $request->get('usertype') == 6  || 
           $request->get('usertype') == 12 || 
           $request->get('usertype') == 15 || 
           $request->get('usertype') == 16 || 
           $request->get('usertype') == 17 || 
           $request->get('usertype') == 8  || 
           $request->get('usertype') == 14
        )
        {

            if($request->get('password') != ''){
                $user_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($request->get('password')),
                    'password2'  => md5($request->get('password')),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => Auth::user()->bunit_code,
                    'emp_id'     => $request->get('employee'),
                    'isAdmin'      => true
                );
            }
            else
            {
                $user_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => Auth::user()->bunit_code,
                    'isAdmin'      => true
                );
            }

        }
        else{

            if($request->get('password') != ''){
                $user_data = array(
                    'name'          => $request->get('name'),
                    'username'      => $request->get('username'),
                    'password'      => Hash::make($request->get('password')),
                    'password2'     => md5($request->get('password')),
                    'usertype_id'   => $request->get('usertype'),
                    'bunit_code'    => Auth::user()->bunit_code,
                    'emp_id'        => $request->get('employee'),
                    'isAdmin'       => false
                );
            }
            else
            {
                $user_data = array(
                    'name'          => $request->get('name'),
                    'username'      => $request->get('username'),
                    'usertype_id'   => $request->get('usertype'),
                    'bunit_code'    => Auth::user()->bunit_code,
                    'emp_id'        => $request->get('employee'),
                    'isAdmin'       => false
                );
            }

        }
        User::where('id','=',$id)->update($user_data);

    
       
    }


    public function add_super_user(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'string', 'max:255','unique:users,username' ],
            'usertype' => ['required'],
            'store' => ['required'],
        ]);

        $default_password = 'alturush2020';

        if($request->get('password'))
        {
            if
            (  $request->get('usertype') == 6  || 
               $request->get('usertype') == 12 || 
               $request->get('usertype') == 15 || 
               $request->get('usertype') == 16 || 
               $request->get('usertype') == 17 || 
               $request->get('usertype') == 8  || 
               $request->get('usertype') == 14
            )
            {
            
                $user_add_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($request->get('password')),
                    'password2'  => md5($request->get('password')),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   =>  $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => true
                );
            }
            else
            {
                $user_add_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($request->get('password')),
                    'password2'  => md5($request->get('password')),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   =>  $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => false
                );
            }
        }
        else
        {
            if
            (  $request->get('usertype') == 6  || 
               $request->get('usertype') == 12 || 
               $request->get('usertype') == 15 || 
               $request->get('usertype') == 16 || 
               $request->get('usertype') == 17 || 
               $request->get('usertype') == 8  || 
               $request->get('usertype') == 14
            )
            {
            
                $user_add_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($default_password),
                    'password2'  => md5($default_password),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   =>  $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => true
                );
            }
            else
            {
                $user_add_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($default_password),
                    'password2'  => md5($default_password),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   =>  $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => false
                );
            }
        }

        User::insert($user_add_data);

    }

    public function edit_super_user(Request $request, $id){

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'usertype' => ['required'],
            'store' => ['required'],
        ]);

        if
        (  $request->get('usertype') == 6  || 
           $request->get('usertype') == 12 || 
           $request->get('usertype') == 15 || 
           $request->get('usertype') == 16 || 
           $request->get('usertype') == 17 || 
           $request->get('usertype') == 8  || 
           $request->get('usertype') == 14
        )
        {

            if($request->get('password') != ""){
                
                $user_edit_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($request->get('password')),
                    'password2'  => md5($request->get('password')),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => true
                );
         
            }

            else{

                $user_edit_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => true,

                );
            }

        }
        else{

            if($request->get('password') != ""){

                $user_edit_data = array(                
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'password'  => Hash::make($request->get('password')),
                    'password2'  => md5($request->get('password')),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => false
                );
            }
            else
            {
                $user_edit_data = array(
                    'name'      => $request->get('name'),
                    'username'  => $request->get('username'),
                    'usertype_id' => $request->get('usertype'),
                    'bunit_code'   => $request->get('store'),
                    'emp_id'     => $request->get('emp_id'),
                    'isAdmin'      => false
                );
            }

        }

        User::where('id','=',$id)->update($user_edit_data);

    }

    public function delete_super_user($id)
    {
        $uom = User::where('id', '=', $id);
        $uom->delete();

    }
    public function employees(Request $request)
    {

        $query = $request->get('query');
        $employees = gc_employee::where('name','like','%'.$query.'%')->get();

        return $employees;
    }

    public function updateprofile(Request $request)
    {
        // $this->validate($request, [
        //     'username' => ['required'],
        // ]);
        // 
        if($request->get('username'))
        {
            $user_profile = array(
                'username'  => $request->get('username'),
            );
        }
        if($request->get('password'))
        {
            $user_profile = array(
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
            );
        }
        if($request->get('username') && $request->get('password') )
        {
            $user_profile = array(
                'username'  => $request->get('username'),
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
            );
        }
        User::where('id','=',Auth::user()->id)->update($user_profile);


    }



}
