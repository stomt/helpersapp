<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('users')->delete();
        
        // new data
        $users = array(
            array('id' =>  1, 'city_id' => 10),
            array('id' =>  2, 'city_id' => 10),
            array('id' =>  3, 'city_id' => 10),
            array('id' =>  4, 'city_id' => 10),
            array('id' =>  5, 'city_id' => 10)
        );

        // insert
        DB::table('users')->insert($users);
    }

}