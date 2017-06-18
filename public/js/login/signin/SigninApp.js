define([
  'angular',
  'jquery'
  ],function () {
  'use strict';
    app.lazy.controller('SigninCtrl',SigninCtrl)
    app.lazy.controller('ModalInstanceCtrl',ModalInstanceCtrl)
    app.lazy.factory('SiginSrvcs', SiginSrvcs)

      SigninCtrl.$inject = ['$scope', 'SiginSrvcs','$uibModal','blockUI', '$http','$window']
      function SigninCtrl($scope, SiginSrvcs, $uibModal, blockUI, $http,$window){
        var vm = this;
        
        vm.display = {
          loading:false,
          loaded:false
        };

        vm.submit = function (data) {
          if (vm.frmSigin.$valid) {
            var formData = angular.copy(data);
            vm.display.loading = true;
            vm.display.loaded = false;
            vm.frmSigin.withError = false;
            
            vm.loginCallBack = {};
            SiginSrvcs.signin(formData)
            .then(function (response) {
             vm.loginCallBack = response.data;
              if (response.data.status == 200) {
               vm.display.loading = false;
               $window.location.href = '/dashboard'
              } else {
                vm.display.loading = false;
              }
              vm.display.loaded = true;
            },function(){
              vm.display.loading = false;
              vm.display.loaded = true;
              vm.loginCallBack = {
                status:400,
                message:'Something went wrong'
              };
            })
          }else{
            vm.frmSigin.withError = true;
          } 
        };
      }

      ModalInstanceCtrl.$inject = ['$uibModalInstance', 'formData']
      function ModalInstanceCtrl ($uibModalInstance, formData) {
        var vm = this;
        vm.formData = formData;
        vm.ok = function() {
          $uibModalInstance.close();
        };

        vm.cancel = function() {
          $uibModalInstance.dismiss('cancel');
        };
      }

      SiginSrvcs.$inject = ['$http']
      function SiginSrvcs($http){
        return {
          signin: function(data) {
            var formData = angular.toJson(data)
            return $http({
              method:'POST',
              url: '/api/login',
              data:formData,
              headers: {'Content-Type': 'application/json','Authorization': data.username+':'+ data.password}
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