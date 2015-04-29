<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('cities')->delete();
        
        // new data
        $cities = array(
        	array('id' =>  1, 'title' => 'Boizenburg'),
            array('id' =>  2, 'title' => 'Deggendorf'),
            array('id' =>  3, 'title' => 'Dresden'),
            array('id' =>  4, 'title' => 'Dömitz'),
            array('id' =>  5, 'title' => 'Gera'),
            array('id' =>  6, 'title' => 'Landshut'),
            array('id' =>  7, 'title' => 'Fischbeck'),
            array('id' =>  8, 'title' => 'Freising'),
            array('id' =>  9, 'title' => 'Magdeburg'),
            array('id' => 10, 'title' => 'Passau'),
            array('id' => 11, 'title' => 'Rosenheim')
        );

        // insert
        DB::table('cities')->insert($cities);
    }

}