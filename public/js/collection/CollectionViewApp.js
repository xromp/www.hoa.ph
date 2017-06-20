define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('CollectionViewCtrl',CollectionViewCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.controller('CollectionDetailsInstanceCtrl',CollectionDetailsInstanceCtrl)
    app.lazy.factory('CollectionViewSrvcs', CollectionViewSrvcs)

      CollectionViewCtrl.$inject = ['$scope', '$window', '$filter', 'CollectionViewSrvcs','$uibModal','blockUI', '$http']
      function CollectionViewCtrl($scope, $window, $filter, CollectionViewSrvcs, $uibModal, blockUI, $http){
        var vm = this;

        vm.query = {
          'startdate':'',
          'enddate':'',
          'posted':false,
          'orno':''
        };

        vm.init = function(){
          vm.search(vm.query);
        };

        vm.search = function (data) {
          var appBlockUI = blockUI.instances.get('blockUI');
          appBlockUI.start();

          var formDataCopy = angular.copy(data);
          formDataCopy.startdate = $filter('date')(formDataCopy.startdate,'yyyy-MM-dd');
          formDataCopy.enddate = $filter('date')(formDataCopy.enddate,'yyyy-MM-dd');

          var formData = angular.toJson(formDataCopy);
          CollectionViewSrvcs.get(formData)
          .then (function (response) {
            if (response.data.status == 200) {
              vm.collectionDetails = response.data.data;
            } else {

            }
            appBlockUI.stop();
          },function(){alert("Error occured!");
            appBlockUI.stop();
          });
        };

        vm.addCollection = function (){
          // vm.templateUrl='collection.create';
          $window.location.href ='/collection/create';
        };
        
        vm.post = function(i) {
          var formDataCopy = angular.copy(i)
          formDataCopy.refid = formDataCopy.orno;
          formDataCopy.refdate = $filter('date')(formDataCopy.ordate,'yyyy-MM-dd');
          formDataCopy.trantype = 'COLLECTION';

          var formData = angular.toJson(formDataCopy);
          CollectionViewSrvcs.post(formData)
          .then(function(response, status){
            if (response.data.status == 200) {
              i.posted = 1;  
            }
            var modalInstance = $uibModal.open({
              controller:'ModalInfoInstanceCtrl',
              templateUrl:'shared.modal.info',
              controllerAs: 'vm',
              resolve :{
                formData: function () {
                  return {
                    title: 'Collection Entry',
                    message: response.data.message
                  };
                }
              }
            });

            modalInstance.result.then(function (){
            },function (){
            });
          },function(){alert('Error occured')});
        };

        vm.edit = function(i) {
          $window.location.href='/collection/edit/'+i.collectionid;
        };

        vm.datepickerOpen = function(i,y) {
          if (y=='DATEFROM') {
            i.dtIsOpen = true;
          } else if (y=='DATETO') {
            i.dtIsOpen2 = true;
          }
        };

        vm.remove = function(i) {
          var formDataCopy = angular.copy(i)

          var formData = angular.toJson(formDataCopy);
          CollectionViewSrvcs.delete(formData)
          .then(function(response, status){
            if (response.data.status == 200) {
              i.deleted = 1;
              vm.search(vm.query);
            }
            var modalInstance = $uibModal.open({
              controller:'ModalInfoInstanceCtrl',
              templateUrl:'shared.modal.info',
              controllerAs: 'vm',
              resolve :{
                formData: function () {
                  return {
                    title: 'Collection Entry',
                    message: response.data.message
                  };
                }
              }
            });

            modalInstance.result.then(function (){
            },function (){
            });
          },function(){alert('Error occured')});
        };

        vm.zeroPad = function(num, places) {
          var zero = places - num.toString().length + 1;
          return Array(+(zero > 0 && zero)).join("0") + num;
        };

        vm.showDetails = function (data) {
          var modalInstance = $uibModal.open({
            controller:'CollectionDetailsInstanceCtrl',
            templateUrl:'collection.view-details',
            controllerAs: 'vm',
            backdrop: 'static',
            resolve :{
              formData: function () {
                return {
                  title: 'Collection Details',
                  formData: data,
                  parent: vm
                };
              }
            }
          });

          modalInstance.result.then(function (){
          },function () {});
        }

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

      CollectionDetailsInstanceCtrl.$inject = ['$uibModalInstance', '$filter', 'formData','CollectionViewSrvcs']
      function CollectionDetailsInstanceCtrl ($uibModalInstance, $filter, formData, CollectionViewSrvcs) {
        var vm = this;
        vm.formData =formData;
        vm.init = function(data) {
          var dataCopy = angular.copy(data);

          var formData = angular.toJson(dataCopy);
          CollectionViewSrvcs.get(formData)
          .then(function(response, status){
            if (response.data.status == 200) {
              vm.collectionDetails = response.data.data[0];
            }
          });
        }
        vm.ok = function() {
          $uibModalInstance.close();
        };

        vm.post = function(i) {
          var formDataCopy = angular.copy(i)
          vm.response = {};
          
          formDataCopy.refid = formDataCopy.orno;
          formDataCopy.refdate = $filter('date')(formDataCopy.ordate,'yyyy-MM-dd');
          formDataCopy.trantype = 'COLLECTION';

          var formData = angular.toJson(formDataCopy);
          CollectionViewSrvcs.post(formData)
          .then(function(response, status){
            vm.response = response.data;
            if (response.data.status == 200) {
              vm.formData.formData.posted =1;
            }
          },function(){alert('Error occured')});
        };

        vm.cancel = function() {
          $uibModalInstance.dismiss(vm.formData.formData);
        };

        vm.zeroPad = function(num, places) {
          var zero = places - num.toString().length + 1;
          return Array(+(zero > 0 && zero)).join("0") + num;
        };

        vm.init(vm.formData.formData);
      }

      CollectionViewSrvcs.$inject = ['$http']
      function CollectionViewSrvcs($http){
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
              method:'POST',
              data:data,
              url: '/api/collection/get',
              headers: {'Content-Type': 'application/json'}
            })
          },
          post: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/transaction/post',
              headers: {'Content-Type': 'application/json'}
            })
          },
          delete: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/collection/delete',
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