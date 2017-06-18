
<form name="s.frmSigin" ng-submit="s.submit(s.signin)" novalidate>
<div class="login__check"></div>
<div class="login__form">
  <!-- <h1 ng-show="s.display.loaded" ng-bind="s.loginCallBack.message"></h1> -->
  <div ng-show="s.display.loaded">
    <div style="font-size:12px;" ng-class="{'alert alert-success':s.loginCallBack.status==200,'alert alert-danger':s.loginCallBack.status!=200}">
      <span ng-class="{'glyphicon glyphicon-exclamation-sign':s.loginCallBack.status!=200}" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      <span ng-bind="s.loginCallBack.message"></span>
    </div>
  </div>
  <div class="login__row">
    <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
      <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
    </svg>
    <input type="text" class="login__input name" name="username" ng-model="s.signin.username" placeholder="Username" required/>
  </div>
  <div class="login__row">
    <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
      <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
    </svg>
    <input type="password" class="login__input pass" name="password" ng-model="s.signin.password" placeholder="Password" required/>
  </div>
  <!-- <button type="submit" class="login__submit">Sign in</button> -->
  <button type="submit" class="login__submit" ng-class="{'processing':s.display.loading,'ripple':s.loginCallBack.status ==200}">Sign in</button>
  <span ng-bind="s.display.loading"></span>
  <p class="login__signup">Don't have an account? &nbsp;<a>Sign up</a></p>
</div>
</form>