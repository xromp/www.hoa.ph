var app;
define('sims.collection',[
	'angular',
	'js/module-loader/dependencyResolverFor.js',
], function(angular, dependencyResolver){
	'use strict';
	 app = angular
		.module('sims.collection',['SidebarApp','ngRoute','ngAnimate','ngSanitize','ui.bootstrap', 'blockUI'])
		.config(Config)

		Config.$inject = ['$routeProvider', '$locationProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', 'blockUIConfig', '$interpolateProvider']
		function Config($routeProvider, $locationProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, blockUIConfig, $interpolateProvider){
			app.lazy = {	
				controller :$controllerProvider.register,
				directive  :$compileProvider.directive,
				filter     :$filterProvider.register,
				factory    :$provide.factory,
				service    :$provide.service,
				blockUI    : blockUIConfig,
			}
	    	
	    	$interpolateProvider.startSymbol('<%');
    		$interpolateProvider.endSymbol('%>');
			
			$locationProvider.html5Mode(true);
			$routeProvider
			.when('/collection/create',{
				templateUrl:'collection.create',
				controller:'CollectionCreateCtrl',
				controllerAs:'p',
				resolve:dependencyResolver([
					'/js/collection/CollectionCreateApp.js'
				])
			})
			.when('/collection/edit/:id',{
				templateUrl:'collection.create',
				controller:'CollectionCreateCtrl',
				controllerAs:'p',
				resolve:dependencyResolver([
					'/js/collection/CollectionCreateApp.js'
				])
			})
			.when('/collection/view',{
				templateUrl:'collection.base',
				controller:'CollectionCtrl',
				controllerAs:'ce',
				resolve:dependencyResolver([
					'/js/collection/CollectionApp.js',
					'/js/collection/CollectionViewApp.js',
					'/js/collection/CollectionCreateApp.js'
				])
			})
			.when('/collection/reports',{
				templateUrl:'collection.reports.base',
				controller:'ReportCtrl',
				controllerAs:'rc',
				resolve:dependencyResolver([
					'/js/collection/ReportApp.js'
				])
			})
			.otherwise({template:'<p>Wrong Url.</p>'})

            var markUp = '';
            markUp += '<div class="block-ui-overlay">'
            markUp += '</div>'
            markUp += '<div class="block-ui-message-container">'
            markUp += '  <div class="block-ui-message" style="color: black!important;font-size: 13px;background-color: transparent;">'
            markUp += '    <i class="fa fa-circle-o-notch fa-spin"></i> Loading... '
            markUp += '    </div>'
            markUp += '</div>'

            blockUIConfig.message='loading message from module';
            blockUIConfig.template = markUp;
            blockUIConfig.autoInjectBodyBlock = false;
		}

	return app;
});
requirejs(['/js/module-loader/requirejs-config.js'], function (){
  requirejs([
	'jquery',
	'angular',
	'sims.collection',

	'angular-route',
	'angular-block-ui',
	'angular-animate',
	'angular-sanitize',
	'ui.bootstrap'
  ],function($,angular,app){
	angular.bootstrap(document, [app.name]);
  });
});