@extends ('layouts.after_default_us')
@section ('content')

    <section class="card_resume_area p-2 p-xl-1 p-xxl-0">
        <div class="container_main">
            <div class="card_resume_top_group_block">
                <div class="card_resume_top_group_block_inner_first card_res_border_right card_res_border_bottom">
                    <div class="card_resume_top_group_block_inner_first_title_age_status_with_img">
                        <div class="card_resume_top_group_block_inner_first_title_age_status">
                            <button onclick="goBack()" class="btn_back">Вернуться</button>

                            <p class="card_resume_top_group_block_inner_first_title">{{ $user->first_name }} {{ $user->last_name }}</p>
                            @php
                                $birthDate = \Carbon\Carbon::parse($user->birth_date);
                                $age = $birthDate->age;
                                $ageSuffix = $age % 10 == 1 && $age % 100 != 11 ? 'год' : ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20) ? 'года' : 'лет');
                                $genderLabel = $user->gender === 'Мужчина' ? 'родился' : 'родилась';
                            @endphp

                            <p class="card_resume_top_group_block_inner_first_age">{{ $user->gender }}, {{ $age }} {{ $ageSuffix }}, {{ $genderLabel }} {{ $birthDate->isoFormat('DD MMMM YYYY') }}</p>

                            @php
                                $statusClass = '';
                                switch ($user->status) {
                                    case 'Активно ищу работу':
                                        $statusClass = 'bg_green';
                                        break;
                                    case 'Рассматриваю предложения':
                                        $statusClass = 'bg_yellow';
                                        break;
                                    case 'Не ищу работу':
                                        $statusClass = 'bg_red';
                                        break;
                                    default:
                                        $statusClass = '';
                                        break;
                                }
                            @endphp
                            <p class="card_resume_top_group_block_inner_first_status {{ $statusClass }}">{{ $user->status }}</p>
                        </div>
                        <img class="img_user_logo" src="{{ asset('storage/photos/' . $resume->photo_path) }}" alt="img_user">
                    </div>
                    
                    <div class="card_resume_top_group_block_inner_contacts">
                        <p class="card_resume_top_group_block_inner_contacts_h">Контакты</p>
                        <p class="card_resume_top_group_block_inner_contacts_p">{{ $user->phone }}</p>
                        <p class="card_resume_top_group_block_inner_contacts_p">{{ $user->email }}</p>
                    </div>
                    
                    <div class="card_resume_top_group_block_inner_city">
                        <p class="card_resume_top_group_block_inner_city_p">
                            @php
                                $region = \App\Models\Region::find($user->region_id);
                            @endphp
                            @if ($region)
                                {{ $region->name }}, {{ $resume->willing_to_relocate }}, {{ $resume->willing_to_travel }}
                            @else
                                Название региона не найдено
                            @endif
                        </p>
                    </div>

                </div>  
            </div>

            <div class="card_resume_main_group_block">
                <div class="card_resume_main_group_block_inner">
                    <div class="card_resume_main_group_block_inner_title_spec_emp_sched">
                        <p class="card_resume_main_group_block_inner_title">{{ $resume->job_title }}</p>
                        <p class="card_resume_main_group_block_inner_spec">Специализации: {{ $resume->specialization->name }}, {{ $resume->profession->name }}</p>
                        <p class="card_resume_main_group_block_inner_emp">Занятость: {{ $resume->employment_type }}</p>
                        <p class="card_resume_main_group_block_inner_sched">График работы: {{ $resume->work_schedule }}</p>
                    </div>
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="card_resume_main_group_block_inner_work_exp_h h_card_resume">Опыт работы</p>
                    <div class="card_resume_main_group_block_inner_work_exp">
                        @if ($resume->workExperiences->isEmpty())
                            <p>Нет опыта работы</p>
                        @else
                            @foreach ($resume->workExperiences as $workExperience)
                                <div class="card_resume_main_group_block_inner_work_exp_box">
                                    <p class="card_resume_main_group_block_inner_work_exp_data">
                                        {{ \Carbon\Carbon::parse($workExperience->start_date)->locale('ru')->isoFormat('MMMM YYYY') }}
                                        - 
                                        {{ \Carbon\Carbon::parse($workExperience->end_date)->locale('ru')->isoFormat('MMMM YYYY') }}
                                    </p>
                                    <div class="card_resume_main_group_block_inner_work_exp_info">
                                        <p class="card_resume_main_group_block_inner_work_exp_company">{{ $workExperience->company_name }}</p>
                                        <p class="card_resume_main_group_block_inner_work_exp_position">{{ $workExperience->position }}</p>
                                        <p class="card_resume_main_group_block_inner_work_exp_description">{{ $workExperience->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="h_card_resume">Ключевые навыки</p>
                    <div>
                        <div class="skill-grid">
                            @foreach ($resume->skills as $skill)
                                <div class="skill-item">{{ $skill->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="h_card_resume">Обо мне</p>
                    <p class="card_resume_main_group_block_inner_about_me">{{$resume->about_me}}</p>
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="h_card_resume">Образование</p>
                    <div class="card_resume_main_group_block_inner_data_education">
                            @if ($resume->educations->isEmpty())
                                <div class="education-item">
                                    <p>Нет образования</p>
                                </div>
                            @else
                            @foreach ($resume->educations as $education)
                            <div class="card_resume_main_group_block_inner_data_education_box">
                                <div class="card_resume_main_group_block_inner_data_ed">
                                    <p class="card_resume_main_group_block_inner_data">{{ \Carbon\Carbon::parse($education->start_date)->locale('ru')->isoFormat('YYYY') }}
                                    - 
                                    {{ \Carbon\Carbon::parse($education->end_date)->locale('ru')->isoFormat('YYYY') }}
                                    </p>
                                </div>
                                <p class="card_resume_main_group_block_inner_education">{{ $education->institution }}</p>
                            </div>   
                            @endforeach
                            @endif
                    </div>
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="h_card_resume">Знание языков</p>
                    @if ($resume->languages->isNotEmpty())
                        <p class="card_resume_main_group_block_inner_languages">{{ implode(', ', $resume->languages->pluck('name')->toArray()) }}</p>
                    @endif
                </div>

                <div class="card_resume_main_group_block_inner">
                    <p class="h_card_resume">Гражданство, время в пути до работы</p>
                    <p class="card_resume_main_group_block_inner_citizenship">Гражданство: {{$resume->citizenship}}</p>
                    <p class="card_resume_main_group_block_inner_commute_time">Желательное время в пути до работы: {{$resume->commute_time}}</p>
                </div>
            </div>

        </div>
    </section>


        
        <!-- Кнопки редактирования и удаления -->
        <div class="d-none">
            <a href="{{ route('resume.edit', $resume->id) }}" class="btn btn-primary">Редактировать</a>
            <form action="{{ route('resume.destroy', $resume->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

  
@endsection