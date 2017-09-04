<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    // Fillable database fields
    protected $fillable = ['user_id','player_id','high_bid','draft_position'];
}
