
define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('ReportCtrl',ReportCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.factory('ReportSrvcs', ReportSrvcs)

      ReportCtrl.$inject = ['$scope', '$filter', '$window', '$location', 'ReportSrvcs','$uibModal','blockUI', '$http']
      function ReportCtrl($scope, $filter, $window, $location, ReportSrvcs, $uibModal, blockUI, $http){
        var vm = this;
        vm.curDate = new Date();

        vm.init = function()
        {
          vm.query = {
            'startdate':new Date(vm.curDate.getFullYear(),vm.curDate.getMonth()),
            'enddate':new Date(vm.curDate.getFullYear(),vm.curDate.getMonth()+1,0),
            'reporturl':'/collection/reports/orlisting'
          };
        };

        vm.reportList = [
          {'id':1,'description':'OR Listing','url':'/collection/reports/orlisting'},
          {'id':2,'description':'Summary Collection & Expense','url':'/transaction/reports/comparative'}
        ];

        vm.generateReport = function(data) {
          var dataCopy = angular.copy(data);

          dataCopy.startdate = $filter('date')(dataCopy.startdate,'yyyy-MM-dd');
          dataCopy.enddate = $filter('date')(dataCopy.enddate,'yyyy-MM-dd');

          // console.log();
          var windowOrlisting = $window.open(window.location.origin+dataCopy.reporturl+'?startdate='+dataCopy.startdate+'&enddate='+dataCopy.enddate+'', '_blank');
          windowOrlisting.print();
        };

        vm.datepickerOpen = function(i,x) {
          if (x == 'STARTDATE') {
            i.startdateOpen = true;
          } else if (x == 'ENDDATE') {
            i.enddateOpen = true;
          }
        };

        vm.init();
      }

      ModalInfoInstanceCtrl.$inject = ['$uibModalInstance', 'formData']
      function ModalInfoInstanceCtrl ($uibModalInstance, formData) {
        var vm = this;
        vm.formData = formData;
        vm.ok = function() {
          $uibModalInstance.close();
        };

        vm.cancel = function() {
          $uibModalInstance.dismiss('cancel');
        };
      }

      ReportSrvcs.$inject = ['$http']
      function ReportSrvcs($http){
        return {
          save: function(data) {
            return $http({
              method:'POST',
              url: '/api/collection/create',
              data:data,
              headers: {'Content-Type': 'application/json'}
            })
          },
          get: function(data) {
            return $http({
              method:'GET',
              data:data,
              url: baseUrlApi + '/api/person?person00id='+ data.person00id,
              headers: {'Content-Type': 'application/json'}
            })
          },
          getperson: function(data) {
            return $http({
              method:'GET',
              url: '/api/person/get?type='+data.type,
              headers: {'Content-Type': 'application/json'}
            })
          },
          getcategory: function(data) {
            return $http({
              method:'GET',
              url: '/api/collection/category/get',
              headers: {'Content-Type': 'application/json'}
            })
          },
        }
      }
});