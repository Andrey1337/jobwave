<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all(); // Получаем список языков из базы данных
        return response()->json($languages); // Возвращаем список языков в формате JSON
    }
}
