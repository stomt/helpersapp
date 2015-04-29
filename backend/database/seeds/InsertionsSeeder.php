<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'notice' => 'bringt Eimer',
                'howlong' => date('Y-m-d H:i:s',strtotime('2013-06-29 13:00'))
                )
        );

        // insert
        DB::table('insertions')->insert($insertions);
    }

}