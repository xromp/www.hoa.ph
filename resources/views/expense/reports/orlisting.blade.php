<link rel="stylesheet" type="text/css" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">

<div>
	<h5>
		GREVHAI<br>
		OR Listing<br>
		From {{$data['formData']['startdate']}} to {{$data['formData']['enddate']}}
	</h5>
</div>

 <table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>OR No.</th>
			<th>OR No.</th>
			<th>OR Date</th>
			<th>Category</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	 	@foreach ($data['orlist'] as $key=> $or)
		<tr>
			<td class="text-muted">{{++$key}}</td>
			<td>{{$or->orno}}</td>
			<td>{{$or->orno}}</td>
			<td>{{$or->ordate}}</td>
			<td>{{$or->category}}</td>
			<td class="text-center">{{$or->amount_paid}}</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="5">Total</td>
			<td class="text-right">{{ $data['total']}}</td>
		</tr>
	</tbody>
</table>