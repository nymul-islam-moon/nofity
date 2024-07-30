<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [ 'title', 'short_description', 'description', 'status', 'tags' ];

    public $timestamps = true;

    public static function getTagNames(array $tagIds)
    {
        $tagNames = Tag::whereIn('id', $tagIds)
                    ->where('status', 1)
                    ->pluck('name')
                    ->toArray();

        return empty($tagNames) ? ['N/A'] : $tagNames;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function rel_to_tags()
    {
        return $this->belongsToMany(Tag::class, 'notification_tag')->withTimestamps();
    }


}
