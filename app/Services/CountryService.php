<?php

namespace App\Services;
use App\Models\Country;

use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class CountryService{

    public function getcountry($name){
        //dd($name);
        $success=false;
        $country=$name;
        $currency_model_return=null;
        $message="Country doesn't exist";
        $url="https://restcountries.com/v3.1/name/".$name;
        try{
            $response=Http::get($url);
            
            $data_decoded=json_decode($response, true);
            //var_dump($data_decoded);
            $data_course=$data_decoded[0];
            $data_course=$data_course['currencies'];
            //var_dump($data_course!=NULL);
            if($data_course!=NULL){
                $data_course=$data_decoded[0];
                $data_course=$data_course['currencies'];
                //var_dump($data_course);
                $currency;
                foreach ($data_course as $key => $value) {
                    $currency=$key;
                    
                }
                $currency_model_exist=Currency::where('name',$currency)->exists();
                if($currency_model_exist){
                    
                    $currency_model=Currency::where('name',$currency)->select('name','id')->get();
                    //dd($currency_model);
                    $success=true;
                    $currency_model_return=$currency_model;
                    $message="The currency of this country";
                }
                else{
                   $message="Currrency doesn't support";
                }
            
            }
            
            
        }catch(\Throwable $th){
            $result['error']=$th->getMessage();
        }
        return [
            'success'=>$success,
            'country'=>$country,
            'currency'=>$currency_model_return,
            'message'=>$message
        ];
    }

}