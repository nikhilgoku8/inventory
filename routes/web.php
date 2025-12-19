<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
});
