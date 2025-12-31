<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GitHubUser extends Model
{
    use HasFactory;

    protected $table = 'github_users';

    protected $fillable = [
        'username',
        'avatar_url',
        'name',
        'bio',
        'public_repos',
    ];
}
