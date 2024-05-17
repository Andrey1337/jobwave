@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)

@section('content')

<section class="top_search_block_area">
    <div class="container_main">
        <div class="position_search_inp_top">
            <form action="{{ route('search_main') }}" method="POST" class="d-flex search_for_emp_function form_searches justify-content-center justify-content-lg-start form_main_search_top" role="search">
                @csrf
                <input class="form-control search_inp search_inp2" type="search" placeholder="Профессия, должность или компания" aria-label="Search" name="search_query">
                <button class="btn_bigger search_inp_btn_main" type="submit">Найти</button>
                <button class="btn_search btn_search2" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</section>


<section class="count_vacancy_main_block">
    <div class="container_main">
        <div class="count_vacancys_and_filters d-flex justify-content-between align-items-center d-xl-block">
            <p class="count_vacancy_main_p fs-4 mulishb p-2 p-xl-1 p-xxl-0"><span class="smalltext_7777 mulishr">всего вакансий на сайте - {{ $vacancyCount }}</span> <br>Найдено {{ $countVacancies }} вакансий на странице</p>
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
                <!-- Форма с фильтрами -->
                <form action="{{ route('search_main') }}" id="searchForm" method="POST">
                    @csrf
                    <!-- Фильтры по графику работы -->
                    <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">График работы</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Полный день"> Полный день</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Сменный график"> Сменный график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Удаленная работа"> Удаленная работа</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Гибкий график"> Гибкий график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Вахтовый метод"> Вахтовый метод</label>
                    </div>
                    </div>
            
                    <!-- Фильтры по уровню дохода -->
                    <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Уровень дохода</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 20 000₽"> от 20 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 35 000₽"> от 35 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 50 000₽"> от 50 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 75 000₽"> от 75 000₽</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 100 000₽"> от 100 000₽</label>
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
            
                    <!-- Фильтры по образованию -->
                    <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Образование</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Не требуется или не указано"> Не требуется или не указано</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Высшее"> Высшее</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Среднее профессиональное"> Среднее профессиональное</label>
                    </div>
                    </div>
            
                    <!-- Фильтры по опыту работы -->
                    <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Опыт работы</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Не имеет значения"> Не имеет значения</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="От 1 года до 3 лет"> От 1 года до 3 лет</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Нет опыта"> Нет опыта</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="От 3 до 6 лет"> От 3 до 6 лет</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Более 6 лет"> Более 6 лет</label>
                    </div>
                    </div>
            
                    <!-- Фильтры по типу занятости -->
                    <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">Тип занятости</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Полная занятость"> Полная занятость</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Частичная занятость"> Частичная занятость</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Стажировка"> Стажировка</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Волонтерство"> Волонтерство</label>
                    </div>
                    </div>
            
                    <!-- Кнопки для отправки формы и сброса фильтров -->
                    <button type="submit" class="btn_outline_14" >Применить</button>
                    <form action="{{ route('reset_filters') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn_outline_14" >Сбросить фильтры</button>
                    </form>
                </form>
                </div>
            </div>


            <form action="{{ route('search_main') }}" id="searchForm" class="d-none d-xl-flex"  method="POST">
                @csrf
                <div class="filter_block_area">
                    <p class="seach_page_checkbox_h mulishb">График работы</p>
                    <div class="filter_block_inputs">
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Полный день"> Полный день</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Сменный график"> Сменный график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Удаленная работа"> Удаленная работа</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Гибкий график"> Гибкий график</label>
                        <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="schedule[]" value="Вахтовый метод"> Вахтовый метод</label>
                    </div>
                </div>
                
            <div class="filter_block_area">
                <p class="seach_page_checkbox_h mulishb">Уровень дохода</p>
                <div class="filter_block_inputs">
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 20 000₽"> от 20 000₽</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 35 000₽"> от 35 000₽</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 50 000₽"> от 50 000₽</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 75 000₽"> от 75 000₽</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="income_level[]" value="от 100 000₽"> от 100 000₽</label>
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
                <p class="seach_page_checkbox_h mulishb">Образование</p>
                <div class="filter_block_inputs">
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Не требуется или не указано"> Не требуется или не указано</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Высшее"> Высшее</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="education[]" value="Среднее профессиональное"> Среднее профессиональное</label>
                </div>
            </div>

            <div class="filter_block_area">
                <p class="seach_page_checkbox_h mulishb">Опыт работы</p>
                <div class="filter_block_inputs">
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Не имеет значения"> Не имеет значения</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="От 1 года до 3 лет"> От 1 года до 3 лет</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Нет опыта"> Нет опыта</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="От 3 до 6 лет"> От 3 до 6 лет</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="required_experience[]" value="Более 6 лет"> Более 6 лет</label>
                </div>
            </div>

            <div class="filter_block_area">
                <p class="seach_page_checkbox_h mulishb">Тип занятости</p>
                <div class="filter_block_inputs">
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Полная занятость"> Полная занятость</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Частичная занятость"> Частичная занятость</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Стажировка"> Стажировка</label>
                    <label class="label_p_for_filter_vacancy"><input type="checkbox" class="custom_checkbox form-check-input" name="employment_type[]" value="Волонтерство"> Волонтерство</label>
                </div>
            </div>

                <button type="submit" class="btn_outline_14" >Применить</button>
                <form action="{{ route('reset_filters') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn_outline_14" >Сбросить фильтры</button>
                </form>
            </form>
            
            <!-- Место для отображения результатов поиска --> 
            @if ($countVacancies === 0)
            <p class="mulishr text-center empty_vacancy_text">По вашему запросу вакансий не найдено.</p>
            @else
            <div class="cards_vacancy_main_area" id="searchResults">
                @foreach($vacancies as $vacancy)
                @if ($vacancy->status === 'Активна')
                <div class="cards_vacancy_main_block">
                    <div class="cards_vacancy_main_block_info">

                        <div class="cards_vacancy_main_block_info_title_vacancy_group">
                            <div class="cards_vacancy_main_block_info_title_vacancy_group_inner">
                                <a href="{{ route('show', $vacancy->id) }}" class="cards_vacancy_main_block_info_title_vacancy mulishb">{{ $vacancy->title }}</a>
                                <p class="cards_vacancy_main_block_info_income_level_vacancy mulishb">от {{ number_format($vacancy->salary_from, 0, '.', ' ') }} ₽</p>
                            </div>
                            <a href="{{ route('emp.profile', ['companyId' => $vacancy->company->id]) }}"> 
                            <img src="{{ asset('storage/' . $vacancy->company->logo) }}" alt="Company Logo" class="company_logo">
                            </a>
                        </div>
                        
                        <p class="cards_vacancy_main_block_info_company_vacancy mulishr">{{ $vacancy->company->name }}, {{ $vacancy->region->name }}</p>

                        <div class="cards_vacancy_main_block_info_experience_and_icon_vacancy">
                            <img src="img/icons/chemodan.svg" alt="" class="icon_experience">
                            <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $vacancy->required_experience }}</p>
                        </div>

                        <a href="{{ route('show', $vacancy->id) }}" class="btn_response mulishSM">Откликнуться</a>

                    </div>
                </div>
                @endif
                @endforeach
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{-- Кнопка "Назад" --}}
                        <li class="page-item {{ $vacancies->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $vacancies->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
            
                        {{-- Страницы --}}
                        @for ($i = 1; $i <= $vacancies->lastPage(); $i++)
                            <li class="page-item {{ $i == $vacancies->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $vacancies->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
            
                        {{-- Кнопка "Вперед" --}}
                        <li class="page-item {{ $vacancies->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $vacancies->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            @endif
        </div>



    </div>
</section>



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



@endsection