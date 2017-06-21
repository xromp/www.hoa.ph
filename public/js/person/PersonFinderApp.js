define(['angular'], function() {
	'use strict';
	// angular
	// 	.module('PersonApp')
		app.lazy.controller('PersonFinderCtrl', PersonFinderCtrl)
		app.lazy.controller('ModalInfoInstanceCtrl',ModalInfoInstanceCtrl)
		app.lazy.directive('showdetail', showdetail)
		app.lazy.factory('PersonFinderSrvs', PersonFinderSrvs)

		PersonFinderCtrl.$inject = ['$scope','$http', '$window', '$uibModal', 'PersonFinderSrvs']
		function PersonFinderCtrl($scope, $http, $window, $uibModal, PersonFinderSrvs) {
			var vm = this;

			vm.query = {
				'personid':''
			};

			vm.init = function(){
      	var data = vm.query;
				PersonFinderSrvs.get(data)
				.then(function(response, status){
					if (response.data.status == 200) {
						vm.personList = response.data.data;
					}
				},function(){alert('Can\'t load all homeowner meber.')});

				vm.get(data);
			};

      vm.edit = function(i) {
        $window.location.href='/person/edit/'+i.personid;
      };

      vm.remove = function(i) {
        var formDataCopy = angular.copy(i);

        var formData = angular.toJson(formDataCopy);
        PersonFinderSrvs.remove(formData)
        .then(function(response, status){
          if (response.data.status == 200) {
            i.deleted = 1;
            vm.get(vm.query);
          }
          var modalInstance = $uibModal.open({
            controller:'ModalInfoInstanceCtrl',
            templateUrl:'shared.modal.info',
            controllerAs: 'vm',
            resolve :{
              formData: function () {
                return {
                  title: 'Remove Member',
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

      vm.get = function (i) {
      	var data = i;
				PersonFinderSrvs.get(data)
				.then(function(response, status){
					if (response.data.status == 200) {
						vm.personData = response.data.data;
					}
				},function(){

				});
      }

    	vm.showPersonDetail = function (person) {
	      if (person.isshowdetails) {
	        person.isshowdetails = false;
	      } else {
	        // person.isshowdetails = true;
	      }
	    };
	    // --- Load Init --
	    vm.init();
		};

		showdetail.$inject = ['PersonFinderSrvs']
		function showdetail(PersonFinderSrvs) {
			return {
				restrict:'A',
				scope:{
					'person':'=person'
				},
				templateUrl: 'person.finder-showdetail',
				controller: function($scope){
					$scope.personDetails = [];

					$scope.unPaidDetails = [];
					$scope.showdetail = function (person, i) {

					  $scope.personDetails = person;
					  console.log(person)

					  PersonFinderSrvs.getcollection(person)
					  .then(function(response, status){
					  	$scope.collection = response.data.data;
					  },function(){alert('Error alert!');});
					};

					$scope.$watch('person.isshowdetails', function (e) {
					  if (e) {
						$scope.showdetail($scope.person);
					  }
					});
				},
				link : function(scope, elem, atrr){

				}

			}
		};

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
    };

		PersonFinderSrvs.inject = ['$http']
		function PersonFinderSrvs($http) {
			return {
				get:function(data){
					return $http({
						method:'GET',
						url:'api/person/get?personid='+data.personid,
						data:data,
						headers:{'Content-Type':'application/json'}
					});
				},
				remove:function(data){
					return $http({
						method:'POST',
						url:'api/person/delete',
						data:data,
						headers:{'Content-Type':'application/json'}
					});
				},
				getcollection:function(data){
					return $http({
						method:'GET',
						url:'api/person/collection/get?personid='+data.personid,
						data:data,
						headers:{'Content-Type':'application/json'}
					});
				}
			};
		};
})
