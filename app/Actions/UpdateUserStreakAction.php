<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Update User Streak Action
 * 
 * Kullanıcının günlük giriş streak'ini güncelleme
 */
class UpdateUserStreakAction
{
    /**
     * Streak güncelle
     */
    public function execute(User $user): User
    {
        $today = today();
        $lastStreakDate = $user->streak_last_date;

        // İlk kez veya uzun süre sonra giriş
        if (!$lastStreakDate) {
            return $this->resetStreak($user);
        }

        // Bugün zaten güncellendi
        if ($lastStreakDate->equalTo($today)) {
            return $user;
        }

        // Dün giriş yapıldı - streak devam
        if ($lastStreakDate->equalTo($today->subDay())) {
            return $this->incrementStreak($user);
        }

        // Streak koptu
        return $this->resetStreak($user);
    }

    /**
     * Streak'i artır
     */
    protected function incrementStreak(User $user): User
    {
        $user->streak_days++;
        $user->streak_last_date = today();
        $user->save();

        // Milestone kontrolü
        $this->checkStreakMilestones($user);

        return $user;
    }

    /**
     * Streak'i sıfırla
     */
    protected function resetStreak(User $user): User
    {
        $user->streak_days = 1;
        $user->streak_last_date = today();
        $user->save();

        return $user;
    }

    /**
     * Streak milestone başarımları
     */
    protected function checkStreakMilestones(User $user): void
    {
        $milestones = [
            7 => 'streak_7_days',
            14 => 'streak_14_days',
            30 => 'streak_30_days',
            60 => 'streak_60_days',
            100 => 'streak_100_days',
            365 => 'streak_365_days',
        ];

        foreach ($milestones as $days => $achievementSlug) {
            if ($user->streak_days >= $days) {
                $achievement = \App\Models\Achievement::where('slug', $achievementSlug)->first();
                
                if ($achievement) {
                    app(GrantAchievementAction::class)->execute($user, $achievement);
                }
            }
        }
    }
}
