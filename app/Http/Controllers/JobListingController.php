<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

class JobListingController extends Controller
{
    public function index()
    {
        $jobs = JobListing::active()->latest('published_at')->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function show(JobListing $job)
    {
        abort_unless($job->is_active, 404);

        return view('jobs.show', compact('job'));
    }
}
