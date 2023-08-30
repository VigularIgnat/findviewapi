<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $element;
        if($request->element!=NULL){
            $element=$this->element;
            $element_name=$this->element_name;
            return [
                'success' => $this->success,
                'message' => $this->message,
                $element_name=>$this->element
                
            ];
        }
        else{
            return [
                'success' => $this->success,
                'message' => $this->message                
            ];
        }
        
    }
}
