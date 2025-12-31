<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_date',
        'count',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'count' => 'integer',
    ];

    /**
     * Bugünkü ziyaretçi sayısını artır
     */
    public static function incrementToday(): int
    {
        $today = now()->toDateString();
        
        $visitor = self::firstOrCreate(
            ['visit_date' => $today],
            ['count' => 0]
        );
        
        $visitor->increment('count');
        
        return $visitor->count;
    }

    /**
     * Bugünkü ziyaretçi sayısını getir
     */
    public static function getTodayCount(): int
    {
        $today = now()->toDateString();
        
        return self::where('visit_date', $today)->value('count') ?? 0;
    }

    /**
     * Belirli bir tarihin ziyaretçi sayısını getir
     */
    public static function getCountByDate(string $date): int
    {
        return self::where('visit_date', $date)->value('count') ?? 0;
    }
}
