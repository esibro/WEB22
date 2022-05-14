<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    $courses =  DB::table('courses')->get();
    return view('courses.index', compact('courses'));
    //return $courses;
});

Route::get('/courses', function () {
    $courses =  DB::table('courses')->get();
    return view('courses.index', compact('courses'));
    //return $courses;
});

Route::get('/courses/{id}', function ($id) {
    $course =  DB::table('courses')->find($id);
    return view('courses.show', compact('course'));
    //return $courses;
});
