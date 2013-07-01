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
     * @param int $city_id
     * @return Response
     */
    public function index($city_id)
    {
        $result["success"] = false;

        $city = City::find($city_id);
        if ($city) {
            $insertions = $city->insertions;

            $result["success"] = true;
            $result["html"] = static::renderInsertions($insertions);
        }

        return Response::json($result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param int $city_id
     * @return Response
     */
    public function store($city_id)
    {
        $result["success"] = false;

        $city = City::find($city_id);
        if ($city) {
            $input = Input::only('address', 'helperRequested', 'notice', 'select-choice-day', 'select-choice-hours', 'select-choice-minutes', 'number');
            $validation = Validator::make($input, Insertion::$rules);
            if ($validation->passes()) {
                $insertion = new Insertion();
                $insertion->user_id = Session::get('user_id');
                $insertion->city_id = $city->id;
                
                $insertion->address = $input['address'];
                $insertion->helperRequested = $input['helperRequested'];
                $insertion->number = $input['number'];
                $insertion->notice = $input['notice'];

                $date = mktime(
                    $input['select-choice-hours'], 
                    $input['select-choice-minutes'], 
                    0,
                    date("m"),
                    date("d")+$input['select-choice-day'],
                    date("Y"));
                $insertion->howlong = date('Y-m-d H:i:s', $date);
                
                if ($insertion->save()) {
                    $result["success"] = true;
                }
            }
        }
        return Response::json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $city_id
     * @param  int  $insertion_id
     * @return Response
     */
    public function update($city_id, $insertion_id)
    {
        $result["success"] = false;
        // TODO
        return Response::json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $city_id
     * @param  int  $insertion_id
     * @return Response
     */
    public function destroy($city_id, $insertion_id)
    {
        $result["success"] = false;

        $city = City::find($city_id);
        $insertion = Insertion::find($insertion_id);
        if ($city && $insertion) {
            if (Session::get('user_id') == $insertion->user_id) {
                $insertion->delete();
                $insertions = $city->insertions;
                $result["success"] = true;
                $result["html"] = static::renderInsertions($insertions);
            } else {
                $result["error"] = "No Access";
            }
        } else {
            $result["error"] = "Not Found";
        }

        return Response::json($result);
    }

    public function myhelp()
    {
        $result["success"] = false;

        $user = User::live();
        $insertions = Insertion::with('users')->get()->filter(function($insertion) use ($user)
        {
            if ($insertion->user_id == $user->id) {
                return $insertion;
            } elseif ($insertion->users()->where('user_id', $user->id)->first()) {
                return $insertion;
            }
        });

        $result["success"] = true;
        $result["html"] = static::renderInsertions($insertions);
        
        return Response::json($result);
    }

    /**
     * Helper function to render a listing of $insertions.
     *
     * @param  Collection of Insertion $insertions
     * @return rendered View
     */
    public static function renderInsertions($insertions)
    {
        static::enrichData($insertions);
        
        return View::make('insertions.index', compact('insertions'))->render(); 
    }

    /**
     * Helper function to convert Insertion data to printable format.
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
         * Helper function to build a sentence containing how long 
         * the helpers are still needed.
         *
         * @param  timestamp  $howlong
         * @return String     rich representation of the time
         */
        private static function howlong($howlong)
        {
            $from = strtotime($howlong);
            // Falls es jetzt früher ist es der Termin + 2 std und es noch heute ist
            $time = time();
            if ($time >= $from && $time <= ($from+1440000)  && date('Ymd') == date('Ymd', $from) ) {
                return "Ab jetzt gebraucht!";
            } else {
                $date = date('Y-m-d', $from);
                $tomorrow = date('Y-m-d', strtotime('tomorrow'));
                $day_after_tomorrow = date('Y-m-d', strtotime('tomorrow + 1 day'));
                if ($date == date('Y-m-d')){
                    return "Ab ".date('H:i',$from).' Uhr gebraucht';
                } elseif ($date == $tomorrow) {
                    return "Morgen ab ".date('H:i',$from).' Uhr gebraucht';
                } elseif ($date == $day_after_tomorrow) {
                    return "Übermorgen ab ".date('H:i',$from).' Uhr gebraucht';
                } else {
                    return "Ab ".date('d.m.Y H:i',$from).' Uhr gebraucht';
                }
            }
        }

        /**
         * Helper function to convert start time.
         *
         * @param  timestamp $since
         * @return string
         */
        private static function niceTime($since){
            $periods         = array("Sekunde", "Minute", "Stunde", "Tag", "Woche", "Monat", "Jahr", "decade");
            $lengths         = array("60","60","24","7","4.35","12","10");

            $now             = time();
            $unix_date       = strtotime($since);

            // check validity of date
            if (empty($unix_date)) {
                return "Bad date";
            }

            // is it future date or past date
            if ($now > $unix_date) {
                $difference     = $now - $unix_date;
                $tense         = "ago";
            } else {
                $difference     = $unix_date - $now;
                $tense         = "from now";
            }

            for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                $difference /= $lengths[$j];
            }

            $difference = round($difference);

            if ($difference != 1) {
                $periods[$j].= (array_key_exists($periods[$j],array('Tag','Monat','Jahr'))) ? 'en' : 'n';
            }

            return "$difference $periods[$j]";
        }

        /**
         * Helper function to check if the current user offered help for this Insertion.
         *
         * @param   Insertion  $insertion
         * @return  int        # of users Group
         */
        private static function helpOffered($insertion)
        {
            $user = $insertion->users()->where('user_id', User::live()->id)->first();
            if ($user) {
                return $user->pivot->amount;
            } else {
                return 0;
            }
        }
        
}