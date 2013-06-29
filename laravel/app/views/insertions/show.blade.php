
<li {{ $insertion->helpOffered > 0 ? 'data-theme="e"' : '' }}>
    <h6>
        <span class="a">{{ $insertion->users()->sum('amount') ? $insertion->users()->sum('amount') : 0 }} / {{ $insertion->helperRequested }}</span> Helfer/Innen zugesagt
    </h6>
    <div class="address">
        Adresse: {{ $insertion->address }} <a href="https://maps.google.com/?q={{ $insertion->address }}">(Google Maps)</a>
    </div>
    <div class="time">
    Eingestellt vor {{ $insertion->created }} | {{ $insertion->howlong }} gebraucht
    </div>
    <span class="bez">Bemerkung:</span> 
    <div class="notice">
        {{ $insertion->notice }}
    </div>
    @if ($insertion->user_id == Session::get('user_id'))
        <span data-mini="true" data-role="button" data-theme="e" class="delete" data-iid="{{ $insertion->id }}">Löschen</span></li>
    @else
        <div data-role="controlgroup" data-type="horizontal">
            
            @if ($insertion->helpOffered > 0) 

                <select class="amountHelper" data-mini="true" data-inline="true" data-theme="e">
                    @for ($i=1; $i <= $insertion->helpOffered; $i++) 
                        <option value="{{ $i }}" {{ $insertion->helpOffered == $i ? " selected" : "" }}>
                            {{ $i == 1 ? "Ich" : $i }}
                        </option>
                    @endfor
                </select>
                <div data-mini="true" data-inline="true" data-role="button" class="help" data-help="decreaseHelp" data-amount="{{ -$insertion->helpOffered }}" data-theme="e" data-iid="{{ $insertion->id }}">wieder absagen!</div>

            @else

                <select class="amountHelper" data-mini="true" data-inline="true">
                    @for ($i=1; $i <= 30 && $i <= $insertion->helperRequested - $insertion->users()->sum('amount'); $i++) 
                        <option value="{{ $i }}" {{ $insertion->helpOffered == $i ? " selected" : "" }}>
                            {{ $i == 1 ? "Ich" : $i }}
                        </option>
                    @endfor
                </select>
                <div data-mini="true" data-inline="true" data-role="button" class="help" data-help="increaseHelp" data-amount="1" data-iid="{{ $insertion->id }}">komme!</div>

            @endif

        </div>
    @endif
</li>