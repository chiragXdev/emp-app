<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('employees');
});

Route::get('employees', [EmployeeController::class, 'index'])->name('employees');

Route::get('/employees/data', [EmployeeController::class, 'getEmployeesData'])->name('employees.data');

