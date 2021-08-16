<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicEmployee extends Model
{
    use HasFactory;

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function publicEntity()
    {
        return $this->belongsTo(PublicEntity::class);
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class);
    }

    public function morphMeetings()
    {
        return $this->morphMany(Meeting::class, 'meetingable');
    }
}
