<div class="page-title">
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Reports
        </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form name="frmReport">
          <div class="row">
            <div class="col-md-5 form-group">
              <select class="form-control col-md-7 col-xs-12" ng-model="rc.query.code" ng-init="selectedQuery()" required>
                <option ng-repeat="type in rc.reportList" ng-bind="type.description" ng-value="type.code"></option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h1 class="panel-title">Query Parameter</h1>
                </div>
                <div class="panel-content">
                  <br>
                    <div class="row">
                      <div class="col-md-12" ng-show="rc.query.code == 'ORLISTING' || rc.query.code =='SUMMARYCOLLECTION' || rc.query.code =='ORCHECKLIST'">
                          <label class="col-md-1 control-label">
                            OR Date
                          </label>
                          <div class="col-md-3 form-group">
                            <p class="input-group">
                              <input type="text" class="form-control" name="startdate" uib-datepicker-popup="MM/dd/yyyy" ng-model="rc.query.startdate" is-open="rc.startdateOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" placeholder="MM/dd/yyyy" readonly required/>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-default" ng-click="rc.datepickerOpen(rc,'STARTDATE')"><i class="glyphicon glyphicon-calendar"></i></button>
                              </span>
                            </p>
                          </div>
                          <div class="col-md-3 form-group">
                            <p class="input-group">
                              <input type="text" class="form-control" name="enddate" uib-datepicker-popup="MM/dd/yyyy" ng-model="rc.query.enddate" is-open="rc.enddateOpen" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats" placeholder="mm/dd/yyyy" readonly required/>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-default" ng-click="rc.datepickerOpen(rc,'ENDDATE')"><i class="glyphicon glyphicon-calendar"></i></button>
                              </span>
                            </p>

                          </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="pull-right">
                          <button class="btn btn-info" ng-click="rc.generateReport(rc.query)" ng-if="rc.query.code != 'ORCHECKLIST'">Generate Report</button>
                          <button class="btn btn-info" ng-click="rc.generateXLS(rc.query)" ng-if="rc.query.code == 'ORCHECKLIST'">Generate XLS</button>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>