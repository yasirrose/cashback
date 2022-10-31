<?php

namespace App\Http\Controllers\Api;

use Validator;
use Carbon\Carbon;
use App\Models\fileUpload;
use App\Models\saveFileData;  
use App\Models\BusinessRecords;  
use App\Models\fileProcessLogs;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;


class ClientController extends BaseController
{
    public function getFileRecords(Request $request)
    {
        DB::enableQueryLog();
        $list = DB::table('words_list')->pluck('text');
        if(Auth::guard('api')->check()){
           $query = saveFileData::select('id', 'ownerLastName', 'ownerFirstName', 'dollarAmount', 'created_at');
           $data['data'] = $query->where('dollarAmount', '>=', $request->minClaimAmount)
           ->where('ownerFirstName','!=','')
           ->whereNotIn('ownerFirstName',$list)
           ->paginate($request->perPage);

           //Discareded Records
           $data['discarded_count'] = saveFileData::onlyTrashed()->count();

           //Business Records
           $data['business_count'] = BusinessRecords::count();
           return $this->sendResponse($data,true);
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function storeBusinessRecords(Request $request)
    {
        $list = DB::table('words_list')->pluck('text');
        if(Auth::guard('api')->check()){
           $data = saveFileData::select('propertyID','created_at','updated_at')
           ->where('dollarAmount', '>=', $request->minClaimAmount)
           ->where('ownerFirstName','')
           ->orWhereIn('ownerFirstName',$list)
           ->get();
           for($i = 0; $i < count($data); $i++){
               $storeData = new BusinessRecords();
               $storeData->propertyID = $data[$i]->propertyID;
               $storeData->created_at = $data[$i]->created_at;
               $storeData->updated_at = $data[$i]->updated_at;
               $count = $storeData->where('propertyID',$data[$i]->propertyID)->count();
               if($count == 0){
                   $storeData->save();
               }
           }
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function destroyRecords(Request $request){
        $data = $request->all();
        for($i = 0; $i < count($data); $i++){
            saveFileData::find($data[$i]['id'])->delete();
        }
        return $this->sendResponse('Record deleted successfully', 'Record deleted successfully!');
    }
    public function keepRecords(Request $request){
        $id_array = $request->all();
        for($i = 0; $i < count($id_array); $i++){
            $data = saveFileData::where('id',$id_array[$i]['id'])->first();
            $storeData = new BusinessRecords();
            $storeData->propertyID = $data->propertyID;
            $storeData->created_at = $data->created_at;
            $storeData->updated_at = $data->updated_at;
            $count = $storeData->where('propertyID',$data->propertyID)->count();
            if($count == 0){
                $storeData->save();
            }
        }
        return $this->sendResponse('Business Record added successfully', 'Business Record added successfully!');
    }

    public function uploadFile(Request $request)
    {
        if($request->file != 'null'){
            $mytime = Carbon::now();
            $date = $mytime->toDateString();
            $time = $mytime->toTimeString();
            $fileName = 'file-'.$date.'-'.time().'.'.$request->file->extension();
            $path = $request->file('file')->storeAs('files', $fileName);
            $fileUpload = new fileUpload;
            $fileUpload->file_name = $fileName;
            $fileUpload->user_id = Auth::guard('api')->user()->id;
            $fileUpload->is_processed = 0;
            $fileUpload->save();
            if($path){
                return $this->sendResponse('File Uploaded successfully', 'File Uploaded successfully');
            }else{
                return $this->sendError('Failed to upload file', 'Failed to upload file');    
            }
        }else{
            return $this->sendError('Please select file', 'Please select file');  
        }
    }

    public function getFileContents(Request $request){
        $fileUpload = fileUpload::get()->where('is_processed', '0')->first();
        if($fileUpload){
            $checkLogs = fileProcessLogs::where(['user_id' => $fileUpload->user_id, 'file_id' => $fileUpload->id])->first();
            if($checkLogs){
                $start = $checkLogs->total_processed;
                $end = $start * 2;
                $file_read_count = $checkLogs->file_hit_count + 1;
            }else{
                $start = 0;
                $end = 500999;
                $file_read_count = 1;
                $createLog = new fileProcessLogs;
            }
            $file = Storage::get('files/'.trim($fileUpload->file_name));
            $newArray = array();
            $scrapeChar = substr($file, $start, $end);
            array_push($newArray, $scrapeChar);
            $array = explode("\n", $newArray[0]);
            $process = array();
            foreach($array as $index => $value) {
                $data = array(
                    "ownerLastName" => (ctype_space(substr($value, 0, 40)) != "1") ? trim(substr($value, 0, 40)) : '',
                    "ownerFirstName" => (ctype_space(substr($value, 40, 30)) != "1") ? trim(substr($value, 40, 30)) : '',
                    "ownerAddressLine1" => (ctype_space(substr($value, 70, 30)) != "1") ? trim(substr($value, 70, 30)) : '',
                    "ownerAddressLine2" => (ctype_space(substr($value, 100, 30)) != "1") ? trim(substr($value, 100, 30)) : '',
                    "ownerAddressLine3" => (ctype_space(substr($value, 130, 30)) != "1") ? trim(substr($value, 130, 30)) : '',
                    "ownerCity" => (ctype_space(substr($value, 160, 30)) != "1") ? trim(substr($value, 160, 30)) : '',
                    "ownerState" => (ctype_space(substr($value, 190, 2)) != "1") ? trim(substr($value, 190, 2)) : '',
                    "ownerZipcode" => (ctype_space(substr($value, 192, 9)) != "1") ? trim(substr($value, 192, 9)) : '',
                    "holderReportYear" => (ctype_space(substr($value, 201, 4)) != "1") ? trim(substr($value, 201, 4)) : '',
                    "propertyType" => (ctype_space(substr($value, 205, 4)) != "1") ? trim(substr($value, 205, 4)) : '',
                    "propertyID" => (ctype_space(substr($value, 209, 19)) != "1") ? trim(substr($value, 209, 19)) : '',
                    "begTransacDate" => (ctype_space(substr($value, 228, 10)) != "1") ? trim(substr($value, 228, 10)) : '',
                    "endTransacDate" => (ctype_space(substr($value, 238, 10)) != "1") ? trim(substr($value, 238, 10)) : '',
                    "dollarAmount" => (ctype_space(substr($value, 248, 10)) != "1") ? trim(substr($value, 248, 10)) : '',
                    "numOfShareRemitd" => (ctype_space(substr($value, 258, 12)) != "1") ? trim(substr($value, 258, 12)) : '',
                    "reportDate" => (ctype_space(substr($value, 270, 10)) != "1") ? trim(substr($value, 270, 10)) : '',
                    "holderName" => (ctype_space(substr($value, 280, 40)) != "1") ? trim(substr($value, 280, 40)) : '',
                    "holderAddressLine1" => (ctype_space(substr($value, 320, 30)) != "1") ? trim(substr($value, 320, 30)) : '',
                    "holderAddressLine2" => (ctype_space(substr($value, 350, 30)) != "1") ? trim(substr($value, 350, 30)) : '',
                    "holderAddressLine3" => (ctype_space(substr($value, 380, 30)) != "1") ? trim(substr($value, 380, 30)) : '',
                    "holderCity" => (ctype_space(substr($value, 410, 30)) != "1") ? trim(substr($value, 410
                        , 30)) : '',
                    "holderState" => (ctype_space(substr($value, 440, 2)) != "1") ? trim(substr($value, 440, 2)) : '',
                    "holderZipCode" => (ctype_space(substr($value, 442, 9)) != "1") ? trim(substr($value, 442, 9)) : '',
                    "addedDate" => (ctype_space(substr($value, 451, 10)) != "1") ? trim(substr($value, 451, 10)) : '',
                    "updatedDate" => (ctype_space(substr($value, 461, 10)) != "1") ? trim(substr($value, 461, 10)) : '',
                    "mostRecentClaimDate" => (ctype_space(substr($value, 471, 30)) != "1") ? trim(substr($value, 471, 30)) : '',
                    "filler" => (ctype_space(substr($value, 501, 19)) != "1") ? trim(substr($value, 501, 19)) : '',
                );
                array_push($process, $data);
            }
            for($count=0; $count<count($process); $count++){
                $record = saveFileData::create(
                    $process[$count]
                );
            }
            $createLog->file_name = trim($fileUpload->file_name);
            $createLog->file_size_total = strlen($file);
            $createLog->total_processed = trim($end);
            $createLog->remaining_to_process = strlen($file) - trim($end);
            $createLog->file_hit_count = $file_read_count;
            $createLog->user_id = trim($fileUpload->user_id);
            $createLog->file_id = trim($fileUpload->id);
            $createLog->save();
            return $this->sendResponse('Records fetched successfully', 'Success');
        }else{
            return $this->sendError('No file found', 'Error');
        }
    }
}
