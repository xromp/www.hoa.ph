<div ng-controller="ExpenseViewCtrl as ev">
  <div class="alert alert-success">
    <div class="row">
      <div class="col-md-5">
        OR Date
        <div class="form-group">
          <div class="col-md-6">
            <p class="input-group">
              <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="ev.query.startdate" is-open="ev.dtIsOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" placeholder="From" />
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="ev.datepickerOpen(ev,'DATEFROM')"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
            </p>
          </div>

          <div class="col-md-6">
            <p class="input-group">
              <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="ev.query.enddate" is-open="ev.dtIsOpen2" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats"/ placeholder="To">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="ev.datepickerOpen(ev,'DATETO')"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        Ref No.
        <div class="form-group">
          <div class="col-md-12">
            <input type="text" name="searchorno" class="form-control" ng-model="ev.query.orno">
          </div>
        </div>
      </div>

      <div class="col-md-3">
        Posted
        <div class="form-group">
          <div class="col-md-5">
            <input type="checkbox" name="posted" class="" ng-model="ev.query.posted" style="zoom:1.8;">
          </div>
        </div>
      </div>
      <div class="pull-right">
        <button class="btn btn-default" ng-click="ev.search(ev.query)"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="pull-right">
      <button class="btn btn-success" ng-click="ec.addExpense()">
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
          <th>PCV</th>
          <th>Ref No.</th>
          <th>OR Date</th>
          <th>Category</th>
          <th>Amount</th>
          <th>Date Encoded</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-class="{'bg-success':expense.posted,'bg-danger':expense.deleted}" ng-repeat="expense in ev.expenseDetails | orderBy:'pcv'" ng-click="ev.showDetails(expense)">
          <td ><% $index+1 %></td>
          <td class="text-right" ng-bind="expense.pcv"></td>
          <td class="text-left" ng-bind="expense.orno"></td>
          <td ng-bind="expense.ordate | date:'dd-MMM-yyyy'"></td>
          <td ng-bind="expense.category_description"></td>
          <td class="text-right" ng-bind="expense.amount | number:2" style="padding-right:5%"></td>
          <td ng-bind="expense.created_at | date:'dd-MMM-yyyy'"></td>
          <td class="">
            <div class="pull-right">
              <button class="btn btn-success btn-xs" ng-disabled="expense.posted || expense.deleted" ng-click="ev.post(expense);$event.stopPropagation();"><i class="glyphicon glyphicon-ok"></i></button>
              <button class="btn btn-info btn-xs" ng-disabled="expense.posted || expense.deleted" ng-click="ev.edit(expense);$event.stopPropagation();"><i class="glyphicon glyphicon-pencil"></i></button>
              <button class="btn btn-danger btn-xs" ng-disabled="expense.posted || expense.deleted" ng-click="ev.remove(expense);$event.stopPropagation();"><i class="glyphicon glyphicon-remove"></i></button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>