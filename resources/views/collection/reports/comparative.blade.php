<link rel="stylesheet" type="text/css" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">

<div>
	<h5>
		GREVHAI<br>
		Summary Collection & Expense<br>
		From {{$data['formdata']['startdate']}} to {{$data['formdata']['enddate']}}
	</h5>
</div>

<div class="row">

	<div class="col-xs-8">
		<br>
		<div class="col-xs-12">COLLECTIONS</div>
		<div class="col-xs-10">
			@foreach ($data['data']['collection']['details'] as $key=> $or)
			<div class="col-xs-8 col-xs-offset-2">{{$or-> description}}</div>
			<div class="col-xs-2">
				<span class=" pull-right">{{ number_format($or-> amount,2,'.',',') }}</span>
			</div>
			@endforeach
		</div>
		<div class="col-xs-10">
			<div class="col-xs-3 col-xs-offset-9" style="border-top:solid">
				<span class=" pull-right"><strong>{{ number_format($data['data']['collection']['total'],2,'.',',') }}</strong></span>
			</div>
		</div>
	</div>
	
	<div class="col-xs-8">
		<br>
		<div class="col-xs-12">EXPENSES</div>
		<div class="col-xs-10">
			@foreach ($data['data']['expense']['details'] as $key=> $or)
			<div class="col-xs-8 col-xs-offset-2">{{$or-> description}}</div>
			<div class="col-xs-2 text-right">{{ number_format($or-> amount,2,'.',',') }}</div>
			@endforeach
		</div>
		<div class="col-xs-10">
			<div class="col-xs-3 col-xs-offset-9 text-right" style="border-top:solid">
			<strong>{{  number_format($data['data']['expense']['total'], 2, '.', ',')}}</strong>
			</div>
		</div>
	</div>

</div>

 