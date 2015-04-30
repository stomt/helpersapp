<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helper-App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="description" content="HelpersApp.org - Get instant help">

    <!-- Styles -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
    <link rel="stylesheet" href="css/main.css">

    <!-- Scripts -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>-->
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.mobile-1.3.1.min.js"></script>

    <script type="text/javascript" src="/js/main.js"></script>

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../favicon.ico">
</head>
<body>

    <div data-role="page" id="home">
        <div data-role="header" data-type="horizontal">
            <a href="http://www.stomt.de" data-icon="star">stomt.com</a>
            <h1>Helpers-App</h1>
        </div><!-- /header -->

        <div data-role="content">
            <h4>Choose your region</h4>
            <select class="chooseCity">
                <option>Please choose a region</option>
                @foreach(City::all() as $city)

                    <option value="{{ $city->id }}"><a data-city="{{ $city->id }}">{{ $city->title }}</a></option>

                @endforeach
            </select>

            <ul>
                <li>no registration needed</li>
                <li>help fast</li>
                <li>help coordinated</li>
                <li>get instant help</li>
                <li>#helpersapp</li>
                <li>Feedback: <a href="mailto:helpersapp@stomt.com">helpersapp@stomt.com</a></li>
            </ul>
        </div><!-- /content -->

        <div data-role="footer" data-position="fixed">
            <a href="http://stomt.com" title="stomt - Feedback">stomt</a>  <small>v2.0.1</small>
            <a href="#impressum" title="Impressum">Contact</a>
        </div>
    </div><!-- /page -->

    <!-- INCLUDE -->
    <div data-role="page" id="helpdata">
        <div data-role="header">
            <a href="#home" data-icon="home">Home</a>
            <h1 class="city"></h1>
            <a href="#helpdata" data-icon="gear">Your Page</a>
        </div><!-- /header -->

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp">Offer Help</a></li>
                <li><a href="#searchHelp" data-show="searchHelp">Need Help</a></li>
            </ul>
        </div><!-- /navbar -->

        <div data-role="content" id="helpDataReq"></div>
    </div>



    <div data-role="page" id="offerHelp">
        <div data-role="header">
            <a href="#home" data-icon="home">Home</a>
            <h1 class="city"></h1>
            <a href="#helpdata" data-icon="gear">Your Page</a>
        </div><!-- /header -->

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp" class="ui-btn-active ui-state-persist">Offer Help</a></li>
                <li><a href="#searchHelp" data-show="searchHelp">Need Help</a></li>
            </ul>
        </div>

        <div data-role="content" id="helpRequests">
        </div>
    </div>



    <div data-role="page" id="impressum">
        <div data-role="header">
            <a href="#home" data-icon="home">Home</a>
            <h1>Impressum</h1>
            <a href="#helpdata" data-icon="gear">Your Page</a>
        </div><!-- /header -->

        <div data-role="content">
            <h2>Impressum</h2>
            Created and offered by <a href="http://stomt.de">stomt</a>:<br>
            Dr.-Hans-Kapfinger-Straße 12, Raum 112/113<br>
            94032 Passau, Germany<br>
            <a href="mailto:helpersapp@stomt.com">helpersapp@stomt.com</a>
            <p>SSL-License through<a href="https://www.aditsystems.de/">Anton Dollmaier</a></p>
        </div>

        <div data-role="footer" data-position="fixed">
            <a href="http://stomt.com" title="stomt - Feedback">stomt</a>  v2.0.0 
            <a href="#impressum" title="Impressum">Kontakt</a>
        </div>
    </div>



    <div data-role="page" id="searchHelp">
        <div data-role="header">
            <a href="#home" data-icon="home">Home</a>
            <h1 class="city"></h1>
            <a href="#helpdata" data-icon="gear">Your Page</a>
        </div><!-- /header -->

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp">Offer Help</a></li>
                <li><a href="#searchHelp" data-show="searchHelp" class="ui-btn-active ui-state-persist">Need Help</a></li>
            </ul>
        </div>

        <div data-role="content">
            <form id="helpRequest" name="helpRequest">

                <h3>Ask for instant help</h3>

                <label for="address">Address:</label>
                <input type="text" name="address" id="address" data-mini="true" />

                <label for="helperRequested">Amount of helpers neccessary:</label>
                <input type="range" name="helperRequested" id="helperRequested" value="10" min="1" max="100" data-mini="true"/>

                <fieldset data-role="controlgroup" data-type="horizontal">
                    <legend>When? (Day / Time):</legend>
                    <label for="select-choice-day">Tag</label>
                    <select name="select-choice-day" id="select-choice-day" data-mini="true">
                       <option id="choice-day-0" value="0">Today</option>
                       <option id="choice-day-1" value="1">Tomorrow</option>
                       <option id="choice-day-2" value="2">in 2 Day</option>
                       <option id="choice-day-3" value="3">in 3 Day</option>
                       <option id="choice-day-4" value="4">in 4 Day</option>
                       <option id="choice-day-5" value="5">in 5 Day</option>
                       <option id="choice-day-6" value="6">in 6 Day</option>
                    </select> 
                    
                    <label for="select-choice-hours">Hours</label>
                    <select name="select-choice-hours" id="select-choice-hours" data-mini="true">
                        @for ($i=0; $i < 23; ++$i)
                            <option id="choice-hour-{{ $i }}"value="{{ $i }}">{{ $i }} h</option>
                        @endfor
                    </select>
                
                    <label for="select-choice-minutes">Minutes</label>
                    <select name="select-choice-minutes" id="select-choice-minutes" data-mini="true">
                        <option value="00">00 min</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>
                </fieldset>

                <label for="number">Phonenumber:</label>
                <input type="tel" name="number" id="number" data-mini="true" />

                <label for="notice">Notice (optional, max. 120 characters):</label>
                <textarea name="notice" id="notice" data-mini="true" maxlength="120" ></textarea>

                <span data-role="button" id="createHelpRequest" data-mini="true">Post</span>
            </form>
        </div>
    </div>
</body>
</html>