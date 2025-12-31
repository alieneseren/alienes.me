<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'title',
        'bio',
        'email',
        'phone',
        'location',
        'profile_image',
        'github_url',
        'github_username',
        'github_avatar_url',
        'github_bio',
        'github_company',
        'github_blog',
        'github_followers',
        'github_following',
        'github_public_repos',
        'github_synced_at',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'resume_url',
    ];

    protected $casts = [
        'github_synced_at' => 'datetime',
    ];
}
