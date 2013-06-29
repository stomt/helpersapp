<?php

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

        if (User::live()->city_id) {
            $result["success"] = true;
            $result["city_id"] = User::live()->city_id;
        }

    	return Response::json($result);
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
                User::live()->city_id = $city->id;
                $result["success"] = true;
                $result["city_id"] = $city->id;
            }
        }
        
        return Response::json($result);
    }

}