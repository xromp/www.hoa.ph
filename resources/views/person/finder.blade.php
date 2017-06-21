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
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="alert alert-success">
          <div class="row">
            <div class="col-md-5">
              Members
              <div class="form-group">
                <ui-select name="personid" ng-model="pf.query.personid" theme="bootstrap" required>
                  <ui-select-match placeholder="Search homeowner members..."><% $select.selected.name%></ui-select-match>
                  <ui-select-choices repeat="person.personid as person in pf.personList | filter: $select.search">
                    <div ng-bind-html="person.name | highlight: $select.search"></div>
                    <small ng-bind-html="person.address | highlight: $select.search"></small>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>

            <div class="pull-right">
              <button class="btn btn-default" ng-click="pf.get(pf.query)"><i class="glyphicon glyphicon-search"></i></button>
            </div>
          </div>
        </div>

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
                  <button class="btn btn-info btn-xs" ng-click="pf.edit(person)"><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger btn-xs" ng-click="pf.remove()"><i class="glyphicon glyphicon-remove"></i></button>
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