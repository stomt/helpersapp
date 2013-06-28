<?php

class InsertionsController extends BaseController {

    /**
     * Insertion Repository
     *
     * @var Insertion
     */
    protected $insertion;

    public function __construct(Insertion $insertion)
    {
        $this->insertion = $insertion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($city_id)
    {
        // $city = City::find($city_id);
        // if ($city) {
        //     $requests = $city->requests;
    	   // return View::make('requests.index', compact('requests'));
        // }
        // return "false";

        $insertions = Insertion::withTrashed()->get();
        return View::make('insertions.index', compact('insertions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        
    }

   	/**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }
}