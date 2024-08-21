<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('employees/{employee}', [EmployeeController::class, 'update']);
Route::apiResource('employees', EmployeeController::class);
//   PUT|PATCH       api/

