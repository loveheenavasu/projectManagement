<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
$myItems = [
            ['name'=>'admin'],
            ['name'=>'project_manager'],
            ['name'=>'teamlead'],
            ['name'=>'employee']
        ];


DB::table("roles")->insert($myItems);




    }
}
