define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('ExpenseCreateCtrl',ExpenseCreateCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.controller('CategoryModalCrtl',CategoryModalCrtl)
    app.lazy.controller('CategoryTypeModalCrtl',CategoryTypeModalCrtl)
    app.lazy.factory('ExpenseCreateSrvcs', ExpenseCreateSrvcs)

      ExpenseCreateCtrl.$inject = ['$scope', '$filter', '$window','$routeParams','ExpenseCreateSrvcs','$uibModal','blockUI', '$http']
      function ExpenseCreateCtrl($scope, $filter, $window, $routeParams, ExpenseCreateSrvcs, $uibModal, blockUI, $http){
        var vm = this;

        vm.default = function(){
          vm.collectionDetails = {
            amount:'',
            category:'',
            action:'CREATE'
          };
        };
        vm.default();

        if ($routeParams.id) {
          vm.collectionDetails.action = 'UPDATE';
          vm.collectionDetails.expenseid = $routeParams.id;
        }

        vm.init  = function() {
          vm.getCategoryList();

          if (vm.collectionDetails.action == 'UPDATE') {
            var data = {
              'posted':0,
              'action':'EDIT',
              'expenseid':vm.collectionDetails.expenseid
            };

            vm.get(data);
          }
        };

        vm.submit = function (data) {
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            
            var dataCopy = angular.copy(data);
            dataCopy.ordate = $filter('date')(dataCopy.ordate,'yyyy-MM-dd');
            dataCopy.entityvalues = [];
            dataCopy.entityvalues.push({
              'entityvalue1':dataCopy.categoryType,
              'entityvalue2':'',
              'entityvalue3':''
            });

            var appBlockUI = blockUI.instances.get('blockUI');
            appBlockUI.start();

            var formData = angular.toJson(dataCopy);
            ExpenseCreateSrvcs.save(formData)
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
                        title: 'Expense Entry',
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

        vm.update = function (data) {
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            
            var dataCopy = angular.copy(data);
            dataCopy.ordate = $filter('date')(dataCopy.ordate,'yyyy-MM-dd');
            dataCopy.entityvalues = [];
            dataCopy.entityvalues.push({
              'entityvalue1':dataCopy.categoryType,
              'entityvalue2':'',
              'entityvalue3':''
            });
            
            var appBlockUI = blockUI.instances.get('blockUI');
            appBlockUI.start();

            var formData = angular.toJson(dataCopy);
            ExpenseCreateSrvcs.update(formData)
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
                        title: 'Expense Entry',
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

        vm.get = function (data) {
          var dataCopy = angular.copy(data)

          var formData = angular.toJson(dataCopy);
          ExpenseCreateSrvcs.get(data)
          .then (function (response) {
            if (response.data.status == 200) {
              vm.collectionDetails = response.data.data[0];
              vm.collectionDetails.ordate = new Date(vm.collectionDetails.ordate);
              vm.collectionDetails.amount = parseFloat(vm.collectionDetails.amount);
            }
          },function(){ alert("Bad Request!")})
        };

        vm.reset = function () {
          // vm.personInfo = {};
        };

        vm.cancel = function () {
          // $scope.$parent.$parent.ec.templateUrl ='expense.view';
          $window.location.href = '/expense/view';
        };
      
        vm.getCategoryList = function() {

          ExpenseCreateSrvcs.getcategory()
          .then(function(response, status){
            if (response.status == 200) {
              vm.categoryList = response.data.data;    
            }
          }, function(){
            alert('Error!')
          });
        };

        vm.getCategoryTypeList = function(data){
          var formDataCopy = angular.copy(data);
          formDataCopy.category_code = formDataCopy.category;

          var formData = angular.toJson(formDataCopy);
          ExpenseCreateSrvcs.getcategorytype(formData)
          .then(function(response, status){
            if (response.status == 200) {
              vm.categoryTypeList = response.data.data;
            }
          }, function(){
            alert('Error!')
          });          
        }

        vm.datepickerOpen = function(i) {
          i.dtIsOpen = true;
        };
        
        vm.addCategory = function(data){

          var modalInstance = $uibModal.open({
            controller:'CategoryModalCrtl',
            templateUrl:'expense.add-category',
            controllerAs: 'vm',
            resolve :{
              formData: function () {
                return {
                  title: 'Add Category',
                  formData: data
                };
              }
            }
          });
          modalInstance.result.then(function (){
            vm.getCategoryList();
          },function (){});
        };

        vm.addCategoryType = function(data){

          var modalInstance = $uibModal.open({
            controller:'CategoryTypeModalCrtl',
            templateUrl:'expense.add-category-type',
            controllerAs: 'vm',
            resolve :{
              formData: function () {
                return {
                  title: 'Add Category Type',
                  formData: data
                };
              }
            }
          });
          modalInstance.result.then(function (){
            vm.getCategoryTypeList(data);
          },function (){});
        };

        vm.getCategoryType = function(i){
          // angular.forEach(vm.)

        }

        vm.init();
      }

      CategoryModalCrtl.$inject = ['$compile','$uibModalInstance', 'formData', 'ExpenseCreateSrvcs']
      function CategoryModalCrtl ($compile, $uibModalInstance, formData, ExpenseCreateSrvcs) {
        var vm = this;
        vm.formData = formData;
        console.log(vm.formData);
        // vm.ok = function() {
        //   $uibModalInstance.close();
        // };
        vm.submit= function(i){
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            vm.response = [];

            var formDataCopy = angular.copy(i);

            var formData = angular.toJson(formDataCopy);
            ExpenseCreateSrvcs.savecategory(formData)
            .then(function(response, status){
              if (response.data.status == 200) {
                vm.categoryDetails = {};s
              }
              vm.response.push(response.data);
            }, function(){alert('Error occured')});
          } else {
            vm.frmCreate.withError = true;
          }
        };

        vm.cancel = function() {
          $uibModalInstance.close();
        };
      }

      CategoryTypeModalCrtl.$inject = ['$compile','$uibModalInstance', 'formData', 'ExpenseCreateSrvcs']
      function CategoryTypeModalCrtl ($compile, $uibModalInstance, formData, ExpenseCreateSrvcs) {
        var vm = this;
        vm.formData = formData;
        // vm.ok = function() {
        //   $uibModalInstance.close();
        // };
        vm.submit= function(i){
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            vm.response = [];

            var formDataCopy = angular.copy(i);
            formDataCopy.category_code = vm.formData.formData.category;

            var formData = angular.toJson(formDataCopy);
            ExpenseCreateSrvcs.savecategorytype(formData)
            .then(function(response, status){
              if (response.data.status == 200) {
                vm.categoryDetails = {};
              }
              vm.response.push(response.data);
            }, function(){alert('Error occured')});
          } else {
            vm.frmCreate.withError = true;
          }
        };

        vm.cancel = function() {
          $uibModalInstance.close();
        };
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

      ExpenseCreateSrvcs.$inject = ['$http']
      function ExpenseCreateSrvcs($http){
        return {
          save: function(data) {
            return $http({
              method:'POST',
              url: '/api/expense/create',
              data:data,
              headers: {'Content-Type': 'application/json'}
            })
          },
          update: function(data) {
            return $http({
              method:'POST',
              url:'/api/expense/update',
              data:data,
              headers:{'Content-Type':'application/json'}
            })
          },
          get: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/expense/get',
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
              url: '/api/expense/category/get',
              headers: {'Content-Type': 'application/json'}
            })
          },
          savecategory: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/expense/category/create',
              headers: {'Content-Type': 'application/json'}
            })
          },
          savecategorytype: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/expense/category/type/create',
              headers: {'Content-Type': 'application/json'}
            })
          },
          getcategorytype: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/expense/category/type/get',
              headers: {'Content-Type': 'application/json'}
            })
          },
        }
      }
});