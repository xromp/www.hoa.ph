<form name="ecc.frmCreate" class="form-horizontal form-label-left" ng-controller="ExpenseCreateCtrl as ecc" novalidate>
  <div class="row">
  </div>

  <div class="row">
    <div class="col-md-6">

<!--       <div class="form-group" ng-class="{'has-error': ecc.frmCreate.pcv.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">PCV No.<span class="required">*</span>
        </small></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="number" min="1" name="pcv" class="form-control col-md-7 col-xs-12" ng-model="ecc.collectionDetails.pcv" required disabled>
          <span class="help-block" ng-show="ecc.frmCreate.pcv.$invalid && ecc.frmCreate.withError">PCV is required field.</span>
        </div>
      </div> -->

      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.orno.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ref No<span class="required">*</span><small>
          (OR,CR,SI)
        </small></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="orno" class="form-control col-md-7 col-xs-12" ng-model="ecc.collectionDetails.orno" required>
          <span class="help-block" ng-show="ecc.frmCreate.orno.$invalid && ecc.frmCreate.withError">OR No. is required field.</span>
        </div>
      </div>

      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.ordate.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ref Date <span class="required">*</span></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
        <p class="input-group">
          <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="ecc.collectionDetails.ordate" is-open="ecc.dtIsOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" required/>
          <span class="input-group-btn">
            <button type="button" class="btn btn-default" ng-click="ecc.datepickerOpen(ecc)"><i class="glyphicon glyphicon-calendar"></i></button>
          </span>
        </p>
        <span class="help-block" ng-show="ecc.frmCreate.ordate.$invalid && ecc.frmCreate.withError">OR Date is required field.</span>
        </div>
      </div>

      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.establishment.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Establishment<span class="required">*</span>
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="establishment"  class="form-control col-md-7 col-xs-12" ng-model="ecc.collectionDetails.establishment" required>
          <span class="help-block" ng-show="ecc.frmCreate.establishment.$invalid && ecc.frmCreate.withError">Establishment is required field.</span>
        </div>
      </div>

      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.amount.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amount <span class="required">*</span>
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="number" min="1" name="amount"  class="form-control col-md-7 col-xs-12" ng-model="ecc.collectionDetails.amount" required>
          <span class="help-block" ng-show="ecc.frmCreate.amount.$invalid && ecc.frmCreate.withError">Amount is required field.</span>
        </div>
      </div>

    </div>
  </div>
  <hr>

  <div class="row">

    <div class="col-md-6">
      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.category.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span>
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <ui-select class="col-md-10" name="category" ng-model="ecc.collectionDetails.category_code" theme="bootstrap" ng-init="ecc.getCategoryTypeList(ecc.collectionDetails,'INIT')" ng-change="ecc.getCategoryTypeList(ecc.collectionDetails,'CHANGE')" required>
            <ui-select-match placeholder="Select from category list..."><% $select.selected.description%></ui-select-match>
            <ui-select-choices repeat="category.code as category in ecc.categoryList | filter: $select.search">
              <div ng-bind-html="category.description | highlight: $select.search"></div>
            </ui-select-choices>
          </ui-select>
          <button class="btn btn-success" ng-click="ecc.addCategory(ec.collectionDetails)"><i class="glyphicon glyphicon-plus"></i></button>
          <span class="help-block" ng-show="ecc.frmCreate.category.$invalid && ecc.frmCreate.withError">Category is required field.</span>
        </div>
      </div>

      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.categorytype.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category type<span class="required">*</span>
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <ui-select class="col-md-10" name="categorytype" ng-model="ecc.collectionDetails.category_type_code" theme="bootstrap" required>
            <ui-select-match placeholder="Select from type list..."><% $select.selected.description%></ui-select-match>
            <ui-select-choices repeat="categorytype.code as categorytype in ecc.categoryTypeList | filter: $select.search">
              <div ng-bind-html="categorytype.description | highlight: $select.search"></div>
            </ui-select-choices>
          </ui-select>
          <button class="btn btn-success" ng-click="ecc.addCategoryType(ecc.collectionDetails)" ng-disabled="!ecc.collectionDetails.category_code"><i class="glyphicon glyphicon-plus"></i></button>
          <span class="help-block" ng-show="ecc.frmCreate.categorytype.$invalid && ecc.frmCreate.withError">Type is required field.</span>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group" ng-class="{'has-error': ecc.frmCreate.remarks.$invalid && ecc.frmCreate.withError }">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <textarea name="remarks" class="form-control col-md-7 col-xs-12" rows="5" ng-model="ecc.collectionDetails.remarks">
          </textarea> 
        </div>
      </div>
    </div>
  </div>

  <div class="ln_solid"></div>
  <div class="form-group">
    <div class="pull-right">
      <button type="submit" class="btn btn-success" ng-if="ecc.collectionDetails.action == 'CREATE'" ng-click="ecc.submit(ecc.collectionDetails)">Submit</button>
      <button type="submit" class="btn btn-success" ng-if="ecc.collectionDetails.action == 'UPDATE'" ng-click="ecc.update(ecc.collectionDetails)">Update</button>
      <button type="button" class="btn btn-default" ng-click="ecc.cancel()">Cancel</button>
    </div>
  </div>
</form>
@include('layouts.errors')
