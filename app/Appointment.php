<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id','appoinment_date','time_slot'];
}
