<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminControllerWeb;

Route::get('/', function () { return view('auth.home'); });

Route::get('/admin', AdminControllerWeb::class);

Route::get('/login', function () { return view('auth.login'); });

Route::get('/dashboard', function () { return view('dashboard.dashboard'); });