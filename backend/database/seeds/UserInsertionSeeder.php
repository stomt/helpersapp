<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserInsertionSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('insertion_user')->delete();
        
        // new data
        $insertion_user = array(
            array('id' =>  1, 'user_id' => 3, 'insertion_id' => 1, 'amount' => 1),
            array('id' =>  2, 'user_id' => 4, 'insertion_id' => 1, 'amount' => 2),
            array('id' =>  3, 'user_id' => 5, 'insertion_id' => 1, 'amount' => 3),
            array('id' =>  4, 'user_id' => 5, 'insertion_id' => 2, 'amount' => 1)
        );

        // insert
        DB::table('insertion_user')->insert($insertion_user);
    }

}