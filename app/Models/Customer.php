<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable
{
    use HasFactory ,  HasRoles;
    
    protected $guard = 'customer';

    protected $table = 'customer';

    protected $primaryKey = 'cus_id';

    protected $fillable = [ 'cus_name' , 'cus_pwd' , 'cus_mobile' , 'cus_email' , 'cus_regdate' , 'cus_block' , 
       'cus_token' , 'cus_address' , 'cus_lan' , 'cus_lat' , 'cus_note' , 'cus_thumbnail' , 'cus_image' ];

    public $timestamps = false;


    public function bills()
    {
        return $this->hasMany('App\Models\Bill', 'bil_id' , 'cus_id');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\Delivery', 'del_id' , 'bil_id');
    }

}
