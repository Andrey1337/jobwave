@extends ('layouts.after_default_us')
@section ('content')

    <section class="resume_content_area">
        <div class="container_main">
            <div class="resume_block p-2 p-xl-1 p-xxl-0">
                <div class="resume_block_h_and_btn_call">
                    <p class="resume_block_h_and_btn_call_text">Мои резюме</p>
                    <a href="{{ route('applicant.resume.create')}}" class="btn_outline_14">Создать резюме</a>
                </div>
                @if (session('success'))
                <div class="succ" id="successAlert">
                    <div class="alert_default">
                        {{ session('success') }}
                    </div>
                </div>
                @endif
                <div class="resume_block_status_work">
                    @php
                        $statusIcon = '';
                        switch($user->status) {
                            case 'Активно ищу работу':
                                $statusIcon = 'green_status.svg';
                                break;
                            case 'Рассматриваю предложения':
                                $statusIcon = 'yellow_status.svg';
                                break;
                            case 'Не ищу работу':
                                $statusIcon = 'red_status.svg';
                                break;
                            default:
                                $statusIcon = 'green_status.svg';
                        }
                    @endphp
                    <div class="resume_block_status_work_icon_with_text">
                        <img src="{{ asset('img/icons/'.$statusIcon )}}" alt="status_work" class="status_work_icon">
                        <p class="resume_block_status_work_text">{{ $user->status }}</p>
                    </div>
                    <button type="button" class="resume_block_status_work_icon_with_text_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Изменить</button>
                </div>                
            </div>
        </div>
    </section>

    <section class="my_resumes_area p-2 p-xl-1 p-xxl-0">
            <div class="container_main">
                <div class="my_resumes_blocks_group">
                    @foreach($resumes as $resume)
                    <div class="my_resumes_block">
                        <a class="my_resumes_block_title" href="{{ route('resume.show', ['id' => $resume->id]) }}">{{ $resume->job_title }}</a>
                        <p class="my_resumes_block_updated_at">Обновлено {{ \Carbon\Carbon::parse($resume->updated_at)->isoFormat('D MMMM YYYY в HH:mm') }}</p>
                        <div class="my_resumes_block_stats_group">
                            <p class="my_resumes_block_stats_group_h">Статистика</p>
                            <div class="my_resumes_block_stats_group_inner">
                                <p class="my_resumes_block_stats_group_inner_stat border_right_grey">{{ $resume->views }} <span class="t_blue">просмотров</span></p>
                                <p class="my_resumes_block_stats_group_inner_stat">{{ $resume->invitations_count ?? 0 }} <span class="t_blue">приглашений</span></p>
                            </div>
                        </div>


                        <div class="my_resumes_block_btns_group">
                            <form action="{{ route('resume.edit', ['id' => $resume->id]) }}" method="GET" style="display: inline;">
                                <button type="submit" class="btn_stock_14">Редактировать</button>
                            </form>
                            <form action="{{ route('resume.destroy', ['id' => $resume->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn_outline_14_w160">Удалить</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    
                    

                </div>
            </div>
        </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение статуса</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_status') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Новый статус:</label>
                            <select class="form-select" name="status" id="status">
                                <option value="Активно ищу работу">Активно ищу работу</option>
                                <option value="Рассматриваю предложения">Рассматриваю предложения</option>
                                <option value="Не ищу работу">Не ищу работу</option>
                            </select>
                        </div>
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn_stock_outline mulishr" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn_stock_outline mulishr">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection