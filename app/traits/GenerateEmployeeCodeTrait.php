<?php

namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Str;

trait GenerateEmployeeCodeTrait
{
    protected function generateEmpCode()
    {
        // Retrieve the last employee document
        $lastEmployee = Employee::orderBy('emp_code', 'desc')->first();

        // Extract the numeric part of the last employee code
        $lastCode = $lastEmployee ? (int) substr($lastEmployee->emp_code, 4) : 0;

        // Increment to get the next code
        $nextCode = str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);

        // Return the new employee code with prefix
        return 'EMP-' . $nextCode;
    }
}
