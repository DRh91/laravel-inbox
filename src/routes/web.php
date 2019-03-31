<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace'=>'drhd\inbox\Http\Controllers', 'names' => []], function () {
    Route::resource('/inbox', 'InboxController')->except(['edit', 'update', 'destroy']);
});