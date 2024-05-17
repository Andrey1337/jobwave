<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Specialization;
use App\Models\Profession;
use App\Models\Job;
use App\Models\Skill;
use App\Models\Region;
use App\Models\JobSkill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class VacancyController extends Controller
{

   
    public function create_vacancy_view(){

        $regions = Region::all();
        $specializations = Specialization::with('professions')->get();
        $skills = Skill::all(); // Получаем список всех навыков
        return view('emp.create_vacancy', ['specializations' => $specializations, 'skills' => $skills, 'regions' => $regions]);
    }


    public function getProfessions($specialization_id) {
        // Здесь вы можете извлечь профессии для указанной специализации и вернуть их в формате JSON
        // Например:
        $professions = Profession::where('specialization_id', $specialization_id)->get();
        return response()->json($professions);
    }

    

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'required_experience' => 'required|in:Не имеет значения,От 1 года до 3 лет,Нет опыта,От 3 до 6 лет,Более 6 лет',
            'selected_skills_array.*' => 'required|exists:skills,id',
            'salary_from' => 'required|numeric|min:20000',
            'salary_to' => 'required|numeric',
            'specialization_id' => 'required|exists:specializations,id',
            'profession_id' => 'required|exists:professions,id',
            'schedule' => 'required|in:Полный день,Сменный график,Удаленная работа,Гибкий график,Вахтовый метод',
            'region_id' => 'required|exists:regions,id', // Используем region_id
            'education' => 'required|in:Не требуется или не указано,Высшее,Среднее профессиональное',
            'employment_type' => 'required|in:Полная занятость,Частичная занятость,Стажировка,Волонтерство',
        ], [
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'description.required' => 'Поле "Описание" обязательно для заполнения.',
            'required_experience.required' => 'Поле "Опыт работы" обязательно для заполнения.',
            'selected_skills_array.required' => 'Поле "Требуемые навыки" обязательно для заполнения.',
            'selected_skills_array.*.exists' => 'Один или несколько выбранных навыков недействительны.',
            'salary_from.required' => 'Поле "Зарплата от" обязательно для заполнения.',
            'salary_from.numeric' => 'Поле "Зарплата от" должно быть числовым значением.',
            'salary_from.min' => 'Минимальная зарплата должна быть не менее 20000.',
            'salary_to.required' => 'Поле "Зарплата до" обязательно для заполнения.',
            'salary_to.numeric' => 'Поле "Зарплата до" должно быть числовым значением.',
            'specialization_id.required' => 'Поле "Специализация" обязательно для заполнения.',
            'specialization_id.exists' => 'Выбранная специализация недействительна.',
            'profession_id.required' => 'Поле "Профессия" обязательно для заполнения.',
            'profession_id.exists' => 'Выбранная профессия недействительна.',
        ]);


        
    
        if (empty($request->selected_skills_array)) {
            return redirect()->back()->withErrors(['selected_skills_array' => 'Выберите хотя бы один навык.']);
        }
    
        if (!$request->has('salary_to')) {
            $request->merge(['salary_to' => $request->salary_from]);
        }
    
        // Получаем текущую авторизованную компанию
        $company = Auth::guard('company')->user();
    
        // Получаем текущий уровень подписки компании
        $subscriptionLevel = $company->subscription_level;

        // Если подписка "Бесплатный", проверяем количество созданных вакансий
        if ($subscriptionLevel === 'Бесплатный') {
            // Получаем текущее количество вакансий у компании
            $currentVacancyCount = Job::where('company_id', $company->id)->count();

            // Проверяем, не превышает ли количество созданных вакансий максимально допустимое (5)
            if ($currentVacancyCount >= 5) {
                // Если превышает, создание новой вакансии запрещено
                return redirect()->back()->withErrors(['message' => 'Вы уже создали максимально допустимое количество вакансий.']);
            }
        }

         // Проверяем, что выбранный регион существует в базе данных
         $region = Region::findOrFail($request->region_id);


        // Создаем новую вакансию в базе данных с учетом company_id
        $vacancy = new Job();
        $vacancy->title = $request->title;
        $vacancy->description = $request->description;
        $vacancy->required_experience = $request->required_experience;
        $vacancy->salary_from = $request->salary_from; // Используем salary_from напрямую
        $vacancy->salary_to = $request->salary_to;
        $vacancy->specialization_id = $request->specialization_id;
        $vacancy->profession_id = $request->profession_id;
        $vacancy->company_id = $company->id; // Присваиваем значение company_id
        $vacancy->status = 'Активна';
        $vacancy->schedule = $request->schedule; // Добавляем расписание работы
        $vacancy->region_id = $region->id;
        $vacancy->education = $request->education; // Добавляем образование
        $vacancy->employment_type = $request->employment_type; // Добавляем тип занятости
        $vacancy->save();
        
        // Job::increment('job_count');


        // Связываем выбранные навыки с вакансией
        $selectedSkills = json_decode($request->selected_skills_array);
        $vacancy->skills()->attach($selectedSkills);

        // После успешного создания вакансии, добавьте уведомление в сессию
        Session::flash('success', 'Вакансия успешно создана!');
        // Перенаправьте пользователя на страницу с вакансиями
        return redirect()->route('vacancy_list');
    }
    
    public function changeStatus(Request $request, $id)
{
    $vacancy = Job::findOrFail($id);
    
    // Проверяем текущий статус вакансии и меняем его
    if ($vacancy->status === 'Активна') {
        $vacancy->status = 'В архиве';
    } else {
        $vacancy->status = 'Активна';
    }
    
    $vacancy->save();

    return redirect()->back()->with('success', 'Статус вакансии успешно изменен.');
}

public function destroy(Job $vacancy)
{
    // Удаляем связанные с вакансией навыки
    $vacancy->skills()->detach();

    // Удаляем вакансию
    $vacancy->delete();

    // Возвращаем пользователя на страницу со списком вакансий
    return redirect()->route('vacancy_list')->with('success', 'Вакансия успешно удалена.');
}


}
