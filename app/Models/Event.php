<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'from_date',
        'to_date',
        'venue',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getStatus()
    {
        $today = Carbon::today();

        if($this->to_date == date('Y-m-d', strtotime(now())))
            return 'On-going';
        else  if($this->to_date < date('Y-m-d', strtotime(now())))
            return 'Past event';
        else
            return 'Future event';
    }

    public function registration()
    {
        return $this->hasMany(Registration::class);
    }
}
