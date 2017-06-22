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
			<th>OR No.</th>
			<th>OR Date</th>
			<th>Category</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	 	@foreach ($data['orlist']->sortBy('orno')  as $key=> $or)
		<tr>
			<td>{{ $or->orno }}</td>
			<td>{{ date("m/d/Y",strtotime($or->ordate)) }}</td>
			<td>{{$or->category}}</td>
			<td class="text-center">{{ number_format($or->amount,2) }}</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="5">Total</td>
			<td class="text-right">{{ $data['total']}}</td>
		</tr>
	</tbody>
</table>