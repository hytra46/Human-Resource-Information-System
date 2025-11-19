<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::where('status', 'active')->count();
        $leave_pending = LeaveRequest::where('status', 'pending')->count();
        if (session('department') == 'HR') {
            $leave_request = LeaveRequest::count();
        } else {
            $leave_request = LeaveRequest::where('employee_id', session('employee_id'))->count();
        }
        if (session('department') == 'HR') {
            $presence = Presence::count();
        } else {
            $presence = Presence::where('employee_id', session('employee_id'))->count();
        }

        $task_pending = Task::where('status', 'pending')->count();
        $task_done = Task::where('status', 'done')->count();

        if (session('department') == 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }


        // Ambil user yang login
        $user = Auth::user();

        // Ambil fullname employee
        $fullname = $user->employee ? $user->employee->fullname : $user->name;

        return view('dashboard.index', compact('employee', 'leave_pending', 'leave_request', 'presence', 'tasks', 'fullname', 'task_pending', 'task_done'));
    }

    // public function presence(){
    //     $raw = Presence::where('status', 'present')
    //         ->selectRaw('MONTH(date) as month, COUNT(*) as total_present')
    //         ->groupBy('month')
    //         ->get()
    //         ->keyBy('month');

    //     $result = [];

    //     for ($m = 1; $m <= 12; $m++) {
    //         $result[] = $raw[$m]->total_present ?? 0; // kalau tidak ada data → 0
    //     }

    //     return response()->json($result);
    // }
    public function presence(){
        if (session('department') == 'HR') {
            $raw = Payroll::selectRaw('MONTH(created_at) as month, SUM(net_salary) as total_salary')
                ->groupBy('month')
                ->get()
                ->keyBy('month');
        } else {
            $raw = Payroll::where('employee_id', session('employee_id'))->selectRaw('MONTH(created_at) as month, SUM(net_salary) as total_salary')
                ->groupBy('month')
                ->get()
                ->keyBy('month');
        }


        $result = [];

        for ($m = 1; $m <= 12; $m++) {
            $result[] = $raw[$m]->total_salary ?? 0;
        }

        return response()->json($result);
    }



}
