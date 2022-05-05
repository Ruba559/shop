<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBill extends Model
{
    use HasFactory;

    protected $table = 'detail_bill';

    protected $primaryKey = 'det_id';

    protected $fillable = [ 'det_id' , 'foo_id' , 'det_price' , 'det_qty' , 'bil_id' , 'price' ];

    public $timestamps = false;


    public function bill()
    {
        return $this->belongsTo('App\Models\Bill', 'bil_id' , 'bil_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'foo_id' , 'foo_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'sup_id' , 'sup_id');
    }
}
