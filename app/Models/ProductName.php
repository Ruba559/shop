<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductName extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [ 'pro_name' ];
    
    public $timestamps = false; 

    
    public function category()
    {
        return $this->belongsTo(Category::class , 'cat_id');
    }
}
