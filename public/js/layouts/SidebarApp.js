var myApp = angular.module('SidebarApp',['ngRoute','ui.bootstrap']);

(function(app){
  "use strict";
  app.controller("SidebarCtrl",SidebarCtrl);
  app.controller('MonthEndPostingCrtl',MonthEndPostingCrtl);
  app.factory('SidebarSrvcs', SidebarSrvcs);

  SidebarCtrl.$inject = ['$window','$uibModal']
  function SidebarCtrl($window, $uibModal){
  	var vm = this;

  	vm.routeTo = function(i){
  		$window.location.href = i;
  		console.log(i);
  	};

    vm.monthEndPost = function(){
      var modalInstance = $uibModal.open({
        controller:'MonthEndPostingCrtl',
        templateUrl:'layouts.month-end-posting',
        controllerAs: 'vm',
        resolve :{
          formData: function () {
            return {
              title: 'Month End Posting'
            };
          }
        }
      });
      modalInstance.result.then(function (){
      },function (){});
    };
  }

  MonthEndPostingCrtl.$inject = ['$compile','$uibModalInstance', '$filter','formData', 'SidebarSrvcs']
  function MonthEndPostingCrtl ($compile, $uibModalInstance, $filter, formData, SidebarSrvcs) {
    var vm = this;
    vm.formData = formData;

    vm.zeroPad = function(num, places) {
      var zero = places - num.toString().length + 1;
      return Array(+(zero > 0 && zero)).join("0") + num;
    };
    
    vm.formData.query = {
      month:vm.zeroPad((new Date()).getMonth(),2),
      year:(new Date()).getFullYear(),
      now: $filter('date')(new Date(),'yyyy-MM-dd')
    };

    vm.init = function(){
      vm.get(vm.formData.query);
    };

    vm.monthname = function(i){
      var months = [ "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December" ];

      return months[parseInt(i-1)];
    };

    vm.post =function(i) {
      var formDataCopy = angular.copy(i);
      formDataCopy.month = vm.zeroPad(formDataCopy.month,2);

      var data = angular.toJson(formDataCopy);
      SidebarSrvcs.post(data)
      .then(function(response, status){
        vm.response = response.data;
        console.log(vm.response);
      }, function(){alert('Error occured.');})
    };

    vm.get = function(i){
      var formDataCopy = {
        month:i.month,
        year:i.year
      };
      var data= angular.toJson(formDataCopy);
      SidebarSrvcs.get(data)
      .then(function(response, status){
        if (response.data.status == 200) {
          vm.formData.total = response.data.data;
        }
      }, function(){alert('Error occured.');});
    };

    vm.cancel =function(i) {
      $uibModalInstance.dismiss('cancel');
    };



    vm.init();
  }

  SidebarSrvcs.$inject = ['$http']
  function SidebarSrvcs($http){
    return {
      get: function(data) {
        return $http({
          method:'POST',
          url: '/api/transaction/reports/get/monthend_posting',
          data:data,
          headers: {'Content-Type': 'application/json'}
        })
      },
      post: function(data) {
        return $http({
          method:'POST',
          url: '/api/transaction/reports/monthend_posting',
          data:data,
          headers: {'Content-Type': 'application/json'}
        })
      }
    }
  }

})(myApp);