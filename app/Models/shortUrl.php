<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shortUrl extends Model
{
    use HasFactory;

    protected $table = 'short_urls';

    protected $fillable = [ 'original_url', 'short_url', 'click_count', 'created_by' ];
}
