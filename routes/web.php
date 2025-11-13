<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

Route::get('/','\App\Http\Controllers\HomeController@redirectToCompanies');

// Authentication
Route::get('login', [AuthController::class,'showLogin'])->name('login');
Route::post('login', [AuthController::class,'login'])->name('login.post');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

// secured resource routes
Route::middleware('auth')->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('employees', EmployeeController::class);
});
