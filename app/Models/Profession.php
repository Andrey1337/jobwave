<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $fillable = ['specialization_id', 'name'];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
