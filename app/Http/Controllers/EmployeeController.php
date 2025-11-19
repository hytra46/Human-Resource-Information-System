<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;                  // Untuk model User
use Illuminate\Support\Facades\Hash;  // Untuk fungsi Hash::make()


class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create() {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.create', compact('departments', 'roles'));
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'fullname' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //         'phone_number' => 'required|string|max:15',
    //         'address' => 'nullable|required',
    //         'birth_date' => 'required|date',
    //         'hire_date' => 'required|date',
    //         'department_id' => 'required',
    //         'role_id' => 'required',
    //         'status' => 'required|string',
    //         'salary' => 'required|numeric'
    //     ]);

    //     Employee::create($request->all());
    //     return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    // }

    public function store(Request $request) {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|required',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required',
            'role_id' => 'required',
            'status' => 'required|string',
            'salary' => 'required|numeric',
            'password' => 'required|string|min:6'
        ]);

        // Simpan employee
        $employee = Employee::create($request->all());

        // Buat akun user otomatis
        User::create([
            'name' => $employee->fullname,
            'email' => $employee->email,
            'password' => Hash::make($request->password),
            'employee_id' => $employee->id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show($id) {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id) {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'departments', 'roles'));
    }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'fullname' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'phone_number' => 'required|string|max:15',
    //         'address' => 'nullable|required',
    //         'birth_date' => 'required|date',
    //         'hire_date' => 'required|date',
    //         'department_id' => 'required',
    //         'role_id' => 'required',
    //         'status' => 'required|string',
    //         'salary' => 'required|numeric',
    //         'password' => 'nullable|string|min:6'
    //     ]);
    //     $employee = Employee::findOrFail($id);
    //     $employee->update($request->all());

    //     return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    // }

    public function update(Request $request, $id) {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|required',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required',
            'role_id' => 'required',
            'status' => 'required|string',
            'salary' => 'required|numeric',
            'password' => 'nullable|string|min:6', // validasi password baru
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update($request->except('password'));

        if ($request->filled('password')) {
            $user = User::where('employee_id', $employee->id)->first();
            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    public function destroy($id) {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
