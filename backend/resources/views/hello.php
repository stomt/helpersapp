<!doctype html><html lang="en"><head>
<meta charset="utf-8"><title>Helpers-App: Nepal</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="description" content="HelpersApp.org - Get instant help">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<link rel="stylesheet" href="/css/main.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
<script src="/js/main.js"></script>
</head><body>
<div data-role="page" id="home" data-dom-cache="true">
<div data-role="header" data-type="horizontal">
<h1>Helpers-App: Nepal</h1>
</div><!-- /header -->

<div data-role="content">
<h4>Choose your district</h4>
<select class="chooseCity">
    <option>Please choose a district</option>
    <?php
    $regions = '';
    $cities = App\Models\City::all();
    foreach($cities as $city){
        $regions .= '<option value="'.$city->id.'"><a data-city="'.$city->id.'">'.$city->title.'</a></option>';
    }
    echo $regions;
    ?>
</select>

<ul>
    <li>Help the people in Nepal</li>
    <li>no registration needed</li>
    <li>help fast & coordinated</li>
    <li>get instant help</li>
    <li>#helpersapp</li>
</ul>
</div><!-- /content -->

<div data-role="footer" data-position="fixed"><small>v2.0.1</small>
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
    <li><a href="#offerHelp">Offer Help</a></li>
    <li><a href="#searchHelp">Need Help</a></li>
</ul>
</div><!-- /navbar -->

<div data-role="content" id="helpDataReq"></div>
</div>


<div data-role="page" id="offerHelp" data-dom-cache="true">
<div data-role="header">
<a href="#home" data-icon="home">Home</a>
<h1 class="city"></h1>
<a href="#helpdata" data-icon="gear">Your Page</a>
</div><!-- /header -->

<div data-role="navbar">
<ul>
    <li><a href="#offerHelp" class="ui-btn-active ui-state-persist">Offer Help</a></li>
    <li><a href="#searchHelp">Need Help</a></li>
</ul>
</div>

<div data-role="content" id="helpRequests">
</div>
</div>



<div data-role="page" id="impressum" data-dom-cache="true">
<div data-role="header">
<a href="#home" data-icon="home">Home</a>
<h1>Impressum</h1>
<a href="#helpdata" data-icon="gear">Your Page</a>
</div><!-- /header -->

<div data-role="content">
<h2>Impressum</h2>
Created and offered by <a href="http://stomt.com">stomt</a>:<br>
Dr.-Hans-Kapfinger-Straße 12, Raum 112/113<br>
94032 Passau, Germany<br>
<a href="mailto:helpersapp@stomt.com">helpersapp@stomt.com</a>
</div>

<div data-role="footer" data-position="fixed">
    <a href="#impressum" title="Impressum">Contact</a>  v2.0.1
    <a href="http://www.stomt.com/helpersapp" title="Helpersapp on stomt">Feedback</a>
</div>
</div>



<div data-role="page" id="searchHelp" data-dom-cache="true">
<div data-role="header">
<a href="#home" data-icon="home">Home</a>
<h1 class="city"></h1>
<a href="#helpdata" data-icon="gear">Your Page</a>
</div><!-- /header -->

<div data-role="navbar">
<ul>
    <li><a href="#offerHelp">Offer Help</a></li>
    <li><a href="#searchHelp" class="ui-btn-active ui-state-persist">Need Help</a></li>
</ul>
</div>

<div data-role="content">
<form id="helpRequest" name="helpRequest">

    <h3>Ask for instant help</h3>

    <label for="address">Address:</label>
    <input type="text" name="address" id="address" data-mini="true" />

    <label for="category">Category</label>
    <select name="category" data-mini="true">
        <option>Please choose a category</option>
        <option value="1"><a data-city="1">Earthquake Damage</a></option><option value="2"><a data-city="2">Medical Evacuation</a></option><option value="3"><a data-city="3">Medical Assistance</a></option><option value="4"><a data-city="4">Food/Water/Shelter</a></option><option value="5"><a data-city="5">Food/Water</a></option><option value="6"><a data-city="6">Blocked Roads</a></option><option value="7"><a data-city="7">People Trapped</a></option><option value="8"><a data-city="8">Fallen Electric Pole</a></option><option value="9"><a data-city="9">Fallen Transformer</a></option>
        <?php
        /*
        $categories = '';
        foreach(App\Models\Category::all() as $category){
            $categories .= '<option value="'.$category->id.'"><a data-city="'.$category->id.'">'.$category->categoryname.'</a></option>';
        }
        echo $categories;*/
        ?>
    </select>

    <label for="helperRequested">Amount of helpers neccessary:</label>
    <input type="range" name="helperRequested" id="helperRequested" value="10" min="1" max="100"/>

    <fieldset data-role="controlgroup" data-type="horizontal">
       <legend>When? (Day / Time):</legend>
       <label for="select-choice-day">Day</label>
       <select name="select-choice-day" id="select-choice-day" data-mini="true">
       <option id="choice-day-0" value="0">Today</option>
       <option id="choice-day-1" value="1">Tomorrow</option>
       <option id="choice-day-2" value="2">in 2 Days</option>
       <option id="choice-day-3" value="3">in 3 Days</option>
       <option id="choice-day-4" value="4">in 4 Days</option>
       <option id="choice-day-5" value="5">in 5 Days</option>
       <option id="choice-day-6" value="6">in 6 Days</option>
       </select>

       <label for="select-choice-hours">Hours</label>
       <select name="select-choice-hours" id="select-choice-hours" data-mini="true">
           <option id="choice-hour-0"value="0">0 h</option><option id="choice-hour-1"value="1">1 h</option><option id="choice-hour-2"value="2">2 h</option><option id="choice-hour-3"value="3">3 h</option><option id="choice-hour-4"value="4">4 h</option><option id="choice-hour-5"value="5">5 h</option><option id="choice-hour-6"value="6">6 h</option><option id="choice-hour-7"value="7">7 h</option><option id="choice-hour-8"value="8">8 h</option><option id="choice-hour-9"value="9">9 h</option><option id="choice-hour-10"value="10">10 h</option><option id="choice-hour-11"value="11">11 h</option><option id="choice-hour-12"value="12">12 h</option><option id="choice-hour-13"value="13">13 h</option><option id="choice-hour-14"value="14">14 h</option><option id="choice-hour-15"value="15">15 h</option><option id="choice-hour-16"value="16">16 h</option><option id="choice-hour-17"value="17">17 h</option><option id="choice-hour-18"value="18">18 h</option><option id="choice-hour-19"value="19">19 h</option><option id="choice-hour-20"value="20">20 h</option><option id="choice-hour-21"value="21">21 h</option><option id="choice-hour-22"value="22">22 h</option>
       </select>

        <label for="select-choice-minutes">Minutes</label>
        <select name="select-choice-minutes" id="select-choice-minutes" data-mini="true">
            <option value="00">00 min</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
    </fieldset>

    <label for="number">Phone:</label>
    <input type="tel" name="number" id="number" data-mini="true" />

    <label for="notice">Notice (optional, max. 120 characters):</label>
    <textarea name="notice" id="notice" data-mini="true" maxlength="120" ></textarea>

    <button data-mini="true" id="createHelpRequest">Ask for help</button>
</form>
</div>
</div>
</body></html>