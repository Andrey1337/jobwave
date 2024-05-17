<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Skill;
use App\Models\WorkExperience;
use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Education;
use App\Models\User;
use App\Models\Job;
use App\Models\Response;
use App\Models\Profession;
use Illuminate\Support\Facades\Auth;



class ResumeController extends Controller
{
      public function showCreateForm()
    {
        $specializations = Specialization::all(); // Получаем список специализаций
        $skills = Skill::all(); // Получаем список всех навыков из базы данных
        $employmentTypes = ['полная занятость', 'частичная занятость', 'стажировка'];
        $workSchedules = ['полный день', 'гибкий график', 'удаленная работа'];

        return view('applicant.create_resume', compact('specializations', 'skills', 'employmentTypes', 'workSchedules'));
    }

    public function create(Request $request)
    {
        
    // Валидация данных
    $request->validate([
        'job_title' => 'required|string|max:100',
        'willing_to_relocate' => 'required|in:готов к переезду,не готов к переезду',
        'willing_to_travel' => 'required|in:готов к командировкам,не готов к командировкам',
        'employment_type' => 'required|array',
        'work_schedule' => 'required|array',
        'specialization_id' => 'required|exists:specializations,id',
        'profession_id' => 'required|exists:professions,id', // Добавлено новое правило для profession_id
        'desired_salary_min' => 'nullable|numeric|min:0',
        'desired_salary_max' => 'nullable|numeric|min:0',
        'about_me' => 'nullable|string',
        'citizenship' => 'nullable|string|max:100',
        'commute_time' => 'nullable|in:менее часа,около часа,не имеет значения',
        'selected_skills_array.*' => 'required|exists:skills,id',
        'work_experiences.*.start_date' => 'required|date',
        'work_experiences.*.end_date' => 'required|date',
        'work_experiences.*.company' => 'required|string|max:255',
        'work_experiences.*.description' => 'required|string',
        'languages.*' => 'nullable|exists:languages,id',
        'educations.*.start_date' => 'required|date',
        'educations.*.end_date' => 'required|date|after_or_equal:educations.*.start_date',
        'educations.*.institution' => 'required|string|max:100',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Максимальный размер файла 2 МБ
    ], [
        'job_title.required' => 'Поле "Название должности" обязательно для заполнения.',
        'willing_to_relocate.required' => 'Поле "Готов к переезду" обязательно для заполнения.',
        'willing_to_travel.required' => 'Поле "Готов к командировкам" обязательно для заполнения.',
        'employment_type.required' => 'Поле "Тип занятости" обязательно для заполнения.',
        'work_schedule.required' => 'Поле "График работы" обязательно для заполнения.',
        'specialization_id.required' => 'Поле "Специализация" обязательно для заполнения.',
        'profession_id.required' => 'Поле "Профессия" обязательно для заполнения.',
        'desired_salary_min.numeric' => 'Поле "Желаемая минимальная зарплата" должно быть числовым.',
        'desired_salary_max.numeric' => 'Поле "Желаемая максимальная зарплата" должно быть числовым.',
        'about_me.string' => 'Поле "О себе" должно быть строкой.',
        'citizenship.string' => 'Поле "Гражданство" должно быть строкой.',
        'citizenship.max' => 'Поле "Гражданство" не должно превышать :max символов.',
        'commute_time.in' => 'Поле "Время на дорогу" должно быть одним из: менее часа, около часа, не имеет значения.',
        'selected_skills_array.required' => 'Поле "Требуемые навыки" обязательно для заполнения.',
        'selected_skills_array.*.exists' => 'Один или несколько выбранных навыков недействительны.',
        'work_experiences.*.start_date.required' => 'Поле "Дата начала работы" обязательно для заполнения.',
        'work_experiences.*.end_date.required' => 'Поле "Дата окончания работы" обязательно для заполнения.',
        'work_experiences.*.company.required' => 'Поле "Название компании" обязательно для заполнения.',
        'work_experiences.*.company.max' => 'Поле "Название компании" не должно превышать :max символов.',
        'work_experiences.*.description.required' => 'Поле "Описание работы" обязательно для заполнения.',
        'educations.*.start_date.required' => 'Поле "Дата начала обучения" обязательно для заполнения.',
        'educations.*.end_date.required' => 'Поле "Дата окончания обучения" обязательно для заполнения.',
        'educations.*.end_date.after_or_equal' => 'Дата окончания обучения должна быть позже или равна дате начала обучения.',
        'educations.*.institution.required' => 'Поле "Учебное заведение" обязательно для заполнения.',
        'educations.*.institution.max' => 'Поле "Учебное заведение" не должно превышать :max символов.',
        'languages.*.exists' => 'Выбранный язык не существует.',
    ]);

    if (empty($request->selected_skills_array)) {
        return redirect()->back()->withErrors(['selected_skills_array' => 'Выберите хотя бы один навык.']);
    }

    // Создаем новый экземпляр резюме
    $resume = new Resume();

    // Заполняем резюме данными из запроса
    $resume->user_id = auth()->id();
    $resume->job_title = $request->job_title;
    $resume->willing_to_relocate = $request->willing_to_relocate;
    $resume->willing_to_travel = $request->willing_to_travel;
    $resume->desired_salary_min = $request->desired_salary_min;
    $resume->desired_salary_max = $request->desired_salary_max;
    $resume->about_me = $request->about_me;
    $resume->citizenship = $request->citizenship;
    $resume->commute_time = $request->commute_time;
    $resume->specialization_id = $request->specialization_id;
    $resume->employment_type = implode(',', $request->employment_type);
    $resume->work_schedule = implode(',', $request->work_schedule);
    $resume->profession_id = $request->profession_id;

    // // Сохранение навыков резюме
    // if ($request->has('selected_skills_array')) {
    //     $resume->skills()->attach($request->selected_skills_array);
    // }
    if ($request->hasFile('photo')) {
        // Обработка файла изображения
        $photo = $request->file('photo');
        $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
        $photo->storeAs('photos', $filename); // Сохранение изображения в хранилище
        $resume->photo_path = 'photos/' . $filename;
    } else {
        // Установка изображения по умолчанию
        $resume->photo_path = 'default_user.png';
    }
        

    
    // Сохраняем резюме
    $resume->save();

     // Связываем выбранные навыки с резюме
     $selectedSkills = json_decode($request->selected_skills_array);
     $resume->skills()->attach($selectedSkills);

    // Сохранение языков резюме
    if ($request->has('selected_languages_array')) {
        $selectedLanguages = json_decode($request->selected_languages_array);
        foreach ($selectedLanguages as $languageId) {
            $resume->languages()->attach($languageId);
        }
    }

    $workExperiences = $request->work_experiences;

     // Сохраняем опыт работы
     if (empty($workExperiences)) {
        if (!is_null($request->$workExperiences)) {
            foreach ($request->work_experiences as $workExperienceData) {
                $workExperience = new WorkExperience();
                $workExperience->resume_id = $resume->id;
                $workExperience->start_date = null;
                $workExperience->end_date = null;
                $workExperience->company_name = null;
                $workExperience->position = null; // Добавляем сохранение должности
                $workExperience->description = null;
                $workExperience->save();
            }
        }
    }

    else {
        foreach ($request->work_experiences as $workExperienceData) {
            $workExperience = new WorkExperience();
            $workExperience->resume_id = $resume->id;
            $workExperience->start_date = $workExperienceData['start_date'];
            $workExperience->end_date = $workExperienceData['end_date'];
            $workExperience->company_name = $workExperienceData['company'];
            $workExperience->position = $workExperienceData['position']; // Добавляем сохранение должности
            $workExperience->description = $workExperienceData['description'];
            $workExperience->save();
        }
    }

     // Обработка образования
     if ($request->has('educations')) {
        foreach ($request->educations as $key => $education) {
            $education = new Education([
                'start_date' => $education['start_date'],
                'end_date' => $education['end_date'],
                'institution' => $education['institution'],
            ]);
            $resume->educations()->save($education);
        }
    }
    

    // Редирект на страницу с подтверждением создания резюме
    return redirect()->route('dashboard_user', $resume->id)->with('success', 'Резюме успешно создано!');
    }


    public function show($id){
        // Находим резюме по его идентификатору
        $resume = Resume::findOrFail($id);
        $user = $resume->user;

        return view('applicant.resume_show' , compact('resume', 'user'));
     }

     public function showAll($id){
        // Находим резюме по его идентификатору
        $resume = Resume::findOrFail($id);
        $user = $resume->user;

        // Проверяем, авторизована ли компания
        if (Auth::guard('company')->check()) {
            // Если компания авторизована, то увеличиваем счетчик просмотров
            $resume->increment('views');
        }

        return view('resume_show_all' , compact('resume', 'user'));
     }

     public function edit($id)
     {
         $resume = Resume::findOrFail($id);
         $selectedSkills = $resume->skills; // Получаем выбранные навыки из модели резюме
         $employmentTypes = ['Полная занятость', 'Частичная занятость', 'Стажировка'];
         $workSchedules = ['Полный день', 'Сменный график', 'Гибкий график', 'Удаленная работа', 'Вахтовый метод'];
         $specializations = Specialization::all();
         $professions = Profession::all(); // Получаем все профессии
         $selectedLanguages = $resume->languages; // Получаем выбранные языки из модели резюме

         // Загрузка данных для полей формы, если это необходимо
         return view('applicant.edit_resume', compact('resume', 'selectedSkills', 'selectedLanguages', 'employmentTypes', 'workSchedules', 'specializations', 'professions'));
        }

        public function update(Request $request, $id)
        {
        $request->validate([
        'job_title' => 'required|string|max:100',
        'willing_to_relocate' => 'required|in:готов к переезду,не готов к переезду',
        'willing_to_travel' => 'required|in:готов к командировкам,не готов к командировкам',
        'employment_type' => 'required|array',
        'work_schedule' => 'required|array',
        'specialization_id' => 'required|exists:specializations,id',
        'profession_id' => 'required|exists:professions,id', // Добавлено новое правило для profession_id
        'desired_salary_min' => 'nullable|numeric|min:0',
        'desired_salary_max' => 'nullable|numeric|min:0',
        'about_me' => 'nullable|string',
        'citizenship' => 'nullable|string|max:100',
        'commute_time' => 'nullable|in:менее часа,около часа,не имеет значения',
        'selected_skills_array.*' => 'required|exists:skills,id',
        'work_experiences.*.start_date' => 'required|date',
        'work_experiences.*.end_date' => 'required|date',
        'work_experiences.*.company' => 'required|string|max:255',
        'work_experiences.*.description' => 'required|string',
        'languages.*' => 'nullable|exists:languages,id',
        'educations.*.start_date' => 'required|date',
        'educations.*.end_date' => 'required|date|after_or_equal:educations.*.start_date',
        'educations.*.institution' => 'required|string|max:100',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Максимальный размер файла 2 МБ
    ], [
        'job_title.required' => 'Поле "Название должности" обязательно для заполнения.',
        'willing_to_relocate.required' => 'Поле "Готов к переезду" обязательно для заполнения.',
        'willing_to_travel.required' => 'Поле "Готов к командировкам" обязательно для заполнения.',
        'employment_type.required' => 'Поле "Тип занятости" обязательно для заполнения.',
        'work_schedule.required' => 'Поле "График работы" обязательно для заполнения.',
        'specialization_id.required' => 'Поле "Специализация" обязательно для заполнения.',
        'profession_id.required' => 'Поле "Профессия" обязательно для заполнения.',
        'desired_salary_min.numeric' => 'Поле "Желаемая минимальная зарплата" должно быть числовым.',
        'desired_salary_max.numeric' => 'Поле "Желаемая максимальная зарплата" должно быть числовым.',
        'about_me.string' => 'Поле "О себе" должно быть строкой.',
        'citizenship.string' => 'Поле "Гражданство" должно быть строкой.',
        'citizenship.max' => 'Поле "Гражданство" не должно превышать :max символов.',
        'commute_time.in' => 'Поле "Время на дорогу" должно быть одним из: менее часа, около часа, не имеет значения.',
        'selected_skills_array.required' => 'Поле "Требуемые навыки" обязательно для заполнения.',
        'selected_skills_array.*.exists' => 'Один или несколько выбранных навыков недействительны.',
        'work_experiences.*.start_date.required' => 'Поле "Дата начала работы" обязательно для заполнения.',
        'work_experiences.*.end_date.required' => 'Поле "Дата окончания работы" обязательно для заполнения.',
        'work_experiences.*.company.required' => 'Поле "Название компании" обязательно для заполнения.',
        'work_experiences.*.company.max' => 'Поле "Название компании" не должно превышать :max символов.',
        'work_experiences.*.description.required' => 'Поле "Описание работы" обязательно для заполнения.',
        'educations.*.start_date.required' => 'Поле "Дата начала обучения" обязательно для заполнения.',
        'educations.*.end_date.required' => 'Поле "Дата окончания обучения" обязательно для заполнения.',
        'educations.*.end_date.after_or_equal' => 'Дата окончания обучения должна быть позже или равна дате начала обучения.',
        'educations.*.institution.required' => 'Поле "Учебное заведение" обязательно для заполнения.',
        'educations.*.institution.max' => 'Поле "Учебное заведение" не должно превышать :max символов.',
        'languages.*.exists' => 'Выбранный язык не существует.',
    ]);
        
            $resume = Resume::findOrFail($id);
        
            // Обновление данных резюме на основе полученных из формы
            $resume->job_title = $request->job_title;
            $resume->willing_to_relocate = $request->willing_to_relocate;
            $resume->willing_to_travel = $request->willing_to_travel;
            $resume->employment_type = implode(',', $request->input('employment_type'));
            $resume->work_schedule = implode(',', $request->input('work_schedule'));
            $resume->specialization_id = $request->specialization_id;
            $resume->profession_id = $request->profession_id;
            $resume->desired_salary_min = $request->desired_salary_min;
            $resume->desired_salary_max = $request->desired_salary_max;
            $resume->about_me = $request->about_me;
            $resume->citizenship = $request->citizenship;
            $resume->commute_time = $request->commute_time;
        
            // Сохранение выбранных языков
            if ($request->selected_languages_array) {
                $selectedLanguagesArray = json_decode($request->selected_languages_array);
                $resume->languages()->sync($selectedLanguagesArray);
            }
        
            // Сохранение выбранных навыков
            if ($request->selected_skills_array) {
                $selectedSkillsArray = json_decode($request->selected_skills_array);
                $resume->skills()->sync($selectedSkillsArray);
            }
        
            // Сохранение фотографии, если она была загружена
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos');
                $resume->photo = $photoPath;
            }

        
            // Сохранение резюме
            $resume->save();
        
            return redirect()->route('dashboard_user')->with('success', 'Резюме успешно обновлено!');
        }

     public function destroy($id)
    {
    $resume = Resume::findOrFail($id);
    // Проверка на права доступа к удалению резюме
    if ($resume->user_id !== auth()->id()) {
        abort(403); // Ошибка 403 - Доступ запрещен
    }

    // Удаление навыков, связанных с резюме
    $resume->skills()->detach();

    // Удаление языков, связанных с резюме
    $resume->languages()->detach();

    // Удаление опыта работы, связанного с резюме
    $resume->workExperiences()->delete();

    // Удаление образования, связанного с резюме
    $resume->educations()->delete();

    // Удаление резюме
    $resume->delete();

    // Редирект на страницу со списком резюме
    return redirect()->route('dashboard_user')->with('success', 'Резюме успешно удалено');
    }


    public function sendResponse(Request $request)
    {
        // Валидация данных формы
        $request->validate([
            'resume_id' => 'required|exists:resumes,id',
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Создание нового отклика
        $response = new Response();
        $response->resume_id = $request->resume_id;
        $response->job_id = $request->job_id;
        $response->user_id = $request->user_id;
        // Другие поля отклика, если они есть
    
        // Сохранение отклика в базе данных
        $response->save();
    
        // Редирект на страницу с вакансией с сообщением об успешном отправлении отклика
        return redirect()->route('show', ['id' => $request->job_id])->with('success', 'Отклик успешно отправлен.');
    }


    public function changeStatus(Request $request, Response $response)
    {
       // Валидация данных формы
    $request->validate([
        'status' => 'required|in:Принят,Отклонен,В ожидании', // Убедитесь, что статус из списка доступных
    ]);

    // Получаем предыдущий статус отклика
    $previousStatus = $response->status;

    // Изменяем статус отклика
    $response->status = $request->status;
    $response->save();

    // Обновляем счетчик приглашений резюме
    $resume = Resume::find($response->resume_id);
    if ($response->status === 'Принят') {
        // Если статус изменен на "Принят", увеличиваем счетчик приглашений
        $resume->invitations_count += 1;
    } elseif ($previousStatus === 'Принят') {
        // Если предыдущий статус был "Принят", а новый не "Принят", уменьшаем счетчик приглашений
        $resume->invitations_count -= 1;
    }
    // Сохраняем изменения
    $resume->save();

    // Редирект на страницу с откликами с сообщением об успешном изменении статуса
    return redirect()->route('candidates')->with('success', 'Статус отклика успешно изменен.');
    }

    public function response_view()
    {
        $userResponses = Response::where('user_id', Auth::id())
        ->with('job.company')
        ->get();
        $vacancies = Job::where('status', 'Активна')->get();
        return view('applicant.responses', ['userResponses' => $userResponses, 'vacancies' => $vacancies]);
    }



}
