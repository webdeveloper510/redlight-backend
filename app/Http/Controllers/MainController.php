<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{    
        public function register(Request $request){
            $validated = $request->validate([
                'role_id'=>'required',
                'first_name'=>'required',
                'last_name'=>'required',
                'email'=>'required|email|unique:users',
                'username'=>'required',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6'
            ]);  

           $users = User::create([
                'role_id'=>$request->role_id,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'username'=>$request->username,
                'password'=>Hash::make($request->password)         
            ]);
    
            return response()->json([
                'status' => 'User has been created successfully!',
                'data'  => $users         
            ]);            
        }
    
        public function login(Request $request){
            if(Auth::attempt($request->only('username', 'password'))){ 
                return response()->json([
                    'status' => 'Logged In'
                ]); 
            }
            return response()->json([
                'status' => 'Your credentials are incorrect!'
            ]);         
        }
        
       public function allUsers(){
            $user = User::all(); 
            if(count($user)>0){
                return response()->json([
                    'status' => 1,
                    'data' => $user
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'data' => 'Users not exists !'                  
                ]);              
            }
        }
        
        
       public function updateUserStatus(Request $request){
            $user_id = $request->user_id;
            $status = $request->status;    

            $user = User::where('id', $user_id)->update(['status'=> $status]);
            if($user){
                return response()->json([
                    'message'=> 'User approved successfully!'
                ]);            
            }else{
                return response()->json([                 
                    'message' => 'Users not exists !'                  
                ]);              
            }
        }   


    }
    

