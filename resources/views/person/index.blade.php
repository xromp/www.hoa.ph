@extends('layouts.master')
@section('layouts.gloabal-templates')
<script type="text/ng-template" id="person.finder">
	@include('person.finder')
</script>
<script type="text/ng-template" id="person.finder-showdetail">
	@include('person.finder-showdetail')
</script>
<script type="text/ng-template" id="person.create">
	@include('person.create')
</script>
<script type="text/ng-template" id="person.dashboard">
	@include('person.dashboard')
</script>
<script type="text/ng-template" id="person.view-details">
  @include('person.view-details')
</script>
@endsection

@section('scripts')
<script type="text/javascript" src="/js/person/person.js"></script>
@endsection

