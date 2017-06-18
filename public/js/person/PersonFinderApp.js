define(['angular'], function() {
	'use strict';
	// angular
	// 	.module('PersonApp')
		app.lazy.controller('PersonFinderCtrl', PersonFinderCtrl)
		app.lazy.directive('showdetail', showdetail)
		app.lazy.factory('PersonFinderSrvs', PersonFinderSrvs)

		PersonFinderCtrl.$inject = ['$scope','$http', 'PersonFinderSrvs']
		function PersonFinderCtrl($scope, $http, PersonFinderSrvs) {
			var vm = this;
			// vm.personData = [
			// 	{'id':1,'name':'Rommel Penaflor','address':'#041 Boni Barangka Drive.','type':'OWNER','total_collection':'1,535.50','course':'Software Engineering'},
			// 	{'id':2,'name':'Erikson Supent','address':'#002 Taas Ilaya Barangka','type':'OWNER','total_collection':'55.00','course':'Mechanical Engineering'},
			// 	{'id':3,'name':'Bryan Evangelista','address':'#023 Barangay Plainview','type':'OWNER','total_collection':'0.00','course':'E-Commerce'}
			// ];

			vm.init = function(){
				var data = [];
				PersonFinderSrvs.get(data)
				.then(function(response, status){
					if (response.data.status == 200) {
						vm.personData = response.data.data;
					}
				},function(){

				});

			};

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

					 //  angular.forEach(personDetails , function (v, k) {
						// if (v.person00id == person.id) {
						//   $scope.personDetails[0] = v;
						// }
					 //  });

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

		PersonFinderSrvs.inject = ['$http']
		function PersonFinderSrvs($http) {
			return {
				get:function(data){
					return $http({
						method:'GET',
						url:'api/person/get',
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
