@extends('layouts.master')

@section('layouts.gloabal-templates')
<script type="text/ng-template" id="collection.base">
	@include('collection.base')
</script>
<script type="text/ng-template" id="collection.create">
	@include('collection.create')
</script>
<script type="text/ng-template" id="collection.view">
	@include('collection.view')
</script>
<script type="text/ng-template" id="collection.add-category">
	@include('collection.add-category')
</script>
<script type="text/ng-template" id="collection.add-person">
	@include('collection.add-person')
</script>
<script type="text/ng-template" id="collection.reports.base">
	@include('collection.reports.base')
</script>
<script type="text/ng-template" id="collection.view-details">
  @include('collection.view-details')
</script>
@endsection


@section('scripts')
<script type="text/javascript" src="{{URL::to('js/collection/collection.js?v=20170716')}}"></script>
@endsection

