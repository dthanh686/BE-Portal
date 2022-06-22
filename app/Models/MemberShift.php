<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberShift extends Model
{
    use HasFactory;

    protected $table = 'member_shift';
    public $fillable = [
        'shift_id',
    ];
    public $timestamps = false;

    public function shifts()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function authorInfo()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
}
