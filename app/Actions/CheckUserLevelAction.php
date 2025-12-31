<?php

namespace App\Actions;

use App\Models\User;

/**
 * Check User Level Action
 * 
 * Kullanıcı seviye ve rütbe kontrolü
 */
class CheckUserLevelAction
{
    /**
     * Seviye eşikleri (XP gereksinimi)
     */
    protected array $levelThresholds = [
        1 => 0,
        2 => 100,
        3 => 300,
        4 => 600,
        5 => 1000,
        6 => 1500,
        7 => 2200,
        8 => 3000,
        9 => 4000,
        10 => 5500,
        11 => 7000,
        12 => 9000,
        13 => 11500,
        14 => 14500,
        15 => 18000,
        16 => 22000,
        17 => 27000,
        18 => 33000,
        19 => 40000,
        20 => 50000,
    ];

    /**
     * Rütbe isimleri
     */
    protected array $rankTitles = [
        1 => 'Çaylak',
        2 => 'Çaylak',
        3 => 'Acemi',
        4 => 'Acemi',
        5 => 'Öğrenci',
        6 => 'Öğrenci',
        7 => 'Kalfa',
        8 => 'Kalfa',
        9 => 'Usta',
        10 => 'Usta',
        11 => 'Uzman',
        12 => 'Uzman',
        13 => 'Profesör',
        14 => 'Profesör',
        15 => 'Büyücü',
        16 => 'Büyücü',
        17 => 'Bilge',
        18 => 'Bilge',
        19 => 'Efsane',
        20 => 'Tanrı',
    ];

    /**
     * Seviye kontrolü ve güncelleme
     */
    public function execute(User $user): User
    {
        $experience = $user->total_points;
        $newLevel = $this->calculateLevel($experience);
        
        if ($newLevel !== $user->level) {
            $user->level = $newLevel;
            $user->rank_title = $this->rankTitles[$newLevel] ?? 'Bilinmeyen';
            $user->save();

            // Seviye atlama bildirimi
            if ($newLevel > ($user->getOriginal('level') ?? 1)) {
                $this->sendLevelUpNotification($user, $newLevel);
            }
        }

        return $user;
    }

    /**
     * XP'ye göre seviye hesapla
     */
    protected function calculateLevel(int $experience): int
    {
        $level = 1;

        foreach ($this->levelThresholds as $lvl => $threshold) {
            if ($experience >= $threshold) {
                $level = $lvl;
            } else {
                break;
            }
        }

        return min($level, 20);
    }

    /**
     * Sonraki seviye için gereken XP
     */
    public function getExperienceForNextLevel(User $user): int
    {
        $nextLevel = min($user->level + 1, 20);
        return $this->levelThresholds[$nextLevel] ?? PHP_INT_MAX;
    }

    /**
     * İlerleme yüzdesi
     */
    public function getLevelProgress(User $user): int
    {
        $currentThreshold = $this->levelThresholds[$user->level] ?? 0;
        $nextThreshold = $this->levelThresholds[$user->level + 1] ?? $currentThreshold;
        
        if ($nextThreshold === $currentThreshold) {
            return 100;
        }

        $progress = ($user->total_points - $currentThreshold) / ($nextThreshold - $currentThreshold) * 100;
        return min(100, max(0, (int) $progress));
    }

    /**
     * Seviye atlama bildirimi
     */
    protected function sendLevelUpNotification(User $user, int $newLevel): void
    {
        \DB::table('user_notifications')->insert([
            'user_id' => $user->id,
            'type' => 'level_up',
            'title' => '🎉 Seviye Atladınız!',
            'message' => "Tebrikler! Artık Seviye {$newLevel} ({$this->rankTitles[$newLevel]}) oldunuz!",
            'icon' => 'star',
            'data' => json_encode([
                'new_level' => $newLevel,
                'rank_title' => $this->rankTitles[$newLevel],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
