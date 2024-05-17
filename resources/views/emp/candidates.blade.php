@extends('layouts.main_afterEMP')


@section('content')

<div class="container_main dop_margin">
    <p class="mulishb fs-4 my_vacancy_h p-2 p-xl-1 p-xxl-0">Кандидаты</p>
    <!-- Ваше представление vacancy_list.blade.php -->
    @if (session('success'))
        <div class=" succ" id="liveAlertPlaceholder" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="alert_default" >
                {{ session('success') }}
            </div>
        </div>
    @endif
 
    <script>
    // Ждем загрузки всего документа
    $(document).ready(function() {
        // Показываем уведомление
        $('.toast').toast('show');
    });
    </script>
    <!-- Ваша текущая разметка для вывода списка вакансий -->


    <ul class="nav nav-pills tabs_vacancy_block mb-3 p-2 p-xl-1 p-xxl-0" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Непросмотренные</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Приглашения</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Отказы</button>
        </li>

        <a href="{{route('create_vacancy')}}" class="btn_stock_outline mulishb">Заполнить вакансию</a>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane table-responsive-md fade show active " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="candidates_group_blocks_main p-2 p-xl-1 p-xxl-0">
                    @foreach ($responses->where('status', 'В ожидании') as $response)
                    @if ($response->resume)
                    <div class="candidate_group_block_inner">
                    <img src="{{ asset('storage/photos/' . $response->resume->photo_path) }}" alt="Candidate Avatar" class="img_candidate_logo">
                    <div class="candidate_block">
                        <a href="{{ route('resume.showAll', ['id' => $response->resume->id]) }}" class="candidate_block_title">{{ $response->resume->job_title }}</a>
                        @php
                        $birthDate = \Carbon\Carbon::parse($response->user->birth_date);
                        $age = $birthDate->age;
                        $ageSuffix = $age % 10 == 1 && $age % 100 != 11 ? 'год' : ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20) ? 'года' : 'лет');
                        @endphp
                        <p class="candidate_block_name_age">{{$response->user->first_name}} {{$response->user->last_name}}, {{ $age }} {{ $ageSuffix }}</p>
                        <p class="candidate_block_response">Откликнулся {{\Carbon\Carbon::parse($response->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                            @php
                            $totalExperience = 0;
                            foreach ($response->resume->workExperiences as $workExperience) {
                                $startDate = new DateTime($workExperience->start_date);
                                $endDate = new DateTime($workExperience->end_date);
                                $interval = $startDate->diff($endDate);
                                $totalExperience += $interval->y;
                            }
                            $experienceText = $totalExperience >= 1 ? 'От ' . $totalExperience . ' лет' : 'Меньше года';
                            @endphp
                            <p class="candidate_block_experience">Опыт работы: {{ $experienceText }}</p>
                        
                            @if ($response->resume->workExperiences->isNotEmpty())
                                <p class="candidate_block_last_work_h">Последнее место работы</p>
                                <p class="candidate_block_last_job_date">
                                    {{ $response->resume->workExperiences->last()->position}},
                                <span class="date_grey">
                                {{  \Carbon\Carbon::parse($workExperience->start_date)->locale('ru')->isoFormat('MMMM YYYY') }} 
                                -           
                                {{ \Carbon\Carbon::parse($workExperience->end_date)->locale('ru')->isoFormat('MMMM YYYY') }}
                                </span>
                                </p>
                                <p class="candidate_block_last_company_name">{{ $response->resume->workExperiences->last()->company_name }}</p>
                            @endif
                    
                        <p class="candidate_block_phone_h">Телефон</p>
                        <p class="candidate_block_phone">{{$response->user->phone}} <span class="date_grey">- предпочитаемый способ связи</span></p>
                        <p class="candidate_block_updated_at">Обновлено {{\Carbon\Carbon::parse($response->resume->updated_at)->isoFormat('D MMMM, HH:mm') }}</p>
                        
                        <form class="form_candidate" action="{{ route('response.change_status', $response) }}" method="POST">
                            @csrf
                            <!-- Выбор нового статуса -->
                            <select class="form-select form_select_candidate" name="status">
                                <option value="Принят">Принят</option>
                                <option value="Отклонен">Отклонен</option>
                                <option value="В ожидании">В ожидании</option>
                            </select>
                            <button type="submit" class="btn_outline_14 align-items-center">Изменить статус</button>
                        </form>
                    
                    </div>
                </div>
                @endif
                @endforeach
                </div>
            
        </div>
    
        <div class="tab-pane table-responsive-md fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            <div class="candidates_group_blocks_main p-2 p-xl-1 p-xxl-0">
                    @foreach ($responses->where('status', 'Принят') as $response)
                    @if ($response->resume)
                    <div class="candidate_group_block_inner_green">
                    <img src="{{ asset('storage/photos/' . $response->resume->photo_path) }}" alt="Candidate Avatar" class="img_candidate_logo">
                    <div class="candidate_block">
                        <a href="{{ route('resume.showAll', ['id' => $response->resume->id]) }}" class="candidate_block_title">{{ $response->resume->job_title }}</a>
                        @php
                        $birthDate = \Carbon\Carbon::parse($response->user->birth_date);
                        $age = $birthDate->age;
                        $ageSuffix = $age % 10 == 1 && $age % 100 != 11 ? 'год' : ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20) ? 'года' : 'лет');
                        @endphp
                        <p class="candidate_block_name_age">{{$response->user->first_name}} {{$response->user->last_name}}, {{ $age }} {{ $ageSuffix }}</p>
                        <p class="candidate_block_response">Откликнулся {{\Carbon\Carbon::parse($response->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                            @php
                            $totalExperience = 0;
                            foreach ($response->resume->workExperiences as $workExperience) {
                                $startDate = new DateTime($workExperience->start_date);
                                $endDate = new DateTime($workExperience->end_date);
                                $interval = $startDate->diff($endDate);
                                $totalExperience += $interval->y;
                            }
                            $experienceText = $totalExperience >= 1 ? 'От ' . $totalExperience . ' лет' : 'Меньше года';
                            @endphp
                            <p class="candidate_block_experience">Опыт работы: {{ $experienceText }}</p>
                        
                            @if ($response->resume->workExperiences->isNotEmpty())
                                <p class="candidate_block_last_work_h">Последнее место работы</p>
                                <p class="candidate_block_last_job_date">
                                    {{ $response->resume->workExperiences->last()->position}},
                                <span class="date_grey">
                                {{  \Carbon\Carbon::parse($workExperience->start_date)->locale('ru')->isoFormat('MMMM YYYY') }} 
                                -           
                                {{ \Carbon\Carbon::parse($workExperience->end_date)->locale('ru')->isoFormat('MMMM YYYY') }}
                                </span>
                                </p>
                                <p class="candidate_block_last_company_name">{{ $response->resume->workExperiences->last()->company_name }}</p>
                            @endif
                    
                        <p class="candidate_block_phone_h">Телефон</p>
                        <p class="candidate_block_phone">{{$response->user->phone}} <span class="date_grey">- предпочитаемый способ связи</span></p>
                        <p class="candidate_block_updated_at">Обновлено {{\Carbon\Carbon::parse($response->resume->updated_at)->isoFormat('D MMMM, HH:mm') }}</p>
                        
                        <form class="form_candidate" action="{{ route('response.change_status', $response) }}" method="POST">
                            @csrf
                            <!-- Выбор нового статуса -->
                            <select class="form-select form_select_candidate" name="status">
                                <option value="Принят">Принят</option>
                                <option value="Отклонен">Отклонен</option>
                                <option value="В ожидании">В ожидании</option>
                            </select>
                            <button type="submit" class="btn_outline_14 align-items-center">Изменить статус</button>
                        </form>
                    
                    </div>
                </div>
                @endif
                @endforeach
            
        </div>
    </div>
        
        <div class="tab-pane table-responsive-md fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
            <div class="candidates_group_blocks_main p-2 p-xl-1 p-xxl-0">
                @foreach ($responses->where('status', 'Отклонен') as $response)
                @if ($response->resume)
                <div class="candidate_group_block_inner_red">
                <img src="{{ asset('storage/photos/' . $response->resume->photo_path) }}" alt="Candidate Avatar" class="img_candidate_logo">
                <div class="candidate_block">
                    <a href="{{ route('resume.showAll', ['id' => $response->resume->id]) }}" class="candidate_block_title">{{ $response->resume->job_title }}</a>
                    @php
                    $birthDate = \Carbon\Carbon::parse($response->user->birth_date);
                    $age = $birthDate->age;
                    $ageSuffix = $age % 10 == 1 && $age % 100 != 11 ? 'год' : ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20) ? 'года' : 'лет');
                    @endphp
                    <p class="candidate_block_name_age">{{$response->user->first_name}} {{$response->user->last_name}}, {{ $age }} {{ $ageSuffix }}</p>
                    <p class="candidate_block_response">Откликнулся {{\Carbon\Carbon::parse($response->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        @php
                        $totalExperience = 0;
                        foreach ($response->resume->workExperiences as $workExperience) {
                            $startDate = new DateTime($workExperience->start_date);
                            $endDate = new DateTime($workExperience->end_date);
                            $interval = $startDate->diff($endDate);
                            $totalExperience += $interval->y;
                        }
                        $experienceText = $totalExperience >= 1 ? 'От ' . $totalExperience . ' лет' : 'Меньше года';
                        @endphp
                        <p class="candidate_block_experience">Опыт работы: {{ $experienceText }}</p>
                    
                        @if ($response->resume->workExperiences->isNotEmpty())
                            <p class="candidate_block_last_work_h">Последнее место работы</p>
                            <p class="candidate_block_last_job_date">
                                {{ $response->resume->workExperiences->last()->position}},
                            <span class="date_grey">
                            {{  \Carbon\Carbon::parse($workExperience->start_date)->locale('ru')->isoFormat('MMMM YYYY') }} 
                            -           
                            {{ \Carbon\Carbon::parse($workExperience->end_date)->locale('ru')->isoFormat('MMMM YYYY') }}
                            </span>
                            </p>
                            <p class="candidate_block_last_company_name">{{ $response->resume->workExperiences->last()->company_name }}</p>
                        @endif
                
                    <p class="candidate_block_phone_h">Телефон</p>
                    <p class="candidate_block_phone">{{$response->user->phone}} <span class="date_grey">- предпочитаемый способ связи</span></p>
                    <p class="candidate_block_updated_at">Обновлено {{\Carbon\Carbon::parse($response->resume->updated_at)->isoFormat('D MMMM, HH:mm') }}</p>
                    
                    <form class="form_candidate" action="{{ route('response.change_status', $response) }}" method="POST">
                        @csrf
                        <!-- Выбор нового статуса -->
                        <select class="form-select form_select_candidate" name="status">
                            <option value="Принят">Принят</option>
                            <option value="Отклонен">Отклонен</option>
                            <option value="В ожидании">В ожидании</option>
                        </select>
                        <button type="submit" class="btn_outline_14 align-items-center">Изменить статус</button>
                    </form>
                
                </div>
            </div>
            @endif
            @endforeach
            
            </div>
    </div>
    </div>












   
    
    <script>
        // Функция для сохранения текущей вкладки в localStorage
        function saveActiveTab(tabId) {
            localStorage.setItem('activeTab', tabId);
        }

        // Функция для получения текущей вкладки из localStorage
        function getActiveTab() {
            return localStorage.getItem('activeTab');
        }

        // При загрузке страницы проверяем, есть ли сохраненная вкладка в localStorage и активируем ее
        document.addEventListener('DOMContentLoaded', function() {
            const activeTab = getActiveTab();
            if (activeTab) {
                const tabButton = document.querySelector(activeTab);
                if (tabButton) {
                    tabButton.click();
                }
            }
        });

        // Обработчик события для сохранения текущей вкладки при ее активации
        const tabButtons = document.querySelectorAll('.link_vacancy_changer');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = '#' + this.getAttribute('id');
                saveActiveTab(tabId);
            });
        });
    </script>




    <form method="post" class="d-none" action="{{route('logout_employer')}}">
        @csrf
        <button class="btn_bigger_main">Выйти</button>
    </form>

</div>



@endsection