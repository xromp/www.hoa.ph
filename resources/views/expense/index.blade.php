@extends('layouts.master')

@section('layouts.gloabal-templates')
<script type="text/ng-template" id="expense.base">
	@include('expense.base')
</script>
<script type="text/ng-template" id="expense.create">
	@include('expense.create')
</script>
<script type="text/ng-template" id="expense.add-category">
	@include('expense.add-category')
</script>
<script type="text/ng-template" id="expense.add-category-type">
	@include('expense.add-category-type')
</script>
<script type="text/ng-template" id="expense.view">
	@include('expense.view')
</script>


<script type="text/ng-template" id="expense.reports.base">
	@include('expense.reports.base')
</script>
@endsection


@section('scripts')
<script type="text/javascript" src="{{URL::to('js/expense/expense.js')}}"></script>
@endsection

