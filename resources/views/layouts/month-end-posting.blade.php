<div class="modal-header">
  <h4 class="modal-title" id="modal-title" ng-bind="vm.formData.title"></h4>
</div>
<div class="modal-body" id="modal-body">
  <div class="text-right" ng-bind="vm.formData.query.now | date:'medium'"></div>
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <label class="control-label col-md-5">Total Collection: </label>
        <div class="text-right col-md-7" ng-bind="vm.formData.total.total_collection"></div>
      </div>
      <div class="row">
        <label class="control-label col-md-5">Total Expense: </label>
        <div class="text-right col-md-7" ng-bind="vm.formData.total.total_expense"></div>
      </div>
    </div>
  </div>
  <div class="row">
      <div ng-show="vm.response.status">
        <div class="text-center" ng-class="{'alert alert-success':vm.response.status == 200,'alert alert-danger':vm.response.status != 200}" ng-bind="vm.response.message">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button class="btn btn-default" type="button" ng-click="vm.cancel()"> Cancel</button>
  <button class="btn btn-success" type="button" ng-click="vm.post(vm.formData.query)"><i class="glyphicon glyphicon-ok"></i> Month End Posting for <% vm.monthname(vm.formData.query.month) +' '+ vm.formData.query.year%></button>
</div>
