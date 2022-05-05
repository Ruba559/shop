<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $table = 'food';

    protected $primaryKey = 'foo_id';

    protected $fillable = [ 'foo_name' , 'foo_name_en' , 'foo_regdate' , 'foo_image' , 'foo_thumbnail' 
    , 'foo_price' , 'foo_offer' , 'foo_info' , 'foo_info_en' , 'cat_id' , 'sup_id' ];
    
    public $timestamps = false;
    
    
    public function category()
    {
        return $this->belongsTo(Category::class , 'cat_id');
    }
    
    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class  , $this->primaryKey);
    }
}
