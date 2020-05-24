<?php

use App\Model\Image;
use App\Model\Product;
use App\Model\Role;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('users', function () {

    return User::with('billingAddress')-> paginate(50);
});

Route::get('products', function () {
    return Product::paginate(100);

});

Route::get('images', function () {
    return Image::paginate(100);

});




Route::get('/', function () {
    return view('welcome');
});

//test

Route::get('e', function () {
    return 'hww';
})->Middleware(['auth','user_is_admin']);



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['auth','user_is_admin'], function() {

    //Units
    Route::get('units','UnitController@index')->name('units');
    Route::post('units','UnitController@store');
    Route::delete('units','UnitController@destroy');
    //Categories
    Route::get('categories','CategoryController@index')->name('categories');

    //Products
    Route::get('products','ProductController@index')->name('products');


    //Tags
    Route::get('tags','TagController@index')->name('tags');

    //Payments
    //Orders
    //Shipments

    //Countries
    Route::get('Countries','CountryController@index')->name('countries');

    //Cities
    Route::get('cities','CityController@index')->name('cities');

    //States
    Route::get('states','StateController@index')->name('states');

    //Reviewes
    Route::get('reviews','ReviewController@index')->name('reviews');

    //Tickets

    Route::get('tickets','TicketController@index')->name('tickets');


    //Roles
    Route::get('roles','RoleController@index')->name('roles');


});


