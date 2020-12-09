<?php

use Illuminate\Support\Facades\Route;

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
    return view('app');
});

Route::post('calendar/events', 'App\Http\Controllers\CalendarEventsController@saveEvents');
Route::get('calendar/current_month', 'App\Http\Controllers\CalendarEventsController@getMonth');
Route::get('calendar/events_list', 'App\Http\Controllers\CalendarEventsController@getEvents');
