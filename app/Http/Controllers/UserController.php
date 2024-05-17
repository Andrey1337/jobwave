<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Specialization;
use App\Models\Profession;
use App\Models\Job;
use App\Models\Skill;
use App\Models\JobSkill;
use App\Models\Region;
use App\Models\Review;
use App\Models\Resume;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
   public function main(){
     // Получаем рандомные активные вакансии
    $randomVacancies = Job::where('status', 'Активна')->inRandomOrder()->limit(15)->get();
    
    $randomCompanies = Company::inRandomOrder()->take(12)->get(); 
     
    $randomVacancies->load('region');
    // Получаем идентификаторы показанных вакансий из переменной $randomVacancies
    $shownVacancyIds = $randomVacancies->pluck('id')->toArray();

    // Получаем еще 14 рандомных активных вакансий, исключая уже показанные
    $moreRandomVacancies = Job::where('status', 'Активна')
                              ->where('region_id', 1) // Фильтр по городу Москва
                              ->whereNotIn('id', $shownVacancyIds)
                              ->inRandomOrder()
                              ->limit(14)
                              ->get();

     // Передаем переменную $randomVacancies в представление
     return view('main_for_user', ['randomVacancies' => $randomVacancies, 'randomCompanies' => $randomCompanies, 'moreRandomVacancies' => $moreRandomVacancies]);
   }

   public function dashboard()
   {
    
    $user = auth()->user(); // Получаем текущего аутентифицированного пользователя

      if ($user) {
        $resumes = Resume::where('user_id', $user->id)->get(); // Получаем резюме для текущего пользователя
        return view('applicant.dashboard_user', compact('user', 'resumes'));
    } else {
        // Если пользователь не аутентифицирован, перенаправление на страницу входа
        return redirect()->route('applicant.login'); // Пример перенаправления на страницу входа
    }

   }



   public function updateStatus(Request $request)
   {
       // Валидация данных
       $validatedData = $request->validate([
           'user_id' => 'required|exists:users,id',
           'status' => 'required|in:Активно ищу работу,Рассматриваю предложения,Не ищу работу',
       ]);

       // Находим пользователя по ID
       $user = User::findOrFail($validatedData['user_id']);

       // Обновляем статус пользователя
       $user->status = $validatedData['status'];
       $user->save();

       // Возвращаем пользователя обратно на страницу и обновляем его статус
       return redirect()->back()->with('success', 'Статус пользователя успешно обновлён.');
   }
}
