<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Generate Global Auth Token Action
 * 
 * Subdomain'ler arası oturum yönetimi için global token oluşturma
 */
class GenerateGlobalAuthTokenAction
{
    protected const TOKEN_EXPIRY_HOURS = 24;

    /**
     * Global auth token oluştur
     */
    public function execute(User $user, ?string $subdomain = null): string
    {
        $token = Str::random(64);
        $expiresAt = now()->addHours(self::TOKEN_EXPIRY_HOURS);

        // Global token'ı kullanıcıya kaydet
        $user->update([
            'global_token' => hash('sha256', $token),
            'global_token_expires_at' => $expiresAt,
        ]);

        // Session tablosuna da kaydet
        DB::table('global_sessions')->insert([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'subdomain' => $subdomain,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'last_activity' => now(),
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $token;
    }

    /**
     * Token'ı doğrula
     */
    public function validate(string $token): ?User
    {
        $hashedToken = hash('sha256', $token);

        $session = DB::table('global_sessions')
            ->where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->first();

        if (!$session) {
            return null;
        }

        // Son aktiviteyi güncelle
        DB::table('global_sessions')
            ->where('id', $session->id)
            ->update(['last_activity' => now()]);

        return User::find($session->user_id);
    }

    /**
     * Token'ı geçersiz kıl
     */
    public function invalidate(string $token): void
    {
        $hashedToken = hash('sha256', $token);

        DB::table('global_sessions')
            ->where('token', $hashedToken)
            ->delete();
    }

    /**
     * Kullanıcının tüm session'larını temizle
     */
    public function invalidateAll(User $user): void
    {
        DB::table('global_sessions')
            ->where('user_id', $user->id)
            ->delete();

        $user->update([
            'global_token' => null,
            'global_token_expires_at' => null,
        ]);
    }

    /**
     * Süresi dolmuş session'ları temizle (cron job için)
     */
    public function cleanupExpired(): int
    {
        return DB::table('global_sessions')
            ->where('expires_at', '<', now())
            ->delete();
    }
}
