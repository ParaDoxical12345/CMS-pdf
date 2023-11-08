<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'form_id',
    //     'allergy',
    //     'amoebiasis',
    //     'anemia',
    //     'asthma',
    //     'cancer',
    //     'chronic',
    //     'diabetes',
    //     'dysmenorrhea',
    //     'fainting',
    //     'deafness',
    //     'endocrine',
    //     'frequent_headache',
    //     'neck_injury',
    //     'heart_disease',
    //     'hernias',
    //     'highblood_pressure',
    //     'insomnia',
    //     'kidney_disease',
    //     'skeletal_disorder',
    //     'nervous_breakdown',
    //     'nose_trouble',
    //     'peptic_ulcer',
    //     'tuberculosis',
    //     'hospitalization',
    //     'surgical_operation',
    // ];

    protected $guarded = [];
    public function form(){
        return $this->belongsTo(Form::class,'form_id');
    }

}
