<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_type extends Model
{
    protected $fillable = ['event_name','event_duration'];
}
