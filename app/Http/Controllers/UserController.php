<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){

        $users = User::with('roles')->get();
        return inertia('User/Index', [
            'users' => $users
        ]);
    }

    public function create(){
        $services = Service::all();
        return inertia('User/Create', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'services' => $services
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'suffix' => 'nullable|string',
            'gender' => 'required|string',
            'type' => 'required|string',
            'email' => 'required|email',
            'contact_no' => 'required',
            'password' => 'required|string',
            'role' => 'required',
        ]);

        $data['password'] = bcrypt($data['password']); // Hash the password

        unset($data['role']);
        $type = $data['type'];
        $role = $request->role;

        $user = User::create($data);

        $user->assignRole($role);

         if ($type === 'doctor') {
            // Handle the "doctor" type here.
            $specialization = $request->input('specialization');
            $selectedServiceIds = $request->input('selectedServiceIds');

            // Create a new doctor associated with the user
            $doctor = new Doctor([
                'specialization' => $specialization,
            ]);

            // Save the doctor first to get an ID.
            $user->doctor()->save($doctor);

            // Attach selected services to the doctor
            $doctor->services()->attach($selectedServiceIds);
        }

        if ($type === 'patient') {
            // Handle the "patient" type here.
            $age = $request->input('age');
            $course = $request->input('course');
            $vaccine = $request->input('vaccine');
            $address = $request->input('address');


            // Create a new patient associated with the user
            $patient = new Patient([
                'age' => $age,
                'course' => $course,
                'vaccine' => $vaccine,
                'address' => $address
            ]);

            // Save the patient first to get an ID.
            $user->patient()->save($patient);


        }
        return redirect()->route('user.index');
    }

    public function edit(User $user){
        // $user = User::with('roles')->find($user->id);
        $roles = Role::all();
         $user->load('doctor','patient', 'doctor.services', 'roles')->find($user->id);
        $services = Service::all();
        $doctor = Doctor::with('user', 'services')->get();
        $patient = Patient::with('user')->get();
        return inertia('User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'services' => $services,
            'doctor' => $doctor,
            'currentRole' => $user->roles->first()->name,
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, User $user){
        $data = $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'suffix' => 'nullable|string',
            'gender' => 'required|string',
            'type' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_no' => 'required',
            'password' => 'nullable|string',
            'role' => 'required',
        ]);

        $isDoctor = $user->hasRole('doctor');

        if ($isDoctor && in_array($data['role'], ['admin', 'student'])) {
            // User was previously a doctor, but now changing to "admin" or "student."
            // Delete the associated "doctor" data.
            $user->doctor->delete();
        }



            // $data['password'] = bcrypt($data['password']); // Hash the password
        if (isset($data['password']) && $data['password'] !== null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // Remove the "password" field from the data array
        }

        // unset($data['role']);

        $role = $request->role;
        $type = $data['type'];

        $user->update($data);

        $user->syncRoles([$data['role']]);

        $currentRole = $user->getRoleNames()->first();
        $type = $data['type'];

        if ($currentRole === 'student' && ($type === 'admin' || $type === 'doctor')) {
            // If the user is a student and the new type is 'admin' or 'doctor',
            // update the user's role to the specified role.
            $user->syncRoles([$type]);
        } else {
            // Handle other type and role changes (same as before).
            $user->syncRoles([$data['role']]);
        }

        if ($data['type'] === 'doctor') {
            $specialization = $request->input('specialization');
            $selectedServiceIds = $request->input('selectedServiceIds');

            // Fetch the doctor record associated with the user (if it exists)
            $doctor = $user->doctor;

            // Update the doctor's data
            if ($doctor) {
                $doctor->specialization = $specialization;
                $doctor->save();
            } else {
                // If the doctor record doesn't exist, create a new one
                $doctor = new Doctor(['specialization' => $specialization]);
                $user->doctor()->save($doctor);
            }

            // Sync selected services
            $doctor->services()->sync($selectedServiceIds);
        } elseif ($data['type'] !== 'doctor') {
            // If the user's type is not 'doctor,' you can delete the doctor record
            $user->doctor()->delete();
        }

        if ($data['type'] === 'patient') {
            $age = $request->input('age');
            $course = $request->input('course');
            $vaccine = $request->input('vaccine');
            $address = $request->input('address');

            // Fetch the patient record associated with the user (if it exists)
            $patient = $user->patient;

            // Update the patient's data
            if ($patient) {
                $patient->age = $age;
                $patient->course = $course;
                $patient->vaccine = $vaccine;
                $patient->address = $address;
                $patient->save();
            } else {
                // If the patient record doesn't exist, create a new one
                $patient = new Patient([
                    'age' => $age,
                    'course' => $course,
                    'vaccine' => $vaccine,
                    'address' => $address
                ]);
                $user->patient()->save($patient);
            }
        } else {
            // If the user's type is not 'patient,' you can delete the patient record
            $user->patient()->delete();
        }



        return redirect()->route('user.index');
    }

    public function destroy(User $user) {
        $user->delete();

        return back();
    }
}
