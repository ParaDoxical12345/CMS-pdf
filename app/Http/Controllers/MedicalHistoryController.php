<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalHistoryController extends Controller
{
    public function index(){
        $medicalhistory = MedicalHistory::all();
        $patientUser = Auth::user();
        return inertia('Medical/Index', [
            'medicalhistory'=> $medicalhistory,
            'patientUser' => $patientUser,
        ]);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        // Add validation rules for other fields
        'allergy' => 'boolean',
        'amoebiasis' => 'boolean',
        'anemia' => 'boolean',
        'asthma' => 'boolean',
        'cancer' => 'boolean',
        'chronic' => 'boolean',
        'diabetes' => 'boolean',
        'dysmenorrhea' => 'boolean',
        'fainting' => 'boolean',
        'deafness' => 'boolean',
        'endocrine' => 'boolean',
        'frequent_headache' => 'boolean',
        'neck_injury' => 'boolean',
        'heart_disease' => 'boolean',
        'hernias' => 'boolean',
        'highblood_pressure' => 'boolean',
        'insomnia' => 'boolean',
        'kidney_disease' => 'boolean',
        'skeletal_disorder' => 'boolean',
        'nervous_breakdown' => 'boolean',
        'nose_trouble' => 'boolean',
        'peptic_ulcer' => 'boolean',
        'tuberculosis' => 'boolean',
        'hospitalization' => 'boolean',
        'surgical_operation' => 'boolean',
    ]);

    // Create a new medicalhistory record with the validated data
    MedicalHistory::create($data);

    return redirect('/form')->with('success', 'Patient created successfully.');
}


}
