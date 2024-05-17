@extends('layouts.after_default_us')

@section('content')
        <form class="form_register_vacancy" enctype="multipart/form-data" method="post" action="{{ route('applicant.resume.create.submit') }}">
            @csrf
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
                <label for="job_title" class="form-label">Название должности</label>
                <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title') }}">
            </div>
            <div class="mb-3">
                <label for="willing_to_relocate" class="form-label">Готов к переезду</label>
                <select class="form-select" id="willing_to_relocate" name="willing_to_relocate">
                    <option value="готов к переезду">Готов к переезду</option>
                    <option value="не готов к переезду">Не готов к переезду</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="willing_to_travel" class="form-label">Готов к командировкам</label>
                <select class="form-select" id="willing_to_travel" name="willing_to_travel">
                    <option value="готов к командировкам">Готов к командировкам</option>
                    <option value="не готов к командировкам">Не готов к командировкам</option>
                </select>
            </div>

            <!-- Форма добавления образования -->
            <div class="mb-3">
                <label for="education" class="form-label">Образование</label>
                <div class="education-container">
                    <div class="education-inputs">
                        <div class="education-item">
                            <label for="start_date_0" class="form-label f12777">Дата начала обучения</label>
                            <input type="date" name="educations[0][start_date]" class="form-control mb-1" placeholder="Дата начала" id="start_date_0">
                            <label for="end_date_0" class="form-label f12777">Дата окончания обучения</label>
                            <input type="date" name="educations[0][end_date]" class="form-control mb-1" placeholder="Дата окончания" id="end_date_0">
                            <input type="text" name="educations[0][institution]" class="form-control mb-3" placeholder="Название учебного заведения">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-education">Удалить</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary add-education">Добавить образование</button>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="employment_type">Тип занятости:</label><br>
                @foreach ($employmentTypes as $type)
                    <input class="custom_checkbox form-check-input" type="checkbox" name="employment_type[]" value="{{ $type }}" id="{{ $type }}">
                    <label for="{{ $type }}">{{ $type }}</label><br>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="work_schedule">График работы:</label><br>
                @foreach ($workSchedules as $schedule)
                    <input class="custom_checkbox form-check-input" type="checkbox" name="work_schedule[]" value="{{ $schedule }}" id="{{ $schedule }}">
                    <label for="{{ $schedule }}">{{ $schedule }}</label><br>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="specialization_id" class="form-label">Специализация</label>
                <select class="form-select" id="specialization_id" name="specialization_id">
                    <option value="">Выберите специализацию</option>
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="profession_id">Профессия:</label>
                <select name="profession_id" class="form-select form-control-for-company" id="profession_id">
                    <option value="">Выберите профессию</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="desired_salary_min" class="form-label">Желаемая минимальная зарплата</label>
                <input type="text" class="form-control" id="desired_salary_min" name="desired_salary_min" value="{{ old('desired_salary_min') }}">
            </div>
            <div class="mb-3">
                <label for="desired_salary_max" class="form-label">Желаемая максимальная зарплата</label>
                <input type="text" class="form-control" id="desired_salary_max" name="desired_salary_max" value="{{ old('desired_salary_max') }}">
            </div>
            <!-- Остальные поля резюме -->

        <div class="mb-3">
            <label for="skills">Ключевые навыки:</label>
            <input type="text" name="skills" class="form-control" id="skills-input">
            <div id="skills-suggestions"></div> <!-- Этот блок будет содержать подсказки -->
            <ul id="selected-skills-list" class="list-group mt-1"></ul> <!-- Список выбранных навыков -->
            <input type="hidden" name="selected_skills_array" id="selected_skills_array">
        </div>

            <!-- Форма добавления опыта работы -->
            <div class="mb-3">
                <label for="work_experience" class="form-label">Опыт работы</label>
                <div class="work-experience-container">
                    <div class="work-experience-inputs">
                        <div class="work-experience-item">
                            <label for="start_date_0" class="form-label f12777">Дата начала работы</label>
                            <input type="date" name="work_experiences[0][start_date]" class="form-control mb-1" placeholder="Дата начала" id="start_date_0">
                            <label for="end_date_0" class="form-label f12777">Дата окончания работы</label>
                            <input type="date" name="work_experiences[0][end_date]" class="form-control mb-1" placeholder="Дата окончания" id="end_date_0">
                            <input type="text" name="work_experiences[0][company]" class="form-control mb-1" placeholder="Название компании">
                            <input type="text" name="work_experiences[0][position]" class="form-control mb-1" placeholder="Должность">
                            <textarea name="work_experiences[0][description]" class="form-control mb-3" placeholder="Описание"></textarea>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-work-experience">Удалить место работы</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary add-work-experience">Добавить опыт работы</button>
                </div>
            </div>
        
            <div class="mb-3">
                <label for="about_me" class="form-label">О себе</label>
                <textarea class="form-control" id="about_me" name="about_me">{{ old('about_me') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="citizenship" class="form-label">Гражданство</label>
                <input type="text" class="form-control" id="citizenship" name="citizenship" value="{{ old('citizenship') }}">
            </div>
            <div class="mb-3">
                <label for="commute_time" class="form-label">Время до работы</label>
                <select class="form-select" id="commute_time" name="commute_time">
                    <option value="менее часа">Менее часа</option>
                    <option value="около часа">Около часа</option>
                    <option value="не имеет значения">Не имеет значения</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="languages">Знание языков</label>
                <input type="text" name="languages" class="form-control" id="languages-input">
                <div id="languages-suggestions"></div> <!-- Этот блок будет содержать подсказки -->
                <ul id="selected-languages-list" class="list-group mt-1"></ul> <!-- Список выбранных языков -->
                <input type="hidden" name="selected_languages_array" id="selected_languages_array">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Фотография</label>
                <input type="file" name="photo" class="form-control" id="photo">
            </div>
            
            <button type="submit" class="btn_stock_main">Создать резюме</button>
        </form>
    
    <script>
        // Поле для ввода языков
        const languagesInput = document.getElementById('languages-input');
    
        // Получение списка языков с сервера
        fetch('/api/languages')
        .then(response => response.json())
        .then(data => {
            const languages = data;
    
            // Блок для отображения подсказок
            const languagesSuggestions = document.getElementById('languages-suggestions');
    
            // Блок для отображения выбранных языков
            const selectedLanguagesList = document.getElementById('selected-languages-list');
    
            // Добавить язык в список выбранных
            function addLanguageToSelectedList(language) {
                const listItem = document.createElement('li');
                listItem.textContent = language.name;
                listItem.dataset.languageId = language.id; // Сохраняем идентификатор языка в дата-атрибуте
                listItem.classList.add('selected-language', 'm-1', 'list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                listItem.style.backgroundColor = '#C3EDFF';
                listItem.style.borderRadius = '4px';
                listItem.style.padding = '5px 12px';
    
                // Кнопка для удаления языка из списка
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-sm');
                deleteButton.innerHTML = '<i class="bi bi-x"></i>';
                deleteButton.addEventListener('click', () => {
                    listItem.remove();
                    updateHiddenField();
                });
    
                listItem.appendChild(deleteButton);
                selectedLanguagesList.appendChild(listItem);
                updateHiddenField();
                console.log('Выбранный язык:', language);
    
            }
    
            // Функция для обновления скрытого поля с выбранными языками
            function updateHiddenField() {
                const selectedLanguages = Array.from(document.querySelectorAll('.selected-language')).map(language => language.dataset.languageId);
                document.getElementById('selected_languages_array').value = JSON.stringify(selectedLanguages);
            }
    
            // Функция для отображения подсказок и добавления выбранного языка
            function showLanguageSuggestions(input) {
                const inputValue = input.value.trim().toLowerCase();
                if (inputValue.length < 3) {
                    languagesSuggestions.innerHTML = '';
                    return;
                }
                const suggestions = languages.filter(language => language.name.toLowerCase().includes(inputValue));
                languagesSuggestions.innerHTML = '';
                suggestions.forEach(language => {
                    const suggestion = document.createElement('div');
                    suggestion.textContent = language.name;
                    suggestion.classList.add('language-suggestion', 'list-group-item');
                    suggestion.addEventListener('click', () => {
                        addLanguageToSelectedList(language);
                        input.value = '';
                        languagesSuggestions.innerHTML = ''; // Скрываем список подсказок
                    });
                    languagesSuggestions.appendChild(suggestion);
                });
            }
    
            // Обработчик события ввода для поля ввода языков
            languagesInput.addEventListener('input', () => {
                showLanguageSuggestions(languagesInput);
            });
        })
        .catch(error => {
            console.error('Ошибка при получении списка языков:', error);
        });
    </script>
    
    <script>
        let index = 0; // начальное значение индекса

        document.querySelector('.add-education').addEventListener('click', function() {
            const educationContainer = document.querySelector('.education-container');
            const educationInputs = document.querySelector('.education-inputs');

            const newEducationItem = document.createElement('div');
            newEducationItem.classList.add('education-item');

            newEducationItem.innerHTML = `
                <label for="start_date_${index}" class="form-label f12777">Дата начала обучения</label>
                <input type="date" name="educations[${index}][start_date]" class="form-control mb-1" placeholder="Дата начала" id="start_date_${index}">
                <label for="end_date_${index}" class="form-label f12777">Дата окончания обучения</label>
                <input type="date" name="educations[${index}][end_date]" class="form-control mb-1" placeholder="Дата окончания" id="end_date_${index}">
                <input type="text" name="educations[${index}][institution]" class="form-control mb-3" placeholder="Название учебного заведения">
                <button type="button" class="btn btn-sm btn-outline-danger remove-education">Удалить</button>
            `;
            
            educationInputs.appendChild(newEducationItem);
            
            index++; // увеличиваем индекс для следующего элемента
        });

        // Удаление блока образования
        document.querySelector('.education-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-education')) {
                event.target.closest('.education-item').remove();
            }
        });

    </script>

    <!-- опыт работы -->
    <script>
        // ОПЫТ РАБОТЫ
        let workExperienceIndex = 0; // начальное значение индекса

        document.querySelector('.add-work-experience').addEventListener('click', function() {
            const workExperienceInputs = document.querySelector('.work-experience-inputs');
            const newWorkExperienceItem = document.createElement('div');
            newWorkExperienceItem.classList.add('work-experience-item');
            newWorkExperienceItem.innerHTML = `
                <label for="start_date_${workExperienceIndex}" class="form-label f12777">Дата начала работы</label>
                <input type="date" name="work_experiences[${workExperienceIndex}][start_date]" class="form-control mb-1" placeholder="Дата начала" id="start_date_${workExperienceIndex}">
                <label for="end_date_${workExperienceIndex}" class="form-label f12777">Дата окончания работы</label>
                <input type="date" name="work_experiences[${workExperienceIndex}][end_date]" class="form-control mb-1" placeholder="Дата окончания" id="end_date_${workExperienceIndex}">
                <input type="text" name="work_experiences[${workExperienceIndex}][company]" class="form-control mb-1" placeholder="Название компании">
                <input type="text" name="work_experiences[${workExperienceIndex}][position]" class="form-control mb-1" placeholder="Должность">
                <textarea name="work_experiences[${workExperienceIndex}][description]" class="form-control mb-3" placeholder="Описание"></textarea>
                <button type="button" class="btn btn-sm btn-outline-danger remove-work-experience">Удалить место работы</button>
            `;
            workExperienceInputs.appendChild(newWorkExperienceItem);
            
            workExperienceIndex++; // увеличиваем индекс для следующего элемента
        });

        document.querySelector('.work-experience-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-work-experience')) {
                event.target.closest('.work-experience-item').remove();
            }
        });


    </script>

    <script>
        // Функция для загрузки списка профессий при выборе специализации
        function loadProfessions() {
                var specializationId = document.getElementById('specialization_id').value;
                var professionSelect = document.getElementById('profession_id');
                professionSelect.innerHTML = ''; // Очищаем список профессий

                // Запрос к серверу для получения списка профессий по выбранной специализации
                fetch('/api/professions/' + specializationId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function (profession) {
                            var option = document.createElement('option');
                            option.text = profession.name;
                            option.value = profession.id;
                            professionSelect.add(option);
                        });
                    });
            }

            // Обработчик события изменения выбора специализации
            document.getElementById('specialization_id').addEventListener('change', loadProfessions);

            // При загрузке страницы вызываем функцию загрузки профессий
            window.onload = loadProfessions;
    </script>

    <script>
        // Поле для ввода навыков
        const skillsInput = document.getElementById('skills-input');

        // Получение списка навыков с сервера
        fetch('/api/skills')
        .then(response => response.json())
        .then(data => {
        const skills = data;

        // Массив для хранения выбранных навыков
        const selectedSkills = [];

        // Блок для отображения подсказок
        const skillsSuggestions = document.getElementById('skills-suggestions');

        // Блок для отображения выбранных навыков
        const selectedSkillsList = document.getElementById('selected-skills-list');

        // Добавить навык в список выбранных
        function addSkillToSelectedList(skill) {
            if (!selectedSkills.includes(skill.id)) {
                selectedSkills.push(skill.id);

                const listItem = document.createElement('li');
                listItem.textContent = skill.name;
                listItem.dataset.skillId = skill.id; // Сохраняем идентификатор навыка в дата-атрибуте
                listItem.classList.add('selected-skill', 'm-1', 'list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                listItem.style.backgroundColor = '#C3EDFF';
                listItem.style.borderRadius = '4px';
                listItem.style.padding = '5px 12px';

                // Кнопка для удаления навыка из списка
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-sm');
                deleteButton.innerHTML = '<i class="bi bi-x"></i>';
                deleteButton.addEventListener('click', () => {
                    selectedSkills.splice(selectedSkills.indexOf(skill.id), 1);
                    listItem.remove();
                    updateHiddenField();
                });

                listItem.appendChild(deleteButton);
                selectedSkillsList.appendChild(listItem);
                updateHiddenField();
                console.log('Выбранный навык:', skill);
            }
        }

        // Функция для обновления скрытого поля с выбранными навыками
        function updateHiddenField() {
            document.getElementById('selected_skills_array').value = JSON.stringify(selectedSkills);
        }

        // Функция для отображения подсказок и добавления выбранного навыка
        function showSuggestions(input) {
            const inputValue = input.value.trim().toLowerCase();
            if (inputValue.length < 3) {
                skillsSuggestions.innerHTML = '';
                return;
            }
            const suggestions = skills.filter(skill => skill.name.toLowerCase().includes(inputValue) && !selectedSkills.includes(skill.id));
            skillsSuggestions.innerHTML = '';
            suggestions.forEach(skill => {
                const suggestion = document.createElement('div');
                suggestion.textContent = skill.name;
                suggestion.classList.add('skill-suggestion', 'list-group-item');
                suggestion.addEventListener('click', () => {
                    addSkillToSelectedList(skill);
                    input.value = '';
                    skillsSuggestions.innerHTML = ''; // Скрываем список подсказок
                });
                skillsSuggestions.appendChild(suggestion);
            });
        }

        // Обработчик события ввода для поля ввода навыков
        skillsInput.addEventListener('input', () => {
            showSuggestions(skillsInput);
        });
    })
    .catch(error => {
        console.error('Ошибка при получении списка навыков:', error);
    });
    </script>


@endsection
