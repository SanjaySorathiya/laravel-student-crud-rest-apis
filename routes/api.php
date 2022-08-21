<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentication Routes --------------------------------------------------------
Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);


Route::group(['middleware' => ['jwt.verify']], function() {

    // Auth
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);    

    // Student Routes
    Route::get('students', [StudentController::class, 'getAllStudents']);
    Route::post('student/create', [StudentController::class, 'createStudent']);
    Route::get('student/{id}', [StudentController::class, 'getStudent']);
    Route::get('findStudents', [StudentController::class, 'findStudents']);
    Route::put('student/update/{id}', [StudentController::class, 'updateStudent']);
    Route::delete('student/delete/{id}', [StudentController::class, 'deleteStudent']);    
});