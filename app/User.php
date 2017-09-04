<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    const NEEDED_PLAYERS = 16;

    const TOTAL_SALARY = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','money'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get players
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players()
    {
        return $this->belongsToMany('App\Player','user_players');
    }

    /**
     * Get total player salary
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTotalPlayerSalary()
    {
        return $this->players->sum('salary');
    }

    /**
     * Get max bid
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getMaxBid()
    {
        $playersNeeded = self::NEEDED_PLAYERS - $this->totalPlayers();
        $salaryLeft = self::TOTAL_SALARY - $this->getTotalPlayerSalary();
        return $salaryLeft - $playersNeeded+1;
    }

    /**
     * Get the draft order of user
     */
    public function draftOrder()
    {
        return $this->hasOne('App\DraftOrder');
    }

    /**
     * Get total number of players
     */
    public function totalPlayers()
    {
        return $this->players->where('is_taxi','!=',1)->count();
    }
}
