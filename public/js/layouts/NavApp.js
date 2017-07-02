var myNav = angular.module('NavApp',['ngRoute']);

(function(app){
  "use strict";
  app.controller("NavCtrl",NavCtrl);
  app.factory('NavSrvcs', NavSrvcs);

  NavCtrl.$inject = ['$window','$uibModal','NavSrvcs']
  function NavCtrl($window, $uibModal,NavSrvcs){
    var vm = this;

    vm.logout = function(i){
      NavSrvcs.logout(i)
      .then(function(response, status){
        $window.location.href = '/login';
      });
    };
  }

  NavSrvcs.$inject = ['$http']
  function NavSrvcs($http){
    return {
      logout: function(data) {
        return $http({
          method:'POST',
          url: '/api/user/logout',
          data:data,
          headers: {'Content-Type': 'application/json'}
        })
      }
    }
  }

})(myNav);