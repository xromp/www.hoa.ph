<td colspan=3 ng-show="person.isshowdetails">
  	<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
		<div class="well profile_view">
		  	<div class="col-sm-12">
				<!-- <h4 class="brief"><i ng-bind="\'sample\'"></i></h4> -->
				<div class="left col-xs-12">
				  	<h2 ng-bind="personDetails.contactno_mobile"></h2>
		  			<ul class="list-unstyled">
		  				<li><i class="fa fa-building"></i> Landline: <small ng-bind="personDetails.contact_telephoneno"></small></li>
						<li><i class="fa fa-building"></i> Year moved: <small ng-bind="personDetails.year_moved"></small></li>
						<li><i class="fa fa-building"></i> Address: <small ng-bind="personDetails.address"></small></li>
						<li><i class="fa fa-user"></i> Representative: <small ng-bind="personDetails.representative + '('+ personDetails.representative_relationship+')'"></small></li>
				  	</ul>
				</div>
				<div class="right col-xs-5 text-center">
					<img src="/assets/images/img.jpg" alt="" class="img-circle img-responsive">
				</div>
		  	</div>
		  <div class="col-xs-12 bottom text-center">
			<div class="col-xs-12 col-sm-6 emphasis">
			  <p class="ratings">
				<a>4.0</a>
				<a href="#"><span class="fa fa-star"></span></a>
				<a href="#"><span class="fa fa-star"></span></a>
				<a href="#"><span class="fa fa-star"></span></a>
				<a href="#"><span class="fa fa-star"></span></a>
				<a href="#"><span class="fa fa-star-o"></span></a>
			  </p>
			</div>
			<div class="col-xs-12 col-sm-6 emphasis">
			  <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
				</i> <i class="fa fa-comments-o"></i> </button>
			  <button type="button" class="btn btn-primary btn-xs">
				<i class="fa fa-user"> </i> View Profile
			  </button>
			</div>
		  </div>
		</div>
  	</div>
  	<div class="col-md-8">
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
					  	<th>Category(Descriptions)</th>
					  	<th>Paid Amount</th>
					</tr>
			  	</thead>
			  <tbody ng-switch="collection['collection'].length">
				<tr ng-switch-when="0"><td colspan="6">No record(s) found.</td></tr>
				<tr ng-switch-when-default ng-repeat="Unpaid in collection['collection']">
				  	<th scope="row" ng-bind="$index +1"></th>
				  	<td class="text-right" ng-bind="Unpaid.orno"></td>
				  	<td ng-bind="Unpaid.ordate"></td>
				  	<td ng-bind="Unpaid.description"></td>
				  	<td class="text-right" ng-bind="Unpaid.amount"></td>
				</tr>
			  </tbody>
			</table>
		  </div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h5 class="panel-title">Monthly Dues<small>for the whole year</small></h5>
					<div class="clearfix"></div>
				</div>
				<div class="panel-content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Month</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>JAN-2017</td>
								<td>PAID</td>
							</tr>

							<tr>
								<td>2</td>
								<td>FEB-2017</td>
								<td>PAID</td>
							</tr>

							<tr>
								<td>3</td>
								<td>MAR-2017</td>
								<td>-</td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h5 class="panel-title">Registered Car<small></small></h5>
					<div class="clearfix"></div>
				</div>
				<div class="panel-content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Sticker ID</th>
								<th>Plate No.</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>S-001</td>
								<td>WED-000</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
  	</div>
</td>