<?php

class UserRequestSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('user_request')->delete();
        
        // new data
        $user_request = array(
            array('id' =>  1, 'user_id' => 3, 'request_id' => 1, 'amount' => 1),
            array('id' =>  2, 'user_id' => 4, 'request_id' => 1, 'amount' => 2),
            array('id' =>  3, 'user_id' => 5, 'request_id' => 1, 'amount' => 3),
            array('id' =>  4, 'user_id' => 5, 'request_id' => 2, 'amount' => 1)
        );

        // insert
        DB::table('user_request')->insert($user_request);
    }

}