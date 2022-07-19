<?php

use Illuminate\Support\Facades\Route;

/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('send-mail', [App\Http\Controllers\EmailController::class, 'sendEmail']);
Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::group([ 'middleware' => 'Language'], function () {
	Route::get('/home',"\App\Http\Controllers\HomeController@index")->name('home');
	Route::get('/change-language/{lang}',"\App\Http\Controllers\HomeController@changeLang");
    Route::resource('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();