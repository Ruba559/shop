<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,  HasRoles;

    
    protected $guard_name = 'web';
    protected $table = 'users';

    protected $primaryKey = 'use_id';

    protected $fillable = [ 'use_name' , 'use_mobile' , 'use_pwd' , 'use_datetime' , 'use_active' 
    , 'use_token' , 'use_lastdate' , 'use_note' ];
    
    public $timestamps = false;
   
    protected $hidden = [
        'use_pwd',
        'remember_token',
    ];

    // public function getAuthPassword()
    // {
    //     return $this->use_pwd;
    // }
   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
