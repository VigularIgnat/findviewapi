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
        if($this->element!=NULL){
            return [
                'success' => $this->success,
                'message' => $this->message,
                'element'=>$this->element_name,
                'user'=>$this->element
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
