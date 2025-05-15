<?php

declare(strict_types=1);

use App\Http\Controllers\Allegro\AllegroController;


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/
// Main
Route::get('/inittoken', [AllegroController::class, 'initToken'])->name('allegro.inittoken');
Route::get('/gettoken/{device_code}', [AllegroController::class, 'getToken'])->name('allegro.gettoken');
Route::get('/checktoken', [AllegroController::class, 'checkToken'])->name('allegro.checktoken');

Route::get('/loadmaincategories', [AllegroController::class, 'loadMainCategories'])->name('allegro.loadmaincategories');
Route::get('/processcategories/{levelprocess?}', [AllegroController::class, 'processCategories'])->name('allegro.processcategories');
Route::get('/processparameter/{levelprocess?}', [AllegroController::class, 'processParameter'])->name('allegro.processparameter');
Route::get('/processproducts/{levelprocess?}', [AllegroController::class, 'processProducts'])->name('allegro.processproducts');
Route::get('/loadchangescategories', [AllegroController::class, 'loadChangesCategories'])->name('allegro.loadchangescategories');

// Route::group([], function () {

    // Route::get('loadmaincategories', [AllegroController::class, 'loadMainCategories'])->name('loadmaincategories');

    // Route::screen('/main', PlatformScreen::class)
    //     ->name('platform.main');

    // // Platform > System > Users
    // Route::screen('users/{user}/edit', UserEditScreen::class)
    //     ->name('platform.systems.users.edit')
    //     ->breadcrumbs(fn (Trail $trail, $user) => $trail
    //         ->parent('platform.systems.users')
    //         ->push(__('User'), route('platform.systems.users.edit', $user)));

    // Route::screen('lang/edit/{id?}', LangEditScreen::class)->name('platform.lang.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('lang list', route('platform.lang.list'))
    //             ->push('Edit lang');
    //     });

    // Route::post('lang/remove/{id?}', [LangEditScreen::class, 'delete'])->name('platform.lang.remove');


    // Route::post('faq/remove/{id?}', [FaqEditScreen::class, 'delete'])->name('platform.faq.remove');


    // Route::get('maps/editcl/{id?}', [MapsEditScreen::class, 'changeLang'])->name('platform.maps.editcl');

// });
