<link rel="stylesheet" type="text/css" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">

<div>
  <h5>
    GREVHAI<br>
    Financial Report<br>
    For the of month {{$data['formData']['datename']}} <br>
  </h5>
</div>
<br>
<div class="row">
  <div class="col-xs-11">
    <div class="col-xs-6">Balance carried forwarded - {{$data['data']['balanceforwarded']['monthname']}}</div>
    <div class="col-xs-6"><span class=" pull-right"><strong>{{ number_format($data['data']['balanceforwarded']['total'],2) }}</strong></span></div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-11">
    @foreach ($data['data']['collection']['details']->sortBy('category')  as $key=> $or)
    <div class="col-xs-5 col-xs-offset-1">{{ $or->category_desc }}</div>
    <div class="col-xs-2"><span class=" pull-right">{{ number_format($or->amount,2) }}</span></div>
    @endforeach
  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-11">
    <div class="col-xs-5 col-xs-offset-1">Total Collections</div>
    <div class="col-xs-4"><strong class="pull-right">{{ number_format(($data['data']['collection']['details_total']),2) }}</strong></div>
  </div>
</div>
<br><br><br>
<div class="row">
  <div class="col-xs-11">
    <div class="col-xs-6 col-xs-offset-1"><strong>Less Expenses:</strong></div>

    @foreach ($data['data']['expense']['details']->sortBy('category')  as $key=> $or)
    <div class="col-xs-5 col-xs-offset-1">{{ $or->category_desc }}</div>
    <div class="col-xs-2"><span class=" pull-right">{{ number_format($or->amount,2) }}</span></div>
    @endforeach

  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-11">
    <div class="col-xs-5 col-xs-offset-1">Total Expenses</div>
    <div class="col-xs-4"><strong class="pull-right">{{ number_format(($data['data']['expense']['details_total']),2) }}</strong></div>
    </div>
</div>
<br>
<div class="row">
  <div class="col-xs-11">
    <div class="col-xs-6">Ending Balance - {{$data['data']['balanceending']['monthname']}}</div>
    <div class="col-xs-6"><span class=" pull-right"><strong>{{ number_format($data['data']['balanceending']['total'],2) }}</strong></span></div>
  </div>
</div>