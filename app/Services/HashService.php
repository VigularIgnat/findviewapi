<?php

namespace App\Services;
use App\Models\User;
use App\Models\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

class HashService{
    protected $hash;
    protected $user;
    public function hashsetup(User $user){
        if($user!=NULL){
            $this->user=$user;
            if($this->user->api_access){
                $data=Hash::where('user_id',$user->id)->select('user_id')->exists();
                if(!$data){
                    $hash=Str::random(32);
                    
                    $mutable = Carbon::now();
                    $data_valid=$mutable->add(1, 'year');
                    $data_valid=$data_valid->format('Y-m-d');
                    $hash_el=Hash::create([
                        'hash'=>$hash,
                        'user_id'=>$user->id,
                        'valid'=>$data_valid
                    ]);
                    return ([
                        'success'=>true,
                        'message' => 'Hash created successfully',
                        'hash' => $hash_el,
                    ]);
                }
                else{
                    return ([
                        'success'=>false,
                        'message' => 'Hash already been created',
                    ]);
                }
            }
        }
        else{
            return ([
                'success'=>false,
                'message' => 'No permissions',
            ]);
        }
        
    }

    public function checkhash(User $user,$hash){
        if($user!=NULL){
            $this->user=$user;
            if($this->user->api_access){
                $data=Hash::where('hash',$hash)->select('user_id')->exists();
                if($data){
                    $data_el=Hash::where('hash',$hash)->select('user_id')->get();
                    return $data_el;
                }
                else{
                   return $data_el=[];
                }
            }
        }
        else{
            return ([
                'success'=>false,
                'message' => 'No permissions',
            ]);
        }
        
    
    }
   
}