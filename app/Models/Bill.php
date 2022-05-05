<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';

    protected $primaryKey = 'bil_id';

    protected $fillable = [ 'bil_id', 'cus_id' , 'del_id' , 'bil_regdate' , 'bil_address' , 'bil_before_note' , 'bil_rate' ,
        'bil_after_note' , 'expected_distance' , 'expected_time'];

    public $timestamps = false;


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'cus_id' , 'cus_id');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\Delivery', 'del_id');
    }

    public function detailBills()
    {
        return $this->hasMany('App\Models\DetailBill', 'bil_id' , 'bil_id');
    }
   
}
