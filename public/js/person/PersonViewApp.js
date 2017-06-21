define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('PersonViewCtrl',PersonViewCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.factory('PersonViewSrvcs', PersonViewSrvcs)

      PersonViewCtrl.$inject = ['$scope', '$filter', '$window', '$routeParams', 'PersonViewSrvcs','$uibModal','blockUI', '$http']
      function PersonViewCtrl($scope, $filter, $window, $routeParams, PersonViewSrvcs, $uibModal, blockUI, $http){
        var vm = this;

        if ($routeParams.personid) {
          vm.personInfo = {}
          vm.personInfo.personid = $routeParams.personid;
        }

        vm.init = function (){
          vm.getByPerson(vm.personInfo);
          vm.getcollection(vm.personInfo);
        }
        vm.getByPerson = function (data) {
          var dataCopy = angular.copy(data)

          PersonViewSrvcs.get(data)
          .then (function (response) {
            if (response.data.status == 200) {
              vm.personInfo = response.data.data[0];
              vm.personInfo.birthday = new Date(vm.personInfo.birthday);
              vm.personInfo.wife_birthday = new Date(vm.personInfo.wife_birthday);
              vm.personInfo.action = dataCopy.action;
            }
          },function(){ alert("Bad Request!")})
        };

        vm.reset = function () {
          vm.default();
        };

        vm.cancel = function () {
          $window.location.href = '/person/finder';
        };
        vm.datepickerOpen = function(i,y) {
          if (y == 1) {
            i.dtIsOpen1 = true;
          } else if (y == 2) {
            i.dtIsOpen2 = true;
          };;
        };

        vm.getcollection = function(i) {
          var dataCopy = angular.copy(i);

          PersonViewSrvcs.getcollection(dataCopy)
          .then(function(response, status){
            $scope.collection = response.data.data;
          },function(){alert('Error alert!');});
        };

        vm.zeroPad = function(num, places) {
          var zero = places - num.toString().length + 1;
          return Array(+(zero > 0 && zero)).join("0") + num;
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

      PersonViewSrvcs.$inject = ['$http']
      function PersonViewSrvcs($http){
        return {
          save: function(data) {
            return $http({
              method:'POST',
              url: '/api/person/create',
              data:data,
              headers: {'Content-Type': 'application/json','Authorization': 'admin'+':'+'admin'}
            })
          },
          get: function(data) {
            return $http({
              method:'GET',
              data:data,
              url: '/api/person/get?personid='+ data.personid,
              headers: {'Content-Type': 'application/json'}
            })
          },
          getcollection:function(data){
            return $http({
              method:'GET',
              url:'api/person/collection/get?personid='+data.personid,
              data:data,
              headers:{'Content-Type':'application/json'}
            });
          },
        }
      }
});