
<li {{ $insertion->helpOffered > 0 ? 'data-theme="e"' : '' }}>
    <h6>
        <span class="a">{{ $insertion->users()->sum('amount') ? $insertion->users()->sum('amount') : 0 }} / {{ $insertion->helperRequested }}</span> Helpers confirmed | {{$insertion->category->categoryname}}
    </h6>
    <div class="address">
        Address: {{ $insertion->address }} <a href="https://maps.google.com/?q={{ $insertion->address }}">(Google Maps)</a>
    </div>
    <div class="time">
    Created {{ $insertion->created }} | {{ $insertion->howlong }}
    </div>
    <?php
    if($insertion->number){
       echo '<div class="time">
        Phone: '.$insertion->number.'
        </div>';
    }
    ?>


    <span class="bez">Notice:</span>
    <div class="notice">
        {{ $insertion->notice }}
    </div>
    <?php if($insertion->user_id == Session::get('user_id')){
        echo '<button data-theme="e" class="delete" data-mini="true" data-iid="'.$insertion->id.'">Delete</button></li>';
    }else{

    echo '<div data-role="controlgroup" data-type="horizontal">';

            
            if ($insertion->helpOffered > 0){

                echo '<select class="amountHelper" data-mini="true" data-inline="true" data-theme="e">';
                    for ($i=1; $i <= $insertion->helpOffered; $i++) {

                        echo '<option value="'.$i.'" '.($insertion->helpOffered == $i ? " selected" : "" ).'>'.
                            ($i == 1 ? "I" : $i).'</option>';
                    }
                ?>
                </select>
                <span data-mini="true" data-inline="true" data-role="button" class="help" data-help="decreaseHelp" data-amount="{{ -$insertion->helpOffered }}" data-theme="e" data-iid="{{ $insertion->id }}">Revoke!</span>

           <?php } else { ?>

                <select class="amountHelper" data-mini="true" data-inline="true">

                    <?php
                    for ($i=1; $i <= $insertion->helperRequested - $insertion->users()->sum('amount'); $i++) {
                        echo '<option value="'.$i.'" '.($insertion->helpOffered == $i ? " selected" : "").'>'.($i == 1 ? "I" : $i).'</option>';
                    }
                    ?>
                </select>

                <button data-inline="true" data-mini="true" class="help" data-help="increaseHelp" data-amount="1" data-iid="{{ $insertion->id }}">will come!</button>
            <?php
            }
            ?>
        </div>
    <?php } ?>
</li>