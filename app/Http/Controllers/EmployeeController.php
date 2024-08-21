<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Traits\GenerateEmployeeCodeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    use GenerateEmployeeCodeTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->get('per_page', 10);
            $query = Employee::query();

            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('joining_date', [$request->start_date, $request->end_date]);
            }

            $employees = $query->paginate($perPage);
            return EmployeeResource::collection($employees);
        }

        return view('employees.index');
    }


    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return new EmployeeResource($employee);
    }



    public function store(Request $request)
    {
        // validation rules
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'joining_date' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData['emp_code'] = $this->generateEmpCode();
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $filename);

            $validatedData['profile_image'] = $filename;
        }

        $employee = Employee::create($validatedData);

        return response()->json($employee, 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // validation rules
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'joining_date' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);



        if ($request->hasFile('profile_image')) {
            if ($employee->profile_image) {
                Storage::delete('public/profile_images/' . $employee->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $filename);

            $validatedData['profile_image'] = $filename;
        }

        $employee->update($validatedData);

        return response()->json($employee, 200);
    }
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->profile_image) {
            Storage::delete('public/profile_images/' . $employee->profile_image);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully.'], 200);
    }




}
