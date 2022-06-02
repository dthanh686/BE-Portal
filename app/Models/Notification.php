<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        dd($this->attributes);
    }

    protected $attributes = [
        'published_to' => 'all'
    ];

    protected $appends = ['full_name'];
    public function __get($key)
    {
        return $this->getAttribute($key);
    }
    public function getFullNameAttribute() {
//        dd($this);

        return "{$this->subject} {$this->message}";
    }

    public function author()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }

}
