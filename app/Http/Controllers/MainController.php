<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Reviewer;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerifyMail;
use Mail;

class MainController extends Controller
{    
        public function register(Request $request){
         
                $request->validate([
                'role_id'=>'required',
                'first_name'=>'required',
                'email'=>'required|email|unique:users',
                'username'=>'required',
                'zip_code' => 'required',
                'password' => 'required|min:6',              
                'confirm_password' => 'required|min:6'
            ]);  


           $users = User::create([
                'role_id'=>$request->role_id,
                'first_name'=>$request->first_name,              
                'email'=>$request->email,
                'username'=>$request->username,
                'zip_code'=>$request->zip_code,
                'password'=>Hash::make($request->password)
            ]);  
            return response()->json([
                'status' => 'User has been created successfully!',
                'data'  => $users         
            ]);           

        }

    

        public function login(Request $request){
            if(Auth::attempt($request->only('email', 'password'))){ 
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
            $id = $request->id;
            $status = $request->status;


            $user = User::where('id', $id)->update(['status'=> $status]);
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

        public function createReviewer(Request $request){
                $request->validate([
                'reviewer_id'=>'required',
                'email'=>'required|email',
                'zip_code'=>'required'
            ]);

            $reviewer = Reviewer::create([
                'reviewer_id'=>$request->reviewer_id,
                'email'=>$request->email,
                'zip_code'=>$request->zip_code               
            ]);    
            return response()->json([
                'status' => 'Reviewer has been created successfully!',
                'data'  => $reviewer        
            ]); 
            
        }

        public function createProvider(Request $request){
            echo "<pre>";
            print_r($request->all());die;
            
                $request->validate([
                    'email'=>'required|email',
                    'sms'=>'required',
                    'zip_code'=>'required',
                    'city'=>'required',
                    'height'=>'required',
                    'weight'=>'required',
                    'hair_color'=>'required',
                    'bust_size'=>'required',
                    'cup_size'=>'required',
                    'dress_size'=>'required',
                    'profile_claimed'=>'required',
                    'profile_id'=>'required',
                    'gallery'=>'required',
                    'advertisement_url'=>'required'
                ]);

                $provider = Provider::create([
                    'email'=>$request->email,
                    'sms'=>$request->sms,
                    'zip_code'=>$request->zip_code,
                    'city'=>$request->city,
                    'height'=>$request->height,
                    'weight'=>$request->weight,
                    'hair_color'=>$request->hair_color,
                    'bust_size'=>$request->bust_size,
                    'cup_size'=>$request->cup_size,
                    'dress_size'=>$request->dress_size,
                    'profile_claimed'=>$request->profile_claimed,
                    'profile_id'=>$request->profile_id,
                    'gallery'=>$request->gallery,
                    'advertisement_url'=>$request->advertisement_url
                ]);  
                return response()->json([
                    'status' => 'Provider has been created successfully!',
                    'data'  =>  $provider        
                ]);  
        }


    }

    



