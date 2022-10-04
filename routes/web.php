<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ResultController;
use App\Http\Controllers\Web\SubjectController;
use App\Models\Result;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/home', [App\Http\Controllers\Web\DashboardController::class, 'index'])->name('home');
//Quiz
Route::get('/create/quiz', [App\Http\Controllers\Web\QuizController::class, 'create'])->name('create.quiz');
Route::get('/quizzes', [App\Http\Controllers\Web\QuizController::class, 'index'])->name('quiz.view');
Route::get('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'edit'])->name('quiz.edit');
Route::post('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'update']);
Route::post('/create/quiz', [App\Http\Controllers\Web\QuizController::class, 'store']);
Route::get('/quiz/delete/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'destroy'])->name('quiz.delete');


//Questions
Route::get('/create/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'create'])->name('create.question');
Route::get('/questions', [App\Http\Controllers\Web\QuestionController::class, 'index'])->name('question.view');
Route::get('/get/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'getQuestion'])->name('question.get');

// Route::get('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'edit'])->name('quiz.edit');
// Route::post('/quiz/{quiz}', [App\Http\Controllers\Web\QuizController::class, 'update']);
Route::post('/create/questions/{quiz?}', [App\Http\Controllers\Web\QuestionController::class, 'store']);
Route::get('/question/delete/{question}/{quiz}', [App\Http\Controllers\Web\QuestionController::class, 'destroy'])->name('question.delete');

//Subject
Route::get('/subject/list', [SubjectController::class, 'index'])->name('subject.list');
Route::post('/create/subject', [SubjectController::class, 'store']);
Route::get('/create/subject', [SubjectController::class, 'create'])->name('teacher.create.subject');
Route::post('/edit/{subject}/subject', [SubjectController::class, 'update']);
Route::get('/edit/{subject}/subject', [SubjectController::class, 'show'])->name('teacher.edit.subject');
Route::get('/subject/{subject}/destroy', [SubjectController::class, 'destroy'])->name('subject.delete');
Route::get('/subject/{status}/{subject}/update', [SubjectController::class, 'statusUpdate'])->name('subject.status');

//User
Route::get('/user/list', [App\Http\Controllers\Web\UserController::class, 'index'])->name('user.list');
Route::post('/user/create', [App\Http\Controllers\Web\UserController::class, 'store']);
Route::post('/user/approve', [App\Http\Controllers\Web\UserController::class, 'statusUpdate']);
Route::get('/user/disable/{user}', [App\Http\Controllers\Web\UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/settings', [App\Http\Controllers\Web\UserController::class, 'userprofile'])->name('user.profile');
Route::post('/user/changepass', [App\Http\Controllers\Web\UserController::class, 'changedPass'])->name('user.changepass');

// Route::get('show/results', function () {
//     $result = Result::find(2);

//     $data['result'] = $result;
//     $data['result_json'] = json_decode($result->results);
//     // dd($data['result_json'][0]->id);
//     return view('admin.showresults', $data);
// });
Route::get('/download/result/{user}/{quiz}', [App\Http\Controllers\Web\DashboardController::class, 'pdfview'])->name('download.results');

//Results
Route::get('/result/{quiz}/users', [App\Http\Controllers\Web\ResultController::class, 'index'])->name('quiz.results');

Route::get('/', [HomeController::class, 'index']);
Route::get('privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');
Route::post('contact', [HomeController::class, 'contact'])->name('contact');
