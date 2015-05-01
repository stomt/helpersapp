<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('projects')->delete();
        $projects = [['projectname' => 'Nepal', 'country' => 'India', 'timezone' => 'IST']];
        // insert
        DB::table('projects')->insert($projects);
    }

}