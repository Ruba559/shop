<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    use HasFactory;

    protected $table = 'food_suppliers';

    protected $primaryKey = 'fd_id';

    protected $fillable = [ 'sup_id' , 'foo_id' , 'price' ];
    
    public $timestamps = false;
    

    public function supllier()
    {
        return $this->belongsTo(Supplier::class , 'sup_id');
    }
}
