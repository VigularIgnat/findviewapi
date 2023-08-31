<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\StatusClass;

use App\Http\Resources\StatusResource;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types_arr=Type::select('name','id')->get();
        return response()->json($types_arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $answer=new StatusClass;
        $answer->success=false;
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
            $answer->message='Type successfully added';
            
            
            
        }
        else{
            $answer->message="You're not authentificated"; 
        }
        return StatusResource::make($answer);
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $answer=new StatusClass;
        $answer->success=false;
        
        if($request->user()!=NULL&& $type->user_id=$request->user()->id){
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:types',
                'type_id'=>'required|',
            ]);
            $type_el_exists=Type::where('id',$request->type_id)->exists();

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            if($type_el_exists){
                
                $type_el=Type::where('id',$request->type_id)->get();
                return response()->json($type_el);
                $type_el->name=$request->name;
                $type_el->update();
                $answer->success=true;
                $answer->message='Type successfully updated';
            }
            

        }
        else{
            $answer->message="You're not authentificated"; 
        }
        return StatusResource::make($answer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Type $type)
    {
        $answer=new StatusClass;
        if($request->user()!=NULL&& $type->user_id==$request->user()->id){
            
            if(app('check_access')->checkDelete($type,'type',$request->user())){

                $type->delete();
                $answer->success=true;
                $answer->message='Type successfully deleted';
            }
            else{
                
                $answer->message='Type is unavailable to delete';
            }
        }
        else{
            $answer->message="You're not authentificated";

        };
        return StatusResource::make($answer);
    }

    
}
