<?php

namespace App\Services;
use App\Models\User;
use App\Models\Hash;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class CurrencyService{
    protected $token='cur_live_81BYHyLjG95GhLsgqRtkRcJZ7UclRdRagHC51NAw';
    protected $api_endpoint='https://api.currencyapi.com/v3/latest?apikey=';
    protected $currencies=['PLN', 'UAH','EUR','CZK','DKK','GBP'];
    public function getArray(){
        return $this->currencies;   
    }
    public function updatecourse(){
        $url=$this->api_endpoint.$this->token.'&currencies=PLN%2CUAH%2CEUR%2CCZK%2CDKK%2CGBP';
        try{
            $response=Http::get($url);
           // dd($response->json());
            //$body_currencies=$response->json();
            //$response->json();
            //https://api.currencyapi.com/v3/currencies?apikey=cur_live_81BYHyLjG95GhLsgqRtkRcJZ7UclRdRagHC51NAw&currencies=PLN%2CUAH%2CEUR%2CCZK%2CDKK%2CGBP
            //return $body_currencies;
            //dd($body_currencies);
            $data_decoded=json_decode($response, true);
            
            $data_course=$data_decoded['data'];
            
            $array_courses=[];
            foreach ($this->currencies as $currency) {
                foreach ($data_course as $data_cur) {
                    
                    //echo 'currency '.$currency."data_cur ".$data_cur['code'];
                    if($currency==$data_cur['code']){
                      
                        $currency_el=Currency::where('name',$currency)->first();
                        //dd($currency_el);
                        $currency_el->course=round($data_cur['value'],2);
                        //dd(round($data_cur['value'],2));
                        //return response()->json($data_cur['value'],2);
                        $array_courses[$currency]=round($data_cur['value'],2);
                        
                        $currency_el->save();
                        
                    }
                }
            }
            $currencies_arr=Currency::all();
            return response()->json($currencies_arr);
            //dd($array_courses);
            //return response()->json($data_course);
            //https://api.currencyapi.com/v3/latest?apikey=cur_live_81BYHyLjG95GhLsgqRtkRcJZ7UclRdRagHC51NAw&currencies=PLN%2CUAH%2CEUR%2CUSD%2CCZK%2CDKK
            //https://api.currencyapi.com/v3/latest?apikey=cur_live_81BYHyLjG95GhLsgqRtkRcJZ7UclRdRagHC51NAw&currencies=EUR%2CUSD%2CCZK%2CPLN%2CUAH
        }catch(\Throwable $th){
            $result['error']=$th->getMessage();
        }
    }

}