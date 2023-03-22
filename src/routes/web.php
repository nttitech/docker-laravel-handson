
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailSendController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail', [MailSendController::class, 'send']);

