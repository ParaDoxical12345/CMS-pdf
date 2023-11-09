<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF(Patient $patient)
    {
        // $users = User::get();
        // $patients = Patient::get();

        $pat = Patient::with('user:id,firstname,lastname')->get();

        $data = [
            'title' => 'MATER DEI COLLEGE',
            'header' => 'MEDICAL CERTIFICATE',
            'address' => 'CABULIJAN, TUBIGON, BOHOL.',
            'facility' => 'School Clinic',
            'date' => date('d/m/Y'),
            'patient' => $pat,
        ];

        $pdf = PDF::loadView('pdf.usersPdf', $data);
        return $pdf->stream();
    }
}
