<link rel="stylesheet" type="text/css" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">

<div>
  <h5>
    GREVHAI<br>
    Member List<br>
  </h5>
</div>

 <table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Address</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data['data']['personlist'] as $key=> $person)
    <tr>
      <td>{{ $key+1 }}</td>
      @if($person->status == 'MARRIED')
      <td>{{ $person->lname.", ".$person->fname." & ".$person->wife_fname }}</td>
      @else
      <td>{{ $person->name }}</td>
      @endif
      <td>{{ $person->address }}</td>
    </tr>
    @endforeach
  </tbody>
</table>