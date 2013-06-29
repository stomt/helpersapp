<!doctype html>
<html lang="en">
<head>
    <title>Fluthilfe-Koordinator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta charset="utf-8">    
    <meta name="description" content="Schnelle und koordinierte Flut-Hilfe fürs Smartphone">

    <!-- Styles -->
    <link rel="stylesheet" media="all" type="text/css" href="/css/jquery.mobile-1.3.1.min.css" />
    <link rel="stylesheet" media="all" type="text/css" href="/css/main.css">

    <!-- Scripts -->
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
            <h3><a href="/">flut.stomt.de</a><br>Fluthilfe-Koordinator</h3>
        </div><!-- /header -->

        <div data-role="content">
            <h4>In welcher Stadt?</h4>
            <select class="chooseCity">
                <option>Bitte Stadt wählen</option>

                @foreach(City::all() as $city)

                    <option value="{{ $city->id }}"><a data-city="{{ $city->id }}">{{ $city->title }}</a></option>

                @endforeach
            </select>

            <ul>
                <li>ohne Registrierung</li>
                <li>schnell helfen</li>
                <li>koordiniert helfen</li>
                <li>schnell Hilfe bekommen</li>
                <li>#fluthilfeapp</li>
                <li>Feedback: <a href="mailto:flut@stomt.de">flut@stomt.de</a></li>
            </ul>
        </div><!-- /content -->

        <div data-role="footer" data-theme="c">
            <a href="http://philippzentner.de" title="Gründer von stomt">Philipp Zentner</a> <a href="http://maxklenk.de" title="Max Klenk">Max Klenk</a> <a href="http://stomt.com" title="stomt - Feedback">stomt</a> | <small>Version <!-- TODO --></small> | <a href="#impressum">Impressum</a>
        </div><!-- /footer -->

    </div><!-- /page -->


    <!-- INCLUDE -->
    <div data-role="page" id="helpdata">
        <div data-role="header" data-type="horizontal">
            <div data-role="navbar"><ul><li><a href="#helpdata" data-theme="c" class="ui-btn-active ui-state-persist">Meine Hilfe-Daten</a></li></ul></div>
            <div><h4>Flut-Hilfe: <a href="#home"><span class="city"></span></a></h4></div>
        </div><!-- /header -->

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp">Helfen</a></li>
                <li><a href="#searchHelp" data-show="searchHelp">Brauchen Hilfe</a></li>
            </ul>
        </div><!-- /navbar -->

        <div data-role="content" id="helpDataReq"></div>
    </div>



    <div data-role="page" id="offerHelp">
        <div data-role="header" data-type="horizontal">
            <div data-role="navbar"><ul><li><a href="#helpdata" data-theme="c">Meine Hilfe-Daten</a></li></ul></div>
            <div><h4>Flut-Hilfe: <a href="#home"><span class="city"></span></a></h4></div>
        </div>

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp" class="ui-btn-active ui-state-persist">Helfen</a></li>
                <li><a href="#searchHelp" data-show="searchHelp">Brauchen Hilfe</a></li>
            </ul>
        </div>

        <div data-role="content" id="helpRequests">
        </div>
    </div>



    <div data-role="page" id="impressum">
        <div data-role="header" data-type="horizontal">
            <div data-role="navbar"><ul><li><a href="#helpdata" data-theme="c">Meine Hilfe-Daten</a></li></ul></div>
            <div><h4><a href="#home">Zurück zum Start</a></h4></div>
        </div>

        <div data-role="content">
            <h2>Impressum</h2>
            Entwickelt und bereitgestellt durch:<br>
            <a href="http://philippzentner.de">Philipp Zentner</a> (<a href="http://stomt.de">stomt</a>) <br>
            Unterer Sand 3-5 (zur Zeit postalisch nicht zu erreichen)<br>
            94032 Passau<br>
            <a href="mailto:flut@stomt.com">flut@stomt.com</a>
            <p>SSL-Lizenz bereit gestellt durch <a href="https://www.aditsystems.de/">Anton Dollmaier</a></p>
        </div>
    </div>



    <div data-role="page" id="searchHelp">
        <div data-role="header" data-type="horizontal">
            <div data-role="navbar"><ul><li><a href="#helpdata" data-theme="c">Meine Hilfe-Daten</a></li></ul></div>
            <div><h4>Flut-Hilfe: <a href="#home"><span class="city"></span></a></h4></div>
        </div>

        <div data-role="navbar">
            <ul>
                <li><a href="#offerHelp" data-show="offerHelp">Helfen</a></li>
                <li><a href="#searchHelp" data-show="searchHelp" class="ui-btn-active ui-state-persist">Brauchen Hilfe</a></li>
            </ul>
        </div>


        <form id="helpRequest" name="helpRequest">
            <h3>Nach sofortiger Hilfe fragen</h3>
            <label for="address">Adresse:</label>
            <input type="text" name="address" id="address" data-mini="true" />

            <label for="helperRequested">Anzahl Helfer benötigt:</label>
            <div style="width:75px">
                <input type="text" data-inline="true" name="helperRequested" maxlength="3" id="helperRequested" data-mini="true" placeholder="(Zahl)" />
            </div>

            <label for="Datum">Ab wann? (Datum / Zeit)</label>
            <div class="datetime">
                   <div><input type="date" name="date" value="<?php echo date('d.m.Y'); ?>"  /></div>
                   <div><input type="time" name="time" value="<?php echo date('H:i'); ?>"  /></div>
            </div>
            <div style="clear: both"></div>

            <label for="notice">Bemerkung (optional, max. 120 Zeichen):</label>
            <input type="text" name="notice" id="notice" maxlength="120" data-mini="true" />

            <span data-role="button" id="createHelpRequest" data-mini="true">Eintragen</span>
        </form>
    </div>

</body>
</html>