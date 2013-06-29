<?php

class InsertionsSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('insertions')->delete();
        
        // new data
        $insertions = array(
        	array(
                'id' =>  1, 
                'city_id' => 10,
                'user_id' => 1,
                'address' => 'daheim',
                'helperRequested' => 10,
                'notice' => 'bringt Eimer'
                )
        );

        // insert
        DB::table('insertions')->insert($insertions);
    }

}