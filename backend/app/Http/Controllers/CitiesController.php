<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Models\City;
use App\Models\User;


class CitiesController extends BaseController {

    /**
     * City Repository
     *
     * @var City
     */
    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $result["success"] = false;

        if (User::live()->city_id !== null) {
            $result["success"] = true;
            $result["city_id"] = User::live()->city_id;
            $cities = [];
            foreach (City::all() as $city) {
                $cities[$city->id] = $city->title;
            }
            $result["cities"] = $cities;
        }

    	return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $result["success"] = false;

        if (Input::has('city_id')) {
            $city = City::find(Input::get('city_id'));
            if ($city) {
                $user = User::live();
                $user->city_id = $city->id;
                $user->save();
                return $this->index();
            }
        }
        
        return response()->json($result);
    }

}