<?php

namespace App\Http\Controllers\Api;

use Hash;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\AppLink;
use App\Models\UserLog;
use App\Models\Keywords;
use App\Models\fileUpload;
use App\Models\UserDetail;
use App\Models\CashbackOffer;
use App\Models\AppSetting;
use App\Models\saveFileData;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\fileProcessLogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\MAil\SendMail;
use Illuminate\Support\Facades\Mail;
   


class AdminController extends BaseController
{
    public function getAdminInfo(Request $request)
    {

   		if(Auth::guard('api')->check()){
   			if(Auth::guard('api')->user()->is_admin == 1){
   				$user = Auth::guard('api')->user();
   				return $this->sendResponse($user, 'user is admin');
   			}else{
   				return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
   			}
   		}else{
   			return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
   		}
    }
	public function updateAdminInfo(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), [
				'email' => 'required|email|unique:users,email,'.Auth::guard('api')->user()->id,
				'first_name' => 'required',
				'last_name' => 'required',
				'username' => 'required|unique:users,username,'.Auth::guard('api')->user()->id,
			]);
	   
			if($validator->fails()){
				return $this->sendError('Validation Error.', $validator->errors());       
			}
			
			$adminUser = User::where('id', Auth::guard('api')->user()->id)->first();
			if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image = time().'.'.$file->getClientOriginalName();
				if($file->move(public_path('image'),$image))
				{
					$adminUser->image  = $image;
				}
				//return response()->json(['status'=>422,'message' =>$request->file('image')]);
			}
			$adminUser->username = $request->username;
			$adminUser->first_name = $request->first_name;
			$adminUser->last_name = $request->last_name;
			$adminUser->email = $request->email;
			if($adminUser->save())
			{
				//$success['user_id'] =  $adminUser->id;
	   
				return $this->sendResponse($adminUser, 'Profile updated successfully.');
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
    }
	public function updatePassword(Request $request)
    {
		try {
			$validator = Validator::make($request->all(), [
				'old_password' => 'required',
				'password' => 'required|same:confirm_password',
				'confirm_password' => 'required',
			]);
	   
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			if(Auth::attempt(['email' => Auth::guard('api')->user()->email, 'password' => $request->old_password])){ 
				if($request->password == $request->confirm_password){
					$adminUser = User::where('email', Auth::guard('api')->user()->email)->first();
					$adminUser->password = bcrypt($request->password);
					$adminUser->save();
					$success['user_id'] =  $adminUser->id;
					return $this->sendResponse($success, 'Password changed successfully.');
				}else{
					return $this->sendError('mismatched', 'Please make sure new and confirm password is same');    
				}
			}else{
				return $this->sendError('old password invalid', 'Cannot verify old password');
			}
		  } catch (\Exception $e) {
			  return $e->getMessage();
		}
    }
	public function updateEmail(Request $request)
	{
		try{
			$validator = Validator::make($request->all(), [
				'email' => 'required|same:repeat_email',
				'repeat_email' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			
			if($request->email == $request->repeat_email){
				$adminUser = User::where('email', Auth::guard('api')->user()->email)->first();
				$adminUser->email = $request->email;
				$adminUser->save();
				$success['user_id'] =  $adminUser->id;
				return $this->sendResponse($success, 'Email updated successfully.');
			}else{
				return $this->sendError('Something goes wrong', 'Cannot update data');
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getAppLinks(){
		try {
			$data = AppLink::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUserLogs(){
		try {
			$data = UserLog::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUsers(){
		try {
			$data = User::where('is_admin','!=',1)->orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function createUser(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|email|unique:users',
				'first_name' => 'required',
				'last_name' => 'required',
				'username' => 'required',
			]);
			if($request->isRandomPassword == 1){
				$request->password = bcrypt(rand(1000,100000));
			} else {
				$validator = Validator::make($request->all(), [
					'email' => 'required|email|unique:users',
					'first_name' => 'required',
					'last_name' => 'required',
					'username' => 'required',
					'password' => 'required|same:confirm_password',
					'confirm_password' => 'required',
				]);
				$request->password = bcrypt($request->password);
			}
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$user = New User;
			$user->email = $request->email;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->username = $request->username;
			$user->status = $request->status;
			$user->password = $request->password;
			if($user->save()){
				$this->sendMail($user->username, $user->email);
				return $this->sendResponse($user,'Data has been updted');
			} else {
				return $this->sendResponse('Something goes wrong',false);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function updateProfileInfo(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'first_name' => 'required',
				'last_name' => 'required',
				'username' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
		$user = User::find(Auth::guard('api')->user()->id);
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->username = $request->username;
		if($user->save()){
			// $user = UserDetail::firstOrNew(array('user_id' => Auth::guard('api')->user()->id));
			// $user->organization_name = $request->organization_name;
			// $user->billing_address = $request->billing_address;
			// $user->type = $request->type;
			// $user->save();
			return $this->sendResponse($user,'Data has been updated');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function deleteUser($id){
		try{
			$delete_user = User::where('id', $id)->delete();
		return $this->sendResponse($delete_user,"User was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function deleteMultiUsers(Request $request){
		try{
			foreach($request->all() as $user_data)
			{
				$user_id[] = $user_data['id'];
			}
			$delete_user = User::whereIn('id', $user_id)->delete();
		return $this->sendResponse($delete_user,"Selected record was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUserProfile($id){
		try {
			$data = User::where('id',$id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateUserProfile(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'first_name' => 'required',
				'last_name' => 'required',
				'username' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
		$user = User::find($request->id);
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->username = $request->username;
		if($user->save()){
			// $user = UserDetail::firstOrNew(array('user_id' => Auth::guard('api')->user()->id));
			// $user->organization_name = $request->organization_name;
			// $user->billing_address = $request->billing_address;
			// $user->type = $request->type;
			// $user->save();
			return $this->sendResponse($user,'Data has been updated');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function sendMail($name, $email)
	{
		Mail::to($email)->send(new SendMail($name, $email));
		return true;
	}
	public function addCashback(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'user_id' => 'required',
				'amount' => 'required',
				'affiliate_url' => 'required',
			
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$cashback = New CashbackOffer;
			$cashback->user_id = $request->user_id;
			$cashback->amount = $request->amount;
			$cashback->affiliate_url = $request->affiliate_url;
		
			if($cashback->save()){
				return $this->sendResponse($cashback,'Data has been updted');
			} else {
				return $this->sendResponse(false,'Something goes wrong');
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getCashbacks(){
		try {
			$data = CashbackOffer::select('cashback_offers.*','users.email')->join('users',
					'users.id', '=', 'cashback_offers.user_id')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function deleteCashback($id){
		try{
			$delete_cashback = CashbackOffer::where('id', $id)->delete();
		return $this->sendResponse($delete_cashback,"Cashback record was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function deleteMultiCashbacks(Request $request){
		try{
			foreach($request->all() as $cashback_data)
			{
				$cashback_id[] = $cashback_data['id'];
			}
			$delete_cashback = CashbackOffer::whereIn('id', $cashback_id)->delete();
		return $this->sendResponse($delete_cashback, "Selected record was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateAppSetting(Request $request){
		//return response()->json(['status'=>422,'message' =>$request->all()]);
		try {
			$validator = Validator::make($request->all(), [
				
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$logo = null;
			if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image = time().'.'.$file->getClientOriginalName();
				if($file->move(public_path('image'),$image))
				{
					$logo = $image;
				}
				//return response()->json(['status'=>422,'message' =>$request->file('image')]);
			}
			
			$app_setting = AppSetting::firstOrNew(['id' => 1]);
 
			$app_setting->logo = $logo;
			
		if($app_setting->save()){
		
			return $this->sendResponse($app_setting,'Data has been updated');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//sample function
	public function uploadFile(Request $request){
		try{
			
			if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image = time().'.'.$file->getClientOriginalName();
				$file->move(public_path('image'),$image);

				return response()->json(['status'=>422,'message' =>$request->file('image')]);
			}
			else{
				return response()->json(['status'=>422,'message' =>'file not found']);
			}
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getAppSetting($id){
		try {
			$data = AppSetting::first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getCashback($id){
		try {
			$data = CashbackOffer::where('id', $id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateCashback(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				
				'amount' => 'required',
				'affiliate_url' => 'required',
				'user_id' => 'required',
				'id' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
		$cashback = CashbackOffer::find($request->id);
		$cashback->amount = $request->amount;
		$cashback->affiliate_url = $request->affiliate_url;
		$cashback->user_id = $request->user_id;
		if($cashback->save()){
		
			return $this->sendResponse($cashback,'Data has been updated');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function addStore(Request $request){
		//return response()->json(['status'=>422,'message' =>$request->all()]);
		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'title' => 'required',
				'percentage' => 'required',
				'featured' => 'required',
				'image' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$logo = null;
			if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image = time().'.'.$file->getClientOriginalName();
				if($file->move(public_path('image'),$image))
				{
					$logo = $image;
				}
				//return response()->json(['status'=>422,'message' =>$request->file('image')]);
			}
			
			$store = new Store;
			$store->name = $request->name;
			$store->title = $request->title;
			$store->percentage = $request->percentage;
			$store->featured = $request->featured;
			$store->image = $logo;
			
		if($store->save()){
		
			return $this->sendResponse($store,'Data was saved successfully');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getStores(){
		try {
			$data = Store::all();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getStore($id){
		try {
			$data = Store::where('id', $id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function deleteStore($id){
		try{
			$store = Store::where('id', $id)->delete();
		return $this->sendResponse($store,"Store was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function deleteMultiStores(Request $request){
		try{
			foreach($request->all() as $store_data)
			{
				$store_id[] = $store_data['id'];
			}
			$store = Store::whereIn('id', $store_id)->delete();
		return $this->sendResponse($store, "Selected record was deleted successfully!");
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateStore(Request $request){
		//return response()->json(['status'=>422,'message' =>$request->all()]);
		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'title' => 'required',
				'percentage' => 'required',
				'featured' => 'required',
				
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}

			$store = Store::find($request->id);

			if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image = time().'.'.$file->getClientOriginalName();
				if($file->move(public_path('image'),$image))
				{
					$logo = $image;
				}
				$store->image = $logo;
				//return response()->json(['status'=>422,'message' =>$request->file('image')]);
			}
			$store->name = $request->name;
			$store->title = $request->title;
			$store->percentage = $request->percentage;
			$store->featured = $request->featured;

		if($store->save()){
		
			return $this->sendResponse($store,'Data was updated successfully');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getCashbacksS(Request $request){
		try {
			$count_data = CashbackOffer::where('cashback_offers.id', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('cashback_offers.amount', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('cashback_offers.affiliate_url', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('users.email', 'LIKE', '%' . $request->searchTerm . '%')
			->select('cashback_offers.*','users.email')->join('users',
			'users.id', '=', 'cashback_offers.user_id')
			->get();
			$count = count($count_data);
			$page = $request->page;
			$page = $page - 1;
			$perPage = $request->perPage;

			$table = 'cashback_offers.';
			$field = $request->sort[0]['field'];
			$sort_type = $request->sort[0]['type'];
			
			if($field == 'action')
			{
				$field = 'id';
			}
			if($field == 'email')
			{
				$table = 'users.';
			}
			if($sort_type != 'asc' && $sort_type != 'desc')
			{
				$sort_type = 'desc';
			}
			$data = CashbackOffer::where('cashback_offers.id', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('cashback_offers.amount', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('cashback_offers.affiliate_url', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('users.email', 'LIKE', '%' . $request->searchTerm . '%')
			->select('cashback_offers.*','users.email')->join('users',
			'users.id', '=', 'cashback_offers.user_id')
			->skip($page*$perPage)->take($perPage)
			->orderBy($table.$field, $sort_type)
			->get();
			$all_data = ['rows'=>$data, 'total_records'=>['count'=>$count], 'search_param'=>$request->searchTerm];

			return $this->sendResponse($all_data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getStoresS(Request $request){
		try {
			$count_data = Store::where('id', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('name', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('title', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('percentage', 'LIKE', '%' . $request->searchTerm . '%')
			->get();
			$count = count($count_data);
			$page = $request->page;
			$page = $page - 1;
			$perPage = $request->perPage;

			$field = $request->sort[0]['field'];
			$sort_type = $request->sort[0]['type'];
			
			if($field == 'action')
			{
				$field = 'id';
			}
			if($sort_type != 'asc' && $sort_type != 'desc')
			{
				$sort_type = 'desc';
			}


			$data = Store::where('id', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('name', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('title', 'LIKE', '%' . $request->searchTerm . '%')
			->orWhere('percentage', 'LIKE', '%' . $request->searchTerm . '%')
			->skip($page*$perPage)->take($perPage)
			->orderBy($field, $sort_type)
			->get();
			$all_data = ['rows'=>$data, 'total_records'=>['count'=>$count], 'search_param'=>$request->searchTerm];

			return $this->sendResponse($all_data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUsersS(Request $request){
		try {
			$data = User::where('is_admin','!=',1)->orderBy('id','desc')->get();

			$count_data = User::where(function ($query) use ($request) {
				$query->where('id', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('first_name', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('last_name', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('username', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('email', 'LIKE', '%' . $request->searchTerm . '%');
			})->where(function ($query) {
				$query->where('is_admin','!=',1);
			})->get();
			
			$count = count($count_data);
			$page = $request->page;
			$page = $page - 1;
			$perPage = $request->perPage;

			$field = $request->sort[0]['field'];
			$sort_type = $request->sort[0]['type'];

			if($field == 'action')
			{
				$field = 'id';
			}
			if($sort_type!= 'asc' && $sort_type != 'desc')
			{
				$sort_type = 'desc';
			}

			$data = User::where(function ($query) use ($request) {
				$query->where('id', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('first_name', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('last_name', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('username', 'LIKE', '%' . $request->searchTerm . '%')
				->orWhere('email', 'LIKE', '%' . $request->searchTerm . '%');
			})->where(function ($query) {
				$query->where('is_admin','!=',1);
			})->skip($page*$perPage)->take($perPage)
			->orderBy($field, $sort_type)
			->get();
			$all_data = ['rows'=>$data, 'total_records'=>['count'=>$count], 'search_param'=>$request->searchTerm];

			return $this->sendResponse($all_data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	


}