<?php

Route::redirect('/', 'dashboard');

Auth::routes(['register' => true]);

// Change Password Routes...

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', 'Pages\DashboardController@index')->name('dashboard');
    Route::resource('permissions', 'Pages\PermissionsController');
    Route::delete('permissions_mass_destroy', 'Pages\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Pages\RolesController');
    Route::delete('roles_mass_destroy', 'Pages\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Pages\UsersController');
    Route::delete('users_mass_destroy', 'Pages\UsersController@massDestroy')->name('users.mass_destroy');
    Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
    Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');
});

Route::get('approval', 'User\DashboardController@approval')->name('approval');


Route::middleware(['approved'])->group(function () {

    Route::get('create_paypal_plan/{subscribePlan}', 'PaypalController@create_plan');
    Route::get('create_stripe_plan/{plan}', 'PlanController@create_stripe_plan');
    Route::post('subscribe/stripe/{plan}', 'SubscribePlanController@create');
    Route::get('subscribe/stripe/cancel', 'SubscribePlanController@cancel');

    Route::get('subscribe/paypal/{subscribePlan}', 'PaypalController@paypalRedirect')->name('paypal.redirect');
    Route::get('subscribe/paypal/cancel/{subscribePlan}', 'PaypalController@paypalCancel')->name('paypal.cancel');
    Route::get('/plans', 'PlanController@index')->name('plans.index');

    Route::get('/user/subscriptions', 'PaypalController@subscriptions')->name("user.subscriptions");
    
});
