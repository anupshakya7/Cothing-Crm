<?php
use Illuminate\Support\Facades\Route;
use Modules\SMS\Http\Controllers\SMSController;
Route::prefix('admin')->group(function(){
    //SMS Route
    Route::prefix('sms')->group(function() {
        Route::get('/', 'SMSController@index')->name('sms.index');
        Route::post('/send-sms', 'SMSController@smsSend')->name('send.sms');
        //Filter API
        Route::get('inBetweenDateFilter',[SMSController::class,'dateFilter'])->name('date.filter');
        Route::get('CustomerFilter',[SMSController::class,'CustomerFilter'])->name('data.CustomerFilter');

    });
    //SMS Route
    //Message Route
    Route::prefix('sms-message')->group(function(){
        Route::get('/','MessageController@index')->name("message.index");
        Route::get('/create','MessageController@create')->name('message.create');
        Route::post('/store','MessageController@store')->name('message.store');
        Route::patch("/update", "MessageController@update")->name("message.update");
        Route::delete("/delete/{id}", "MessageController@destroy")->name("message.delete");
    });
    //Message Route
});

