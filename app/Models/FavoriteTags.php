<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteTags extends Model
{
    use HasFactory;

    protected $table = 'favorite_tags';

    protected $fillable = [ 'student_id', 'tag_id' ];

    /**
     * Get the student that owns the favorite tag.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the tag that is associated with the favorite tag.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
