<div class="page-title">
  <div class="title_left">
    <h3>People Finder</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
        </span>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Member's Inquiry
          <small>This <strong>Member's Inquiry</strong> responsible for viewing of member's profile including unpaid contributions/dues.</small>
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="pull-right">
          <a class="btn btn-success" href="/person/create"><i class="glyphicon glyphicon-plus"></i> Add Member</a>
        </div>
        <br />
        <table class="table table-hover">
          <thead>
            <tr>
              <th>
                Name<br>
                <small>Address</small>
              </th>
              <th></th>
              <!-- <th>Total Contributions</th> -->
            </tr>
          </thead>
          <tbody ng-repeat="person in pf.personData">
            <tr ng-click="pf.showPersonDetail(person)">
              <td>
                <img class="img-rounded img-responsive pull-left" src="/assets/images/img.jpg" alt="" width="40" height="40">
                <div class="col-md-6">
                  <p  style="margin-bottom: 0px;" ng-bind="person.name"></p>
                  <small  style="margin-bottom: 0px;" ng-bind="person.address"></small>
                </div>
              </a>
              </td>
              <td class="">
                <div class="pull-right">
                  <button class="btn btn-info btn-xs" ng-click="pf.edit(collection)"><i class="glyphicon glyphicon-pencil"></i></button>
                  <!-- <button class="btn btn-success" ng-click="pf.post(collection)">Activate</button> -->
                  <button class="btn btn-danger btn-xs" ng-click="pf.remove(collection)"><i class="glyphicon glyphicon-remove"></i></button>
                </div>
              </td>
              <!-- <td ng-bind="person.type"></td> -->
              <!-- <td class="text-right" ng-bind="person.total_collection"></td> -->
            </tr>
            <tr style="background-color: #f7f7f7;" showdetail person="person" showdetails="person.isshowdetails"></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>