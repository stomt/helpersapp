<?php

class HelpController extends BaseController {

    /**
     * User Repository
     *
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($city_id, $insertion_id)
    {
        $city = City::find($city_id);
        $insertion = Insertion::find($insertion_id);
        if ($city && $insertion) {
            $insertion->users()->attach(Session::get('user_id'), array('amount' => Input::get('amount')));
            
            $insertions = $city->insertions;
            InsertionsController::enrichData($insertions);
            $result = array(
                "success" => true,
                "amount" => $insertion->helperRequested - $insertion->users()->sum('amount'),
                "reqs" => View::make('insertions.index', compact('insertions'))->render()
                );
            return json_encode($result);
        }

        $result = array("success" => false);
        return json_encode($result);
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