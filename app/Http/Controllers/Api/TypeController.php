<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\StatusClass;

use App\Http\Resources\StatusResource;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types_arr=Type::all()->select('name','id');
        return response()->json($types_arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->user()!=NULL){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:types',
                
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $type=Type::create([
                'name'=>$request->name,
                'user_id'=>$request->user()->id
            ]);
            $answer=new StatusClass;

            $answer->success=true;
            $answer->element_name='type';
            $answer->element=$type;
            

            return StatusResource::make($answer);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"You're not authentificated",
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        if($request->user()!=NULL&& $type->user_id=$request->user()->id){
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:types',
                'type_id'=>'required|',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $type->name=$request->name;
            $type->update();
            return response()->json([
                'success'=>true,
                'message'=>'Type successfully updated',
                'type'=>$type
            ]);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"You're not authentificated",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Type $type)
    {
        if($request->user()!=NULL&& $type->user_id=$request->user()->id){
            
            if(app('check_access')->checkDelete($type,'type',$request->user())){

                $type->delete();
                return response()->json([
                    'success'=>true,
                    'message'=>'Type successfully deleted',
                    
                ]);
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>"Type wasn't deleted",

                ]);
            }
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"You're not authentificated",
            ]);
        }
    }
}
