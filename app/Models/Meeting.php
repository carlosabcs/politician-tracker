<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    public function publicEmployee()
    {
        return $this->belongsTo(PublicEmployee::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function meetingable()
    {
        return $this->morphTo();
    }
}
