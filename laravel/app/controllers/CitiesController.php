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
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
            if ($user && $user->hasCity()) {
                return $user->city_id;
            }
        }
    	return "false";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (Input::has('city_id')) {
            $city = City::find(Input::get('city_id'));
            if ($city) {
                
                if(Session::has('user_id'))
                    $user = User::find(Session::get('user_id'));
                if(!$user)
                    $user = new User();
                $user->city_id = $city->id;
                $user->save();
                Session::put('user_id', $user->id);
            }

        }
    }

}