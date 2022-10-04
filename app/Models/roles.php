<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;
   protected $table='roles';
    protected $fillable = ['name'];



 public function role()
    {
        return $this->hasOne(User_role::class, "user_id", "id")->with('role_detail');
    }
}