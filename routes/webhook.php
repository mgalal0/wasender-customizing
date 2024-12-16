<?php

use App\Http\Controllers\Webhook\MyFatoorahController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function () {
    Route::post('myfatoorah', [MyFatoorahController::class, 'index']);
});
