@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)


@section('content')
    @if (session('success'))
        <div class=" succ" id="successAlert" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="alert_default" >
                {{ session('success') }}
            </div>
        </div>
    @endif
 
    
    <section class="vacancy_inner_cards_area">
        <div class="container_main">
        <div class="vacancy_inner_cards_block justify-content-center justify-content-xl-start p-2 p-xl-2 p-xxl-0 ">

            <div class="vacancy_inner_card_block">

                <div class="vacancy_inner_card_block_title_with_salary">
                    <p class="vacancy_inner_card_block_title">{{ $vacancy->title }}</p>
                    <p class="vacancy_inner_card_block_salary">от {{ number_format($vacancy->salary_from, 0, '.', ' ') }} ₽ до вычета налогов</p>
                </div>

                <div class="vacancy_inner_card_block_others_info">
                    <p class="vacancy_inner_card_block_others_info_text mulishr">
                    Требуемый опыт работы: {{ $vacancy->required_experience }}
                    {{ $vacancy->employment_type }}, {{ $vacancy->schedule }}
                    </p>
                </div>
                
                <!-- <div class="vacancys_btns_block">
                    <a href="#" class="btn_response_bigger">Откликнуться</a>
                    <a href="#" class="heart_btn"><img src="{{asset ('img/icons/heart.svg')}}" alt="" class="heart_svg"></a>
                </div> -->


                @if (Auth::check())
                    <!-- Button trigger modal -->
                    @if ($resumes->isEmpty())
                        <div class="alert alert-warning alert_without_something" role="alert">
                            У вас нет резюме. Пожалуйста, создайте резюме перед тем, как откликнуться на вакансию. <br><br>
                            <a href="{{ route('applicant.resume.create') }}" class="btn_outline_14">Создать резюме</a>
                        </div>
                    @else
                    <div class="vacancys_btns_block">
                    <button type="button" class="btn_response_bigger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Откликнуться
                    </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выберите резюме</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <!-- Форма для выбора резюме -->
                                        <form id="resumeForm" action="{{ route('send_response') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="job_id" value="{{ $job_id }}">
                                            <input type="hidden" name="user_id" value="{{ $user_id }}">
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
                                                <label for="resumeSelect" class="form-label">Выберите резюме:</label>
                                                <select class="form-select" id="resumeSelect" name="resume_id">
                                                    @foreach ($resumes as $resume)
                                                        <option value="{{ $resume->id }}">{{ $resume->job_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn_outline_14" data-bs-dismiss="modal">Закрыть</button>
                                                <button type="submit" class="btn_outline_14" id="sendResponseBtn">Отправить отклик</button>
                                            </div>
                                        </form>
                            </div>
                        </div>
                    </div>
                    @endif

                @else
                    <!-- Если пользователь не авторизован, выводим ссылку на страницу авторизации -->
                    <div class="vacancys_btns_block">
                        <a href="{{route ('applicant.login')}}" class="btn_response_bigger">Откликнуться</a>
                    </div>
                @endif
                

            </div>

            <div class="vacancy_inner_card_block_for_company d-none d-xl-flex">
                <img src="{{ asset('storage/' . $vacancy->company->logo) }}" alt="Company Logo" class=" company_logo_in_vacancy">
                <a href="{{ route('emp.profile', ['companyId' => $vacancy->company->id]) }}" class="vacancy_inner_card_block_for_company_title mulishr">{{ $vacancy->company->name }}</a>
                <p class="vacancy_inner_card_block_for_company_city mulishr">{{ $vacancy->company->city }}</p>
            </div>


        </div>

        <div class="vacancy_inner_description_main mx-auto mx-xl-0 p-2 p-xl-2 p-xxl-0 ">
            <p class="vacancy_inner_description_main_p mulishr">
                {{ $vacancy->description }}
                
            </p>

            <p class="data_create_vacancy_inner_p mulishr">Вакансия опубликована {{ \Carbon\Carbon::parse($vacancy->created_at)->isoFormat('D MMMM YYYY') }}</p>
        
            @if (Auth::check())
                    <!-- Button trigger modal -->
                    <button type="button" class="btn_response_bigger p-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Откликнуться
                    </button>

                @else
                
                <a href="#" class="btn_response_bigger">Откликнуться</a>

            @endif

            <hr class="hr_blue">
        </div>

        @if($randomVacancies->isNotEmpty())
        <div class="random_vacancys_block align-items-center align-items-xl-start p-2 p-xl-2 p-xxl-0 ">
            @foreach($randomVacancies as $vacancy)   
            <div class="cards_vacancy_main_block2">
                <div class="cards_vacancy_main_block_info2">
                    <div class="cards_vacancy_main_block_info_title_vacancy_group">
                        <div class="cards_vacancy_main_block_info_title_vacancy_group_inner">
                            <p class="cards_vacancy_main_block_info_title_vacancy2 mulishb">{{ $vacancy->title }}</p>
                            <p class="cards_vacancy_main_block_info_income_level_vacancy mulishb">от {{ number_format($vacancy->salary_from, 0, '.', ' ') }} ₽</p>
                        </div>
                        <img src="{{ asset('storage/' . $vacancy->company->logo) }}" alt="Company Logo" class=" company_logo">
                    </div>
                    
                    <p class="cards_vacancy_main_block_info_company_vacancy2 mulishr">{{ $vacancy->company->name }}, {{ $vacancy->region->name }}</p>

                    <div class="cards_vacancy_main_block_info_experience_and_icon_vacancy2">
                        <img src="{{ asset('img/icons/chemodan.svg') }}" alt="" class="icon_experience">
                        <p class="cards_vacancy_main_block_info_experience_vacancy">{{ $vacancy->required_experience }}</p>
                    </div>

                <div class="cards_vacancy_main_block_info_description_and_btn">
                    <div class="cards_vacancy_main_block_info_description" id="descriptionContainer">
                        <p class="cards_vacancy_main_block_info_description_p mulishr descriptionText" >{{ $vacancy->description }}</p>
                    </div>
                    
                    <a href="{{ route('show', $vacancy->id) }}" class="btn_response mulishSM">Откликнуться</a>
                </div>
                    
                </div>
            </div>
            @endforeach
        </div>
        @endif
        

           
        </div>
    </section>
    
    <script>
        function truncateText(elements, maxLength) {
            elements.forEach(function(element) {
                let text = element.textContent.trim();
                if (text.length > maxLength) {
                    element.textContent = text.slice(0, maxLength) + '...';
                }
            });
        }
    
        // Пример использования:
        let descriptionTexts = document.querySelectorAll('.descriptionText');
        truncateText(descriptionTexts, 230); // Максимальная длина текста 240 символов
    </script>
</body>
@endsection