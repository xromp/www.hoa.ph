<div class="col-md-3 left_col" ng-app="SidebarApp">
  <div class="left_col scroll-view" ng-controller="SidebarCtrl as sc" >
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.html" class="site_title"><i class="fa fa-home"></i> <span>GREVHAI</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
      <div class="profile_pic">
        <img src="/assets/images/img.jpg" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2>John Doe</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-edit"></i> General <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="/person/finder" ng-click="sc.routeTo('/person/finder')">Members</a></li>
              <li><a href="/collection/view" ng-click="sc.routeTo('/collection/view')">Collection Entry</a></li>
              <li><a href="/expense/view" ng-click="sc.routeTo('/expense/view')">Expense Entry</a></li>
              <li><a ng-click="sc.monthEndPost()">Monthly End Posting</a></li>
              <li><a href="/collection/reports" ng-click="sc.routeTo('/collection/reports')">Reports</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>
<script type="text/ng-template" id="layouts.month-end-posting">
  @include('layouts.month-end-posting')
</script>