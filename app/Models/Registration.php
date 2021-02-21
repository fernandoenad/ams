<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'last_name',
        'first_name',
        'middle_name',
        'contact_no',
        'position',
        'office_name',
        'event_id',
        'status',
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

    public function getFullname()
    {
        return ucwords(mb_strtolower($this->first_name). " " . mb_strtoupper($this->last_name));
    }

    public function getFullnameSorted()
    {
        return ucwords(mb_strtoupper($this->last_name). ", " . mb_strtolower($this->first_name));
    }

    public function getStatus()
    {
        switch($this->status){
            case 0: 
                $status_name = 'Declined';
                break;
            case 1: 
                $status_name = 'New';
                break;
            case 2: 
                $status_name = 'Confirmed';
                break;
            case 3: 
                $status_name = 'Attended';
                break;
            case 4: 
                $status_name = 'Participated';
                break;
            case 5: 
                $status_name = 'Completed';
                break;
        }

        return $status_name;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function clocklog()
    {
        return $this->hasMany(ClockLog::class);
    }
}


