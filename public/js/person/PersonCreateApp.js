define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('PersonCreateCtrl',PersonCreateCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.factory('PersonSrvcs', PersonSrvcs)

      PersonCreateCtrl.$inject = ['$scope', '$filter', '$window', '$routeParams', 'PersonSrvcs','$uibModal','blockUI', '$http']
      function PersonCreateCtrl($scope, $filter, $window, $routeParams, PersonSrvcs, $uibModal, blockUI, $http){
        var vm = this;

        vm.default = function(){
          vm.personInfo = {};
          vm.personInfo.action = 'CREATE';
          vm.personInfo.type = 'HOMEOWNER';
          vm.personInfo.status = 'MARRIED';
        }

        vm.default();

        if ($routeParams.personid) {
          vm.editInfo = {};
          vm.personInfo.personid = $routeParams.personid;

          vm.personInfo.action = 'EDIT';
        }

        vm.init = function (i){
          if (i.action == 'CREATE') {

          } else if (i.action == 'EDIT') {
            vm.getByPerson(vm.personInfo);
          }
        }
        vm.submit = function (data) {
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            var dataCopy = angular.copy(data);
            dataCopy.lname = dataCopy.lname.toUpperCase();
            dataCopy.fname = dataCopy.fname.toUpperCase();
            dataCopy.mname = dataCopy.mname ? dataCopy.mname.toUpperCase() :'';
            
            dataCopy.action = vm.personInfo.action;
            dataCopy.birthday = $filter('date')(dataCopy.birthday,'yyyy-MM-dd');

            dataCopy.wife_lname = dataCopy.wife_lname ? dataCopy.wife_lname.toUpperCase() : '';
            dataCopy.wife_fname = dataCopy.wife_fname ? dataCopy.wife_fname.toUpperCase() : '';
            dataCopy.wife_mname = dataCopy.wife_mname ? dataCopy.wife_mname.toUpperCase() : '';
            dataCopy.wife_birthday = dataCopy.wife_birthday ? $filter('date')(dataCopy.wife_birthday,'yyyy-MM-dd') : '';

            var formData = angular.toJson(dataCopy);
            var appBlockUI = blockUI.instances.get('blockUI');
            appBlockUI.start();
            PersonSrvcs.save(formData)
            .then (function (response) {
              if (response.data.status == 200) {
                vm.default();
              } else {

              }
              var modalInstance = $uibModal.open({
                  controller:'ModalInfoInstanceCtrl',
                  templateUrl:'shared.modal.info',
                  controllerAs: 'vm',
                  resolve :{
                    formData: function () {
                      return {
                        title: 'Create People',
                        message: response.data.message
                      };
                    }
                  }
                });

                modalInstance.result.then(function (){
                },function (){
                });
              appBlockUI.stop();
            },function(){alert("Error occured!");
            appBlockUI.stop();
            });
          } else {
            vm.frmCreate.withError = true;
          }
        };

        vm.getByPerson = function (data) {
          var dataCopy = angular.copy(data)

          PersonSrvcs.get(data)
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

        vm.init(vm.personInfo);
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

      PersonSrvcs.$inject = ['$http']
      function PersonSrvcs($http){
        return {
          save: function(data) {
            return $http({
              method:'POST',
              url: '/api/person/create',
              data:data,
              // headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              headers: {'Content-Type': 'application/json','Authorization': 'admin'+':'+'admin'}
              // Access-Control-Allow-Origin
              // headers: {'Content-Type': 'multipart/form-data'}
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
          protected: function(data) {
            return $http({
              method:'GET',
              url: baseUrlApi + '/api/protected',
              headers: {'Content-Type': 'application/json','Authorization': 'admin'+':'+'admin'}
            })
          },
        }
      }
});