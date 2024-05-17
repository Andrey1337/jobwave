<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'start_date',
        'end_date',
        'company_name',
        'description',
    ];

    // Определяем отношение к модели Resume
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
