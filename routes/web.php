<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterEmployerController;
use App\Http\Controllers\Auth\AuthEmployerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ApplicantAuthController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\LanguageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/about_company", [EmployerController::class, 'about_us'])->name('about_company'); 
Route::get("/contacts", [EmployerController::class, 'contacts'])->name('contacts'); 
Route::get("/help", [EmployerController::class, 'help_page'])->name('help_page'); 
Route::get("/privacy_policy", [EmployerController::class, 'privacy_policy'])->name('privacy_policy'); 



// Main Search Page for Employer
Route::get('/search_main', [EmployerController::class, 'search_main_view'])->name('search_main');
Route::post('/search_main', [EmployerController::class, 'search'])->name('search_main');
Route::get('/load-more-regions', [EmployerController::class, 'loadMoreRegions'])->name('load_more_regions');
Route::get('/load-more-regions-sidebar', [EmployerController::class, 'loadMoreRegionsSidebar'])->name('load_more_regions_sidebar');
Route::get('/reset-filters', [EmployerController::class, 'resetFilters'])->name('reset_filters');

// Links from main_user
Route::get('/search_main/regions', [EmployerController::class, 'vacanciesByRegion'])->name('vacancies_by_region');
Route::get('/search_main/specialization', [EmployerController::class, 'vacanciesBySpecialization'])->name('vacancies_by_specialization');


// Card Vacancy
Route::get('/vacancy/{id}', [EmployerController::class, 'show'])->name('show');

// About Company
Route::get('/company/{companyId}', [EmployerController::class, 'profile'])->name('emp.profile');
Route::post('/add_review/{companyId}', [EmployerController::class, 'addReview'])->name('emp.add_review');




Route::get('/api/professions/{specialization_id}', [VacancyController::class, 'getProfessions']);
Route::get('/api/skills', [SkillController::class, 'getSkills']);
Route::get('/api/languages', [LanguageController::class, 'index']);

// Маршруты, доступные только для неавторизованных пользователей
Route::group(['middleware' => 'guest.only'], function () {
    Route::get('/', [EmployerController::class, 'main'])->name('main_for_emp'); 
    Route::get('/main_for_user', [UserController::class, 'main'])->name('main_for_user'); 

    Route::get('/register_employer', [RegisterEmployerController::class, 'showRegisterFormEmp'])->name('register_employer');
    Route::post('/register_employer', [RegisterEmployerController::class, 'register']);
    
    Route::get('/login_employer', [AuthEmployerController::class, 'showAuthFormEmp'])->name('login_employer');
    Route::post('/login_employer', [AuthEmployerController::class, 'login']);

    // Маршруты для входа соискателей
    Route::get('/login/applicant', [ApplicantAuthController::class, 'showLoginForm'])->name('applicant.login');
    Route::post('/login/applicant', [ApplicantAuthController::class, 'login'])->name('applicant.login.submit');
    
    // Маршруты для регистрации соискателей
    Route::get('/register/applicant', [ApplicantAuthController::class, 'showRegistrationForm'])->name('applicant.register');
    Route::post('/register/applicant', [ApplicantAuthController::class, 'register'])->name('applicant.register.submit');
});

// Маршруты, доступные только для авторизованных компаний
Route::middleware('auth:company')->group(function () {
    Route::post('/company/profile', [RegisterEmployerController::class, 'update'])->name('company.profile.update');
    Route::post('/company/change-password', [RegisterEmployerController::class, 'changePassword'])->name('company.change.password');
    Route::post('/payment/process', [EmployerController::class, 'process'])->name('payment.process');
    Route::post('/cancel-subscription', [EmployerController::class, 'cancel_subscribe'])->name('cancel.subscription');
    Route::delete('/vacancy/{vacancy}', [VacancyController::class, 'destroy'])->name('delete.vacancy');
    
    // Employer and Vacancy Profile
    Route::post('/logout_employer', [AuthEmployerController::class, 'logout'])->name('logout_employer');
    Route::get('/dashboard_employer', [EmployerController::class, 'dashboard_view'])->name('dashboard_employer');
    Route::get('/vacancy_list', [EmployerController::class, 'vacancys_view'])->name('vacancy_list');
    Route::post('/change-vacancy-status/{id}', [VacancyController::class, 'changeStatus'])->name('change_vacancy_status');
    Route::get('/create_vacancy', [VacancyController::class, 'create_vacancy_view'])->name('create_vacancy');
    Route::post('/create_vacancy', [VacancyController::class, 'create'])->name('create_vacancy');
    Route::post('/propose-job', [ResumeController::class, 'proposeJob'])->name('propose_job');
    Route::delete('/responses/{id}', [EmployerController::class, 'deleteResponse'])->name('responses.delete');
    Route::get('/search_resume', [ResumeController::class, 'showSearchForm'])->name('search_resume');
    Route::post('/search_resume', [ResumeController::class, 'search'])->name('search_resume.submit');
    
});

    

// Маршруты, доступные только для авторизованных соискателей
Route::middleware('auth:web')->group(function () {
    // Маршрут для отображения формы создания резюме
    Route::get('/dashboard_user/resume/create', [ResumeController::class, 'showCreateForm'])->name('applicant.resume.create');

    // Маршрут для отправки формы создания резюме
    Route::post('/dashboard_user/resume/create', [ResumeController::class, 'create'])->name('applicant.resume.create.submit');

    Route::get('/dashboard_user', [UserController::class, 'dashboard'])->name('dashboard_user');
    Route::post('/dashboard_user/update-status', [UserController::class, 'updateStatus'])->name('update_status');
    Route::get('/resume/{id}/edit', [ResumeController::class, 'edit'])->name('resume.edit');
    Route::post('/resume/{id}/update', [ResumeController::class, 'update'])->name('resume.update');
    Route::delete('/resume/{id}', [ResumeController::class, 'destroy'])->name('resume.destroy');
    Route::put('/resume/{id}/update', [ResumeController::class, 'update'])->name('resume.update');

    // Отправка отклика
    Route::post('/send-response', [ResumeController::class, 'sendResponse'])->name('send_response');
    Route::post('/logout_applicant', [ApplicantAuthController::class, 'logout'])->name('logout_applicant');
});

Route::get('/responses', [ResumeController::class, 'response_view'])->name('responses.view');


Route::get('/candidates', [EmployerController::class, 'candidates'])->name('candidates');
Route::post('/response/{response}/change_status', [ResumeController::class, 'changeStatus'])->name('response.change_status');

// Маршруты для резюме
Route::get('/dashboard_user/resume/{id}', [ResumeController::class, 'show'])->name('resume.show');
Route::get('/resume/show/{id}', [ResumeController::class, 'showAll'])->name('resume.showAll');



// Route::group(['middleware' => 'job_seeker'], function () {

    
// });


// // Группа маршрутов для регистрации и входа, перенаправляющая авторизованных пользователей
// Route::group(['middleware' => 'company'], function () {
//     Route::get('/register_employer', [RegisterEmployerController::class, 'showRegisterFormEmp'])->name('register_employer');
//     Route::post('/register_employer', [RegisterEmployerController::class, 'register']);
    
//     Route::get('/login_employer', [AuthEmployerController::class, 'showAuthFormEmp'])->name('login_employer');
//     Route::post('/login_employer', [AuthEmployerController::class, 'login']);
// });


// // Resume Routes
// Route::get('/search', [ResumeController::class, 'search'])->name('search_resumes');
// Route::get('/resume/{id}', [ResumeController::class, 'show'])->name('show_resume');
// Route::post('/resume/{id}/invite', [ResumeController::class, 'invite'])->name('invite_to_interview');
