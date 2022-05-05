<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Velocity extends Model
{
    use HasFactory;

    protected $table = 'velocity';

    protected $primaryKey = 'id';

    protected $fillable = [ 'velocity_value' , 'time' , 'distance'];
    
    public $timestamps = false; 

}
