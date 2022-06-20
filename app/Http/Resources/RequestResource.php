<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'member_id' => $this->member_id,
            'request_type' => $this->request_type,
            'request_for_date' => $this->request_for_date,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'compensation_time' => $this->compensation_time,
            'compensation_date' => $this->compensation_date,
            'leave_all_day' => $this->leave_all_day,
            'leave_start' => $this->leave_start,
            'leave_end' => $this->leave_end,
            'leave_time' => $this->leave_time,
            'request_ot_time' => $this->request_ot_time,
            'reason' => $this->reason,
            'status' => $this->status,
            'manager_confirmed_status' => $this->manager_confirmed_status,
            'manager_confirmed_at' => $this->manager_confirmed_at,
            'manager_confirmed_comment' => $this->manager_confirmed_comment,
            'admin_approved_status' => $this->admin_approved_status,
            'admin_approved_at' => $this->admin_approved_at,
            'admin_approved_comment' => $this->admin_approved_comment,
            'error_count' => $this->error_count,
            'full_name' => $this->member->full_name,
            'email' => $this->member->email,
            'division_name' => $this->member->with('divisions')->first()->divisions->first()->division_name,
        ];
    }
}
