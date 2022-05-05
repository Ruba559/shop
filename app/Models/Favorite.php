<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorite';

    protected $primaryKey = 'fav_id';

    protected $fillable = [ 'foo_id' , 'cus_id' , 'fav_regdate' ];

    public $timestamps = false;
}
