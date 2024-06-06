@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)
@section ('content')
    <section class="help_page_area p-2 p-xl-2 p-xxl-0">
        <div class="container_main">
            <div class="about_company_blocks_group">

                <div class="about_company_block">
                    <p class="about_company_block_h">Помощь</p>
                    <p class="about_company_block_p">Добро пожаловать на страницу помощи JobWave! Здесь вы найдете ответы на часто задаваемые вопросы, руководства по использованию сайта и полезные советы.</p><br>
                    <p class="about_company_block_h2">
                    Часто задаваемые вопросы (FAQ)
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">1. Как зарегистрироваться на JobWave?</p>
                    <p class="about_company_block_p">
                        Чтобы зарегистрироваться, нажмите на кнопку "Регистрация" в правом верхнем углу страницы и следуйте инструкциям. Вы можете зарегистрироваться как соискатель или работодатель.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">2. Как разместить вакансию?</p>
                    <p class="about_company_block_p">
                        Для размещения вакансии вам необходимо зарегистрироваться как работодатель, затем перейти в личный кабинет и нажать на кнопку "Добавить вакансию". Заполните все необходимые поля и нажмите "Опубликовать".
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">3. Как найти подходящие вакансии?</p>
                    <p class="about_company_block_p">
                        Используйте нашу поисковую систему, чтобы найти вакансии по ключевым словам, местоположению, уровню зарплаты и другим параметрам. Вы также можете настроить фильтры для более точного поиска.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">4. Как откликнуться на вакансию?</p>
                    <p class="about_company_block_p">
                        Для отклика на вакансию вам необходимо зарегистрироваться как соискатель, найти интересующую вакансию и нажать кнопку "Откликнуться". Выберите подходящее резюме и прикрепите его к отклику.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">5. Как удалить или убрать вакансию в архив?</p>
                    <p class="about_company_block_p">
                        Для удаления вакансии необходимо нажать на крестик на странице "Вакансии" в личном кабинете работодателя. Чтобы убрать вакансию в архив, необходимо нажать на кнопку "Перевести в архив" на странице "Вакансии" в личном кабинете работодателя.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">Техническая поддержка</p>
                    <p class="about_company_block_p">
                        Если вы столкнулись с техническими проблемами при использовании сайта, пожалуйста, свяжитесь с нашей службой поддержки: <br><br>
                        <b>Электронная почта:</b> <a href="mailto:support@jobwave.ru?subject=Общий вопрос" class="blue_p">support@jobwave.ru</a>
                        <br>
                        <b>Телефон:</b> +7-985-482-82-48
                    </p>
                </div>
               
                
            </div>
        </div>
    </section>




@endsection