<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'tax_10orders';

    protected $primaryKey = 'order_code';

    public function taxonomy() {
    	return $this->hasMany('App\Taxonomy');
    }

    public function families() {
    	$families_code = Taxonomy::where('order_code',$this->order_code)->select('family_code')->get();
    	
    	return Family::whereIn('family_code', $families_code)->get();
    }
}
