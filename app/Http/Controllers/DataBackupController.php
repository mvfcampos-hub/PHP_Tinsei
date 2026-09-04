<?php

namespace App\Http\Controllers;

use App\Models\BackupPlan;

class DataBackupController extends Controller
{
    public function __invoke()
    {
        return view('databackup.show', [
            'plans' => BackupPlan::active()->get(),
        ]);
    }
}
