<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Tag extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'tags';

    protected $fillable = [ 'name', 'status' ];

   /**
     * Get the favorite tags for the tag.
     */
    public function favoriteTags()
    {
        return $this->hasMany(FavoriteTags::class);
    }

    public function rel_to_notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_tag')->withTimestamps();
    }
}
