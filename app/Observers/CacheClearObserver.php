<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class CacheClearObserver
{
    public function saved($model)
    {
        $this->clearCache();
    }

    public function deleted($model)
    {
        $this->clearCache();
    }

    private function clearCache()
    {
        Cache::forget('profile_first');
        Cache::forget('has_experiences');
        Cache::forget('has_skills');
        Cache::forget('has_projects');
        Cache::forget('has_published_cv');
        Cache::forget('experiences_ordered');
        Cache::forget('educations_ordered');
        Cache::forget('skills_ordered');
        Cache::forget('featured_projects');
    }
}