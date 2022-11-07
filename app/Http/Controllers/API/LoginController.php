<?php

namespace App\Http\Controllers\API;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin'=>1])){ 
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['username'] =  $user->username;
            $success['is_admin'] =  $user->is_admin;
            $success['id'] =  $user->id;
            $success['image'] =  $user->image;

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

    public function forgotPassword(Request $request)
    {
        try{
            $request->validate(['email' => 'required|email']);
 
            $status = Password::sendResetLink(
            $request->only('email')
            );
    
            return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
