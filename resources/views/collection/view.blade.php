<div ng-controller="CollectionViewCtrl as cv">
  <div class="alert alert-success">
    <div class="row">
      <div class="col-md-5">
        OR Date
        <div class="form-group">
          <div class="col-md-6">
            <p class="input-group">
              <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="cv.query.startdate" is-open="cv.dtIsOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" placeholder="From" />
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="cv.datepickerOpen(cv,'DATEFROM')"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
            </p>
          </div>

          <div class="col-md-6">
            <p class="input-group">
              <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="cv.query.enddate" is-open="cv.dtIsOpen2" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats"/ placeholder="To">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="cv.datepickerOpen(cv,'DATETO')"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        OR No.
        <div class="form-group">
          <div class="col-md-12">
            <input type="text" name="searchorno" class="form-control" ng-model="cv.query.orno">
          </div>
        </div>
      </div>

      <div class="col-md-3">
        Posted
        <div class="form-group">
          <div class="col-md-5">
            <input type="checkbox" name="posted" class="" ng-model="cv.query.posted" style="zoom:1.8;">
          </div>
        </div>
      </div>
      <div class="pull-right">
        <button class="btn btn-default" ng-click="cv.search(cv.query)"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="pull-right">
      <button class="btn btn-success" ng-click="cv.addCollection()">
        <i class="glyphicon glyphicon-plus"></i>
        Add New Collection
      </button>
    </div>
  </div>
  <div class="row">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Ref No.</th>
          <th>Ref Date</th>
          <th>Collection Category</th>
          <th>From</th>
          <th>Amount</th>
          <th>Date Encoded</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-class="{'bg-success':collection.posted,'bg-danger':collection.deleted}" ng-repeat="collection in cv.collectionDetails | orderBy:'orno'" ng-click="cv.showDetails(collection)">
          <td ><% $index+1 %></td>
          <td class="text-left" ng-bind="collection.orno"></td>
          <td ng-bind="collection.ordate | date:'dd-MMM-yyyy'"></td>
          <td ng-bind="collection.category_description"></td>
          <td ng-bind="collection.fullname"></td>
          <td class="text-right" ng-bind="collection.amount | number:2" style="padding-right:5%"></td>
          <td ng-bind="collection.created_at | date:'dd-MMM-yyyy'"></td>
          <td class="">
            <div class="pull-right">
              <button class="btn btn-success btn-xs" ng-disabled="collection.posted || collection.deleted" ng-click="cv.post(collection);$event.stopPropagation();"><i class="glyphicon glyphicon-ok"></i></button>
              <button class="btn btn-info btn-xs" ng-disabled="collection.posted || collection.deleted" ng-click="cv.edit(collection);$event.stopPropagation();"><i class="glyphicon glyphicon-pencil"></i></button>
              <button class="btn btn-danger btn-xs" ng-disabled="collection.posted || collection.deleted" ng-click="cv.remove(collection);$event.stopPropagation();"><i class="glyphicon glyphicon-remove"></i></button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>