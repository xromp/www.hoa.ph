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
          vm.getMonthlyDues(vm.personInfo);
          vm.getCarSticker(vm.personInfo);

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
          ];
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
        
        vm.getMonthlyDues = function(i){
          var data = angular.copy(i);
          vm.year = [(new Date().getFullYear())];
          vm.monthlydueslist = [];

          PersonViewSrvcs.getmonthlydues(data)
          .then(function (response,status){
            if (response.data.status == 200) {
              vm.paidmonthlydues = response.data.data.monthlydueslist;

              angular.forEach(vm.year, function(v, k){
                angular.forEach(vm.month, function(v1, k1){
                  vm.monthlydueslist.push({
                    'description':v1.code + '-'+ v,
                    'code':v1.code + '-'+ v,
                    'paid':0,
                  });
                });
              });

              angular.forEach(vm.monthlydueslist, function(v, k){
                angular.forEach(vm.paidmonthlydues, function(v1, k1){
                  if (v.code == v1.code) {
                    v.paid =1;
                  }
                })
              });
            }
          }, function(){alert('Error Occured!')});
        };

        vm.getCarSticker = function(i){
          var data = angular.copy(i);
          vm.year = [(new Date().getFullYear())];
          vm.monthlydueslist = [];

          PersonViewSrvcs.getcarsticker(data)
          .then(function (response,status){
            if (response.data.status == 200) {
              vm.carstickerlist = response.data.data.carstickerlist;
            }
          }, function(){alert('Error Occured!')});
        };

        vm.back = function () {
          $window.location.href = '/person/finder/';
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
          getmonthlydues:function(data){
            return $http({
              method:'GET',
              url:'/api/person/collection/getmonthlydues?personid='+data.personid,
              data:data,
              headers:{'Content-Type':'application/json'}
            });
          },
          getcarsticker:function(data){
            return $http({
              method:'GET',
              url:'/api/person/collection/getcarsticker?personid='+data.personid,
              data:data,
              headers:{'Content-Type':'application/json'}
            });
          },
        }
      }
});