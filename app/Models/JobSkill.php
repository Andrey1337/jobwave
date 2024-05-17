<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    use HasFactory;

    protected $table = 'job_skills'; // Указываем имя таблицы, если оно отличается от соглашения по именованию
    protected $fillable = ['job_id', 'skill_id']; // Указываем заполняемые поля

    // Описываем связь с моделью Job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Описываем связь с моделью Skill
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
