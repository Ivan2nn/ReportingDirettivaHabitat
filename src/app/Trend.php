<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trend extends Model
{
	protected $table = 'trend';
	
    protected $fillable = [
        'name',
        'code'
    ];
}
