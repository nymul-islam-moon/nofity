<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuySubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $table = 'buy_subscriptions';

    protected $fillable = [ 'user_id', 'exp_date', 'phone_num', 'trans_num', 'status' ];
}
