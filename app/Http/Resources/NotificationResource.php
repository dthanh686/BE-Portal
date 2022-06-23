<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'published_date' => $this->published_date,
            'subject' => $this->subject,
            'status' => $this->status,
            'attachment' => $this->attachment,
            'published_to' => $this->published_to,
            'status' => $this->status,
            'message' => $this->message,
            'created_by' => $this->authorInfo->full_name,
            'author_email' => $this->authorInfo->email,
            'author_other_email' => $this->authorInfo->other_email,
            'author_phone' => $this->authorInfo->phone,
        //     'division_name' => $this->authorInfo->divisions->first()->division_name,
        //     'id_divison' => $this->authorInfo->divisions->first()->id,
         ];
    }
}
