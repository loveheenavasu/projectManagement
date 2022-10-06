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






}
