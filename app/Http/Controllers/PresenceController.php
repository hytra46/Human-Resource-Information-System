<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index() {
        if (session('department') == 'HR') {
            $presences = Presence::all();
        } else {
            $presences = Presence::where('employee_id', session('employee_id'))->get();
        }
        return view('presences.index', compact('presences'));
    }

    public function create() {
        $employees = Employee::all();

        // untuk non HR → cek apakah sudah check in
        $todayPresence = null;
        if (session('department') != 'HR') {
            $todayPresence = Presence::where('employee_id', session('employee_id'))
                ->where('date', Carbon::now()->format('Y-m-d'))
                ->first();
        }

        return view('presences.create', compact('employees', 'todayPresence'));
    }


    public function store(Request $request) {
        if (session('department') == 'HR') {

            $request->validate([
                'employee_id' => 'required',
                'check_in' => 'required',
                'check_out' => 'required',
                'date' => 'required|date',
                'status' => 'required|string'
            ]);

            Presence::create($request->all());
        } else {

            // Cek apakah user sudah presensi hari ini
            $presence = Presence::where('employee_id', session('employee_id'))
                        ->where('date', Carbon::now()->format('Y-m-d'))
                        ->first();

            // Jika belum ada presence → Check In
            if (!$presence) {
                Presence::create([
                    'employee_id' => session('employee_id'),
                    'check_in' => Carbon::now()->format('Y-m-d H:i:s'),
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'status' => 'present'
                ]);

            } else {
                // Jika sudah check in → maka ini Check Out
                $presence->update([
                    'check_out' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->route('presences.index')->with('success', 'Presence recorded successfully.');
    }


    public function edit(Presence $presence) {
        $employees = Employee::all();

        return view('presences.edit', compact('presence', 'employees'));
    }

    public function update (Request $request, Presence $presence) {
        $request->validate([
            'employee_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'date' => 'required|date',
            'status' => 'required|string'
        ]);

        $presence->update($request->all());

        return redirect()->route('presences.index')->with('success', 'Presence updated successfull.');
    }

    public function destroy(Presence $presence) {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Presence deleted successfull.');
    }
}
