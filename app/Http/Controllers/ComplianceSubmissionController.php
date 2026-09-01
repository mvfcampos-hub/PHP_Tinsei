<?php

namespace App\Http\Controllers;

use App\Models\ComplianceSubmission;
use App\Models\ComplianceSubmissionFile;
use Illuminate\Http\Request;

class ComplianceSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nutritionist_name' => ['required', 'string', 'max:255'],
            'crn_number' => ['required', 'string', 'max:50'],
            'inspection_reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
        ]);

        $submission = ComplianceSubmission::create([
            'protocol' => ComplianceSubmission::generateProtocol(),
            'nutritionist_name' => $data['nutritionist_name'],
            'crn_number' => $data['crn_number'],
            'inspection_reference' => $data['inspection_reference'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        foreach ($request->file('files') as $uploadedFile) {
            $path = $uploadedFile->store('adequacao', 'public');

            ComplianceSubmissionFile::create([
                'compliance_submission_id' => $submission->id,
                'file' => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
            ]);
        }

        return redirect()
            ->route('compliance.show', $submission)
            ->with('submitted', true);
    }

    public function show(ComplianceSubmission $submission)
    {
        $submission->load('files');

        return view('compliance.show', compact('submission'));
    }
}
