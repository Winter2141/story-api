<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStoryRelation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id", "story_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id');
    }
}
