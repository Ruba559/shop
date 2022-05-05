<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $primaryKey = 'cat_id';

    protected $fillable = [ 'cat_name' , 'cat_name_en' , 'cat_regdate' , 'cat_image' , 'cat_thumbnail' ];

    public $timestamps = false;


    public function products()
    {
        return $this->hasMany( Product::class ,  $this->primaryKey , $this->foreignKey );
    }
}
