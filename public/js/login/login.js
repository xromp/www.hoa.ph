var app;
define('sims.login',[
  'angular',
  '/js/module-loader/dependencyResolverFor.js',
  'ui.bootstrap',
  ],function (angular, dependencyResolver) {
  'use strict';
    app = angular.module('LoginApp', ['ngRoute','ngAnimate','ngSanitize','ui.bootstrap','blockUI']);
    app.config(
    [
        '$routeProvider',
        '$locationProvider',
        '$controllerProvider',
        '$compileProvider',
        '$filterProvider',
        '$provide',
        'blockUIConfig',

        function($routeProvider, $locationProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, blockUIConfig)
        {
          app.lazy = {
            controller :$controllerProvider.register,
            directive  :$compileProvider.directive,
            filter     :$filterProvider.register,
            factory    :$provide.factory,
            service    :$provide.service,
            blockUI    : blockUIConfig,
          }
          $locationProvider.html5Mode(true);

          $routeProvider
          .when('/login',{
            templateUrl: 'login.signin.signin',
            controller:'SigninCtrl',
            controllerAs:'s',
            resolve: dependencyResolver([
              '/js/login/signin/SigninApp.js'
            ])
          })
          .otherwise({redirectTo: '/login'});
        }
    ]);
   return app;
});
requirejs(['/js/module-loader/requirejs-config.js'], function (){
  requirejs([
    'jquery',
    'angular',
    'sims.login',
    
    'bootstrap',
    'angular-route',
    'angular-block-ui',
    'angular-animate',
    'angular-sanitize',
    'ui.bootstrap'
  ],function($,angular,app){
    angular.bootstrap(document, [app.name]);
  });
});