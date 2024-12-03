<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\AuthController;

Route::post('/api/auth/register', [RegisterController::class, 'store']);
Route::post('/api/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
     Route::get('/api/city', [CitiesController::class, 'index']); 
     Route::get('/api/city/{id}', [CitiesController::class, 'show']); 
     Route::post('/api/city', [CitiesController::class, 'store']); 
     Route::put('/api/city/{id}', [CitiesController::class, 'update']); Route::delete('/api/city/{id}', [CitiesController::class, 'destroy']); 
     
     Route::get('/api/school', [SchoolController::class, 'index']); 
     Route::get('/api/school/{id}', [SchoolController::class, 'detail']); 
     Route::get('/api/school/{id}/class', [SchoolController::class, 'clases']); Route::get('/api/school/{id}/students', [SchoolController::class, 'students']); 
     Route::post('/api/school', [SchoolController::class, 'store']); 
     Route::put('/api/school/{id}', [SchoolController::class, 'update']); Route::delete('/api/school/{id}', [SchoolController::class, 'destroy']); 
     
     Route::get('/api/student-class', [StudentClassController::class, 'index']); Route::get('/api/student-class/{id}', [StudentClassController::class, 'show']); 
     Route::post('/api/student-class', [StudentClassController::class, 'store']); Route::put('/api/student-class/{id}', [StudentClassController::class, 'update']); 
     Route::delete('/api/student-class/{id}', [StudentClassController::class, 'destroy']); 

     Route::get('/api/student', [StudentController::class, 'index']); 
     Route::get('/api/student/{id}', [StudentController::class, 'show']); Route::post('/api/student', [StudentController::class, 'store']); 
     Route::put('/api/student/{id}', [StudentController::class, 'update']); Route::delete('/api/student/{id}', [StudentController::class, 'destroy']);
 });