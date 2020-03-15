<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\City;
use App\User;
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

        if (User::live()->city_id !== null) {
            $result["success"] = true;
            $result["city_id"] = User::live()->city_id;
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

        if(! Request::has('city_id') ){
            abort(400, 'CitiesController needs a city_id for storing');
        }

        $city_id = Request::input('city_id');
        $city = City::where('id',$city_id)->first();
        if ($city !== null) {
            $result["success"] = true;
            User::live();
            return $this->index();
        }
        
        return response()->json($result);
    }

}