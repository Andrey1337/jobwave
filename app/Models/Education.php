<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';

    protected $fillable = ['start_date', 'end_date', 'institution'];

    // Отношение "принадлежит одному" к модели Resume
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
