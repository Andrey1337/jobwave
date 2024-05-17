<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'description', 'required_experience', 'selected_skills', 'salary', 'company_id', 'specialization_id', 'profession_id',

    'schedule', 'income_level', 'region', 'education', 'employment_type'


    ];

    public function setSalaryFromAttribute($value)
    {
        $this->attributes['salary_from'] = $value; // Устанавливаем значение salary_from

        if ($value < 20000) {
            $this->attributes['income_level'] = 'Не имеет значения';
        } elseif ($value < 35000) {
            $this->attributes['income_level'] = 'от 20 000₽';
        } elseif ($value < 50000) {
            $this->attributes['income_level'] = 'от 35 000₽';
        } elseif ($value < 75000) {
            $this->attributes['income_level'] = 'от 50 000₽';
        } elseif ($value < 100000) {    
            $this->attributes['income_level'] = 'от 75 000₽';
        } else {
            $this->attributes['income_level'] = 'от 100 000₽';
        }
    }
    
    
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills');
    }

    
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    

    // Метод для фильтрации вакансий по региону
    public function scopeByRegion($query, $regions)
    {
        return $query->whereIn('region', $regions);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
