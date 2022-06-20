<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public $fillable = [
        'member_id',
        'request_for_date',
        'request_type',
        'check_in',
        'check_out',
        'compensation_time',
        'compensation_date',
        'reason',
        'status',
        'request_ot_time',
        'compensation_date',
        'compensation_time',
        'leave_all_day',
        'leave_start',
        'leave_end',
        'leave_time',
        'request_ot_time',
        'manager_confirmed_status',
        'manager_confirmed_at',
        'manager_confirmed_comment',
        'admin_approved_status',
        'admin_approved_at',
        'admin_approved_comment',
        'error_count',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // public function divisions()
    // {
    //     return $this->hasManyThrough('Division::class','DivisionMember::class');
    // }
}
