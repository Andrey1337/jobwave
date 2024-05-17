<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        
        'company' => [ // Добавляем сторож 'company' в блок 'guards'
            'driver' => 'session',
            'provider' => 'companies', // Указываем провайдер для компаний
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'companies' => [ // Добавляем провайдер 'companies'
            'driver' => 'eloquent',
            'model' => App\Models\Company::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
