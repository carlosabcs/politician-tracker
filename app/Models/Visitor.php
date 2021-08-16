<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public function morphMeetings()
    {
        return $this->morphMany(Meeting::class, 'meetingable');
    }
}
