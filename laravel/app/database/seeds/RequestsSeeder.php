<?php

class RequestsSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('requests')->delete();
        
        // new data
        $requests = array(
        	array(
                'id' =>  1, 
                'city_id' => 10,
                'user_id' => 1,
                'address' => 'daheim',
                'helperRequested' => 10,
                'notice' => 'Ganz viele Helfer'
                ),
            array(
                'id' =>  2, 
                'city_id' => 10,
                'user_id' => 2,
                'address' => 'bei Ihm',
                'helperRequested' => 15,
                'notice' => 'bringt Schaufeln'
                )
        );

        // insert
        DB::table('requests')->insert($requests);
    }

}