<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Rules\NotBeforeToday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{

    public function index()
    {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $appointments = Appointment::with(['doctor', 'doctor.user', 'user', 'service'])->get();
    } elseif ($user->hasRole('doctor')) {
        $appointments = Appointment::with(['doctor', 'doctor.user', 'user', 'service'])
            ->whereHas('doctor', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
    } elseif ($user->hasRole('patient')) {
        $appointments = Appointment::with(['doctor', 'doctor.user', 'user', 'service'])
            ->where('user_id', $user->id)
            ->get();
    } else {
        // Handle other roles or unauthorized access as needed
        return abort(403);
    }
    return inertia('Appointment/Index', [
        'appointments' => $appointments,
    ]);
}


    public function create(Request $request)
{
    $doctors = Doctor::whereHas('user', function ($query) {
        $query->where('status', 1);
    })->with(['services', 'user'])->get();

    $services = Service::all();

    // Assuming you want to search for users based on a search term provided in the request
    $searchTerm = $request->input('term');
    $users = User::where('status', 'active')
        ->where(function ($query) use ($searchTerm) {
            $query->where('firstname', 'like', "%$searchTerm%")
                ->orWhere('lastname', 'like', "%$searchTerm%");
        })
        ->get();

    $isAdminOrDoctor = auth()->user()->hasAnyRole(['admin', 'doctor']);
    $isDoctor = auth()->user()->hasRole('doctor');
    $selectedDoctor = null;
    $availableServices = [];

    if ($isDoctor) {
        // If the user is a doctor, get their information
        $selectedDoctor = Doctor::where('user_id', auth()->user()->id)->first();
        $availableServices = $selectedDoctor->services;
    }

    return inertia('Appointment/Create', [
        'doctors' => $doctors,
        'services' => $services,
        'users' => $users,
        'isAdminOrDoctor' => $isAdminOrDoctor,
        'isDoctor' => $isDoctor,
        'selectedDoctor' => $selectedDoctor,
        'availableServices' => $availableServices,
    ]);
}


    public function store(Request $request){
        $user = Auth::user();
        $userType = $user->hasRole(['admin', 'doctor']) ? 'admin_doctor' : 'student_teacher';

        $fields = $request->validate([
            'user_id' => $userType === 'admin_doctor'
            ? 'required|exists:users,id' // Validate the user search input
            : 'sometimes',
            'doc_id' => 'required',
            'service_id' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|after_or_equal:now',
            'reason' => 'required',
        ]);

        if ($userType === 'student_teacher') {
            $fields['user_id'] = $user->id; // Automatically set the user's ID
        }

        if ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->first(); // Retrieve the corresponding doctor record
            if ($doctor) {
                $fields['doc_id'] = $doctor->id; // Set the doctor's id
            } else {
                // Handle the case where a doctor record for the user is not found.
            }
        }

        Appointment::create($fields);
        return redirect()->route('appointment.index')->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment){
        $appointment = Appointment::with(['user', 'service', 'doctor'])->find($appointment->id);
        $doctor = Doctor::with('user', 'services')->find($appointment->doc_id);
        return inertia ('Appointment/Show', ['appointment'=> $appointment, 'doctor' => $doctor]);
    }

    public function accept(Appointment $appointment){
        $appointment->update(['status' => 'Approved']);

        $user = $appointment->user;
        $doctor = $appointment->doctor;
        // Send an email notification to the patient
        Mail::send('email.confirm-email', ['user' => $user, 'appointment'=>$appointment, 'doctor'=> $doctor ], function ($message) use ($user, $appointment) {
            $message->to($user->email);
            $message->subject('Appointment Confirmation');
        });

        return redirect()->route('appointment.index')->with('success', 'Appointment approved successfully.');
    }

    public function cancel(Appointment $appointment){
    // Update the appointment status to 'canceled'
    $appointment->update(['status' => 'Canceled']);

    $user = $appointment->user;

    // Send an email notification to the patient
    Mail::send('email.cancel-email', ['user' => $user, 'appointment'=>$appointment], function ($message) use ($user) {
        $message->to($user->email);
        $message->subject('Appointment Cancelation');
    });
    return redirect()->route('appointment.index')->with('success', 'Appointment canceled successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointment.index');
    }
}
