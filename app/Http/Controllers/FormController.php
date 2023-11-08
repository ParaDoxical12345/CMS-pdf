<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Form;
use App\Models\History;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PhysicalExamination;
use App\Models\Radiologic;
use App\Models\Remarks;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function create(Patient $patient){
        $doctor = Doctor::whereHas('user')->with([ 'user'])->get();
        $patient->load('user');
        return inertia('Form/Sample', [
            'patient' => $patient,
            'doctor' => $doctor
        ]);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'doc_id' => 'required|exists:doctors,id',
            'pat_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            // Add validation rules for other fields as needed
        ]);

        // dd($validatedData);
        $form = Form::create($validatedData);
        $formId = $form->id;
        $forms = $form->id;
        $phyform =  $form->id;

        $field = $request->validate([
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
            // 'form_id' => 'required'
        ]);

        $field['form_id'] = $forms;

     $medicalhistory = MedicalHistory::create($field);

        $data = $request->validate([

            'remarks' => 'required|string'
        ]);

            $data['form_id'] = $formId;

            // dd($data);
            $remark = Remarks::create($data);



         $physicals = $request->validate([
                    // Add validation rules for other fields
                    'height' => 'numeric',
                    'weight' => 'numeric',
                    'bp' => 'string',
                    'rr' => 'string',
                    'pr' => 'string',
                    'saturation' => 'string',
                    'lmp' => 'string',
                    'head_neck_scalp' => 'boolean',
                    'eyes' => 'boolean',
                    'ears' => 'boolean',
                    'nose_sinuses' => 'boolean',
                    'mouth' => 'boolean',
                    'neck_thyroid' => 'boolean',
                    'chest_breast_axilla' => 'boolean',
                    'heart' => 'boolean',
                    'lungs' => 'boolean',
                    'abdomen' => 'boolean',
                    'back' => 'boolean',
                    'anus' => 'boolean',
                    'gut' => 'boolean',
                    'inguinals' => 'boolean',
                    'reflexes' => 'boolean',
                    'extremities' => 'boolean',
                    'dental' => 'boolean',
                    'right_eye' => 'string',
                    'left_eye' => 'string',
                    'withg_right_eye'=> 'string',
                    'withg_left_eye' => 'string',
                    'ishihara' => 'string',
                    'colour_blind' => 'string',
                   'head_neck_scalp_findings'=> 'string|nullable',
                    'eyes_findings'=> 'string|nullable',
                    'ears_findings'=> 'string|nullable',
                    'nose_sinuses_findings'=> 'string|nullable',
                    'mouth_findings'=> 'string|nullable',
                    'neck_thyroid_findings'=> 'string|nullable',
                    'chest_breast_axilla_findings'=> 'string|nullable',
                    'heart_findings'=> 'string|nullable',
                    'lungs_findings'=> 'string|nullable',
                    'abdomen_findings'=> 'string|nullable',
                    'back_findings'=> 'string|nullable',
                    'anus_findings'=> 'string|nullable',
                    'gut_findings'=> 'string|nullable',
                    'inguinals_findings'=> 'string|nullable',
                    'reflexes_findings'=> 'string|nullable',
                    'extremities_findingd'=> 'string|nullable',
                    'dental_finding'=> 'string|nullable',

                ]);

                $physicals['form_id'] = $phyform;

                $physicalexam = PhysicalExamination::create($physicals);



        // You can also redirect to a success page or return a response
        return redirect('/patient')->with('success', 'Physical Examination record and Medical History saved successfully');

    }
    // public function store(Request $request){
    //     $validatedData = $request->validate([
    //         'doc_id' => 'required|exists:doctors,id',
    //         'pat_id' => 'required|exists:patients,id',
    //         'date' => 'required|date',
    //         // Add validation rules for other fields as needed
    //     ]);

    //     $form = Form::create($validatedData);



    //     $data = $request->validate([
    //         // Add validation rules for other fields
    //         'allergy' => 'boolean',
    //         'amoebiasis' => 'boolean',
    //         'anemia' => 'boolean',
    //         'asthma' => 'boolean',
    //         'cancer' => 'boolean',
    //         'chronic' => 'boolean',
    //         'diabetes' => 'boolean',
    //         'dysmenorrhea' => 'boolean',
    //         'fainting' => 'boolean',
    //         'deafness' => 'boolean',
    //         'endocrine' => 'boolean',
    //         'frequent_headache' => 'boolean',
    //         'neck_injury' => 'boolean',
    //         'heart_disease' => 'boolean',
    //         'hernias' => 'boolean',
    //         'highblood_pressure' => 'boolean',
    //         'insomnia' => 'boolean',
    //         'kidney_disease' => 'boolean',
    //         'skeletal_disorder' => 'boolean',
    //         'nervous_breakdown' => 'boolean',
    //         'nose_trouble' => 'boolean',
    //         'peptic_ulcer' => 'boolean',
    //         'tuberculosis' => 'boolean',
    //         'hospitalization' => 'boolean',
    //         'surgical_operation' => 'boolean',
    //         'form_id'=> 'required'
    //     ]);

    //     // $formId = $data['form_id'];

    //     $medicalHistory = MedicalHistory::create([
    //         'allergy' => $data['allergy'],
    //         'amoebiasis' => $data["amoebiasis"],
    //         'anemia' => $data["anemia"],
    //         'asthma' => $data["asthma"],
    //         'cancer' => $data["cancer"],
    //         'chronic' => $data["chronic"],
    //         'diabetes' => $data["diabetes"],
    //         'dysmenorrhea' => $data["dysmenorrhea"],
    //         'fainting' => $data["fainting"],
    //         'deafness' => $data["deafness"],
    //         'endocrine' => $data["endocrine"],
    //         'frequent_headache' => $data["frequent_headache"],
    //         'neck_injury' => $data["neck_injury"],
    //         'heart_disease' => $data["heart_disease"],
    //         'hernias' => $data["hernias"],
    //         'highblood_pressure' => $data["highblood_pressure"],
    //         'insomnia' => $data["insomnia"],
    //         'kidney_disease' => $data["kidney_disease"],
    //         'skeletal_disorder' => $data["skeletal_disorder"],
    //         'nervous_breakdown' => $data["nervous_breakdown"],
    //         'nose_trouble' => $data["nose_trouble"],
    //         'peptic_ulcer' => $data["peptic_ulcer"],
    //         'tuberculosis' => $data["tuberculosis"],
    //         'hospitalization' => $data["hospitalization"],
    //         'surgical_operation' => $data["surgical_operation"],
    //         'form_id'=> $form
    //     ]);



    //     $hist = new History([
    //         'history' => $request->input('history'), // Set your medical history fields here
    //         'form_id' => $form
    //     ]);

    //     $hist = History::create($hist);

    //     $fields = $request->validate([
    //         // Add validation rules for other fields
    //         'height' => 'numeric',
    //         'weight' => 'numeric',
    //         'bp' => 'string',
    //         'pr' => 'string',
    //         'saturation' => 'string',
    //         'lmp' => 'string',
    //         'head_neck_scalp' => 'boolean',
    //         'eyes' => 'boolean',
    //         'ears' => 'boolean',
    //         'nose_sinuses' => 'boolean',
    //         'mouth' => 'boolean',
    //         'neck_thyroid' => 'boolean',
    //         'chest_breast_axilla' => 'boolean',
    //         'heart' => 'boolean',
    //         'lungs' => 'boolean',
    //         'abdomen' => 'boolean',
    //         'back' => 'boolean',
    //         'anus' => 'boolean',
    //         'gut' => 'boolean',
    //         'inguinals' => 'boolean',
    //         'reflexes' => 'boolean',
    //         'extermities' => 'boolean',
    //         'dental' => 'boolean',
    //         'right_eye' => 'string',
    //         'left_eye' => 'string',
    //         'withg_right_eye'=> 'string',
    //         'withg_left_eye' => 'string',
    //         'ishihara' => 'string',
    //         'colour_blind' => 'string',
    //         'form_id' => 'required'

    //     ]);

    //    PhysicalExamination::create([
    //     'height' => $fields['height'],
    //     'weight' => $fields['weight'],
    //     'bp' => $fields['bp'],
    //     'pr' => $fields['pr'],
    //     'saturation' => $fields['saturation'],
    //     'lmp' => $fields['lmp'],
    //     'head_neck_scalp' => $fields['head_neck_scalp'],
    //     'eyes' => $fields['eyes'],
    //     'ears' => $fields['ears'],
    //     'nose_sinuses' => $fields['nose_sinuses'],
    //     'mouth' => $fields['mouth'],
    //     'neck_thyroid' => $fields['neck_thyroid'],
    //     'chest_breast_axilla' => $fields['chest_breast_axilla'],
    //     'heart' => $fields['heart'],
    //     'lungs' => $fields['lungs'],
    //     'abdomen' => $fields['abdomen'],
    //     'back' => $fields['back'],
    //     'anus' => $fields['anus'],
    //     'gut' => $fields['gut'],
    //     'inguinals' => $fields['inguinals'],
    //     'reflexes' => $fields['reflexes'],
    //     'extermities' => $fields['extermities'],
    //     'dental' => $fields['dental'],
    //     'right_eye' => $fields['right_eye'],
    //     'left_eye' => $fields['left_eye'],
    //     'withg_right_eye'=> $fields['withg_right_eye'],
    //     'withg_left_eye' => $fields['withg_left_eye'],
    //     'ishihara' => $fields['ishihara'],
    //     'colour_blind' => $fields['colour_blind'],
    //     'form_id' => $form
    //    ]);

    //      Radiologic::create([
    //         'exam_results' => $request->input('exam_results'), // Set your medical history fields here
    //         'form_id' => $form
    //     ]);



    //     Remarks::create([
    //         'remarks' => $request->input('remarks'), // Set your medical history fields here
    //         'form_id' => $form
    //     ]);


    //     // You can also redirect to a success page or return a response
    //     return redirect('/form')->with('success', 'Physical Examination record and Medical History saved successfully');

    // }
}
