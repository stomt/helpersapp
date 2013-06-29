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
        $success = false;

        if ($city && $insertion) {
            $user = $insertion->user(Session::get('user_id'));
            $amount = Input::get('amount');

            // new entry
            if (!$user && $amount > 0) {
                $insertion->users()->attach(Session::get('user_id'), array('amount' => Input::get('amount')));
                $success = true;
                

            // edit entry
            } elseif ($user && $amount < 0) {
                $newAmount = $user->pivot->amount + $amount;
                
                // all removed
                if ($newAmount <= 0) {
                    $insertion->users()->detach($user->id);
                
                // just decreased
                } else {
                    $user->pivot->amount = $newAmount;
                    $user->pivot->save();
                }
                $success = true;
            }
        }

        if ($success) {
            $insertions = $city->insertions;
            InsertionsController::enrichData($insertions);
            $result = array(
                "success" => true,
                "html" => View::make('insertions.index', compact('insertions'))->render()
            );
        } else {
            $result = array(
                "success" => false
            );
        }
        
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