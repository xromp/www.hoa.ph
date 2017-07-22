<link rel="stylesheet" type="text/css" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">

<div>
  <h5>
    GREVHAI<br>
    Current Balance<br>
    For the of month {{$data['formData']['datename']}}
  </h5>
</div>
<br>
<div class="row">
  <div class="col-xs-8">
    <div class="col-xs-6 col-xs-offset-1">Previous Month Total Collections</div>
    <div><span class=" pull-right">{{ number_format($data['data']['collection']['prev_total'],2) }}</span></div>

    @foreach ($data['data']['collection']['details']->sortBy('category')  as $key=> $or)
    <div class="col-xs-7 col-xs-offset-2">{{ $or->category_desc }}</div>
    <div class="col-xs-2"><span class=" pull-right">{{ number_format($or->amount,2) }}</span></div>
    @endforeach

    <div class="col-xs-6 col-xs-offset-1">Total Collections</div>
    <div><strong class="pull-right">{{ number_format(($data['data']['collection']['details_total'] + $data['data']['collection']['prev_total']),2) }}</strong></div>
  </div>
</div>
<br><br><br>
<div class="row">
  <div class="col-xs-8">
    <div class="col-xs-6 col-xs-offset-1">Previous Month Total Expenses</div>
    <div><span class=" pull-right">{{ number_format($data['data']['expense']['prev_total'],2) }}</span></div>

    @foreach ($data['data']['expense']['details']->sortBy('category')  as $key=> $or)
    <div class="col-xs-7 col-xs-offset-2">{{ $or->category_desc }}</div>
    <div class="col-xs-2"><span class=" pull-right">{{ number_format($or->amount,2) }}</span></div>
    @endforeach

    <div class="col-xs-6 col-xs-offset-1">Total Expense</div>
    <div class=""><strong class="pull-right">{{ number_format(($data['data']['expense']['details_total'] + $data['data']['expense']['prev_total']),2) }}</strong></div>
  </div>
</div>