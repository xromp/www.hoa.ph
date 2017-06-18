(function(){
	angular
		.module('sims.modal',['$uibModalInstance'])
		.controller('ModalInfoInstanceCtrl', ModalInfoInstanceCtrl)

		ModalInfoInstanceCtrl.$inject = ['$uibModalInstance']
		function ModalInfoInstanceCtrl(){
			var vm = this;
			// vm.formData = formData;

			// vm.ok = function() {
			// 	$uibModalInstance.close();
			// };

			// vm.cancel = function() {
			// 	$uibModalInstance.dismiss('cancel');
			// };
		};
})
