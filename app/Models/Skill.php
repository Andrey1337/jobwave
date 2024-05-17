<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name'];
    protected $primaryKey = 'id'; // Указываем имя столбца, который является первичным ключом

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    // Отношение "принадлежит многим" к модели Resume
    public function resumes()
    {
        return $this->belongsToMany(Resume::class);
    }
}
