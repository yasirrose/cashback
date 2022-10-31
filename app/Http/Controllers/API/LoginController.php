<?php

namespace App\Http\Controllers\API;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
         
            'email' => 'required|email',
            'password' => 'required',

        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;

            $cookie_name = "secret";
            $cookie_token = $success['token'];
            setcookie($cookie_name, $cookie_token, time() + 3600, "/");
   
            return $this->sendResponse($success, 'Login successfully.');
        } 
        else{ 
            return $this->sendError(['status'=>false,'message'=>'Unauthorized']);
        } 
    }

    public function logout(Request $request){
        setcookie('secret', '', time() + 3600, "/");
       return $this->sendResponse('Logged Out', 'Logged out successfully.');
    }
    
    public function all_users(Request $request){
        $users = User::where('id', '!=', auth()->id())->get();
        return response()->json($users, 200);
    }

    public function delete_user($id){

        $delete_user = User::where('id', $id)->first();
        $delete_user->is_active = 0;
        $delete_user->save();
        return response()->json(null, 204);
    }

    public function update_user(Request $request, $user_email){
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
        ]);
        
        $user = User::where('id',Auth::user()->id)->first();
        
        $data=[
            'name'=> $request->name,
            'email'=> $request->email,
        ];
        
        if($request->password !=''){
            $data['password'] =\Hash::make($request->password);   
        }

        $user=User::where('id',Auth::user()->id)->update($data);
        if($user){
            return response()->json(['error' => false ,'message'=>'Profile Updated'], $this->successStatus);
        }else{
            return response()->json(['error' => true ,'message'=>'Something went wrong please try again'], $this->successStatus); 
        }
    }
}
