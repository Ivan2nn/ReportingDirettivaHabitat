<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classis extends Model
{
	protected $table = 'tax_06classes';

	protected $primaryKey = 'class_code';

    public function taxonomy() {
    	return $this->hasMany('App\Taxonomy');
    }

    public function orders() {
    	$orders_code = Taxonomy::where('class_code',$this->class_code)->select('order_code')->get();
    	
    	return Order::whereIn('order_code', $orders_code)->get();
    }
}
