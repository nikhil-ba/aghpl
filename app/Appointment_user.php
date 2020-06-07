<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment_user extends Model
{
    protected $fillable = ['appointment_id','fname','lname','email'];
}
