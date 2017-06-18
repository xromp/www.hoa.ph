var myApp = angular.module('SidebarApp',['ngRoute']);

(function(app){
  "use strict";
  app.controller("SidebarCtrl",SidebarCtrl);

  SidebarCtrl.$inject = ['$window']
  function SidebarCtrl($window){
  	var vm = this;

  	vm.routeTo = function(i){
  		$window.location.href = i;
  		console.log(i);
  	};
  }

})(myApp);