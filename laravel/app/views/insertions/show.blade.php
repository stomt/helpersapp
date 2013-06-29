
<li>
    <h6>
        <span class="a">TODO / {{ $insertion->helperRequested }}</span> Helfer/Innen zugesagt
    </h6>
    <div class="address">
        Adresse: {{ $insertion->address }} <a href="https://maps.google.com/?q={{ $insertion->address }}">(Google Maps)</a>
    </div>
    <div class="time">
    Eingestellt vor 2 Wochen | Morgen ab 03:14 Uhr gebraucht
    </div>
    <span class="bez">Bemerkung:</span> 
    <div class="notice">
        Hier eine Testbemerkung vom Entwickler dieser App.
    </div>
    <div data-role="controlgroup" data-type="horizontal">
        <select class="amountHelper" data-mini="true" data-inline="true">
            <option value="1">Ich</option>
            <option value="2">2</option>
        </select>
        <div data-mini="true" data-inline="true" data-role="button" class="help" data-help="increaseHelp" data-iid="{{ $insertion->id }}">komme!</div>
    </div>
</li>
