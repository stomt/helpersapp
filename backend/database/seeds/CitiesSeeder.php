<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder {

    public function run()
    {
        // cleanup
        DB::table('cities')->delete();

        $list="Bihar, Uttar Pradesh, West Bengal, Delhi/NCR, Assam, Uttarakhand, Andhra Pradesh,
        Odisha, Gujarat, Sikkim, Karnataka, Kochi, Kerala
        Patna district, Samastipur, Bhagalpur districts, Bhita, Supual, Darbhanga, Muzaffarpur, Gopalganj,
        Kanpur, lucknow, allahabad, Agra, Varanashi, Jhansi, Sonebhadra, Gorakhpur,
        Kolkata, Lake Town, Salt Lake, Dalhousie, Darjeeling/Siliguri, Park street area,
        Telipara, Purulia, Bankura, Burdwan, East Midnapore, Nadia district,
        New Delhi, Noida, Chandigarh, Jaipur, Barmer, Dumka, Pakur, Sahibganj, rishikesh, Ahmedabad,
        Ranchi, Jamshedpur, Bhubaneswar, Visakhapatnam, Srikakulam, East Godavari districts, Kochi, Nagpur,
        Jabalpur, Jafar Nagar, Jaripatka, Bhopal, Gwalior, Mandla, Hoshangabad, Sidhi, Indore, Chhindwara, Shahdol

        ";

        $cities = explode(',',$list);
        $finalCities = [];
        foreach($cities as $key => $value){
            $finalCities[] = [ 'title' => trim($value), 'project_id' => 1];
        }


        // insert
        DB::table('cities')->insert($finalCities);
    }

}