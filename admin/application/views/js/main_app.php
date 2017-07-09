<script type="text/javascript">
	var app = angular.module("mainApp", ['ui.bootstrap', 'ui.select', 'ngSanitize']);
	app.controller("mainCtrl", function($scope, $http, $uibModal, $log) {
	    //code
	});
	// enter to tab
	app.directive('enter',function(){
		return function(scope,element,attrs){
			element.bind("keydown keypress",function(event){
				if(event.which===13){
					event.preventDefault();
					var fields=$(this).parents('form:eq(0),body').find('input, textarea, select');
					var index=fields.index(this);
					if(index> -1&&(index+1)<fields.length)
						fields.eq(index+1).focus();
				}
			});
		};
	});

</script>
