<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\MenuItem;

class CampaignObserver
{
    public function created(Campaign $campaign): void
    {
        $this->sync($campaign);
    }

    public function updated(Campaign $campaign): void
    {
        $this->sync($campaign);
    }

    public function deleted(Campaign $campaign): void
    {
        $campaign->menuItem?->delete();
    }

    private function sync(Campaign $campaign): void
    {
        if (! $campaign->is_active) {
            $campaign->menuItem?->delete();

            if ($campaign->menu_item_id) {
                $campaign->menu_item_id = null;
                $campaign->saveQuietly();
            }

            return;
        }

        $attributes = [
            'label' => $campaign->title,
            'url' => '/campanhas/'.$campaign->slug,
            'sort_order' => $campaign->sort_order,
            'is_external' => false,
            'opens_new_tab' => false,
        ];

        if ($campaign->menuItem) {
            $campaign->menuItem->update($attributes);

            return;
        }

        $parent = $this->campanhasMenuItem();

        if (! $parent) {
            return;
        }

        $menuItem = MenuItem::create($attributes + ['parent_id' => $parent->id]);

        $campaign->menu_item_id = $menuItem->id;
        $campaign->saveQuietly();
    }

    private function campanhasMenuItem(): ?MenuItem
    {
        return MenuItem::where('label', 'Campanhas')
            ->whereHas('parent', fn ($query) => $query->where('label', 'Comunicação'))
            ->first();
    }
}
