<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\Customer;


class Delivery extends Model
{
    use HasFactory;

    protected $table = 'delivery';

    protected $primaryKey = 'del_id';
    protected $foreignKey = 'del_id';

    protected $fillable = [ 'del_name' , 'del_mobile' , 'del_address' , 'del_pwd' , 'del_regdate' , 'del_lastdate' , 'del_thumbnail' ,
     'del_worktime' , 'del_status' , 'del_image' , 'del_rate'];

    public $timestamps = false;


    public function bills()
    {
        return $this->hasMany( Bill::class , $this->foreignKey , $this->primaryKey);
    }


    



}
