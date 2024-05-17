<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['name'];

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }

    // Отношение "принадлежит многим" к модели Resume
    public function resumes()
    {
        return $this->belongsToMany(Resume::class);
    }
}
