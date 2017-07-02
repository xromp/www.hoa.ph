<div class="page-title">
  <div class="title_left">
    <h3>People</h3>
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
        <h2><%p.personInfo.action%> Person 
          <small>This <strong>People <% p.personInfo.action %></strong> feature is for HOMEOWNER only.</small>
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
        <br />
        <form name="p.frmCreate" class="form-horizontal form-label-left" novalidate>
          <h4>Personal Information</h4>
          <div class="row">
            <label class="col-md-1">
              <input type="radio" name="status" ng-model="p.personInfo.status" style="zoom:1.2;" value="SINGLE">
              Single
            </label>
            <label class="col-md-1">
              <input type="radio" name="status" ng-model="p.personInfo.status" style="zoom:1.2;" value="MARRIED">
              Married
            </label>
          </div>
          <hr>
          <h5 ng-if="p.personInfo.status == 'MARRIED'"><strong>(Husband)</strong></h5>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.lname.$invalid && p.frmCreate.withError }">
                <label class="control-label">Last Name <span class="required">*</span>
                </label>
                <input type="text" name="lname" class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.lname" required>
                  <span class="help-block" ng-show="p.frmCreate.lname.$invalid && p.frmCreate.withError">Last name is required field.</span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.fname.$invalid && p.frmCreate.withError }">
                <label class="control-label">First Name <span class="required">*</span>
                </label>
                <input type="text" name="fname"  class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.fname" required>
                <span class="help-block" ng-show="p.frmCreate.fname.$invalid && p.frmCreate.withError">First name is required field.</span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Middle Name / Initial</label>
                <input type="text" name="mname" class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.mname">
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-md-4">
              <label class="control-label">Birthday</label>
              <p class="input-group">
                <input type="text" class="form-control" name="birthday" uib-datepicker-popup="MM/dd/yyyy" ng-model="p.personInfo.birthday" is-open="p.dtIsOpen1" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats"/>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" ng-click="p.datepickerOpen(p,1)"><i class="glyphicon glyphicon-calendar"></i></button>
                </span>
              </p>
            </div>

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.contact_mobileno.$invalid && p.frmCreate.withError }">
                <label class="control-label">Mobile No.</label>
                <input type="text" name="mobileno" class="form-control" ng-model="p.personInfo.contact_mobileno" placeholder="+639000000000">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.email.$invalid && p.frmCreate.withError }">
                <label class="control-label">Email</label>
                <input type="email" name="email" class="form-control" ng-model="p.personInfo.email" placeholder="sample@sample.com">
                <span class="help-block" ng-show="p.frmCreate.$error.email && p.frmCreate.withError">Not valid email.</span>
              </div>
            </div>
          </div>
          <div ng-if="p.personInfo.status == 'MARRIED'">
            <hr>
            <h5><strong>(Wife)</strong></h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group" ng-class="{'has-error': p.frmCreate.wife_lname.$invalid && p.frmCreate.withError }">
                  <label class="control-label">Last Name <span class="required">*</span>
                  </label>
                  <input type="text" name="wife_lname" class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.wife_lname" required>
                    <span class="help-block" ng-show="p.frmCreate.wife_lname.$invalid && p.frmCreate.withError">Last name is required field.</span>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group" ng-class="{'has-error': p.frmCreate.wife_fname.$invalid && p.frmCreate.withError }">
                  <label class="control-label">First Name <span class="required">*</span>
                  </label>
                  <input type="text" name="wife_fname"  class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.wife_fname" required>
                  <span class="help-block" ng-show="p.frmCreate.wife_fname.$invalid && p.frmCreate.withError">First name is required field.</span>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Middle Name / Initial</label>
                  <input type="text" name="wife_mname" class="form-control col-md-7 col-xs-12" ng-model="p.personInfo.wife_mname">
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <label class="control-label">Birthday</label>
                <p class="input-group">
                  <input type="text" class="form-control" name="wife_birthday" uib-datepicker-popup="MM/dd/yyyy" ng-model="p.personInfo.wife_birthday" is-open="p.dtIsOpen2" datepicker-options="dateOptions" close-text="Close" alt-input-formats="altInputFormats"/>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="p.datepickerOpen(p,2)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>
                </p>
              </div>

              <div class="col-md-4">
                <div class="form-group" ng-class="{'has-error': p.frmCreate.wife_contact_mobileno.$invalid && p.frmCreate.withError }">
                  <label class="control-label">Mobile No.</label>
                  <input type="text" name="mobileno" class="form-control" ng-model="p.personInfo.wife_contact_mobileno" placeholder="+639000000000">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group" ng-class="{'has-error': p.frmCreate.wife_email.$invalid && p.frmCreate.withError }">
                  <label class="control-label">Email</label>
                  <input type="wife_email" name="wife_email" class="form-control" ng-model="p.personInfo.wife_email" placeholder="sample@sample.com">
                  <span class="help-block" ng-show="p.frmCreate.$error.wife_email && p.frmCreate.withError">Not valid email.</span>
                </div>
              </div>
            </div>
          </div>
          <hr>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.address_street.$invalid && p.frmCreate.withError }">
                <label class="control-label">Address <span class="required">*</span></label>
                <input type="text" name="address_street" class="form-control" ng-model="p.personInfo.address_street" placeholder="Street" required>
                <span class="help-block" ng-show="p.frmCreate.address_street.$invalid && p.frmCreate.withError">Address is required field.</span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.address_city.$invalid && p.frmCreate.withError }">
                <label class="control-label">Municipality/City <span class="required">*</span></label>
                <input type="text" name="address_city" class="form-control" ng-model="p.personInfo.address_city" placeholder="Municipality/City" required>
                <span class="help-block" ng-show="p.frmCreate.address_city.$invalid && p.frmCreate.withError">Municipality/City is required field.</span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.address_province.$invalid && p.frmCreate.withError }">
                <label class="control-label">Province <span class="required">*</span></label>
                <input type="text" name="address_province" class="form-control" ng-model="p.personInfo.address_province" placeholder="Municipality/City" required>
                <span class="help-block" ng-show="p.frmCreate.address_province.$invalid && p.frmCreate.withError">Province is required field.</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.contact_telephoneno.$invalid && p.frmCreate.withError }">
                <label class="control-label">Landline No.</label>
                <input type="text" name="telephone" class="form-control" ng-model="p.personInfo.contact_telephoneno" placeholder="000-000">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Year moved to Green Ridge</label>
                  <input type="text" name="year_moved" class="form-control" ng-model="p.personInfo.year_moved">
                </div>
              </div>
            </div>
          </div>


          <hr>

          <h4>Authorized Representative</h4>
          <div class="row">

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.representative.$invalid && p.frmCreate.withError }">
                <label class="control-label">Name</label>
                <input type="text" name="representative" class="form-control" ng-model="p.personInfo.representative" placeholder="Lastname, Firstname">
              </div>  
            </div>

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.representative_relationship.$invalid && p.frmCreate.withError }">
                <label class="control-label">Relationship</label>
                <input type="text" name="representative" class="form-control" ng-model="p.personInfo.representative_relationship" placeholder="e.g Father">
              </div>  
            </div>

            <div class="col-md-4">
              <div class="form-group" ng-class="{'has-error': p.frmCreate.representative_contactno.$invalid && p.frmCreate.withError }">
                <label class="control-label">Contact No.</label>
                <input type="text" name="representative" class="form-control" ng-model="p.personInfo.representative_contactno" placeholder="+639000000000">
              </div>  
            </div>

          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="pull-right">
              <button type="reset" class="btn btn-danger" ng-click="p.cancel()"><i class="fa fa-arrow-left"></i> View Finder</button>
              <button type="reset" class="btn btn-default" ng-click="p.reset()">Reset</button>
              <button type="submit" class="btn btn-success" ng-click="p.submit(p.personInfo)" ng-disabled="p.frmCreate.$invalid && p.frmCreate.withError" ng-bind="(p.personInfo.action=='CREATE')?'Submit':'Update'"></button>
            </div>
          </div>
        </form>
        @include('layouts.errors')
      </div>
    </div>
  </div>
</div>
