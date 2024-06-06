@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)
@section('content')
    <section class="top_search_block_area">
        <div class="container_main">
            <div class="position_search_inp_top">
                <form id="search_form_top" action="{{ route('search_resume.submit') }}" method="POST" class="d-flex search_for_emp_function form_searches justify-content-center justify-content-lg-start form_main_search_top" role="search">
                    @csrf
                    <input class="form-control search_inp search_inp2" type="search" placeholder="Профессия, должность или компания" aria-label="Search" name="search_query">
                    <button class="btn_bigger search_inp_btn_main" type="submit">Найти</button>
                    <button class="btn_search btn_search2" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </section>
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
            $('.succ').toast('show');
        });
    </script>
    <section class="count_vacancy_main_block">
        <div class="container_main">
            <div class="count_vacancys_and_filters d-flex justify-content-between align-items-center d-xl-block">
                <p class="count_vacancy_main_p fs-4 mulishb p-2 p-xl-1 p-xxl-0"><span class="smalltext_7777 mulishr">всего резюме на сайте - {{ $resumesCount }}</span> <br>Найдено {{ $countResumes }} резюме на странице</p>
                <!-- Кнопка для открытия бокового меню -->
                <a class="btn_outline_14 d-block d-xl-none m-2 m-xl-1 m-xxl-0" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter">
                    <i class="bi bi-funnel"></i> Открыть фильтры
                </a>
            </div>
            
    
            <hr class="count_vacancy_main_hr">
        </div>
    </section>

    <section class="main_content_search_blocks">
        <div class="container_main">
            <div class="main_content_search_blocks_inner d-block d-xl-flex p-2 p-xl-2 p-xxl-0">

                    <!-- Боковое меню с фильтрами -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasFilterLabel">Фильтры</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{ route('search_resume.submit') }}" id="searchForm"  method="POST">
                        @csrf
                        <div class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">График работы</p>
                            <div class="filter_block_inputs">
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Полный день"> Полный день</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Сменный график"> Сменный график</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Удаленная работа"> Удаленная работа</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Гибкий график"> Гибкий график</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Вахтовый метод"> Вахтовый метод</label>
                            </div>
                        </div>
                        
                        <div class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">Желаемый уровень дохода</p>
                            <div class="filter_block_inputs">
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 20 000₽"> от 20 000₽</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 35 000₽"> от 35 000₽</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 50 000₽"> от 50 000₽</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 75 000₽"> от 75 000₽</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 100 000₽"> от 100 000₽</label>
                            </div>
                        </div>
            
                        <!-- Фильтры по регионам -->
                        <div id="regionsContainerSidebar" class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">Регионы</p>
                            @foreach($regions->take(5) as $region)
                                <div class="region label_p_for_filter_vacancy">
                                    <input type="checkbox" class="custom_checkbox form-check-input" name="regions[]" value="{{ $region->id }}"> {{ $region->name }}<br>
                                </div>
                            @endforeach
                        </div>
            
                        <!-- Кнопка "Показать ещё" -->
                        <button id="showMoreRegionsSidebar" class="btn_stroke_outline_14" type="button" data-total-regions="{{ $regions->count() }}">Показать ещё</button>
            
                        <div class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">Тип занятости</p>
                            <div class="filter_block_inputs">
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Полная занятость"> Полная занятость</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Частичная занятость"> Частичная занятость</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Стажировка"> Стажировка</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Волонтерство"> Волонтерство</label>
                            </div>
                        </div>
        
                        <div class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">Готовность к переезду</p>
                            <div class="filter_block_inputs">
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_relocate[]" value="готов к переезду"> Готов к переезду</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_relocate[]" value="не готов к переезду"> Не готов к переезду</label>
                            </div>
                        </div>
        
                        <div class="filter_block_area">
                            <p class="seach_page_checkbox_h mulishb">Готовность к командировкам</p>
                            <div class="filter_block_inputs">
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_travel[]" value="готов к командировкам"> Готов к командировкам</label>
                                <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_travel[]" value="не готов к командировкам"> Не готов к командировкам</label>
                            </div>
                        </div>
            
                        <button type="submit" class="btn_outline_14" >Применить</button>
                        <form action="{{ route('reset_filters') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn_outline_14" >Сбросить фильтры</button>
                        </form>
                    </form>

                </div>
            </div>

            <form action="{{ route('search_resume.submit') }}" id="searchForm" class="d-none d-xl-flex"  method="POST">
                @csrf
                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">График работы</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Полный день"> Полный день</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Сменный график"> Сменный график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Удаленная работа"> Удаленная работа</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Гибкий график"> Гибкий график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="work_schedule[]" value="Вахтовый метод"> Вахтовый метод</label>
                    </div>
                </div>
                
                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Желаемый уровень дохода</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 20 000₽"> от 20 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 35 000₽"> от 35 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 50 000₽"> от 50 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 75 000₽"> от 75 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="desired_salary_min[]" value="от 100 000₽"> от 100 000₽</label>
                    </div>
                </div>

                <div id="regionsContainer" class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Регионы</p>
                    @foreach($regions->take(5) as $region)
                        <div class="region label_p_for_filter_vacancy">
                            <input type="checkbox" class="custom_checkbox form-check-input" name="regions[]" value="{{ $region->id }}"> {{ $region->name }}<br>
                        </div>
                    @endforeach
                </div>
            
                <!-- Кнопка "Показать ещё" -->
                <button id="showMoreRegions" class="btn_stroke_outline_14" type="button" data-total-regions="{{ $regions->count() }}">Показать ещё</button>

                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Тип занятости</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Полная занятость"> Полная занятость</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Частичная занятость"> Частичная занятость</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Стажировка"> Стажировка</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Волонтерство"> Волонтерство</label>
                    </div>
                </div>

                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Готовность к переезду</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_relocate[]" value="готов к переезду"> Готов к переезду</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_relocate[]" value="не готов к переезду"> Не готов к переезду</label>
                    </div>
                </div>

                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Готовность к командировкам</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_travel[]" value="готов к командировкам"> Готов к командировкам</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="willing_to_travel[]" value="не готов к командировкам"> Не готов к командировкам</label>
                    </div>
                </div>

                <button type="submit" class="btn_outline_14" >Применить</button>
                <form action="{{ route('reset_filters') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn_outline_14" >Сбросить фильтры</button>
                </form>
            </form>



            <!-- Место для отображения результатов поиска --> 
            @if ($countResumes === 0)
            <p class="mulishr text-center empty_vacancy_text">По вашему запросу резюме не найдено.</p>
            @else
            <div class="cards_vacancy_main_area" id="searchResults">
            @foreach($resumes as $resume)
            <div class="cards_vacancy_main_block">
                <div class="cards_vacancy_main_block_info">

                    <div class="cards_vacancy_main_block_info_title_vacancy_group">
                        <div class="cards_vacancy_main_block_info_title_vacancy_group_inner">
                            <a href="{{ route('resume.show', ['id' => $resume->id]) }}" class="cards_vacancy_main_block_info_title_vacancy mulishb">{{ $resume->job_title }}</a>
                            <p class="cards_resume_main_block_info_income_level_vacancy mulishb">от {{ number_format($resume->desired_salary_min, 0, '.', ' ') }} до {{ number_format($resume->desired_salary_max, 0, '.', ' ') }} ₽</p>
                            @php
                                $birthDate = \Carbon\Carbon::parse($resume->user->birth_date);
                                $age = $birthDate->age;
                                $ageSuffix = $age % 10 == 1 && $age % 100 != 11 ? 'год' : ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20) ? 'года' : 'лет');
                            @endphp

                        </div>
                        <a href="{{ route('resume.show', ['id' => $resume->id]) }}"> 
                        <img src="{{ asset('storage/photos/' . $resume->photo_path) }}" alt="Company Logo" class="company_logo">
                        </a>
                    </div>
                    <p class="cards_vacancy_main_block_info_company_vacancy mulishr">{{ $resume->user->first_name }} {{ $resume->user->last_name }}, {{ $age }} {{ $ageSuffix }} </p>

                    @php
                    $totalExperience = 0;
                    foreach ($resume->workExperiences as $workExperience) {
                        $startDate = new DateTime($workExperience->start_date);
                        $endDate = new DateTime($workExperience->end_date);
                        $interval = $startDate->diff($endDate);
                        $totalExperience += $interval->y;
                    }
                    $experienceText = $totalExperience >= 1 ? 'от ' . $totalExperience . ' лет' : 'меньше года';
                    @endphp
                    <p class="cards_vacancy_main_block_info_company_vacancy mulishr">Опыт работы - {{ $experienceText }}</p>

                    <div class="cards_resumes_main_block_info_experience_and_icon_vacancy">
                        <div class="icon_with_resum_info">
                            <img src="img/icons/plane.svg" alt="" class="icon_experience">
                            <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $resume->willing_to_relocate }}</p>
                        </div>
                        <div class="icon_with_resum_info">
                            <img src="img/icons/backpack.svg" alt="" class="icon_experience">
                            <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $resume->willing_to_travel }}</p>
                        </div>
                        <div class="icon_with_resum_info">
                            <img src="img/icons/calendar.svg" alt="" class="icon_experience">
                            <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $resume->employment_type }}</p>
                        </div>
                        <div class="icon_with_resum_info">
                            <img src="img/icons/clock.svg" alt="" class="icon_experience">
                            <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $resume->work_schedule }}</p>
                        </div>
                        
                        
                        
                        
                    </div>

                    
                    <!-- Button trigger modal -->
                    <div class="vacancys_btns_block">
                        <button type="button" class="btn_response mulishSM" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $resume->id }}">
                            Пригласить
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $resume->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $resume->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel{{ $resume->id }}">Выберите вакансию</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Форма для выбора вакансии -->
                                    <form id="vacancyForm{{ $resume->id }}" action="{{ route('propose_job') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="resume_id" value="{{ $resume->id }}">
                                        <input type="hidden" name="user_id" value="{{ $resume->user_id }}">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="vacancySelect{{ $resume->id }}" class="form-label">Выберите вакансию:</label>
                                            <select class="form-select" id="vacancySelect{{ $resume->id }}" name="job_id">
                                                @foreach($jobs as $job)
                                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn_outline_14" data-bs-dismiss="modal">Закрыть</button>
                                        <button type="submit" class="btn_outline_14" id="sendResponseBtn{{ $resume->id }}">Отправить отклик</button>
                                    </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Кнопка "Назад" --}}
                    <li class="page-item {{ $resumes->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $resumes->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        
                    {{-- Страницы --}}
                    @for ($i = 1; $i <= $resumes->lastPage(); $i++)
                        <li class="page-item {{ $i == $resumes->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $resumes->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
        
                    {{-- Кнопка "Вперед" --}}
                    <li class="page-item {{ $resumes->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $resumes->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>


        

        

      
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    var showMoreButton = document.getElementById('showMoreRegions');
    var regionsContainer = document.getElementById('regionsContainer');
    var totalRegions = showMoreButton.getAttribute('data-total-regions');

    showMoreButton.addEventListener('click', function() {
        fetch('/load-more-regions?start=' + (regionsContainer.querySelectorAll('.region').length), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Добавляем новые регионы на страницу
            data.forEach(region => {
                var regionContainer = document.createElement('div');
                regionContainer.className = 'region label_p_for_filter_vacancy';
                regionContainer.innerHTML = '<input type="checkbox" class="custom_checkbox form-check-input" name="regions[]" value="' + region.id + '"> ' + region.name + '<br>';

                regionsContainer.appendChild(regionContainer);
            });

            // Проверяем, нужно ли скрывать кнопку "Показать ещё" после добавления регионов
            if (regionsContainer.querySelectorAll('.region').length === parseInt(totalRegions)) {
                showMoreButton.style.display = 'none'; // Если все регионы уже показаны, скрываем кнопку
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var showMoreButton = document.getElementById('showMoreRegionsSidebar');
    var regionsContainerSidebar = document.getElementById('regionsContainerSidebar');
    var totalRegions = showMoreButton.getAttribute('data-total-regions');

    showMoreButton.addEventListener('click', function() {
        fetch('/load-more-regions-sidebar?start=' + (regionsContainerSidebar.querySelectorAll('.region').length), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(region => {
                var regionContainer = document.createElement('div');
                regionContainer.className = 'region label_p_for_filter_vacancy';
                regionContainer.innerHTML = '<input type="checkbox" class="custom_checkbox form-check-input" name="regions[]" value="' + region.id + '"> ' + region.name + '<br>';
                regionsContainerSidebar.appendChild(regionContainer);
            });

            if (regionsContainerSidebar.querySelectorAll('.region').length === parseInt(totalRegions)) {
                showMoreButton.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    });
});

</script>
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
@endsection