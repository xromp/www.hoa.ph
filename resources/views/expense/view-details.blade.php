<div class="modal-header">
  <h5 class="modal-title" id="modal-title" ng-bind="vm.formData.title"></h5>
</div>
<div class="modal-body" id="modal-body">
  <form name="vm.frmCreate" novalidate>
    <div class="row">
      <div class="col-md-7 col-md-offset-2">

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">PCV No.: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.pcv"></label>
          </div>

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Ref No.: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.orno"></label>
          </div>

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Ref Date: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.ordate"></label>
          </div>

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Establishment: </label>
              <label class="control-label col-md-5 col-sm-3 col-xs-12 col-md-offset-1" ng-bind="vm.collectionDetails.establishment"></label>
          </div>

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Amount: </label>
              <label class="control-label col-md-5 col-sm-3 col-xs-12 col-md-offset-1" ng-bind="vm.collectionDetails.amount | number:2"></label>
          </div>

      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-7 col-md-offset-2">

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Category: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.category_description"></label>
          </div>

          <div class="form-group">
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Type: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.category_type_desc"></label>
          </div>

          <div class="form-group">
              <br>
              <label class="control-label col-md-4 col-sm-3 col-xs-12">Remarks: </label>
              <label class="control-label col-md-8 col-sm-3 col-xs-12" ng-bind="vm.collectionDetails.remarks"></label>
          </div>
      </div>
    </div>
    <div class="col-md-10 col-md-offset-1" ng-show="vm.response.status">
      <div class="text-center" ng-class="{'alert alert-success':vm.response.status == 200,'alert alert-danger':vm.response.status != 200}" ng-bind="vm.response.message">
      </div>
    </div>
  </form>

  <!-- <div ng-bind="vm.formData.message"></div> -->
  <!-- <div class="modal-footer"> -->
  <br>
    <div class="pull-right">
      <button class="btn btn-default" type="button" ng-click="vm.cancel()">Close</button>
      <button class="btn btn-success" type="button" ng-click="vm.post(vm.collectionDetails)" ng-disabled="vm.collectionDetails.posted"><i class="glyphicon glyphicon-ok"></i> Post</button>
    </div>
  <!-- </div> -->
  <br>
  <br>
</div>

