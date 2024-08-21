<?php

namespace App\Models;

use App\Traits\GenerateEmployeeCodeTrait;
use MongoDB\Laravel\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'employees';

    //Employee Code (Auto Generate Series: EMP-0001)
//  First Name
// Last Name
//  Joining Date (Date-picker optional)
// Profile Image (max 2MB validation optional)
    protected $fillable = [
        'emp_code',
        'first_name',
        'last_name',
        'joining_date',
        'profile_image',
    ];
}
