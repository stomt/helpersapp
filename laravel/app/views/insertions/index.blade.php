<ul data-role="listview" data-shadow="false" data-inset="true" data-icon="false" data-theme="d" class="requests">

	@if (count($insertions) > 0)
		@foreach ($insertions as $insertion)
			@include('insertions.show')
		@endforeach
	@else
		Sei der Erste der einen Eintrag erstellt!
	@endif
	
</ul>