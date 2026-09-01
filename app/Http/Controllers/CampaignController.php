<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function show(Campaign $campaign)
    {
        abort_unless($campaign->is_active, 404);

        $campaign->load('episodes');

        return view('campaigns.show', compact('campaign'));
    }
}
