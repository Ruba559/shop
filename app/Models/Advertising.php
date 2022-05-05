<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    use HasFactory;

    protected $table = 'Advertising';

    protected $primaryKey = 'advert_id';

    protected $fillable = [ 'advert_name' , 'advert_name_en' , 'advert_image' ];

    public $timestamps = false;

}
