<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Models\CvTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CvTemplateController extends Controller
{
    /**
     * Save the submitted CV data as a new editable template.
     */
    public function store(StoreCvRequest $request): RedirectResponse
    {
        $data = $request->cvData();

        $cvTemplate = CvTemplate::create([
            'template' => $data['template'],
            'data' => collect($data)->except('template')->all(),
        ]);

        return redirect()
            ->route('cv.templates.edit', $cvTemplate)
            ->with('status', 'Zapisano! Zachowaj ten link, aby wrócić do edycji później.');
    }

    /**
     * Show the CV builder pre-filled with a saved template's data.
     */
    public function edit(CvTemplate $cvTemplate): View
    {
        return view('cv.create', ['cvTemplate' => $cvTemplate]);
    }

    /**
     * Update an existing saved template with resubmitted CV data.
     */
    public function update(StoreCvRequest $request, CvTemplate $cvTemplate): RedirectResponse
    {
        $data = $request->cvData();

        $cvTemplate->update([
            'template' => $data['template'],
            'data' => collect($data)->except('template')->all(),
        ]);

        return redirect()
            ->route('cv.templates.edit', $cvTemplate)
            ->with('status', 'Zmiany zapisane.');
    }
}
