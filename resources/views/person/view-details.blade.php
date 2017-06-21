<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">

        <div class="row" style="margin-bottom:25px;">
          <div class="clearfix"></div>
          <div class="col-md-5 col-sm-4 col-xs-6">
            <div class="">
              <div class="col-sm-12">
                <div class="right col-xs-4 text-center">
                  <img src="/assets/images/user.png" alt="" class="img-circle img-responsive">
                </div>
                <div class="left col-xs-7">
                  <h4 ng-bind="pv.personInfo.lname +', '+ pv.personInfo.fname + ' ' + pv.personInfo.mname"></h4>
                  <p><strong> </strong> </p>
                  <ul class="list-unstyled">
                    <li><i class="fa fa-gift"></i> Birthday: <% pv.personInfo.birthday | date:'dd-MMM-yyyy' %> </li>
                    <li><i class="fa fa-phone"></i> Phone #: <% pv.personInfo.contact_mobileno %></li>
                    <li><i class="fa fa-envelope"></i> Email: <% pv.personInfo.email %></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-4 col-xs-6" ng-if="pv.personInfo.status=='MARRIED'">
            <div class="">
              <div class="col-sm-12">
                <div class="right col-xs-4 text-center">
                  <img src="/assets/images/user.png" alt="" class="img-circle img-responsive">
                </div>
                <div class="left col-xs-7">
                  <h4 ng-bind="pv.personInfo.wife_lname +', '+ pv.personInfo.wife_fname + ' ' + pv.personInfo.wife_mname"></h4>
                  <p><strong> </strong> </p>
                  <ul class="list-unstyled">
                    <li><i class="fa fa-gift"></i> Birthday: <% pv.personInfo.wife_birthday | date:'dd-MMM-yyyy' %> </li>
                    <li><i class="fa fa-phone"></i> Phone #: <% pv.personInfo.wife_contact_mobileno %></li>
                    <li><i class="fa fa-envelope"></i> Email: <% pv.personInfo.wife_email %></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <ul class="list-unstyled">
              <li><i class="fa fa-building"></i> Address: <% pv.personInfo.address %></li>
              <li><i class="glyphicon glyphicon-phone-alt"></i> Landline: <% pv.personInfo.contact_telephoneno %></li>
              <li><i class="glyphicon glyphicon-lock"></i> Year moved to GreenRidge: <% pv.personInfo.year_moved %></li>
            </ul>
          </div>
          <div class="col-md-6">
            Authorized Representative
            <ul class="list-unstyled">
              <li><i class="glyphicon glyphicon-user"></i> Name: <% pv.personInfo.representative +'('+ pv.personInfo.representative_relationship +')' %></li>
              <li><i class="fa fa-phone"></i> Phone: <% pv.personInfo.representative_contactno %></li>
            </ul>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="panel panel-info">
            <div class="panel-heading">
            <h5 class="panel-title">Contributions<small> Within current posted month</small></h5>
            <div class="clearfix"></div>
            </div>
            <div class="panel-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>OR No.</th>
                    <th>OR Date</th>
                    <th>Category</th>
                    <th>Paid Amount</th>
                </tr>
                </thead>
              <tbody ng-switch="collection['collection'].length">
              <tr ng-switch-when="0"><td colspan="6">No record(s) found.</td></tr>
              <tr ng-switch-when-default ng-repeat="Unpaid in collection['collection']">
                  <th scope="row" ng-bind="$index +1"></th>
                  <td class="text-center" ng-bind="pv.zeroPad(Unpaid.orno,6)"></td>
                  <td ng-bind="Unpaid.ordate"></td>
                  <td ng-bind="Unpaid.description"></td>
                  <td class="text-right" ng-bind="Unpaid.amount"></td>
              </tr>
              </tbody>
            </table>
            </div>
          </div>
        </div>
        <div>
        </div>
      </div>
    </div>
  </div>
</div>