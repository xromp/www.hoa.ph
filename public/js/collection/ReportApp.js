
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
            'code':'ORLISTING'
          };
        };

        vm.reportList = [
          {'id':1,'code':'ORLISTING','description':'OR Listing','url':'/collection/reports/orlisting'},
          {'id':3,'code':'ORCHECKLIST','description':'OR Checklist','url':''},
          {'id':2,'code':'SUMMARYCOLLECTION','description':'Summary Collection & Expense','url':'/transaction/reports/comparative'},
          {'id':4,'code':'CURRENTBALANCE','description':'Current Balance for the month','url':'/transaction/reports/currentbalance'},
          {'id':5,'code':'PERSONLIST','description':'Members List','url':'/person/report/getpersonprofile'}
        ];

        vm.generateReport = function(data) {
          var dataCopy = angular.copy(data);
          var windowOrlisting;
          angular.forEach(vm.reportList, function(v, k){
            if (v.code == dataCopy.code) {
              dataCopy.reporturl = v.url;
            };
          });
          console.log(dataCopy.reporturl);
          dataCopy.startdate = $filter('date')(dataCopy.startdate,'yyyy-MM-dd');
          dataCopy.enddate = $filter('date')(dataCopy.enddate,'yyyy-MM-dd');
          
          if (dataCopy.reporturl == '/transaction/reports/currentbalance') {
            var month = (new Date()).getMonth()+1;
            var year = (new Date()).getFullYear();
            windowOrlisting = $window.open(window.location.origin+dataCopy.reporturl+'?month='+month+'&year='+year+'', '_blank');
          } else {
            windowOrlisting = $window.open(window.location.origin+dataCopy.reporturl+'?startdate='+dataCopy.startdate+'&enddate='+dataCopy.enddate+'', '_blank');
          }
          windowOrlisting.print();
        };

        vm.datepickerOpen = function(i,x) {
          if (x == 'STARTDATE') {
            i.startdateOpen = true;
          } else if (x == 'ENDDATE') {
            i.enddateOpen = true;
          }
        };

        vm.generateXLS = function (i){
          var dataCopy = angular.copy(i);
          dataCopy.datestart  = $filter('date')(dataCopy.startdate,'yyyy-MM-dd');
          dataCopy.dateend    = $filter('date')(dataCopy.enddate,'yyyy-MM-dd');
          vm.total = {};
          vm.columns =[];

          var data = angular.toJson(dataCopy);
          ReportSrvcs.getcategorysummary(data)
          .then(function (response, status){
            if (response.data.status == 200) {
              vm.categorysummarylist = response.data.data.categorysummarylist;
              angular.forEach(vm.categorysummarylist, function(v, k){
                v.ordate  = $filter('date')(v.ordate,'M/d/y');
                delete v.refid;
                delete v.posted;
                delete v.deleted;
                delete v.personid;
                for(var p in v){
                  if (p != 'orno' && p != 'ordate' && p != 'name') {
                    v[p]=(+v[p]||0);
                    vm.total[p] = (+vm.total[p]||0) +  (+v[p]||0);
                    if (k == 0) {
                      vm.columns.push(p);
                    };
                  };
                }
              });
              vm.categorysummarylist.push(vm.total);

              alasql('SELECT orno, ordate, name, '+vm.columns.join()+' INTO XLSX("category_summary_'+dataCopy.datestart+'_'+dataCopy.dateend+'.xlsx",{headers:true}) FROM ?',[vm.categorysummarylist]);
            };
          },function(){alert('Error occured.')});
        };

        vm.getReport = function(i){
          console.log(i);
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
          getcategorysummary: function(data) {
            return $http({
              method:'POST',
              data:data,
              url: '/api/collection/reports/category_summary',
              headers: {'Content-Type': 'application/json'}
            })
          },
        }
      }
});