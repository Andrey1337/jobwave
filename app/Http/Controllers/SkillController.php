<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Контроллер для получения списка навыков
    public function getSkills()
    {
        $skills = Skill::select('id', 'name')->get();
        return response()->json($skills);
    }
}
