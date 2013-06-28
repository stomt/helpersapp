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
    	
    }

}