<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\DB;

/**
 * Grant Achievement Action
 * 
 * Kullanıcıya başarım kazandırma
 */
class GrantAchievementAction
{
    /**
     * Başarım kazandır
     */
    public function execute(User $user, Achievement $achievement, bool $force = false): ?UserAchievement
    {
        // Zaten kazanılmış mı?
        $existing = UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->first();

        if ($existing && $existing->is_completed && !$force) {
            return $existing;
        }

        return DB::transaction(function () use ($user, $achievement, $existing) {
            $userAchievement = $existing ?? new UserAchievement([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);

            $userAchievement->progress = 100;
            $userAchievement->is_completed = true;
            $userAchievement->unlocked_at = now();
            $userAchievement->save();

            // Puan ekle
            $user->increment('total_points', $achievement->points);

            // Bildirim gönder
            $this->sendNotification($user, $achievement);

            // Seviye kontrolü
            app(CheckUserLevelAction::class)->execute($user);

            return $userAchievement;
        });
    }

    /**
     * İlerleme güncelle
     */
    public function updateProgress(User $user, Achievement $achievement, int $progress): ?UserAchievement
    {
        $userAchievement = UserAchievement::firstOrCreate(
            [
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ],
            [
                'progress' => 0,
                'is_completed' => false,
            ]
        );

        if ($userAchievement->is_completed) {
            return $userAchievement;
        }

        $userAchievement->progress = min(100, max($progress, $userAchievement->progress));

        if ($userAchievement->progress >= 100) {
            return $this->execute($user, $achievement);
        }

        $userAchievement->save();
        return $userAchievement;
    }

    /**
     * Bildirim gönder
     */
    protected function sendNotification(User $user, Achievement $achievement): void
    {
        DB::table('user_notifications')->insert([
            'user_id' => $user->id,
            'type' => 'achievement',
            'title' => '🏆 Yeni Başarım!',
            'message' => "Tebrikler! \"{$achievement->name}\" başarımını kazandınız!",
            'icon' => $achievement->icon,
            'data' => json_encode([
                'achievement_id' => $achievement->id,
                'points' => $achievement->points,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
