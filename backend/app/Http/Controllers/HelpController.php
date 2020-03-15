<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\City;
use App\User;
use App\Insertion;

class HelpController extends BaseController {

    /**
     * Handel a submitted help offer.
     *
     * @return Response
     */
    public function store($city_id, $insertion_id)
    {
        $result["success"] = false;

        $city = City::find($city_id);
        $insertion = Insertion::find($insertion_id);
        if ($city && $insertion) {

            $user = $insertion->user(User::live()->id);
            $amount = Request::input('amount');

            // store new entry
            if (!$user && $amount > 0) {
                $this->storeHelp($insertion, $amount);
                $result["success"] = true;  

            } elseif ($user && $amount < 0) {
                $newAmount = $user->pivot->amount + $amount;
                
                // destroy entry
                if ($newAmount <= 0) {
                    $this->destroyHelp($insertion);
                
                // update entry
                } else {
                    $this->updateHelp($user, $newAmount);
                }

                $result["success"] = true; 
            }
        }

        if ($result["success"]) {
            $insertions = $city->currentInsertions();
            $result["html"] = InsertionsController::renderInsertions($insertions);
        }
        
        return response()->json($result);
    }

    private function storeHelp($insertion, $amount)
    {
        $insertion->users()
                  ->attach(User::live()->id, ['amount' => $amount]);
    }

    private function updateHelp($user, $amount) 
    {
        $user->pivot->amount = $amount;
        $user->pivot->save();
    }

    private function destroyHelp($insertion)
    {
        $insertion->users()->detach(User::live()->id);
    }
}