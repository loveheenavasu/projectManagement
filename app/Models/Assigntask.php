<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigntask extends Model
{
    use HasFactory;
    protected $table='assigntasks';
    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'starting_date',
        'ending_date',
        'status',
       
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function project(){
        return $this->hasOne(Projects::class, 'id', 'project_id');
    }
    public function task_detail(){
        return $this->hasOne(Tasks::class, 'id', 'task_id');
    }

    public function user_task_detail(){
        return $this->hasOne(Tasks::class, 'id', 'task_id');
    }

    public function project_detail(){
        return $this->hasOne(Projects::class, 'id', 'project_id');
    }



}
