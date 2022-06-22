<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'member_id' => $this->member->id,
            'member_name' => $this->member->full_name,
            'email' => $this->member->email,
            'division_name' => $this->member->divisions->first()->division_name,
            'shift_id' => $this->shifts->id,
            'shift_name' => $this->shifts->shift_name,
            'check_in' => $this->shifts->check_in,
            'check_out' => $this->shifts->check_out,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'free_check' => $this->free_check,
            'part_time' => $this->part_time,
            'note' => $this->note,
            'created_by' => $this->authorInfo->full_name,
            'created_at' => $this->created_at,
        ];
    }
}
