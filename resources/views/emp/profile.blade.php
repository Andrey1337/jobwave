@extends(
Auth::guard('web')->check() ?
'layouts.after_default_us' :
(Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)


@section('content')

<section class="profile_company_info_area">
    <div class="container_main p-2 p-xl-2 p-xxl-0">
        <div class="profile_company_info_block">
            <div class="profile_company_info_block_title_and_logo">
                <div class="profile_company_info_block_title_and_logo_inner">
                    <p class="profile_company_info_block_title_and_logo_type mulishr">{{ $company->company_type }}</p>
                    <p class="profile_company_info_block_title_and_logo_title mulishb">{{ $company->name }}</p>
                </div>

                <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class=" company_logo_in_vacancy">
            </div>

            <p class="profile_company_info_block_description mulishr">{{ $company->description }}</p>

            <hr class="hr_blue">
        </div>


        <div class="reviews_main_area">
            <div class="top_block_reviews_text_with_btn">
                <p class="top_block_reviews_text_with_btn_p">Отзывы</p>
                <!-- Button trigger modal -->
                <button type="button" class="m-2 m-xl-2 m-xxl-0 btn_outline_14 align-items-center"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Оставить отзыв
                </button>
            </div>

            <div class="block_reviews_main">
                @if($reviews->isEmpty())
                <p>Пока нет отзывов</p>
                @else
                @foreach($reviews->take(2) as $review)
                <div class="review">
                    <p class="review_employee_profession_result">{{ $review->employee_profession }}</p>
                    <div class="review_rating_and_created_data_block">
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$review->stars)
                                <img src="{{ asset('img/icons/star.svg') }}" alt="Star">
                                @else
                                <img src="{{ asset('img/icons/star_grey.svg') }}" alt="Star">
                                @endif
                                @endfor
                        </div>
                        <p class="review_created_data">{{ \Carbon\Carbon::parse($review->created_at)->isoFormat('MMMM
                            YYYY') }}</p>
                    </div>
                    <p class="review_description_result mulishr">{{ $review->description }}</p>
                </div>
                @endforeach

                @endif

            </div>
            <hr class="hr_blue">
        </div>





        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Отзыв</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form class="form_register acn mb-3"
                            action="{{ route('emp.add_review', ['companyId' => $company->id]) }}" method="POST">
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
                            <div class="form-group">
                                <label for="employee_profession">Профессия сотрудника:</label>
                                <input type="text" name="employee_profession" id="employee_profession"
                                    class="form-control">
                            </div>

                            <div class="form-group stars_with_input">
                                <label for="stars">Оценка:</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="stars" value="5">
                                    <label for="star5" class="star"><img src="{{ asset('img/icons/star_grey.svg') }}"
                                            alt="Star"></label>
                                    <input type="radio" id="star4" name="stars" value="4">
                                    <label for="star4" class="star"><img src="{{ asset('img/icons/star_grey.svg') }}"
                                            alt="Star"></label>
                                    <input type="radio" id="star3" name="stars" value="3">
                                    <label for="star3" class="star"><img src="{{ asset('img/icons/star_grey.svg') }}"
                                            alt="Star"></label>
                                    <input type="radio" id="star2" name="stars" value="2">
                                    <label for="star2" class="star"><img src="{{ asset('img/icons/star_grey.svg') }}"
                                            alt="Star"></label>
                                    <input type="radio" id="star1" name="stars" value="1">
                                    <label for="star1" class="star"><img src="{{ asset('img/icons/star_grey.svg') }}"
                                            alt="Star"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Описание:</label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>

                            </div>
                            <input type="hidden" name="company_id" value="{{ $company->id }}">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn_stock_outline mulishr" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn_stock_outline mulishr">Оставить отзыв</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(count($vacancies) > 0)
        <p class="vacancys_company_profile_block_h">Вакансии компании</p>
        <div class="vacancys_company_profile_block">
            @foreach($vacancies as $vacancy)
            <a href="{{ route('show', ['id' => $vacancy->id]) }}" class="vacancys_company_profile_btn">{{
                $vacancy->title }}</a>
            @endforeach
        </div>
        @endif

    </div>















</section>







<script>
    document.addEventListener('DOMContentLoaded', function () {
        var stars = document.querySelectorAll('.star-rating input[type="radio"]');
        var starLabels = document.querySelectorAll('.star-rating label.star img');

        stars.forEach(function (star, index) {
            star.addEventListener('change', function () {
                fillStars(index);
            });
        });

        function fillStars(index) {
            starLabels.forEach(function (img, i) {
                if (i <= index) {
                    img.src = "{{ asset('img/icons/star.svg') }}";
                } else {
                    img.src = "{{ asset('img/icons/star_grey.svg') }}";
                }
            });
        }
    });
</script>

@endsection