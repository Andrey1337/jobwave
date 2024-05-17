<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeSkill extends Model
{
    use HasFactory;

    protected $table = 'resumes_skills';

    protected $fillable = [
        'resume_id',
        'skill_id',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    /**
     * Определение отношения "многие ко многим" к модели Skill.
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
