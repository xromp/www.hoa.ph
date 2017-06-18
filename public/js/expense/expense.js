var app;
define('sims.expense',[
	'angular',
	'js/module-loader/dependencyResolverFor.js',
], function(angular, dependencyResolver){
	'use strict';
	 app = angular
		.module('sims.expense',['SidebarApp','ngRoute','ngAnimate','ngSanitize','ui.bootstrap', 'blockUI'])
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
			.when('/expense/create',{
				templateUrl:'expense.create',
				controller:'ExpenseCreateCtrl',
				controllerAs:'p',
				resolve:dependencyResolver([
					'/js/expense/ExpenseCreateApp.js'
				])
			})
			.when('/expense/view',{
				templateUrl:'expense.base',
				controller:'ExpenseCtrl',
				controllerAs:'ec',
				resolve:dependencyResolver([
					'/js/expense/ExpenseApp.js',
					'/js/expense/ExpenseViewApp.js',
					'/js/expense/ExpenseCreateApp.js'
				])
			})
			.when('/expense/reports',{
				templateUrl:'expense.reports.base',
				controller:'ReportCtrl',
				controllerAs:'rc',
				resolve:dependencyResolver([
					'/js/expense/ReportApp.js'
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
	'sims.expense',

	'angular-route',
	'angular-block-ui',
	'angular-animate',
	'angular-sanitize',
	'ui.bootstrap'
  ],function($,angular,app){
	angular.bootstrap(document, [app.name]);
  });
});