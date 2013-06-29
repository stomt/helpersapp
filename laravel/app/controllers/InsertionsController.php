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
        $city = City::find($city_id);
        if ($city) {
            $insertions = $city->insertions;
    	    return View::make('insertions.index', compact('insertions'));
        }
        return "false";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($city_id)
    {
        $city = City::find($city_id);
        if ($city) {
            $input = Input::only('address', 'helperRequested', 'notice', 'date', 'time');
            $validation = Validator::make($input, Insertion::$rules);
            if ($validation->passes()) {
                $insertion = new Insertion();
                $insertion->user_id = Session::get('user_id');
                $insertion->city_id = $city->id;
                
                $insertion->address = $input['address'];
                $insertion->notice = $input['notice'];
                $insertion->howlong = date('Y-m-d H:i:s',strtotime($input['date'].' '.$input['time']));
                
                $insertion->save();

                return 1;
            }
        }
        return "false";
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