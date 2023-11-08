<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $users = User::get();
        // $patients = Patient::get();

        $data = [
            'title' => 'MATER DEI COLLEGE',
            'header' => 'MEDICAL CERTIFICATE',
            'address' => 'CABULIJAN, TUBIGON, BOHOL.',
            'facility' => 'School Clinic',
            'date' => date('d/m/Y'),
            'users' => $users,
        ];

        $pdf = PDF::loadView('pdf.usersPdf', $data);
        return $pdf->stream();
    }
}
