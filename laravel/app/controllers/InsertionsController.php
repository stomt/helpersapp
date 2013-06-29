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
            static::enrichData($insertions);
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
                $insertion->helperRequested = $input['helperRequested'];
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
    public function update($city_id, $insertion_id)
    {
        return 'TODO: update';
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($city_id, $insertion_id)
    {
        $insertion = Insertion::find($insertion_id);
        $result = array("success" => false);
        if ($insertion) {
            if (Session::get('user_id') == $insertion->user_id) {
                $insertion->delete();
                $result = array(
                    "success" => true,
                    "html" => $this->index($city_id)->render() 
                );
            } else {
                $result["error"] = "No Access";
            }
        } else {
            $result["error"] = "Not Found";
        }

        return json_encode($result);
    }

    /**
     * Helper
     *
     * Converts data to printable format.
     */
    public static function enrichData($insertions)
    {
        foreach ($insertions as $insertion) {
            $insertion->howlong = static::howlong($insertion->howlong);
            $insertion->created = static::niceTime($insertion->created_at);
            $insertion->helpOffered = static::helpOffered($insertion);
        }
    }

    /**
     * Helper
     *
     * Builds a sentence containing how long the helpers are still needed
     */
    public static function howlong($howlong)
    {
        $from = strtotime($howlong);
        // Falls es jetzt früher ist es der Termin + 2 std und es noch heute ist
        $time = time();
        if($time >= $from && $time <= ($from+1440000)  && date('Ymd') == date('Ymd', $from) ){
            return "Ab jetzt gebraucht!";
        }else{
            $date = date('Y-m-d', $from);
            $tomorrow = date('Y-m-d', strtotime('tomorrow'));
            $day_after_tomorrow = date('Y-m-d', strtotime('tomorrow + 1 day'));
            if($date == date('Y-m-d')){
                return "Ab ".date('H:i',$from).' Uhr gebraucht';
            }elseif ($date == $tomorrow) {
                return "Morgen ab ".date('H:i',$from).' Uhr gebraucht';
            } else if ($date == $day_after_tomorrow) {
                return "Übermorgen ab ".date('H:i',$from).' Uhr gebraucht';
            }else{
                return "Ab ".date('d.m.Y H:i',$from).' Uhr gebraucht';
            }
        }
    }

    /**
     * Helper
     *
     * How long ago...
     * @param $since timestamp
     * @return string
     */
    public static function niceTime($since){
        $periods         = array("Sekunde", "Minute", "Stunde", "Tag", "Woche", "Monat", "Jahr", "decade");
        $lengths         = array("60","60","24","7","4.35","12","10");

        $now             = time();
        $unix_date       = strtotime($since);

        // check validity of date
        if(empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if($now > $unix_date) {
            $difference     = $now - $unix_date;
            $tense         = "ago";
        } else {
            $difference     = $unix_date - $now;
            $tense         = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= (array_key_exists($periods[$j],array('Tag','Monat','Jahr'))) ? 'en' : 'n';
        }

        return "$difference $periods[$j]";
    }

    /**
     * Helper
     */
    public static function helpOffered($insertion)
    {
        $user = $insertion->users()->where('user_id', Session::get('user_id'))->first();
        if ($user) {
            return $user->pivot->amount;
        } else {
            return 0;
        }
    }
}