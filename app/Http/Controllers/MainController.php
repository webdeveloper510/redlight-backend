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
use Carbon\Carbon;

class MainController extends Controller
{    
        public function register(Request $request){
        //  echo "<pre>";
        //  print_r($request->all());die;
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
            $id = $request->id;        
            $ip_address = $request->ip();
            $last_login = Carbon::now();
            $user = User::where('id', $id)->update(['ip_address'=> $ip_address, 'last_login'=>$last_login]);

            if(Auth::attempt($request->only('email', 'password'))){ 
                return response()->json([
                    'status' => 'Logged In',
                    'ip_address' => $ip_address
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

        public function createProvider(Request $request){    
            
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
               
                ]);               
                // echo "<pre>";
                // print_r($request->all());die;          
               if($files = $request->image1){                    
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $upload_path = 'public/image/';
                $image_url1 = $upload_path.$image_full_name;
                $file->move($upload_path,$image_full_name);                   
                                    
               }
               if($files = $request->image2){                     
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $upload_path = 'public/image/';
                $image_url2 = $upload_path.$image_full_name;
                $file->move($upload_path,$image_full_name);                   
                                
               }
                if($files = $request->image3){                   
                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name.'.'.$ext;
                    $upload_path = 'public/image/';
                    $image_url3 = $upload_path.$image_full_name;
                    $file->move($upload_path,$image_full_name);                   
                                
               }

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
                    'image1'=>$request->image1,
                    'image2'=>$request->image2,
                    'image3'=>$request->image3,
                    'advertisement_url1'=>$request->advertisement_url1,
                    'advertisement_url2'=>$request->advertisement_url2,
                    'advertisement_url3'=>$request->advertisement_url3,

                ]);  
                return response()->json([
                    'status' => 'Provider has been created successfully!',
                    'data'  =>  $provider        
                ]);  
        }


    }

    



