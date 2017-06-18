define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('CollectionCreateCtrl',CollectionCreateCtrl)
    app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
    app.lazy.controller('CategoryModalCrtl',CategoryModalCrtl)
    app.lazy.controller('PersonModalCrtl',PersonModalCrtl)
    app.lazy.factory('CollectionCreateSrvcs', CollectionCreateSrvcs)

      CollectionCreateCtrl.$inject = ['$scope', '$window', '$filter', '$routeParams', 'CollectionCreateSrvcs','$uibModal','blockUI', '$http']
      function CollectionCreateCtrl($scope, $window, $filter, $routeParams, CollectionCreateSrvcs, $uibModal, blockUI, $http){
        var vm = this;

        vm.collectionDetails = {
          type:'HOMEOWNER',
          refid:'',
          qty:1,
          amount:0,
          category:'CARSTICKER',
          action:'CREATE'
        };

        if ($routeParams.id) {
          vm.collectionDetails.action = 'EDIT';
          vm.collectionDetails.collectionid = $routeParams.id;
        }

        vm.init  = function() {
          vm.getOrList();
          vm.getCategoryList();

          vm.typeList = [
            {'id':1,'code':'HOMEOWNER','description':'Homeowner'},
            {'id':2,'code':'OUTSIDE','description':'Non-Homeowner'}
          ];

          vm.month = [
            {'id':1,'code':'JAN','description':'January'},
            {'id':2,'code':'FEB','description':'February'},
            {'id':2,'code':'MAR','description':'March'},
            {'id':2,'code':'APR','description':'April'},
            {'id':2,'code':'MAY','description':'May'},
            {'id':2,'code':'JUN','description':'June'},
            {'id':2,'code':'JUL','description':'July'},
            {'id':2,'code':'AUG','description':'August'},
            {'id':2,'code':'SEP','description':'September'},
            {'id':2,'code':'OCT','description':'October'},
            {'id':2,'code':'NOV','description':'November'},
            {'id':2,'code':'DEC','description':'December'}
          ]
          vm.year = [(new Date()).getFullYear()];
          vm.populateMonths();

          // CAR STICKER
          vm.stickerDetails = [
            {'stickerid':'', 'plateno':''}
          ]

          // load collection details if edit.
          if (vm.collectionDetails.action == 'CREATE') {

          } else if (vm.collectionDetails.action == 'EDIT') {
            var data = {
              'posted':0,
              'action':'EDIT',
              'collectionid':vm.collectionDetails.collectionid
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

            if (data.category == 'MONTHLYDUES') {
              angular.forEach(vm.monthSelected, function(v, k){
                if (v) {
                  dataCopy.entityvalues.push({
                    'entityvalue1':k.split('-')[0],
                    'entityvalue2':k.split('-')[1],
                    'entityvalue3':''
                  })
                }
              });
            } else if (data.category == 'CARSTICKER') {
              angular.forEach(vm.stickerDetails, function(v, k) {
                if (v) {
                  dataCopy.entityvalues.push({
                    'entityvalue1':v.stickerid,
                    'entityvalue2':v.plateno,
                    'entityvalue3':''
                  });
                }
              });
            } else {
              dataCopy.entityvalues.push({
                'entityvalue1':'',
                'entityvalue2':'',
                'entityvalue3':''
              });
            }
            
            var appBlockUI = blockUI.instances.get('blockUI');
            appBlockUI.start();

            var formData = angular.toJson(dataCopy);
            CollectionCreateSrvcs.save(formData)
            .then (function (response) {
              if (response.data.status == 200) {
                
                vm.personInfo = {};
              } else {

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

          CollectionCreateSrvcs.get(data)
          .then (function (response) {
            if (response.data.status == 200) {
              vm.collectionDetails = response.data.data[0];
              vm.collectionDetails.ordate = new Date(vm.collectionDetails.ordate);
              vm.collectionDetails.amount = parseFloat(vm.collectionDetails.amount);

              if (vm.collectionDetails.category_code == 'MONTHLYDUES') {
                vm.year = ['2017','2018'];
                vm.populateMonths();
              }
            }
          },function(){ alert("Bad Request!")})
        };

        vm.reset = function () {
          vm.personInfo = {};
        };

        vm.cancel = function () {
          // $scope.$parent.$parent.ce.templateUrl ='collection.view';
          $window.location.href = '/collection/view';
        };
        
        vm.getOrList = function() {
          vm.orList = [
            {'id':'','orno':'001','category':'Membership Fee'},
            {'id':'','orno':'002','category':'Car Sticker'},
            {'id':'','orno':'003','category':'Car Sticker'}
          ];
        };

        vm.getRefList = function(data) {
          var formDataCopy = angular.copy(data);

          // var formData = angular.toJson(formDataCopy);
          CollectionCreateSrvcs.getperson(formDataCopy)
          .then( function(response, status) {
            if (response.data.status == 200) {
              vm.refList = response.data.data;
            }
          },function(){alert("Error occured!");
          });
        };

        vm.getCategoryList = function() {

          CollectionCreateSrvcs.getcategory()
          .then(function(response, status){
            if (response.status == 200) {
              vm.categoryList = response.data.data;    
            }
          }, function(){
            alert('Error!')
          });
        };

        vm.datepickerOpen = function(i) {
          i.dtIsOpen = true;
        };

        vm.getCategoryTypeList = function (i){
          vm.categoryTypeList = [{'month':vm.monthList,'year':vm.year}];
        };

        vm.modifyYear = function(i) {
          var tempHighYear = 0;
          var tempLowYear = 2099;
          var newYear;

          angular.forEach(vm.year, function(v, k){
            if (v > tempHighYear && i=='ADD') {
              tempHighYear = v;
              newYear = tempHighYear+1;
            }

            if (v < tempLowYear && i == 'LESS') {
              tempLowYear =v;
              newYear = tempLowYear-1
            }
          });

          vm.year.push(newYear);
          vm.populateMonths();
        };

        vm.populateMonths = function() {
          vm.monthList = [];
          angular.forEach(vm.year, function(v1, k1){
              angular.forEach(vm.month, function(v2, k2) {
                vm.monthList.push({
                  'code':v2.code,
                  'year':v1,
                  'description':v2.code +'-'+v1,
                  'name':v2.code +'-'+v1
                });
              });
          });
          vm.getCategoryTypeList();
        };

        vm.addCarSticker = function() {
          vm.stickerDetails.push({'stickerid':'', 'plateno':''});
        };
        
        vm.removeCarSticker = function(i) {
          vm.stickerDetails.splice(i,1);
        };

        vm.addRef = function(data){
          var modalInstance = $uibModal.open({
            controller:'PersonModalCrtl',
            templateUrl:'collection.add-person',
            controllerAs: 'vm',
            resolve :{
              formData: function () {
                return {
                  title: 'Add person in '+ vm.collectionDetails.type,
                  formData: data
                };
              }
            }
          });

          modalInstance.result.then(function (){
            vm.getRefList(data);
          },function (){});


        };

        vm.addCategory = function(data){

          var modalInstance = $uibModal.open({
            controller:'CategoryModalCrtl',
            templateUrl:'collection.add-category',
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

      CategoryModalCrtl.$inject = ['$compile','$uibModalInstance', 'formData', 'CollectionCreateSrvcs']
      function CategoryModalCrtl ($compile, $uibModalInstance, formData, CollectionCreateSrvcs) {
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
            CollectionCreateSrvcs.savecategory(formData)
            .then(function(response, status){
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

      PersonModalCrtl.$inject = ['$compile','$uibModalInstance', 'formData', 'CollectionCreateSrvcs']
      function PersonModalCrtl ($compile, $uibModalInstance, formData, CollectionCreateSrvcs) {
        var vm = this;
        vm.formData = formData.formData;

        vm.submit= function(i){
          if (vm.frmCreate.$valid) {
            vm.frmCreate.withError = false;
            vm.response = [];

            var formDataCopy = angular.copy(i);
            formDataCopy.type = vm.formData.type;
            formDataCopy.action = 'CREATE';

            var formData = angular.toJson(formDataCopy);
            CollectionCreateSrvcs.saveperson(formData)
            .then(function(response, status){
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


      CollectionCreateSrvcs.$inject = ['$http']
      function CollectionCreateSrvcs($http){
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
              method:'POST',
              data:data,
              url: '/api/collection/get',
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
          savecategory: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/collection/category/create',
              headers: {'Content-Type': 'application/json'}
            })
          },
          saveperson: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/person/create',
              headers: {'Content-Type': 'application/json'}
            })
          },

        }
      }
});