<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Log;


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

        if (User::live($this->city)->city_id !== null) {
            $result["success"] = true;
            $result["city_id"] = User::live($this->city)->city_id;
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
        $city_id = Input::has('city_id');
        if ($city_id) {
            $city = City::where('id',$city_id)->first();
            if ($city !== null) {
                $user = User::live($city_id);
                $user->save();
                return $this->index();
            }
        }
        
        return response()->json($result);
    }

}