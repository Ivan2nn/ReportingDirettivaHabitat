<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $primaryKey = 'status_code';

    protected $fillable = ['status_code','status_name'];
}
