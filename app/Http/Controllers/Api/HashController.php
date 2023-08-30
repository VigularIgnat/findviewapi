<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Hash;
use App\Models\User;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HashController extends Controller
{
    public function gethash(User $user){
        if($user!==NULL){
            if($user->api_access){
                $hash_response=app('hash_service')->hashsetup($user);
                return $hash_response;
            }
        }
        else{
            return response()->json([
                'message' => 'You are not authentificated',
            ]);
        }
    }
}
