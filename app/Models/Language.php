<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name']; // Поля, которые можно заполнять

    // Определение отношения между языками и резюме (многие к многим)
    public function resumes()
    {
        return $this->belongsToMany(Resume::class);
    }
}
