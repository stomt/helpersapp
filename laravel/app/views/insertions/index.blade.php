<ul data-role="listview" data-shadow="false" data-inset="true" data-icon="false" data-theme="d" class="requests">

	@foreach ($insertions as $insertion)
		@include('insertions.show')
	@endforeach

</ul>