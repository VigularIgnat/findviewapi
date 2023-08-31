<?php

namespace App\Services;
use App\Models\User;
use App\Models\Hash;
use App\Models\Place;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class CheckService{
    protected $typeElements=[
        ['element'=>'currency', 'delete'=>false],
        ['element'=>'country', 'delete'=>false],
        ['element'=>'hash', 'delete'=>false],
        ['element'=>'user', 'delete'=>false],
        ['element'=>'type', 'delete'=>true],
        ['element'=>'city', 'delete'=>true],
        ['element'=>'place', 'delete'=>true],
    ];
    public function checkDelete($el, $type_el,User $user){
        $access=false;
        foreach ($this->typeElements as $typeElement) {
            if($typeElement['element']==$type_el){
                if($typeElement['delete']){
                    if($el->user_id==$user->id){
                        switch ($type_el) {
                            case 'type':
                                $place_exist=Place::where('type_id',$el->id)->exists();
                                $access=!$place_exist;
                                break;
                            case 'city':
                                $place_exist=Place::where('city_id',$el->id)->exists();
                                $access=!$place_exist;
                                break;
                        }
                    }
                }
            }
            
        }
        return $access;
    }

    

}