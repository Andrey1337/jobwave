<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'company'; // Указываем guard для модели

    protected $fillable = [
        'name', 'description', 'industry', 'company_size', 'city', 'company_type', 'logo', 'email', 'password', 'updated_at', 'created_at', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function responses()
    {
        return $this->hasManyThrough(Response::class, Job::class);
    }

}
