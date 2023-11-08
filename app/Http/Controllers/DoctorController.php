<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class DoctorController extends Controller
{
    public function index(){
        $doctors = Doctor::with(['user', 'services'])->get();
        return inertia('Doctor/Index',[
            'doctors' =>$doctors
        ]);
    }

    public function create(){
        $services = Service::all();
        return inertia('Doctor/Create', ['services' => $services]);
    }

    public function store(Request $request)
    {
        $fields= $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'gender' => 'required',
                'contact_no' => 'required|max:11',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'specialization' => 'required|string|max:255',
                'selectedServiceIds' => 'required|array', // Assuming 'service' is an array of selected service IDs.
            ]);

            // Create a new user
            $user = User::create([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'suffix' => $request->input('suffix'),
                'middlename' => $request->input('middlename'),
                'gender' => $request->input('gender'),
                'contact_no' => $request->input('contact_no'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'type' => 'doctor'
            ]);


            // Create a new doctor associated with the user
            $doctor = new Doctor([
                'specialization' => $request->input('specialization'),

            ]);


        // Save the doctor first to get an ID.

            $selectedServiceIds = $request->input('selectedServiceIds');
            // Attach selected services to the doctor
            $user->doctor()->save($doctor);
            $doctor->services()->attach($selectedServiceIds);

            $doctorRole = Role::where('name', 'doctor')->first();
            $user->assignRole($doctorRole);

            return redirect('/doctor')->with('message', 'Doctor successfully created');
    }


    public function edit(Doctor $doctor){
        $doctor = Doctor::with('user', 'services')->find($doctor->id);
        $services = Service::all();

        return inertia('Doctor/Edit', ['doctor' => $doctor, 'services' => $services]);
    }

    public function update(Request $request, Doctor $doctor)
    {

        $user = $doctor->user;


        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'middlename' => $request->middlename,
            'gender' => $request->gender,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'doctor'
        ]);

        // Update doctor details
        $doctor->update([
            'specialization' => $request->specialization,
        ]);

        // dd($doctor) and dd($user);
        // Sync the associated services
        $doctor->services()->sync($request->input('selectedServiceIds'));

        return redirect()->route('doctor.index');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctor.index');
    }

    public function show(Doctor $doctor){
        $doctor = Doctor::with(['user', 'services'])->find($doctor->id);
        $serviceCount = $doctor->services->count();
        return inertia ('Doctor/Show', ['doctor'=> $doctor, 'serviceCount'=> $serviceCount]);
    }

    public function getServices(Doctor $doctor)
{
    // Retrieve the services offered by the specified doctor
    $services = $doctor->services;

    // Return the services as JSON
    return response()->json(['services' => $services]);
}

public function getDoctorServices()
    {
        $user = auth()->user();

        if ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->with('services')->first();

            if ($doctor) {
                $doctorName = $user->firstname . ' ' . $user->lastname;
                $services = $doctor->services;

                return response()->json([
                    'isDoctor' => true,
                    'doctorName' => $doctorName,
                    'services' => $services,
                ]);
            }
        }

        return response()->json([
            'isDoctor' => false,
            'doctorName' => '',
            'services' => [],
        ]);
    }
}
