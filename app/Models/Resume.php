<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime; // Добавляем использование класса DateTime

class Resume extends Model
{
    protected $fillable = [
        'job_title',
        'willing_to_relocate',
        'willing_to_travel',
        'desired_salary_min',
        'desired_salary_max',
        'about_me',
        'citizenship',
        'commute_time',
        'work_schedule',
        'employment_type',
        'specialization_id',
    ];

    // Один ко многим: Опыт работы
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    // Один ко многим: Образование
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    // Многие ко многим: Навыки
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resumes_skills');
    }


     // Определите отношение к языкам
     public function languages()
     {
        return $this->belongsToMany(Language::class, 'resume_languages', 'resume_id', 'language_id');
    }

    // Определение связи с таблицей специализаций
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateExperience()
{
    // Получаем все опыты работы для данного резюме
    $workExperiences = $this->workExperiences;

    // Вычисляем общий опыт работы на основе дат начала и окончания работы
    $totalExperience = 0;
    foreach ($workExperiences as $workExperience) {
        $startDate = new DateTime($workExperience->start_date);
        $endDate = new DateTime($workExperience->end_date);
        $interval = $startDate->diff($endDate);
        $totalExperience += $interval->y; // Предположим, что опыт работы измеряется в годах
    }

    // Возвращаем общий опыт работы
    return $totalExperience >= 1 ? 'От ' . $totalExperience . ' лет' : 'Меньше года';
}
}
