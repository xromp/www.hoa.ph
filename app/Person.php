<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // protected $fillable = array('lname', 'fname', 'mname');	
    protected $table = 'person';
}
