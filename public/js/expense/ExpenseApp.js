define([
  'angular'
 ],function () {
  'use strict';
    app.lazy.controller('ExpenseCtrl',ExpenseCtrl)

    ExpenseCtrl.$inject = ['$scope', '$filter']
    function ExpenseCtrl($scope, $filter){
      var vm = this;

      vm.templateUrl = 'expense.view';

      vm.addExpense = function (){
        vm.templateUrl='expense.create';
      };
    }
});