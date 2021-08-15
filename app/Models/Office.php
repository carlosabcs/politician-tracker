<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class);
    }

    public function publicEntity()
    {
        return $this->belongsTo(PublicEntity::class);
    }
}
