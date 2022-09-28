<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprojects extends Model
{
    use HasFactory;
    protected $table='user_projects';
    protected $fillable = [
        'project_id',
        'user_id'
    ];
    public function user_detail(){
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
