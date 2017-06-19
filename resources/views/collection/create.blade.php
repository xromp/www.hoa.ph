<div class="page-title">
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Collection Entry 
        </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      
        <form name="cc.frmCreate" class="form-horizontal form-label-left" ng-controller="CollectionCreateCtrl as cc" novalidate>
          <div class="row">
          </div>
          <div class="row">

            <div class="col-md-6">
              <div class="form-group" ng-class="{'has-error': cc.frmCreate.type.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Type <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control col-md-7 col-xs-12" ng-model="cc.collectionDetails.type" ng-init="cc.getRefList(cc.collectionDetails)" ng-change="cc.getRefList(cc.collectionDetails)" required>
                    <option ng-repeat="type in cc.typeList" ng-bind="type.description" ng-value="type.code"></option>
                  </select>
                  <!-- <input type="text" name="type"  class="form-control col-md-7 col-xs-12" ng-model="cc.collectionDetails.type" required> -->
                  <span class="help-block" ng-show="cc.frmCreate.type.$invalid && cc.frmCreate.withError">type is required field.</span>
                </div>
              </div>

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.orno.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">OR No.</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="number" name="orno" min='1' class="form-control col-md-7 col-xs-12" ng-model="cc.collectionDetails.orno" ng-disabled="cc.collectionDetails.action == 'EDIT'" required>
                  <span class="help-block" ng-show="cc.frmCreate.orno.$invalid && cc.frmCreate.withError">OR No. is required field.</span>
                </div>
              </div>

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.ordate.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">OR Date <span class="required">*</span></label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <p class="input-group">
                  <input type="text" class="form-control" name="ordate" uib-datepicker-popup="MM/dd/yyyy" ng-model="cc.collectionDetails.ordate" is-open="cc.dtIsOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" required/>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="cc.datepickerOpen(cc)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>
                </p>
                <span class="help-block" ng-show="cc.frmCreate.ordate.$invalid && cc.frmCreate.withError">OR Date is required field.</span>
                </div>
              </div>

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.amount.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Amount<span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="number" min="1" name="amount"  class="form-control col-md-7 col-xs-12" ng-model="cc.collectionDetails.amount" required>
                  <span class="help-block" ng-show="cc.frmCreate.amount.$invalid && cc.frmCreate.withError">Amount is required field.</span>
                </div>
              </div>

            </div>
          </div>
          <hr>

          <div class="row">

            <div class="col-md-6">

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.personid.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">From
                  <span class="required">*</span>
                  <small>(Members/Outside)</small>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <%cc.collectionDetails.personid%>
                  <ui-select name="personid" ng-model="cc.collectionDetails.personid" theme="bootstrap" required>
                    <ui-select-match placeholder="Select from <% cc.collectionDetails.type %>..."><%cc.collectionDetails.personid.name%></ui-select-match>
                    <ui-select-choices repeat="item in cc.personList | filter: $select.search">
                      <div ng-bind-html="item.name | highlight: $select.search"></div>
                      <small ng-bind-html="item.address | highlight: $select.search"></small>
                    </ui-select-choices>
                  </ui-select>
                  <span class="help-block" ng-show="cc.frmCreate.personid.$invalid && cc.frmCreate.withError">From is required field.</span>
                </div>
              </div>

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.category.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <p class="input-group">
                    <select class="form-control" name="category" ng-model="cc.collectionDetails.category_code" ng-init="cc.getCategoryTypeList(cc.collectionDetails)" ng-change="cc.getCategoryTypeList(cc.collectionDetails)" required>
                      <option ng-repeat="category in cc.categoryList" ng-bind="category.description" ng-value="category.code"></option>
                    </select>
                    <span class="input-group-btn">
                      <button class="btn btn-success" ng-click="cc.addCategory(cc.collectionDetails)"><i class="glyphicon glyphicon-plus"></i></button>
                    </span>
                  </p>
                  <!-- <input type="text" name="type"  
                  class="form-control col-md-7 col-xs-12" ng-model="cc.collectionDetails.category" required> -->
                  <span class="help-block" ng-show="cc.frmCreate.category.$invalid && cc.frmCreate.withError">Categorys is required field.</span>
                </div>
              </div>

              <div class="col-md-9 col-md-offset-3">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h1 class="panel-title">Collection Category Details</h1>
                  </div>
                  <div class="panel-content">
                    <br>
                    <!-- MONTH DUES-->
                    <div  ng-if="cc.collectionDetails.category_code == 'MONTHLYDUES'">
                      <div class="form-group">
                        <div class="pull-right">
                          <button class="btn btn-danger" ng-click="cc.modifyYear('LESS')"><i class="glyphicon glyphicon-plus"></i> Prev Year</button>
                          <button class="btn btn-success" ng-click="cc.modifyYear('ADD')"><i class="glyphicon glyphicon-plus"></i>Next Year</button>
                        </div>
                      </div>

                      <div class="form-group" ng-class="{'has-error': cc.frmCreate.entityvalues.$invalid && cc.frmCreate.withError }">
                        <div class="col-md-4 col-sm-9 col-xs-12" ng-class="{'col-md-offset-3':cc.categoryTypeList[0].year.length < 2}" ng-repeat="yr in cc.categoryTypeList[0].year | orderBy:year">
                          <div class="row form-group" style="margin-bottom: 0px;" ng-repeat="month in cc.categoryTypeList[0].month | filter:{'year':yr}">
                            <label>
                              <input type="checkbox" name="" ng-model="cc.monthSelected[month.name]">
                              <%month.description%>
                            </label>
                            <br>
                          </div>
                          <hr>
                        </div>
                      </div>
                    </div>
                    <!-- END MONTHLY DUES -->

                    <!--CAR Sticker  -->
                    <div ng-if="cc.collectionDetails.category_code == 'CARSTICKER'">
                      <div class="form-group">
                        <div class="form-group" ng-repeat="sticker in cc.stickerDetails">
                          <div class="col-md-4 col-md-offset-3">
                            <input type="text" name="stickerid" class="form-control" ng-model="sticker.stickerid" placeholder="Sticker ID">
                          </div>
                          <div class="col-md-4">
                            <input type="text" name="stickerid" class="form-control" ng-model="sticker.plateno" placeholder="Plate No.">
                          </div>
                          <div class="pull-right" ng-if="!$first">
                            <button class="btn btn-danger btn-xs" ng-click="cc.removeCarSticker($index)">X</button>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="pull-right">
                          <button class="btn btn-success" ng-click="cc.addCarSticker()"><i class="glyphicon glyphicon-plus"></i>Add Car Sticker</button>
                        </div>
                      </div>
                    </div>
                    <!-- END CAR Sticker -->
                    <div>
                      
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-md-6">

              <div class="form-group" ng-class="{'has-error': cc.frmCreate.remarks.$invalid && cc.frmCreate.withError }">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <textarea name="remarks" class="form-control col-md-7 col-xs-12" rows="5" ng-model="cc.collectionDetails.remarks">
                  </textarea> 
                </div>
              </div>

            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="pull-right">
              <button type="submit" class="btn btn-success" ng-click="cc.submit(cc.collectionDetails)">Submit</button>
              <button type="button" class="btn btn-default" ng-click="cc.cancel()">Cancel</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>


@include('layouts.errors')
