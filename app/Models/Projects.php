<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function assigned_detail(){
        return $this->hasMany(Userprojects::class, 'project_id', 'id')->with('user_detail');
    }
}
