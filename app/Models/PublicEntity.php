<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicEntity extends Model
{
    use HasFactory;

    public function publicEmpoyees()
    {
        return $this->belongsToMany(PublicEmployee::class);
    }
}
