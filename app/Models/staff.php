<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function present()
    {
        return $this->hasMany(present::class);
    }

    public function shiff()
    {
        return $this->belongsTo(Time::class);
    }
}
