<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Specialization;
use App\Models\Profession;
use App\Models\Job;
use App\Models\Skill;
use App\Models\JobSkill;
use App\Models\Resume;
use App\Models\Region;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTime; // Добавляем использование класса DateTime


class EmployerController extends Controller
{
    public function main(){
        return view("main_for_emp");
    }

    public function dashboard_view(){
        $company = Auth::guard('company')->user();

        return view('emp.dashboard_employer', ['company' => $company]);
    }

    public function vacancys_view(){
        $company = Auth::guard('company')->user();
        
        $allVacancies = $company->jobs()->paginate(20);
        $vacancies = $company->jobs()->where('status', 'Активна')->paginate(20);
        $archivedVacancies = $company->jobs()->where('status', 'В архиве')->paginate(20);
        return view('emp.vacancy_list', compact('vacancies','archivedVacancies','allVacancies'));
    }
    
    public function search_main_view(){
        $regions = Region::all();
        $vacancies = Job::where('status', 'Активна')->paginate(10); // Получаем только активные вакансии

        // Получаем количество всех вакансий
        $countVacancies = count($vacancies);

        // Определяем тип пользователя
        if (Auth::guard('company')->check()) {
            // Если пользователь аутентифицирован как компания, устанавливаем тип пользователя как работодатель
            $userType = 'employer';
        } elseif (Auth::guard('web')->check()) {
            // Если пользователь аутентифицирован через стандартный сторож и не компания, считаем его соискателем
            $userType = 'job_seeker';
        } else {
            // Если пользователь не аутентифицирован, устанавливаем тип пользователя как гость
            $userType = 'guest';
        }
        // Передаем переменные в представление
        return view('search_main', [
            'regions' => $regions, 
            'vacancies' => $vacancies,
            'countVacancies' => $countVacancies,// Передаём количество вакансий
            'userType' => $userType,
        ]);
    }

    public function profile($companyId)
    {
        $company = Company::findOrFail($companyId);
        $reviews = Review::where('company_id', $companyId)->get();
        $vacancies = Job::where('company_id', $companyId)->get();
    
    return view('emp.profile', compact('company', 'reviews', 'vacancies'));
    }

    public function show($id)
    {
        $vacancy = Job::findOrFail($id); // Получаем данные о вакансии по ID
        // Получаем список резюме текущего пользователя (пример)
        $resumes = auth()->check() ? Resume::where('user_id', auth()->user()->id)->get() : [];
        // Получаем список всех вакансий, исключая текущую
        $otherVacancies = Job::where('id', '!=', $id)->inRandomOrder()->take(6)->get();

        // Перемешиваем список вакансий в рандомном порядке
        $randomVacancies = $otherVacancies->shuffle();

        // Передаем данные в представление
        return view('show', [
            'vacancy' => $vacancy,
            'randomVacancies' => $randomVacancies,
            'resumes' => $resumes,
            'job_id' => $id, // Передаем $id как $job_id в представление
            'user_id' => auth()->check() ? auth()->user()->id : null, // Передаем ID текущего пользователя, если он авторизован
        ]);

    }

    public function loadMoreRegions(Request $request)
    {
        // Получаем номер начального региона, который нужно загрузить
        $start = $request->query('start', 0);
    
        // Загружаем дополнительные регионы начиная с указанного номера
        $regions = Region::skip($start)->take(5)->get();
    
        // Возвращаем регионы в формате JSON
        return response()->json($regions);
    }

        public function loadMoreRegionsSidebar(Request $request)
    {
        $start = $request->query('start', 0);
        $regions = Region::skip($start)->take(5)->get();
        return response()->json($regions);
    }

    public function resetFilters()
    {
        // Очистка сессионных данных с фильтрами
        session()->forget(['selected_regions', 'selected_schedules', 'selected_income_levels', 'selected_educations', 'selected_employment_types']);
    
        // Перенаправление обратно на страницу поиска
        return redirect()->route('search_main');
    }
    

    public function vacanciesByRegion(Request $request)
    {
    // Получаем значение региона из запроса
    $regionId = $request->input('region_id');
    
    // Получаем вакансии для указанного региона
    $jobs = Job::where('region_id', $regionId)
                        ->where('status', 'Активна') // Предположим, что у вакансии есть статус
                        ->paginate(10);
    // Получаем список всех регионов (если необходимо)
    $regions = Region::all();

    // Получаем количество отфильтрованных вакансий
    $countVacancies = $jobs->count();

    // Передача вакансий, регионов и количества вакансий в представление
    return view('search_main', ['vacancies' => $jobs, 'regions' => $regions, 'countVacancies' => $countVacancies]);
    }

    public function vacanciesBySpecialization(Request $request)
{
    // Получаем значение specialization_id из запроса
    $specializationId = $request->input('specialization_id');
    
    // Получаем вакансии для указанной специализации
    $jobs = Job::where('specialization_id', $specializationId)
                        ->where('status', 'Активна') // Предположим, что у вакансии есть статус
                        ->paginate(10); // Предположим, что мы хотим пагинировать результаты
    
    // Получаем список всех регионов
    $regions = Region::all();

     // Получаем количество отфильтрованных вакансий
     $countVacancies = $jobs->count();

     // Передача вакансий, регионов и количества вакансий в представление
     return view('search_main', ['vacancies' => $jobs, 'regions' => $regions, 'countVacancies' => $countVacancies]);
}

    public function search(Request $request)
    {

    // Получаем данные из запроса
    $selectedRegions = $request->input('regions');
    $selectedSchedules = $request->input('schedule');
    $selectedIncomeLevels = $request->input('income_level');
    $selectedEducations = $request->input('education');
    $selectedExperience = $request->input('required_experience');
    $selectedEmploymentTypes = $request->input('employment_type');
    $searchQuery = $request->input('search_query'); // Добавляем получение поискового запроса

    // Начинаем строить запрос для фильтрации вакансий
    $jobs = Job::query()->where('status', 'Активна'); // Добавляем условие для выборки только активных вакансий


    // Фильтрация по регионам
    if (!empty($selectedRegions)) {
        $jobs->whereIn('region_id', $selectedRegions);
    }

    // Фильтрация по графику работы
    if (!empty($selectedSchedules)) {
        $jobs->whereIn('schedule', $selectedSchedules);
    }

     
    // Определяем диапазоны для каждого уровня дохода
    $incomeLevelRanges = [
        'от 20 000₽' => [20000, PHP_INT_MAX],
        'от 35 000₽' => [35000, PHP_INT_MAX],
        'от 50 000₽' => [50000, PHP_INT_MAX],
        'от 75 000₽' => [75000, PHP_INT_MAX],
        'от 100 000₽' => [100000, PHP_INT_MAX],
    ];

   // Фильтрация по уровню дохода
   if (!empty($selectedIncomeLevels)) {
    $jobs->where(function ($query) use ($selectedIncomeLevels, $incomeLevelRanges) {
        foreach ($selectedIncomeLevels as $incomeLevel) {
            if (isset($incomeLevelRanges[$incomeLevel])) {
                $range = $incomeLevelRanges[$incomeLevel];
                $query->orWhereBetween('salary_from', $range);
            }
        }
    });
}

    // Фильтрация по образованию
    if (!empty($selectedEducations)) {
        $jobs->whereIn('education', $selectedEducations);
    }
    
    // Фильтрация по опыту работы
    if (!empty($selectedExperience)) {
        $jobs->whereIn('required_experience', $selectedExperience);
    }

    // Фильтрация по типу занятости
    if (!empty($selectedEmploymentTypes)) {
        $jobs->whereIn('employment_type', $selectedEmploymentTypes);
    }

    // Если указан поисковой запрос, применяем его
    if (!empty($searchQuery)) {
        $jobs->where(function($query) use ($searchQuery) {
            $query->where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%')
                ->orWhereHas('company', function($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                });
        });
    }

    // Получаем отфильтрованные вакансии
    $jobs = $jobs->paginate(10);

    // Получаем список всех регионов
    $regions = Region::all();

    $countVacancies = $jobs->count();

    // Передаем отфильтрованные данные и список регионов в представление
    return view('search_main', ['vacancies' => $jobs, 'regions' => $regions, 'countVacancies' => $countVacancies]);
}

    

    public function addReview(Request $request, $companyId)
    {
    $request->validate([
        'employee_profession' => ['required', 'string', 'max:255'],
        'stars' => ['required', 'integer', 'min:1', 'max:5'],
        'description' => ['required', 'string'],
    ], [
            'employee_profession.required' => 'Поле "Профессия сотрудника" обязательно для заполнения.',
            'stars.required' => 'Поле "Оценка" обязательно для заполнения.',
            'description.required' => 'Поле "Описание" обязательно для заполнения.',
        ]);

    $review = new Review();
    $review->company_id = $companyId;
    $review->employee_profession = $request->employee_profession;
    $review->stars = $request->stars;
    $review->description = $request->description;
    $review->save();

    return redirect()->route('emp.profile', ['companyId' => $companyId])
                     ->with('success', 'Отзыв успешно добавлен.');
    }



    public function candidates()
{
     // Получаем текущего работодателя
     $employer = Auth::guard('company')->user();
    
     // Получаем список всех откликов на вакансии текущего работодателя
     $responses = $employer->responses()->with(['resume.user'])->get();
 
     return view('emp.candidates', ['responses' => $responses]);
}



public function process(Request $request)
{
    // Получаем ID компании из сессии или из другого места
    $companyId = Auth::guard('company')->id();

    // Обновляем подписку компании
    $company = Company::findOrFail($companyId);
    $company->subscription_level = 'Расширенный'; // Или какое-то другое значение, обозначающее расширенную подписку
    $company->save();

    // После успешного обновления подписки
    // Вы можете выполнить другие действия, например, редирект на страницу с подтверждением

    // Возвращаем ответ пользователю
    return redirect()->route('dashboard_employer')->with('success', 'Подписка успешно обновлена.');
}

public function cancel_subscribe(Request $request)
{
    // Получаем ID компании из сессии или из другого места
    $companyId = Auth::guard('company')->id();

    // Обновляем подписку компании
    $company = Company::findOrFail($companyId);
    $company->subscription_level = 'Бесплатный'; // Или какое-то другое значение, обозначающее расширенную подписку
    $company->save();

    // Возвращаем ответ пользователю
    return redirect()->route('dashboard_employer')->with('success', 'Подписка успешно отменена.');
}
}
