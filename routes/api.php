<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api', 'auth.jwt']], function (){
    Route::post('courses', [CourseController::class, 'save']);
    Route::put('courses/{subject}', [CourseController::class, 'update']);
    Route::delete('courses/{subject}', [CourseController::class, 'delete']);
    Route::post('auth/logout',[AuthController::class,'logout']);
    Route::get('mycourses/{user_id}', [CourseController::class, 'findByUserId']);

});


Route::post('auth/login',[AuthController::class,'login']);

Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{subject}', [CourseController::class, 'findBySubject']);
Route::get('courses/checksubject/{subject}', [CourseController::class, 'checkSubject']);
Route::get('courses/search/{description}', [CourseController::class, 'findByDescription']);

