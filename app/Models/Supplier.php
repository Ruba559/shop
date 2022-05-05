<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $primaryKey = 'sup_id';

    protected $fillable = [ 'sup_name' , 'sup_pwd' , 'sup_mobile' , 'sup_email'	, 'sup_regdate' , 'sup_block' ,
     'sup_token' , 'sup_address' , 'sup_note' ];

    public $timestamps = false;

}
