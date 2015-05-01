<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('categories')->delete();

        $list="Earthquake Damage, Medical Evacuation, Medical Assistance, Food/Water/Shelter, Food/Water, Blocked Roads, People Trapped,
        Fallen Electric Pole, Fallen Transformer

        ";

        $categories = explode(',',$list);
        $finalCategories = [];
        foreach($categories as $key => $value){
            $finalCategories[] = ['categoryname' => trim($value), 'project_id' => 1];
        }


        // insert
        DB::table('categories')->insert($finalCategories);
    }

}