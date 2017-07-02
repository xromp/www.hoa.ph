<!-- top navigation -->
<div class="top_nav" ng-app="NavApp">
  <div class="nav_menu" ng-controller="NavCtrl as n">
    <nav class="" role="navigation">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" ng-click="n.logout()" class="user-profile dropdown-toggle" aria-expanded="false">
            Log Out <i class="glyphicon glyphicon-log-out"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
