<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    use HasFactory;
    protected $table='user_role';
    protected $fillable = ['user_id','role_id'];
    public function role_detail()
    {
        return $this->hasOne(roles::class, "id", "role_id");
    }
    
}
