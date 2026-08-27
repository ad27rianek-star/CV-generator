<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CvController extends Controller
{
    /**
     * Show the CV builder form.
     */
    public function create(): View
    {
        return view('cv.create');
    }

    /**
     * Render the submitted CV data as a downloadable PDF.
     */
    public function download(StoreCvRequest $request): Response
    {
        $data = $request->cvData();

        $pdf = Pdf::loadView('pdf.cv', $data)->setPaper('a4');

        $fileName = trim($data['personal']['first_name'].'-'.$data['personal']['last_name'], '-');
        $fileName = Str::slug($fileName ?: 'cv').'.pdf';

        return $pdf->download($fileName);
    }
}
