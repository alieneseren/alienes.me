<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProjectService;
use App\Services\GameService;
use App\Services\StudyService;

/**
 * Bento Grid Homepage Component
 * 
 * Modern glassmorphism grid layout ile ana sayfa
 */
class BentoHomepage extends Component
{
    public function render()
    {
        $projectService = app(ProjectService::class);
        $gameService = app(GameService::class);
        $studyService = app(StudyService::class);

        return view('livewire.bento-homepage', [
            'featuredProjects' => $projectService->getFeaturedProjects(3),
            'projectStats' => $projectService->getStats(),
            'featuredGames' => $gameService->getGames(true),
            'gameStats' => $gameService->getGlobalStats(),
            'featuredCourses' => $studyService->getFeaturedCourses(2),
            'studyStats' => $studyService->getStats(),
        ]);
    }
}
