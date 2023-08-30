<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IndexDataRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\City;
use App\Models\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 
use App\Http\Resources\IndexDataResource;

class IndexDataController extends Controller
{
   
    public function index(Request $request,$hash,$letter){
    
        if($hash!=''&&Str::length($hash)==32&&$letter!=''){
            //return response()->json(app('currency_service')->updatecourse());
            $hash_el=Hash::where('hash',$hash)->exists();
            if($hash_el){
                $hash_model=Hash::where('hash',$hash)->get();
                if (Gate::allows('check_hash', $hash_model)) {
                    return response()->json([
                        'message' => 'No permissions'
                    ]);
                }
                else{
                    $result=Country::join('cities', 'countries.id', '=','cities.country_id')
                    ->where('countries.name', 'like', '%'.$letter.'%')
                    ->orwhere('cities.name', 'like', '%'.$letter.'%')
                    ->select('cities.id as city_id','countries.name as country_name','cities.name as city_name')
                    ->get();
                    //return response()->json(app('currency_service')->updatecourse());
                    
                    return response()->json($result);
                    //return IndexDataResource::make($result);
                }
            }
            
            
        }
        
    }


}
