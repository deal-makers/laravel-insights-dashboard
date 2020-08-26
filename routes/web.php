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
    Route::resource('detections', 'Pages\DetectionsController');
    Route::post('upload_file', 'Pages\DetectionsController@ajaxUploadFile');
    Route::post('delete_file', 'Pages\DetectionsController@ajaxDeleteFile');
    Route::post('mark_read/{detection}', 'Pages\DetectionsController@ajaxMarkRead');
    Route::post('send_feedback/{detection}', 'Pages\DetectionsController@ajaxSendFeedback');
    Route::resource('contacts', 'Pages\ContactsController');

    Route::get('load_file', 'Pages\DetectionsController@ajaxLoadFile');
    Route::get('download_file', 'Pages\DetectionsController@downLoadFile');
    Route::resource('tags', 'Pages\TagsController');
    Route::post('tagupdate/{tag}', 'Pages\TagsController@ajaxUpdate');

});

Route::get('approval', 'User\DashboardController@approval')->name('approval');


Route::middleware(['approved'])->group(function () {

   
    
});
