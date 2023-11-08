<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PatientController extends Controller
{
    public function index(){
        $patients = Patient::with('user')
        ->get();

        $user = User::withCount('appointment')
        ->whereIn('id', $patients->pluck('user.id'))
        ->get();
        // $patients = Patient::with(['user'])->withCount('user.appointment')->get();
        return inertia('Patient/Index', [
            'patients' => $patients,
            'user' => $user
        ]);
    }

    public function create(){
        return inertia('Patient/Create');
    }

    public function store(Request $request){

        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'suffix' => $request->input('suffix'),
            'middlename' => $request->input('middlename'),
            'gender' => $request->input('gender'),
            'contact_no' => $request->input('contact_no'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'type' => 'patient'
        ]);

        $patient = new Patient([
            'age' => $request->input('age'),
            'vaccine' => $request->input('vaccine'),
            'course' =>  $request->input('course'),
            'address' => $request->input('address')
        ]);

        $user->patient()->save($patient);
        $patientRole = Role::where('name', 'patient')->first();
        $user->assignRole($patientRole);

        return redirect('/doctor')->with('message', 'Doctor successfully created');
    }

    public function show(Patient $patient){

        $patient = Patient::with(['user'])->find($patient->id);
        $user = $patient->user;

        // Retrieve the appointments for the user (patient)
        $patientAppointments = Appointment::with(['doctor.user','service'])->where('user_id', $user->id)->get();

        return inertia ('Patient/Show',
            [
                'patient' => $patient,
                'patientAppointments' => $patientAppointments,

            ]);
    }
}
