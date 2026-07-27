<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobSubmissionController extends Controller
{
    public function create()
    {
        return view('jobs.submit');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'location' => ['nullable', 'string', 'max:255'],
            'contract_type' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'submitter_name' => ['required', 'string', 'max:255'],
            'submitter_email' => ['required', 'email', 'max:255'],
            'submitter_phone' => ['nullable', 'string', 'max:50'],
        ]);

        $job = JobListing::create([
            ...$data,
            'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(6)),
            'status' => 'pending',
            'is_active' => false,
            'removal_token' => JobListing::generateRemovalToken(),
        ]);

        return redirect()
            ->route('jobs.manage', $job->removal_token)
            ->with('submitted', true);
    }

    public function manage(string $token)
    {
        $job = JobListing::where('removal_token', $token)->firstOrFail();

        return view('jobs.manage', compact('job'));
    }

    public function requestRemoval(Request $request, string $token)
    {
        $job = JobListing::where('removal_token', $token)->firstOrFail();

        $job->update([
            'is_active' => false,
            'removal_requested_at' => now(),
        ]);

        return redirect()->route('jobs.manage', $token)->with('removed', true);
    }
}
