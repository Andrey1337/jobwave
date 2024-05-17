@extends('layouts.main_afterEMP')


@section('content')
<div class="container_main">
<p class="text-center mulishb сreate_vacancy_h mb-5">Создание вакансии</p>


<form action="{{ route('create_vacancy') }}" class="form_register_vacancy" method="POST">
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
        <label for="title">Название вакансии:</label>
        <input type="text" name="title" class="form-control form-control-for-company" id="title">
    </div>

    <div class="mb-3">
        <label for="description">Описание вакансии:</label>
        <textarea name="description" class="form-control form-control-for-company" style="height: 100px" id="description"></textarea>
    </div>

    <div class="mb-3">
        <label for="required_experience">Опыт работы:</label>
        <select name="required_experience" class="form-control" id="required_experience">
            <option value="Не имеет значения">Не имеет значения</option>
            <option value="От 1 года до 3 лет">От 1 года до 3 лет</option>
            <option value="Нет опыта">Нет опыта</option>
            <option value="От 3 до 6 лет">От 3 до 6 лет</option>
            <option value="Более 6 лет">Более 6 лет</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="skills">Требуемые навыки:</label>
        <input type="text" name="skills" class="form-control" id="skills-input">
        <div id="skills-suggestions"></div> <!-- Этот блок будет содержать подсказки -->
        <ul id="selected-skills-list" class="list-group mt-1"></ul> <!-- Список выбранных навыков -->
        <input type="hidden" name="selected_skills_array" id="selected_skills_array">
    </div>


    <div class="mb-3">
        <label for="salary_from">Зарплата от:</label>
        <input type="text" name="salary_from" class="form-control form-control-for-company" id="salary_from">
    </div>

    <div class="mb-3">
        <label for="salary_to">Зарплата до:</label>
        <input type="text" name="salary_to" class="form-control form-control-for-company" id="salary_to">
    </div>

    <div class="mb-3">
        <label for="specialization_id">Специализация:</label>
        <select name="specialization_id" class="form-control form-control-for-company" id="specialization_id">
            @foreach($specializations as $specialization)
                <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="profession_id">Профессия:</label>
        <select name="profession_id" class="form-control form-control-for-company" id="profession_id">
            <option value="">Выберите профессию</option>
        </select>
    </div>

    <div class="mb-3">
        <!-- Остальные поля... -->

        <!-- Поле График работы -->
        <label for="schedule">График работы:</label>
        <select name="schedule" class="form-control" id="schedule">
            <option value="Полный день">Полный день</option>
            <option value="Сменный график">Сменный график</option>
            <option value="Удаленная работа">Удаленная работа</option>
            <option value="Гибкий график">Гибкий график</option>
            <option value="Вахтовый метод">Вахтовый метод</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="region">Регион:</label>
            <select name="region_id" class="form-control" id="region">
                <option value="">Выберите регион</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
            </select>
    </div>


    <div class="mb-3">
        <!-- Поле Образование -->
        <label for="education">Образование:</label>
        <select name="education" class="form-control" id="education">
            <option value="Не требуется или не указано">Не требуется или не указано</option>
            <option value="Высшее">Высшее</option>
            <option value="Среднее профессиональное">Среднее профессиональное</option>
        </select>
    </div>

    <div class="mb-3">
        <!-- Поле Тип занятости -->
        <label for="employment_type">Тип занятости:</label>
        <select name="employment_type" class="form-control" id="employment_type">
            <option value="Полная занятость">Полная занятость</option>
            <option value="Частичная занятость">Частичная занятость</option>
            <option value="Стажировка">Стажировка</option>
            <option value="Волонтерство">Волонтерство</option>
        </select>
    </div>
    



    <button type="submit" class="btn_stock_main">Создать вакансию</button>
</form>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const selectedSkills = Array.from(document.querySelectorAll('.selected-skill')).map(skill => skill.dataset.skillId);
        console.log('Selected skills:', selectedSkills); // Проверяем, какие навыки выбраны
        if (selectedSkills.length === 0) {
            event.preventDefault(); // Предотвращаем отправку формы
            alert('Выберите хотя бы один навык!'); // Выводим сообщение об ошибке
        } else {
            document.getElementById('selected_skills_array').value = JSON.stringify(selectedSkills);
        }
    });
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


</div>






































    <form method="post" class="" action="{{route('logout_employer')}}">
        @csrf
        <button class="btn_bigger_main">Выйти</button>

    </form>
</div>


@endsection