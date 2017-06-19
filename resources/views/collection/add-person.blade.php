
<div class="modal-header">
  <h5 class="modal-title" id="modal-title" ng-bind="vm.formData.title"></h5>
</div>
<div class="modal-body" id="modal-body">
	<form name="vm.frmCreate" novalidate>
		<div class="row">
			<div class="col-md-8 col-md-offset-1">

			  	<div class="form-group" ng-class="{'has-error': vm.frmCreate.lname.$invalid && vm.frmCreate.withError }">
			        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lastname</label>
			        <div class="col-md-9 col-sm-9 col-xs-12 form-group">
			          <input type="text" name="lname" class="form-control col-md-7 col-xs-12" ng-model="vm.categoryDetails.lname" required>
			          <span class="help-block" ng-show="vm.frmCreate.lname.$invalid && vm.frmCreate.withError">Lastname is required field.</span>
			        </div>
			  	</div>

			  	<div class="form-group" ng-class="{'has-error': vm.frmCreate.fname.$invalid && vm.frmCreate.withError }">
			        <label class="control-label col-md-3 col-sm-3 col-xs-12">Firstname</label>
			        <div class="col-md-9 col-sm-9 col-xs-12 form-group">
			          <input type="text" name="fname" class="form-control col-md-7 col-xs-12" ng-model="vm.categoryDetails.fname" required>
			          <span class="help-block" ng-show="vm.frmCreate.fname.$invalid && vm.frmCreate.withError">Firstname is required field.</span>
			        </div>
			  	</div>

			  	<div class="form-group" ng-class="{'has-error': vm.frmCreate.mname.$invalid && vm.frmCreate.withError }">
			        <label class="control-label col-md-3 col-sm-3 col-xs-12">Middlename/ Initials</label>
			        <div class="col-md-9 col-sm-9 col-xs-12 form-group">
			          <input type="text" name="mname" class="form-control col-md-7 col-xs-12" ng-model="vm.categoryDetails.mname">
			          <span class="help-block" ng-show="vm.frmCreate.mname.$invalid && vm.frmCreate.withError">Firstname is required field.</span>
			        </div>
			  	</div>

			</div>
			<div class="col-md-8 col-md-offset-1" ng-show="vm.response.length">
				<div class="text-center" ng-class="{'alert alert-success':vm.response[0].status == 200,'alert alert-danger':vm.response[0].status != 200}" ng-bind=vm.response[0].message>
				</div>
			</div>
		</div>
	</form>

  <!-- <div ng-bind="vm.formData.message"></div> -->
	<!-- <div class="modal-footer"> -->
	<br>
		<div class="pull-right">
		  <button class="btn btn-default" type="button" ng-click="vm.cancel()">Cancel</button>
		  <button class="btn btn-success" type="button" ng-click="vm.submit(vm.categoryDetails)">Submit</button>
		</div>
	<!-- </div> -->
  <br>
  <br>
</div>

